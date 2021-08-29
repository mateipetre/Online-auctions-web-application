<?php
// Include config file
require_once "config.php";
 
// afiseaza producatorii de telefoane de pe site in ordine crescatoare dupa ID fara duplicate
$sql1 = "SELECT DISTINCT p.ProducatorID, p.NumeProducator FROM producator p ORDER BY p.ProducatorID";
// afiseaza preturile de pornire ale telefoanelor de pe site in ordine crescatoare dupa ID fara duplicate 
$sql2 = "SELECT DISTINCT ps.PretID, ps.ValoarePret, ps.TipMoneda FROM pret_start ps ORDER BY ps.PretID";
$result = mysqli_query($link, $sql1);
$result1 = mysqli_query($link, $sql2);
if($result != NULL && $result1 != NULL){
    if(mysqli_num_rows($result) > 0 && mysqli_num_rows($result1) > 0){
        echo "<table align=center font=Arial >";
            echo "<tr align=center>";
                echo "<th align=center>[ ProducatorID ] [  </th>";
                echo "<th align=center> NumeProducator ] [  </th>";
                echo "<th align=center> PretID ] </th>";
                echo "<th align=center>[ ValoarePret ] [</th>";
                echo "<th align=center> TipMoneda ] </th>";
            echo "</tr>";
        $row = mysqli_fetch_array($result);
        $row1 = mysqli_fetch_array($result1);
        while($row != NULL || $row1 != NULL){
            echo "<tr align=center>";
                if ($row != NULL) {
                    echo "<td align=center>" . $row['ProducatorID'] . "</td>";
                    echo "<td align=center>" . $row['NumeProducator'] . "</td>";
                }
                if ($row1 != NULL) {
                    echo "<td align=center>" . $row1['PretID'] . "</td>";
                    echo "<td align=center>" . $row1['ValoarePret'] . "</td>";   
                    echo "<td align=center>" . $row1['TipMoneda'] . "</td>";  
                }
            echo "</tr>";
            $row = mysqli_fetch_array($result);
            $row1 = mysqli_fetch_array($result1);
        }

        echo "</table>";
        // Free result set
        mysqli_free_result($result);
        mysqli_free_result($result1);
        
    } else{
        echo "Nu exista producatori sau preturi de start de afisat.";
    }
} else{
    echo "ERROR: Could not able to execute $sql1. " . mysqli_error($link);
}      
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
   background-image: url('http://pavbca.com/walldb/original/5/d/a/289933.jpg');
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
  <h2>Producatori de telefoane si preturi de pornire standard pe site</h2>
  <p>
        <a href="insert_into_telefoane.php" class="btn btn-warning">Inapoi la pagina de adaugare a unui telefon</a>
    </p> 
</div>
</body>
</html>