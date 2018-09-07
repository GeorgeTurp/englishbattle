<?php
  require_once 'includes/dbconnect.php';
  include 'includes/isloggedin.php';
?>
<!DOCTYPE>
<html>
<head>
  <title>English Battle - Accueil</title>
  <?php include 'includes/head.php'; ?>
</head>
<body class="home-page">
  <input class="user-id-container" name="userId" type="hidden" value="<?php echo $GLOBALS['userId']; ?>" />
  <?php include 'includes/nav.php';?>
  <div class="main-wrapper">
    <h2 class="msg-accueil">Bonjour <?php echo $GLOBALS['prenom']; ?></h2>
  </div>
  <div class="home-wrapper">
    <?php

    $userId = $GLOBALS['userId'];

    $sql="SELECT id, idJoueur, score FROM partie WHERE idJoueur = $userId ORDER BY score DESC LIMIT 0,1";
    $query=mysqli_query($link, $sql);
    $i=0;

    while($row=mysqli_fetch_assoc($query)) {
        $id[$i] = $row['id'];
        $score[$i] = $row['score'];
        $i++;
    }

    $bestScore = $score[0];


    $userId = $GLOBALS['userId'];

    $sql2="SELECT id, idJoueur FROM partie WHERE idJoueur = $userId";
    $query2=mysqli_query($link, $sql2);
    $i=0;

    while($row2=mysqli_fetch_assoc($query2)) {
        $id[$i] = $row2['id'];
        $i++;
    }

    $gameCount = $i;

    ?>
    <div class="home-infos-container">
      <p>Mon meilleur score : <span><?php echo $bestScore; ?></span></p>
      <p><span><?php echo $gameCount; ?></span> parties jouées</p>
    </div>
    <button type="submit" class="btn btn-success new-game">Nouvelle Partie</button>
    <div class="rules-container">
      <h3 class="rules-title">Règles du jeu</h3>
      <p><u>Les règles sont assez simples :</u></p>
      <p>Pour chaque verbe, le jeu vous donne la traduction et la base verbale. Il vous reste donc à trouver le <b>Preterit</b> et le <b>Participe Passé</b> de ce dernier.</p>
      <p>Vous avez <b>120 secondes</b> pour trouver un maximum de réponses.</p>
      <p>Vous ne pouvez pas valider votre réponse tant que le Preterit et le Participe Passé ne sont pas corrects.</p>
      <p>Chaque réponse juste vous rapporte <b>100 points</b>.</p>
      <p>Vous avez la possibilité de passer les verbes pour lesquels vous ne trouvez pas les réponses, cela entraine un malus de <b>-50 points</b>.</p>
    </div>
    <div class="leaderboard-container">
      <h3 class="leaderboard-title">Les meilleurs scores</h3>
      <table>
        <thead>
          <tr>
            <th>Classement</th>
            <th>Joueur</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody>
            <?php

              $sql="SELECT partie.id AS id, partie.idJoueur, partie.score AS score, joueur.id, joueur.nom AS nom, joueur.prenom AS prenom FROM partie INNER JOIN joueur ON partie.idJoueur=joueur.id WHERE score != 'NULL' ORDER BY score DESC";
              $query=mysqli_query($link, $sql);
              $i=1;

              while ($row=mysqli_fetch_assoc($query)) {
                  $idPartie[$i] = $row['id'];
                  $nomJoueur[$i] = $row['nom'];
                  $prenomJoueur[$i] = $row['prenom'];
                  $score[$i] = $row['score'];
                  $i++;

                  echo $score[$i];
              }

              for ($i = 1; $i <= 10; $i++) {
                if ($prenomJoueur[$i] != null) {
                  echo "<tr>";
                  if ($i == 1) {
                    echo "<td class='first-player-rank'><i class='fas fa-trophy first-player-picto'></i> $i</td>";
                  } else {
                    if ($i == 2) {
                      echo "<td class='second-player-rank'><i class='fas fa-trophy second-player-picto'></i> $i</td>";
                    } else {
                      if ($i == 3) {
                        echo "<td class='third-player-rank'><i class='fas fa-trophy third-player-picto'></i> $i</td>";
                      } else {
                        echo "<td>$i</td>";
                      }
                    }
                  }
                  echo "<td>$prenomJoueur[$i] $nomJoueur[$i]</td>";
                  echo "<td>$score[$i]</td>";
                  echo "</tr>";
                }
              }

            ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php include 'includes/body-scripts.php'; ?>
</body>
</html>
