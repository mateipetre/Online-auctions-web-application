<?php

// porneste conexiunea cu baza de date
require_once "config.php";

// sterge telefoanele de pe site care nu sunt inca puse la licitatie -> nu exista o legatura intre ele si nicio licitatie de pe site
$sql = "DELETE FROM telefon WHERE TelefonID NOT IN (SELECT t1.TelefonID FROM telefon t1 INNER JOIN participare_licitatie_tel plt ON t1.TelefonID = plt.TelefonID INNER JOIN licitatie l ON plt.LicitatieID = l.LicitatieID)";

// directioneaza catre toate telefoanele puse pe site
if (mysqli_query($link, $sql)) {
  session_destroy();
  header("location: telefoane.php");
} else {
  echo "Error deleting record: " . mysqli_error($link);
}
// inchide conexiunea cu baza de date
mysqli_close($link);
?>