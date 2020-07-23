<script>
    document.getElementById('stop1-male').setAttribute('offset', (100-91)+'%')
    document.getElementById('stop2-male').setAttribute('offset', (100-91)+'%')

    document.getElementById('stop1-female').setAttribute('offset', (100-84)+'%')
    document.getElementById('stop2-female').setAttribute('offset', (100-84)+'%')

    var financementctx = document.getElementById('financement-doughnut')
    var financementchart = new Chart(financementctx, {
        type: 'doughnut',
        options: {
            title: {
                display: true,
                text: 'Financement du projet',
                fontFamily: "'Renner Bold', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                fontSize: 16,
                padding: 5
            },
            cutoutPercentage: 90,
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 20
                }
            }
        },
        data: {
            datasets: [{
                data:[57, 34, 16, 4],
                backgroundColor: [
                    '#e85048', '#deebee', '#ee7969', '#262631'
                ]
            }],
            labels: [
                'Région',
                'Ville',
                'Taxes',
                'Donations'
            ]
        }
    })


    // Changement images questionnaire
    var imgLeft = document.getElementById('img-left');
    var imgRight = document.getElementById('img-right');
    var radio = document.getElementById('radio-listener');

    function chgImg(el) {
        if (el.type != 'radio') {
            return false
        }

        img = imgRight;
        if (el.name == 'left') {img = imgLeft;}

        img.src = '/images/questionnaire/'+el.dataset.img+'.svg'
        img.nextElementSibling.textContent = el.dataset.txt
    }


</script>
