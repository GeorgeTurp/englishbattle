<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

?>
<nav class="nav-container">
  <ul>
    <li>
    <?php
    if (strpos($url,'game') !== false || strpos($url,'scores') !== false || strpos($url,'end') !== false) {
        echo '<a class="go-back-link" href="index.php">Retour à l\'accueil</a>';
    }
    ?>
    </li>
    <li class="has-submenu">
      <a><?php echo $GLOBALS['prenom'] . " " . $GLOBALS['nom']; ?> <i class="far fa-user-circle"></i></a>
      <div class="sub-menu">
        <ul>
          <li><a href="scores.php">Mes scores</a></li>
          <li><a href="logout.php">Déconnexion</a></li>
        </ul>
      </div>
    </li>
  </ul>
  <span class="game-title">E<span>NGLISH</span> B<span>ATTLE</span></span>
</nav>
