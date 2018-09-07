<?php
  require_once 'includes/dbconnect.php';
  include 'includes/isloggedin.php';
  $urlGame = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
<?php
  if (strpos($urlGame,'partie') !== false) {
    ?>
    <!DOCTYPE>
    <html>
    <head>
      <title>English Battle - Fin de partie</title>
      <?php include 'includes/head.php'; ?>
    </head>
    <body class="end-page">
      <?php include 'includes/nav.php' ?>
      <input class="user-id-container" name="userId" type="hidden" value="<?php echo $GLOBALS['userId']; ?>" />
      <input class="game-id-container" name="gameId" type="hidden" value="<?php echo $_GET['partie']; ?>" />
      <div id="achievment-wrapper">
        <i class="fas fa-trophy"></i>
      </div>
      <div class="content-wrapper">
        <h1 class="end-title">Résultats de la partie</h1>
        <?php

        $gameId = $_GET['partie'];

        $sql1="SELECT id, idPartie FROM question WHERE idPartie = $gameId";
        $query1=mysqli_query($link, $sql1);
        $i=0;

        while($row=mysqli_fetch_assoc($query1)) {
            $id[$i] = $row['id'];
            $idPartie[$i] = $row['idPartie'];
            $i++;
        }

        $sql2="SELECT id, score FROM partie WHERE id = $gameId";
        $query2=mysqli_query($link, $sql2);
        $i2=0;

        while($row=mysqli_fetch_assoc($query2)) {
            $id[$i2] = $row['id'];
            $score[$i2] = $row['score'];
            $i2++;
        }

        $gameScore = $score[0]

        ?>
        <div class="end-text-wrapper">
          <p>Bien joué !</p>
          <p>Votre avez obtenu un score de <span class="score-count"><?php echo $gameScore; ?></span></p>
          <p>Avec <span class="score-count"><?php echo $i; ?></span> réponses justes.</p>
        </div>
        <div class="buttons-wrapper">
          <a type="button" class="btn btn-default go-home-btn" href="index.php">Retour à l'accueil</a>
          <button type="button" class="btn btn-success new-game">Rejouer</button>
        </div>
      </div>
      <?php include 'includes/body-scripts.php'; ?>
    </body>
    </html>
  <?php
} else {
  header("Location: index.php");
}
?>
