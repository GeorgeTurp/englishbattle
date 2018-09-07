<?php

require_once 'dbconnect.php';

$idPartie = (int) $_POST['idPartie'];
$idVerbe = (int) $_POST['idVerbe'];
$reponsePreterit = $_POST['reponsePreterit'];
$reponseParticipePasse = $_POST['reponseParticipePasse'];
$dateEnvoi = $_POST['dateEnvoi'];
$dateReponse = $_POST['dateReponse'];

$sql="INSERT INTO question (idPartie, idVerbe, reponsePreterit, reponseParticipePasse, dateEnvoi, dateReponse) VALUES ('$idPartie', '$idVerbe', '$reponsePreterit', '$reponseParticipePasse', '$dateEnvoi', '$dateReponse')";
$query=mysqli_query($link, $sql);


?>
