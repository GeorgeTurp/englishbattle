<?php

require_once 'dbconnect.php';

$userId = $_POST['userId'];

$sql="INSERT INTO partie (idJoueur) VALUES ('$userId')";
$query=mysqli_query($link, $sql);


$sql2="SELECT id FROM partie WHERE idJoueur='$userId' ORDER BY id DESC";
$result=mysqli_query($link, $sql2);
$i=1;

while($row=mysqli_fetch_assoc($result)) {
    $id[$i] = $row['id'];
    $i++;
}

for ($i = 1; $i <= 1; $i++) {
    echo $id[$i];
}

?>
