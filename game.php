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
      <title>English Battle - Partie</title>
      <?php include 'includes/head.php'; ?>
    </head>
    <body class="game-page">
      <?php include 'includes/nav.php' ?>
      <input class="user-id-container" name="userId" type="hidden" value="<?php echo $GLOBALS['userId']; ?>" />
      <input class="game-id-container" name="gameId" type="hidden" value="<?php echo $_GET['partie']; ?>" />
      <div class='radialtimer' id='timer'></div>
      <div class="game-wrapper">
        <div class="top-game-wrapper">
          <p class="count-text-container">Question n°<span class="question-count">1</span></p>
          <p class="score-text-container">Score : <span class="score-count">0</span></p>
        </div>
        <p>Le verbe '<span class="loaded-verb-trad-container"></span>'</p>
          <div class="game-verb-container">
            <div class="form-group form-group-inline">
              <input class="form-input input-disabled loaded-verb-bb-container" type="text" id="baseVerbale" name="baseVerbale" value="" placeholder="Base verbale" disabled>
            </div>
            <div class="form-group form-group-inline">
              <input class="form-input" type="text" id="preterit" name="preterit" value="" placeholder="Préterit">
            </div>
            <div class="form-group form-group-inline">
              <input class="form-input" type="text" id="participe-passe" name="participe-passe" value="" placeholder="Participe passé">
            </div>
          </div>
          <div class="buttons-wrapper">
            <button type="button" class="btn btn-danger pass-btn">Passer</button>
            <button type="button" class="btn btn-success validation-btn">Valider</button>
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
