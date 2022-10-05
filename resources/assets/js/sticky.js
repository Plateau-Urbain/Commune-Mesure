// Hauteur de trigger (% de window height)
const ratio = .6

// Sections à observer
const scrollspies = document.querySelectorAll('[data-spy]')

// Span de texte à changer
const scrolltitle = document.getElementById('sticky-section')

if (scrolltitle === null) {
    throw new Error('Section title not found')
}

const activate = function (elem) {
    // On met le titre du dataset dans la section
    const title = elem.dataset.spy
    scrolltitle.textContent = title
}

// entries = chaque élément observés
const callback = function(entries) {
    entries.forEach(function (entry) {
        // Si l'entrée est visible (à trigger l'intersection)
        if (entry.isIntersecting) {
            activate(entry.target)
        }
    })
}

if (scrollspies.length > 0) {
    const y = Math.round(window.innerHeight * ratio)
    const observer = new IntersectionObserver(callback, {
        // Ligne de 1 px de hauteur qui trigger l'intersection
        rootMargin: `-${window.innerHeight - y - 1}px 0px -${y}px 0px`
    })

    // on ajoute tous les éléments à observer
    scrollspies.forEach(function(spy) {
        observer.observe(spy)
    })
}
