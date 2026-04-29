<?php
$pageTitle = 'Jonathan Connell Portfolio';
$currentPage = 'home';
$basePath = '';

require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
?>
<main class="content">
<section class="hero" id="about">
    <div class="hero__content">
        <h1 id="hero-title">My Name is Jonathan Connell</h1>
        <p id="hero-text"></p>
    </div>
    <a class="hero__scroll" href="#portfolio">Scroll Down<br>&#8964;</a>
</section>

<section class="portfolio section" id="portfolio">
    <div class="projects-grid">
        <div class="project-card">
            <img src="img/project-1.png" alt="Project One">
            <h2>Project One</h2>
            <a href="#">View Project &#8594;</a>
        </div>
        <div class="project-card">
            <img src="img/project-2.png" alt="Project Two">
            <h2>Project Two</h2>
            <a href="#">View Project &#8594;</a>
        </div>
        <div class="project-card">
            <img src="img/project-3.png" alt="Project Three">
            <h2>Project Three</h2>
            <a href="#">View Project &#8594;</a>
        </div>
        <div class="project-card">
            <img src="img/project-4.png" alt="Project Four">
            <h2>Project Four</h2>
            <a href="#">View Project &#8594;</a>
        </div>
        <div class="project-card">
            <img src="img/project-5.png" alt="Project Five">
            <h2>Project Five</h2>
            <a href="#">View Project &#8594;</a>
        </div>
        <div class="project-card">
            <img src="img/project-6.png" alt="Project Six">
            <h2>Project Six</h2>
            <a href="#">View Project &#8594;</a>
        </div>
    </div>
</section>

<section class="contact section" id="contact">
    <div class="contact__info">
        <h2>Get In Touch</h2>
        <p>
            I’m currently looking for opportunities to start my career in web development and continue building my skills.
        </p>
        <a href="tel:07301294775">07301 294775</a>
        <a href="mailto:jonathanconnell321@gmail.com">jonathanconnell321@gmail.com</a>
        <p>
            If you have a role available, a project in mind, or would just like to connect, feel free to get in touch. I’d be happy to hear from you.
        </p>
    </div>

    <form class="contact__form">
        <div class="contact__row">
            <div class="first-name-input">
                <input type="text" id="first-name" placeholder="First Name*">
                <span class="error"></span>
            </div>
            <div class="last-name-input">
                <input type="text" id="last-name" placeholder="Last Name*">
                <span class="error"></span>
            </div>
        </div>
        <input type="email" id="email" placeholder="Email Address*">
        <span class="error"></span>
        <input type="text" id="subject" placeholder="Subject">
        <span class="error"></span>
        <textarea id="message" placeholder="Message" rows="8"></textarea>
        <span class="error"></span>
        <button type="submit">Send Message</button>
    </form>
    <div id="form-success" class="form-success">
        <p>Thank you for your message! I'll get back to you soon.</p>
    </div>
</section>
<footer class="footer">
    <a href="#top">&#8963;<br>Back to Top</a>
</footer>
<?php require __DIR__ . '/partials/footer.php'; ?>