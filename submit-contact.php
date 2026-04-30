<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/config/mailer.php';

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method.'
        ]);
        exit;
    }

    $pdo = require __DIR__ . '/config/database.php';

    function clean($value) {
        return trim(str_replace(["\r", "\n"], '', $value ?? ''));
    }

    $firstName = clean($_POST['first_name'] ?? '');
    $lastName  = clean($_POST['last_name'] ?? '');
    $email     = clean($_POST['email'] ?? '');
    $phone     = clean($_POST['phone'] ?? '');
    $subject   = clean($_POST['subject'] ?? '');
    $message   = trim($_POST['message'] ?? '');

    $errors = [];

    if ($firstName === '') {
        $errors['first_name'] = 'First name is required.';
    }

    if ($lastName === '') {
        $errors['last_name'] = 'Last name is required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    } else {
        $domain = substr(strrchr($email, '@'), 1);

        if (!$domain || !checkdnsrr($domain, 'MX')) {
            $errors['email'] = 'Please enter a real email address.';
        }
    }

    if ($phone !== '') {
        $digits = preg_replace('/\D+/', '', $phone);

        if (!preg_match('/^\+?[0-9\s().-]{7,20}$/', $phone) || strlen($digits) < 7 || strlen($digits) > 15) {
            $errors['phone'] = 'Please enter a valid phone number.';
        }
    }

    if ($subject === '') {
        $errors['subject'] = 'Subject is required.';
    }

    if ($message === '') {
        $errors['message'] = 'Message is required.';
    }

    if ($errors) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Please correct the highlighted errors.',
            'errors' => $errors
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO contact_messages
            (first_name, last_name, email, phone, subject, message, created_at)
        VALUES
            (:first_name, :last_name, :email, :phone, :subject, :message, NOW())
    ");

    $stmt->execute([
        ':first_name' => $firstName,
        ':last_name'  => $lastName,
        ':email'      => $email,
        ':phone'      => $phone ?: null,
        ':subject'    => $subject,
        ':message'    => $message,
    ]);

    $mail = createMailer();
    $mail->Subject = "New Contact Message: $subject";
    $mail->Body = "You have received a new message from your portfolio contact form:\n\n" .
                   "Name: $firstName $lastName\n" .
                   "Email: $email\n" .
                   "Phone: " . ($phone ?: 'N/A') . "\n" .
                   "Subject: $subject\n" .
                   "Message:\n$message";
    try {
        $mail->send();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to send email.'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => "Thank you for your message! I'll get back to you soon."
    ]);
} catch (Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}