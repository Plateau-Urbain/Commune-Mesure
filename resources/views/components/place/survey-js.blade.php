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

    function surveyPlace(select){

    }

    function flashingBox(id){
      var illustrationContract = document.getElementById(id);
      illustrationContract.style.border = 'solid 1em  #e85048';
      illustrationContract.style.padding = '5px';
      illustrationContract.style.transition = 'border-width 0.6s linear';

      illustrationContract.style.animation = 'blinker 2s cubic-bezier(.5, 0, 1, 1) infinite alternate';
    }

    function flashingOffBox(id){
      var illustrationContract = document.getElementById(id);
      illustrationContract.style.border = null;
      illustrationContract.style.animation = null;
    }



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

    window.onload = (event) => {//TODO move in index.js
        radio.onchange = (event) => {
            for (var target = event.target; target && target != this; target = target.parentNode) {
                if (target.matches('input[type=radio]')) {
                    chgImg(target)
                    break
                }
            }
        }
        var contract = document.getElementById("contract");
        contract.addEventListener("mouseover", flashingBox.bind(null, "illustration-contract"));
        contract.addEventListener("mouseout", flashingOffBox.bind(null, "illustration-contract"));

        var owner = document.getElementById("owner");
        owner.addEventListener("mouseover", flashingBox.bind(null, "illustration-contract"));
        owner.addEventListener("mouseout", flashingOffBox.bind(null, "illustration-contract"));

        var budgetYear = document.getElementById("budget-year");
        budgetYear.addEventListener("mouseover", flashingBox.bind(null, "budget-value-illustration-detail"));
        budgetYear.addEventListener("mouseout", flashingOffBox.bind(null, "budget-value-illustration-detail"));

        var budgetTotal = document.getElementById("budget-total");
        budgetTotal.addEventListener("mouseover", flashingBox.bind(null, "budget-value-illustration-detail"));
        budgetTotal.addEventListener("mouseout", flashingOffBox.bind(null, "budget-value-illustration-detail"));

        var budgetFund = document.getElementById("budget-fund");
        budgetFund.addEventListener("mouseover", flashingBox.bind(null, "budget-fund-illustration-detail"));
        budgetFund.addEventListener("mouseout", flashingOffBox.bind(null, "budget-fund-illustration-detail"));
    }
</script>
