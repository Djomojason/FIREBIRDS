<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 170px;
            background-color: #f85206;
            color: rgb(5, 5, 5);
            padding: 10px;
            height: 120vh;
            position: fixed;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background-color: #555;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }
        /* Styles pour les pages spécifiques */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            background-color: #f85206;
            color: rgb(5, 5, 5);
            padding: 10px 0;
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #333;
            color: #fff;
            margin: 10px 0;
            padding: 10px;
            text-align: center;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        .score-form {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .score-form input {
            margin-left: 5px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fonction de chargement du contenu de la page
        function loadContent(page) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', page, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    document.getElementById('content').innerHTML = this.responseText;
                    initContentScripts();
                } else {
                    document.getElementById('content').innerHTML = '<p>Erreur de chargement du contenu.</p>';
                }
            };
            xhr.send();
        }

        // Initialisation des scripts dans le contenu chargé dynamiquement
        function initContentScripts() {
            // Recharger Chart.js si nécessaire
            if (document.querySelector('canvas')) {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                document.body.appendChild(script);
                script.onload = function () {
                    // Initialiser les graphiques après le chargement de Chart.js
                    const scripts = document.getElementById('content').getElementsByTagName('script');
                    for (let script of scripts) {
                        eval(script.innerText);
                    }
                };
            }
        }

        // Gestion des événements de menu
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.sidebar a');
            links.forEach(function (link) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    loadContent(link.getAttribute('href'));
                });
            });
        });

        function afficherMatchs(categorie) {
            window.location.href = "statistique.php?categorie=" + categorie;
        }

        function afficherCourbe(evenements) {
            const ctx = document.getElementById('courbeResultats').getContext('2d');
            const dates = [];
            const scores = [];
            let victoires = 0, nuls = 0, defaites = 0;

            evenements.forEach(evenement => {
                dates.push(evenement.date);
                const score = evenement.score.split('-');
                const scoreEquipe = parseInt(score[0]);
                const scoreAdversaire = parseInt(score[1]);

                if (scoreEquipe > scoreAdversaire) {
                    scores.push(1); // Victoire
                    victoires++;
                } else if (scoreEquipe === scoreAdversaire) {
                    scores.push(0); // Nul
                    nuls++;
                } else {
                    scores.push(-1); // Défaite
                    defaites++;
                }
            });

            const data = {
                labels: dates,
                datasets: [{
                    label: 'Résultats',
                    data: scores,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            };
            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Courbe d\'évolution des résultats'
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Résultat'
                            },
                            ticks: {
                                callback: function(value) {
                                    if (value === 1) return 'Victoire';
                                    if (value === 0) return 'Nul';
                                    if (value === -1) return 'Défaite';
                                }
                            }
                        }
                    }
                }
            };
            new Chart(ctx, config);

            const totalMatchs = victoires + nuls + defaites;
            const pourcentageVictoires = totalMatchs ? (victoires / totalMatchs) * 100 : 0;
            const pourcentageNuls = totalMatchs ? (nuls / totalMatchs) * 100 : 0;
            const pourcentageDefaites = totalMatchs ? (defaites / totalMatchs) * 100 : 0;

            document.getElementById('pourcentageVictoires').innerText = 'Pourcentage de Victoires: ' + pourcentageVictoires.toFixed(2) + '%';
            document.getElementById('pourcentageNuls').innerText = 'Pourcentage de Nuls: ' + pourcentageNuls.toFixed(2) + '%';
            document.getElementById('pourcentageDefaites').innerText = 'Pourcentage de Défaites: ' + pourcentageDefaites.toFixed(2) + '%';
        }

        function confirmerSuppression(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet événement?")) {
                window.location.href = "supprimer_evenement.php?id=" + id;
            }
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <a href="index.php">Accueil</a>
        <a href="joueurs.php">Joueurs</a>
        <a href="calendrier.php">Calendrier</a>
        <a href="statistique.php">Statistique</a>
        <a href="finance.php">Finance</a>
    </div>
    <div class="content" id="content">
        <h1>Bienvenue</h1>
        <p>Sélectionnez une rubrique dans le menu pour afficher le contenu ici.</p>
    </div>
</body>
</html>
