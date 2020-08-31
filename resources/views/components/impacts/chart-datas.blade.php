<template id="chromosomic-row">
    <div class="columns">
        <div class="column is-4">
            <p class="title is-4">
                <a href=""></a>
            </p>
        </div>
        <div class="column is-8 has-text-centered">
            <div class="chromosomic"></div>
        </div>
    </div>
</template>

<script>

//TODO move that function because is used also in other page
var order = @json($resiliences['order']);
var place = @json($resiliences['byPlace']);
var infos = @json($resiliences['places']);

var section = document.getElementById('sectionResilienceBar')
var chromosomesTemplate = document.querySelector('#chromosomic-row')

function createResilienceBar(select) {
    _clean(section)

    var type = select.value
    const keys = Object.keys(order[type])

    keys.forEach(function (key) {
        // on clone le template
        var line = document.importNode(chromosomesTemplate.content, true)
        var chromosomic = line.querySelector('.chromosomic')

        // Titre du chromosome (le lieu)
        link = line.querySelector('p.title > a')
        link.href = infos[key].url
        link.textContent = key.trim()

        // On créé le premier div du chromosome
        var color = 0
        var total = infos[key].total
        var firstdiv = document.createElement('div')

        _style(firstdiv, type, order[type][key], total)
        firstdiv.dataset.tooltip = order[type][key] + '%'
        chromosomic.appendChild(firstdiv)

        Object.keys(place[key]).forEach(function (k) {
            if (k == type) {
                return false
            }

            var div = document.createElement('div')
            _style(div, k, place[key][k], total)
            div.dataset.tooltip = place[key][k] + '%'
            chromosomic.appendChild(div)
            color++
        })

        section.appendChild(line)
    })
}

function _clean(div) {
    while(div.firstChild) {
        div.removeChild(div.lastChild)
    }
}

function _style(div, color, width, total) {
    div.classList.add(color+'-color');
    div.style.width = (width * 100) / total + '%'
}
</script>
