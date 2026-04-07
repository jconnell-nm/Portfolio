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

        let delay = 0;

        const words = text.split(" ");

        words.forEach((word, wordIndex) => {
            const wordSpan = document.createElement("span");
            wordSpan.style.display = "inline-block";
            wordSpan.style.whiteSpace = "nowrap";

            word.split("").forEach((char, charIndex) => {
                const charSpan = document.createElement("span");
                charSpan.textContent = char;
                charSpan.style.opacity = "0";
                charSpan.style.display = "inline-block";
                charSpan.style.transform = "translateY(20px)";
                charSpan.style.transition = "all 0.3s ease";

                wordSpan.appendChild(charSpan);

                setTimeout(() => {
                    charSpan.style.opacity = "1";
                    charSpan.style.transform = "translateY(0)";
                }, delay);
                
                delay += speed;
            });

            const space = document.createTextNode(" ");
            element.appendChild(wordSpan);
            element.appendChild(space);
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