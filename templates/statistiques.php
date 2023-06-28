<?php

session_start();

if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
} else {
    // L'utilisateur n'est pas connecté --> rediriger vers la page de connexion/inscription
}

// Requête SQL
$sql = "SELECT COUNT(*) AS total_seances, SUM(statut_seance = 1) AS seances_effectuees FROM attribution_seance WHERE id_user = $userID AND statut_seance != 0";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $totalSeances = $row['total_seances'];
    $seancesEffectuees = $row['seances_effectuees'];

    // Calcul des pourcentages des séances effectuées
    $pourcentage = ($seancesEffectuees / $totalSeances) * 100;
} else {
    echo "Erreur lors de l'exécution de la requête : " . $conn->error;
}
?>

<html>

<head>
    <title>Statistiques des séances</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Statistiques des séances</h1>
    <canvas id="graphique-seances"></canvas>

    <script>

        var totalSeances = <?php echo $totalSeances; ?>;
        var seancesEffectuees = <?php echo $seancesEffectuees; ?>;
        var pourcentage = <?php echo $pourcentage; ?>;

        // Configurer les données du graph
        var data = {
            labels: ['Séances effectuées', 'Séances non effectuées'],
            datasets: [{
                data: [seancesEffectuees, totalSeances - seancesEffectuees],
                backgroundColor: ['#36A2EB', '#FF6384']
            }]
        };

        var options = {
            responsive: true
        };

        // Graph
        document.write("Nombre total de séances : " + totalSeances + "<br>");
        document.write("Nombre de séances effectuées : " + seancesEffectuees + "<br>");
        document.write("Pourcentage de séances effectuées : " + pourcentage + "%<br>");

        var ctx = document.getElementById('graphique-seances').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });
    </script>

    <?php
    if ($result) {
         // Afficher les statistiques
        echo "Nombre total de séances : " . $totalSeances . "<br>";
        echo "Nombre de séances effectuées : " . $seancesEffectuees . "<br>";
        echo "Pourcentage de séances effectuées : " . $pourcentage . "%";
    } else {
        echo "Erreur lors de la récupération des statistiques.";
    }
    ?>

</body>
</html>
