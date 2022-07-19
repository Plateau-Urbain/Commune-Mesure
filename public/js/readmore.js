let readmoreButtons = document.querySelectorAll('.readmore');

let toggleMore = (e) => {
    let target = e.target;
    let parent = target.parentElement;

    let dots = parent.querySelector('.dots');
    let moreText = parent.querySelector('.more');
    let btnText = parent.querySelector('.readmore');
    let excerpt = parent.querySelector('.excerpt');

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Lire la suite";
        moreText.style.display = "none";
        excerpt.style.display = "inline";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "Lire moins";
        moreText.style.display = "inline";
        excerpt.style.display = "none";
    }
}

document.querySelectorAll('.readmore').forEach(readmore =>
    readmore.addEventListener("click", (e) => toggleMore(e))
);