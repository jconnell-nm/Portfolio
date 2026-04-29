<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
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

$namePattern = "/^[a-zA-ZÀ-ÿ' -]{2,50}$/";

if (!preg_match($namePattern, $firstName)) {
    $errors['first_name'] = 'Please enter a valid first name.';
}

if (!preg_match($namePattern, $lastName)) {
    $errors['last_name'] = 'Please enter a valid last name.';
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
    $phoneDigits = preg_replace('/\D+/', '', $phone);

    if (!preg_match('/^\+?[0-9\s().-]{7,20}$/', $phone) || strlen($phoneDigits) < 7 || strlen($phoneDigits) > 15) {
        $errors['phone'] = 'Please enter a valid phone number.';
    }
}

if ($subject === '' || strlen($subject) > 100) {
    $errors['subject'] = 'Subject is required and must be under 100 characters.';
}

if ($message === '' || strlen($message) > 2000) {
    $errors['message'] = 'Message is required and must be under 2000 characters.';
}

$blockedPatterns = [
    '/<script\b/i',
    '/\b(select|insert|update|delete|drop|union|alter|truncate)\b.*\b(from|into|table|database|where)\b/i',
    '/(--|#|\/\*)/',
];

foreach ([$firstName, $lastName, $email, $phone, $subject, $message] as $field) {
    foreach ($blockedPatterns as $pattern) {
        if (preg_match($pattern, $field)) {
            $errors['general'] = 'Your message contains invalid content.';
            break 2;
        }
    }
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

try {
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

    echo json_encode([
        'success' => true,
        'message' => "Thank you for your message! I'll get back to you soon."
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, something went wrong. Please try again later.'
    ]);
}