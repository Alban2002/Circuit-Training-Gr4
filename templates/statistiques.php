<?php

$BDD_host="localhost";
$BDD_user="root";
$BDD_password="";
$BDD_base="grp4_circuit_training"; // nom de la base de données


$db = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);

$userID = $_SESSION['idUser'];
// Requête SQL
$sql = "SELECT COUNT(*) AS total_seances, SUM(statut_seance = 'fait') AS seances_effectuees FROM attribution_seance WHERE ID_user = $userID AND statut_seance != 'a faire' ";
$result = $db->query($sql);

if ($result) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalSeances = $row['total_seances'];
    $seancesEffectuees = $row['seances_effectuees'];

    // Calcul des pourcentages des séances effectuées
    $pourcentage = ($seancesEffectuees / $totalSeances) * 100;
} else {
    echo "Erreur lors de l'exécution de la requête : " . $db->error;
}
?>

<html>

<head>
    <title>Statistiques des séances</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Statistiques des séances</h1>
    <canvas id="graphique-seances" style="width: 400px; height: 400px;"></canvas>

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
            responsive: false
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

</body>
</html>
