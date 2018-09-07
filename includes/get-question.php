<?php

require_once 'dbconnect.php';

$sql="SELECT id, baseVerbale, preterit, participePasse, traduction FROM verbe";
$query=mysqli_query($link, $sql);
$i=1;

while($row=mysqli_fetch_assoc($query)) {
    $id[$i] = $row['id'];
    $baseVerbale[$i] = $row['baseVerbale'];
    $preterit[$i] = $row['preterit'];
    $participePasse[$i] = $row['participePasse'];
    $traduction[$i] = $row['traduction'];
    $i++;
}

echo '[';

for ($i = 1; $i <= count($id); $i++) {
    echo '{';
    echo '"id": ' . $id[$i] . ',';
    echo '"baseVerbale": "' . $baseVerbale[$i] . '",';
    echo '"preterit": "' . $preterit[$i] . '",';
    echo '"participePasse": "' . $participePasse[$i] . '",';
    echo '"traduction": "' . $traduction[$i] . '"';
    if ($id[$i] == 161) {
      echo '}';
    } else {
      echo '},';
    }
}

echo ']';

?>
