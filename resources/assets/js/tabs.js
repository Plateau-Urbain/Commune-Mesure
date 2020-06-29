var tabSelector = '.tabs > ul > li'
var tabContentSelector = '.tabs-content > .tab'
var activeClass = 'is-active'

var tabs = document.querySelectorAll(tabSelector)
var tabsContent = document.querySelectorAll(tabContentSelector)

function switchTab(tab, event) {
    var tabGroup = tab.closest('.tabs').dataset.tabGroup

    tabs.forEach(function (el) {
        if (el.closest('.tabs').dataset.tabGroup === tabGroup) {
            el.classList.remove(activeClass)
        }
    })

    tabsContent.forEach(function (el) {
        if (el.closest('.tabs-content').dataset.tabGroup === tabGroup) {
            el.classList.remove(activeClass)
        }
    })

    tab.classList.add(activeClass)
    var pane = tab.firstElementChild.getAttribute('href').substr(1)

    tabsContent.forEach(function (el) {
        if (el.closest('.tabs-content').dataset.tabGroup === tabGroup &&
            el.dataset.tab === pane
        ) {
            el.classList.add(activeClass)
        }
    })
}

document.addEventListener('click', function (event) {
    for (var target = event.target; target && target != this; target = target.parentNode) {
        if (target.matches(tabSelector)) {
            switchTab(target, event)
        }
    }
}, false)
