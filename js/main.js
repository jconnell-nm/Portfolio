import { animateText, animateTextLoop } from "./animations.js";

document.addEventListener("DOMContentLoaded", () => {
    initHeroAnimations();
});

function initHeroAnimations() {
    const heroTitle = document.getElementById("hero-title");
    const heroText = document.getElementById("hero-text");

    console.log(heroTitle);
    console.log(heroText);

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