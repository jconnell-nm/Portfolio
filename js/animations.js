function animateText({
    element,
    text, 
    speed = 50,
    delay = 0,
    pause = 2000,
    loop = false
}) {
    if (!element) return;

    let index = 0;

    function type() {
        element.textContent = "";

        text.split("").forEach((char, i) => {
            const span = document.createElement("span");

            // Preserve spaces
            span.textContent = char === " " ? "\u00A0" : char;
            
            span.style.opacity = "0";
            span.style.display = "inline-block";
            span.style.transform = "translateY(20px)";
            span.style.transition = `opacity 0.3s ease, transform 0.3s ease`;
            
            element.appendChild(span);

            setTimeout(() => {
                span.style.opacity = "1";
                span.style.transform = "translateY(0)";
            }, i * speed);
        });
    }

    function start() {
        type();

        if (loop) {
            setInterval(() => {
                element.textContent = "";
                type();
            }, text.length * speed + pause);
        }
    }

    setTimeout(start, delay);
}

function animateTextLoop({
    element,
    phrases,
    speed = 50,
    delay = 0,
    pause = 2000
}) {
    let phraseIndex = 0;

    function run() {
        const currentPhrase = phrases[phraseIndex];

        animateText({
            element,
            text: phrases[phraseIndex],
            speed,
        });

        const totalDuration = currentPhrase.length * speed + pause;
        phraseIndex = (phraseIndex + 1) % phrases.length;

        setTimeout(run, totalDuration);
    }

    setTimeout(run, delay);
}

export { animateText, animateTextLoop };