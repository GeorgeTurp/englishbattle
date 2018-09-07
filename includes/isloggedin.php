<?php

session_start();

$email=$_SESSION['email'];

$sql="SELECT id, nom, prenom FROM joueur WHERE email='$email'";
$result=mysqli_query($link, $sql);
$i=1;

while($row=mysqli_fetch_assoc($result)) {
    $id[$i] = $row['id'];
    $first[$i] = $row['prenom'];
    $last[$i] = $row['nom'];
    $i++;
}

for ($i = 1; $i <=count($id); $i++) {
    $GLOBALS['userId']=$id[$i];
    $GLOBALS['prenom']=$first[$i];
    $GLOBALS['nom']=$last[$i];
}

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
        header("location: login.php");
}
