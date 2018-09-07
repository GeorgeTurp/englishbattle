<?php
  require_once 'includes/dbconnect.php';
  include 'includes/isloggedin.php';
  $urlScores = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
<?php
  if (strpos($urlScores,'scores') !== false) {
    ?>
    <!DOCTYPE>
    <html>
    <head>
      <title>English Battle - Mes scores</title>
      <?php include 'includes/head.php'; ?>
    </head>
    <body class="scores-page">
      <?php include 'includes/nav.php' ?>
      <h1 class="scores-title">Mes scores</h1>
      <div class="scores-wrapper">
        <table>
          <thead>
            <tr>
              <th></th>
              <th>Score</th>
            </tr>
          </thead>
          <tbody>
              <?php

                $sql="SELECT partie.id AS id, partie.idJoueur, partie.score AS score, joueur.id, joueur.email AS email FROM partie LEFT JOIN joueur ON partie.idJoueur=joueur.id WHERE email='$email' ORDER BY score DESC";
                $query=mysqli_query($link, $sql);
                $i=1;

                while ($row=mysqli_fetch_assoc($query)) {
                    $idPartie[$i] = $row['id'];
                    $score[$i] = $row['score'];
                    $i++;

                    echo $score[$i];
                }

                for ($i = 1; $i <= count($idPartie); $i++) {
                  if ($idPartie[$i] != null && $score[$i] != null) {
                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>$score[$i]</td>";
                    echo "</tr>";
                  }
                }

              ?>
          </tbody>
        </table>
      </div>
      <?php include 'includes/body-scripts.php'; ?>
    </body>
    </html>
  <?php
} else {
  header("Location: index.php");
}
?>
