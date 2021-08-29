<?php

// porneste conexiunea cu baza de date
require_once "config.php";

$current_date = date('Y-m-d H:i:s');

// sterge licitatiile care nu mai sunt active
$sql = "DELETE FROM licitatie WHERE DataLicitatie < '$current_date'";

// directioneaza catre toate licitatiile
if (mysqli_query($link, $sql)) {
  session_destroy();
  header("location: licitatii.php");
} else {
  echo "Error deleting record: " . mysqli_error($link);
}
// inchide conexiunea cu baza de date
mysqli_close($link);
?>