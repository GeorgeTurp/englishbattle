<?php

require_once 'dbconnect.php';

$idPartie = (int) $_POST['idPartie'];
$score = (int) $_POST['score'];

$sql="UPDATE partie SET score='$score' WHERE id=$idPartie";
$query=mysqli_query($link, $sql);


?>
