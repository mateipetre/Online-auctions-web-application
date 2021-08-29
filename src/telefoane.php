<?php

// Include config file
require_once "config.php";
 
// afiseaza toatele telefoanele puse pe site 

$sql = "SELECT TelefonID, NumeModel, Culoare, Procesor, MemorieExterna, MemorieRAM, DimensiuneEcran, Greutate, AnulProducerii, NumeProducator, ValoarePret, TipMoneda FROM telefon t INNER JOIN producator p ON t.ProducatorID = p.ProducatorID
                                                        INNER JOIN pret_start ps ON t.PretID = ps.PretID ";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table align=center font=Arial>";
            echo "<tr align=center>";
                echo "<th align=center>[ TelefonID ] [</th>";
                echo "<th align=center>NumeModel ] </th>";
                echo "<th align=center>[ Culoare ] [ </th>";
                echo "<th align=center>Procesor ] </th>";
                echo "<th align=center>[ MemorieExterna ] [  </th>";
                echo "<th align=center>MemorieRAM ] [  </th>";
                echo "<th align=center>DimensiuneEcran ] [  </th>";
                echo "<th align=center>Greutate ] [  </th>";
                echo "<th align=center>AnulProducerii ] [ </th>";
                echo "<th align=center>Producator ] [  </th>";
                echo "<th align=center>PretPornire ] [</th>";
                echo "<th align=center>TipMoneda ]</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr align=center>";
                echo "<td align=center>" . $row['TelefonID'] . "</td>";
                echo "<td align=center>" . $row['NumeModel'] . "</td>";
                echo "<td align=center>" . $row['Culoare'] . "</td>";
                echo "<td align=center>" . $row['Procesor'] . "</td>";
                echo "<td align=center>" . $row['MemorieExterna'] . "</td>";
                echo "<td align=center>" . $row['MemorieRAM'] . "</td>";
                echo "<td align=center>" . $row['DimensiuneEcran'] . "</td>";
                echo "<td align=center>" . $row['Greutate'] . "</td>";
                echo "<td align=center>" . $row['AnulProducerii'] . "</td>";
                echo "<td align=center>" . $row['NumeProducator'] . "</td>";
                echo "<td align=center>" . $row['ValoarePret'] . "</td>";
                echo "<td align=center>" . $row['TipMoneda'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
        
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<style>
* {box-sizing: border-box;}

body {
  margin: 50px;
  font-family: Arial, Helvetica, sans-serif;
   text-align: center;
   background-image: url('https://wallpapercave.com/wp/wp3306977.jpg');
}

.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #2196F3;
  color: white;
}

.topnav .search-container {
  float: right;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px 10px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
</style>
</head>
<body>
<div class="page-header">
  <h2>Telefoane puse la licitatie pe site</h2>
  <p>
        <a href="welcome_admin.php" class="btn btn-warning">Inapoi la pagina principala</a>
    </p> 
</div>
</body>
</html>