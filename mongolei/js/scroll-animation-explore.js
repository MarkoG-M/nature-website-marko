/* reveal animation */

const observer = new IntersectionObserver((entries) => {

  entries.forEach((entry) => {

    if(entry.isIntersecting){
      entry.target.classList.add("show");
    }

  });

}, {
  threshold: 0.2
});

document.querySelectorAll(".reveal")
  .forEach((el) => observer.observe(el));

/* quotes */

const quotes = [
  "„Die Berge rufen und ich muss gehen.“",
  "„Natur ist Freiheit.“",
  "„In den Bergen findet man Ruhe.“"
];

let current = 0;

const quoteText = document.getElementById("quoteText");

function changeQuote(dir){

  if(!quoteText) return;

  quoteText.classList.add("fade-out");

  setTimeout(() => {

    current += dir;

    if(current < 0){
      current = quotes.length - 1;
    }

    if(current >= quotes.length){
      current = 0;
    }

    quoteText.textContent = quotes[current];

    quoteText.classList.remove("fade-out");
    quoteText.classList.add("fade-in");

  }, 200);

}