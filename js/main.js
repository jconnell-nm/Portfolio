import { animateText, animateTextLoop } from "./animations.js";

document.addEventListener("DOMContentLoaded", () => {
    // Initialize hero animations
    initHeroAnimations();
    initMobileNav();
    initContactForm();

    
});

function initHeroAnimations() {
    const heroTitle = document.getElementById("hero-title");
    const heroText = document.getElementById("hero-text");

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
    const form = document.querySelector("form");

    const firstNameInput = document.querySelector("#first-name");
    const lastNameInput = document.querySelector("#last-name");
    const emailInput = document.querySelector("#email");
    const subjectInput = document.querySelector("#subject");
    const messageInput = document.querySelector("#message");

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    firstNameInput.addEventListener("input", () => validateFirstName());
    lastNameInput.addEventListener("input", () => validateLastName());
    emailInput.addEventListener("input", () => validateEmail());
    subjectInput.addEventListener("input", () => validateSubject());
    messageInput.addEventListener("input", () => validateMessage());

    firstNameInput.addEventListener("blur", () => validateFirstName());
    lastNameInput.addEventListener("blur", () => validateLastName());
    emailInput.addEventListener("blur", () => validateEmail());
    subjectInput.addEventListener("blur", () => validateSubject());
    messageInput.addEventListener("blur", () => validateMessage());

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const isFirstNameValid = validateFirstName();
        const isLastNameValid = validateLastName();
        const isEmailValid = validateEmail();
        const isSubjectValid = validateSubject();
        const isMessageValid = validateMessage();

        if (isFirstNameValid && isLastNameValid && isEmailValid && isSubjectValid && isMessageValid) {
            alert("Thank you for your message! I'll get back to you soon.");
            form.reset();
            clearValidationState();
        }
    });

    function validateFirstName() {
        const value = firstNameInput.value.trim();

        if (value === "") {
            showError(firstNameInput, "First name is required.");
            return false;
        }

        showSuccess(firstNameInput);
        return true;
    }

    function validateLastName() {
        const value = lastNameInput.value.trim();

        if (value === "") {
            showError(lastNameInput, "Last name is required.");
            return false;
        }

        showSuccess(lastNameInput);
        return true;
    }

    function validateEmail() {
        const value = emailInput.value.trim();

        if (value === "") {
            showError(emailInput, "Email is required.");
            return false;
        } else if (!emailPattern.test(value)) {
            showError(emailInput, "Please enter a valid email address.");
            return false;
        }

        showSuccess(emailInput);
        return true;
    }

    function validateSubject() {
        const value = subjectInput.value.trim();

        if (value === "") {
            showError(subjectInput, "Subject is required.");
            return false;
        }

        showSuccess(subjectInput);
        return true;
    }

    function validateMessage() {
        const value = messageInput.value.trim();

        if (value === "") {
            showError(messageInput, "Message is required.");
            return false;
        }

        showSuccess(messageInput);
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

    function clearValidationState() {
        const fields = [firstNameInput, lastNameInput, emailInput, subjectInput, messageInput];

        fields.forEach((field) => {
            field.classList.remove("valid", "invalid");
            const error = field.nextElementSibling;
            if (error && error.classList.contains("error")) {
                error.textContent = "";
            }
        });
    }
}