// Script pour créer les graphiques des covoiturages
// On recupere l'element canvas
const graph = document.getElementById('myChart');
// On recupere les donnees de l'API
fetch('index.php?controller=api&action=getGraphData')
    .then(response => response.json())
    .then(data => {
        // On appelle la fonction createChart avec les donnees recuperees
        createChart(data, 'bar')
    })

// Fonction pour creer le graphique
function createChart(charData, chartType) {
    const dateGainQuantityData = charData[0] // Les datas pour le jour, la quantité et les gains journaliers
    const totalGains = charData[1] // le nombre total de crédit gagné par la plateforme
    let dates = dateGainQuantityData.map(data => data.jour) // Les dates des covoiturages
    let numberOfCovoiturages = dateGainQuantityData.map(data => data.nb_trajets) // Les quantites de covoiturages
    let gains = dateGainQuantityData.map(data => data.gain) // Les gains par jour selon la participation aux covoiturages
    const isMobile = window.innerWidth <= 768 // Pour savoir si on est sur mobile ou pas
    // On cree le graphique avec Chart.js
    new Chart(graph, {
        type: chartType,
        data: {
            labels: dates,
            datasets: [{
                label: 'Nombre de covoiturages par jour',
                data: numberOfCovoiturages,
                backgroundColor: '#0163AC',
                borderWidth: 1
            }, {
                label: 'Nombre de credits gagnes par jour',
                data: gains, // Pour calculer les credits gagnes par jour
                backgroundColor: '#EDE42C',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Important pour le responsive
            scales: {
                x: {
                    // Pour faire tourner les labels sur l'axe des x en mode responsive
                    ticks: {
                        maxRotation: isMobile ? 90 : 45,
                        minRotation: isMobile ? 45 : 0,
                        font: { // Pour changer la taille de la police en monde responsive
                            size: isMobile ? 10 : 12
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    // Pour faire tourner les labels sur l'axe des y en mode responsive
                    ticks: {
                        font: {
                            size: isMobile ? 10 : 12
                        }
                    }
                }
            },
            // Le texte qui explique les couleurs des barres
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: isMobile ? 10 : 12
                        }
                    }
                },
                // Pour ajouter un sous-titre avec le nombre des crédits gagnés par la plateforme
                subtitle: {
                    display: true,
                    text: 'Nombre total de crédit gagné = ' + totalGains,
                    color: 'black',
                    padding : 8,
                    font: {
                      size: isMobile ? 12 : 15,
                      weight: 'bold',
                    },
                  }
            
            }
        }
    })

}