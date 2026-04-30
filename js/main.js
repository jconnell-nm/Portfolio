import { animateText, animateTextLoop } from "./animations.js";

document.addEventListener("DOMContentLoaded", () => {
    initHeroAnimations();
    initMobileNav();
    initContactForm();
    initPageTransitions();
});

function initHeroAnimations() {
    const heroTitle = document.getElementById("hero-title");
    const heroText = document.getElementById("hero-text");

    if (!heroTitle || !heroText) return;

    // Animate the hero title
    animateText({
        element: heroTitle, 
        text: "My Name is Jonathan Connell", 
        speed: 60,
        delay: 250
    });

    // Animate the hero text with looping phrases
    animateTextLoop({
        element: heroText, 
        phrases: [
            "I'm a Web Developer",
            "I build responsive websites",
            "I enjoy Javascript"
        ],
        speed: 40,
        delay: 1000
    });
}

function initMobileNav() {
    const navToggle = document.getElementById("nav-toggle");
    const sidebar = document.querySelector(".sidebar");

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            navToggle.checked = false;
        }
    });

    document.addEventListener("click", (e) => {
        if (
            window.innerWidth < 768 &&
            navToggle.checked &&
            !sidebar.contains(e.target) &&
            e.target !== navToggle
        ) {
            navToggle.checked = false;
        }
    });
}

function initContactForm() {
    const form = document.querySelector("#contact-form");
    const formMessage = document.querySelector("#form-message");

    const firstNameInput = document.querySelector("#first-name");
    const lastNameInput = document.querySelector("#last-name");
    const emailInput = document.querySelector("#email");
    const phoneInput = document.querySelector("#phone");
    const subjectInput = document.querySelector("#subject");
    const messageInput = document.querySelector("#message");

    if (!form || !firstNameInput || !lastNameInput || !emailInput || !phoneInput || !subjectInput || !messageInput) {
        return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^\+?[0-9\s().-]{7,20}$/;

    firstNameInput.addEventListener("input", validateFirstName);
    lastNameInput.addEventListener("input", validateLastName);
    emailInput.addEventListener("input", validateEmail);
    phoneInput.addEventListener("input", validatePhone);
    subjectInput.addEventListener("input", validateSubject);
    messageInput.addEventListener("input", validateMessage);

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        validateFirstName();
        validateLastName();
        validateEmail();
        validatePhone();
        validateSubject();
        validateMessage();

        showFormMessage("Sending your message...", true);

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                showFormMessage(result.message || "Please check the form and try again.", false);
                if (result.errors) showServerErrors(result.errors);
                return;
            }

            clearValidationState();
            form.reset();
            showFormMessage(result.message, true);
        } catch {
            showFormMessage("Sorry, your message could not be sent. Please try again.", false);
        }
    });

    function validateFirstName() {
        return validateRequired(firstNameInput, "First name is required.");
    }

    function validateLastName() {
        return validateRequired(lastNameInput, "Last name is required.");
    }

    function validateEmail() {
        const value = emailInput.value.trim();

        if (value === "") {
            showError(emailInput, "Email is required.");
            return false;
        }

        if (!emailPattern.test(value)) {
            showError(emailInput, "Please enter a valid email address.");
            return false;
        }

        showSuccess(emailInput);
        return true;
    }

    function validatePhone() {
        const value = phoneInput.value.trim();

        if (value !== "" && !phonePattern.test(value)) {
            showError(phoneInput, "Please enter a valid phone number.");
            return false;
        }

        showSuccess(phoneInput);
        return true;
    }

    function validateSubject() {
        return validateRequired(subjectInput, "Subject is required.");
    }

    function validateMessage() {
        return validateRequired(messageInput, "Message is required.");
    }

    function validateRequired(input, message) {
        if (input.value.trim() === "") {
            showError(input, message);
            return false;
        }

        showSuccess(input);
        return true;
    }

    function showError(input, message) {
        const error = input.nextElementSibling;
        error.textContent = message;
        input.classList.add("invalid");
        input.classList.remove("valid");
    }

    function showSuccess(input) {
        const error = input.nextElementSibling;
        error.textContent = "";
        input.classList.remove("invalid");
        input.classList.add("valid");
    }

    function showServerErrors(errors) {
        const fields = {
            first_name: firstNameInput,
            last_name: lastNameInput,
            email: emailInput,
            phone: phoneInput,
            subject: subjectInput,
            message: messageInput
        };

        Object.entries(errors).forEach(([key, message]) => {
            if (fields[key]) {
                showError(fields[key], message);
            }
        });
    }

    function showFormMessage(message, success) {
        const p = formMessage.querySelector("p");

        p.textContent = message;

        formMessage.classList.add("show");
        formMessage.classList.toggle("success", success);
        formMessage.classList.toggle("error", !success);

        formMessage.scrollIntoView({ behavior: "smooth", block: "start" });

        setTimeout(() => {
            formMessage.classList.remove("show");
        }, 5000);
    }

    function clearValidationState() {
        [firstNameInput, lastNameInput, emailInput, phoneInput, subjectInput, messageInput].forEach((field) => {
            field.classList.remove("valid", "invalid");
            const error = field.nextElementSibling;
            if (error && error.classList.contains("error")) {
                error.textContent = "";
            }
        });
    }
}

function initPageTransitions() {
    const pageContent = document.querySelector(".content");
    if (!pageContent) return;

    pageContent.classList.add("is-animating", "is-entering");

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            pageContent.classList.remove("is-entering");
            pageContent.classList.add("is-visible");
        });
    });

    const links = document.querySelectorAll("a[href]");

    links.forEach((link) => {
        link.addEventListener("click", (e) => {
            if (
                e.defaultPrevented ||
                e.button !== 0 ||
                e.metaKey ||
                e.ctrlKey ||
                e.shiftKey ||
                e.altKey
            ) {
                return;
            }

            const href = link.getAttribute("href");

            if (
                !href ||
                href.startsWith("mailto:") ||
                href.startsWith("tel:") ||
                href.startsWith("javascript:") ||
                link.target === "_blank" ||
                link.hasAttribute("download")
            ) {
                return;
            }

            const targetUrl = new URL(link.href, window.location.href);
            const currentUrl = new URL(window.location.href);

            if (targetUrl.origin !== currentUrl.origin) return;

            const samePath =
                targetUrl.pathname.replace(/\/$/, "") === currentUrl.pathname.replace(/\/$/, "");
            const sameSearch = targetUrl.search === currentUrl.search;

            // same document, including hash navigation
            if (samePath && sameSearch) {
                return;
            }

            e.preventDefault();

            pageContent.classList.remove("is-visible");
            pageContent.classList.add("is-leaving");

            const navigate = () => {
                window.location.href = targetUrl.href;
            };

            pageContent.addEventListener("transitionend", navigate, { once: true });
            setTimeout(navigate, 350);
        });
    });
}
