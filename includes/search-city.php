<?php

require_once("dbvillecontroller.php");

$db_handle = new DBController();

if(!empty($_POST["keyword"])) {

  $query ="SELECT * FROM ville WHERE nom like '" . $_POST["keyword"] . "%' ORDER BY nom LIMIT 0,5";
  $result = $db_handle->runQuery($query);

  if(!empty($result)) {
    ?>
    <ul id="country-list">
      <?php
      foreach($result as $ville) {
        ?>
        <li onClick="selectCity('<?php echo $ville["nom"]; ?>', '<?php echo $ville["id"]; ?>');"><?php echo $ville["nom"]; ?></li>
      <?php } ?>
    </ul>
  <?php
  }
}
?>
