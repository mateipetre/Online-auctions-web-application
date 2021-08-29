<?php

// Include config file
require_once "config.php";
 
// afiseaza toti utilizatorii de pe site
$sql = "SELECT * FROM participant";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table align=center font=Arial>";
            echo "<tr align=center>";
                echo "<th align=center>[ ParticipantID ] [</th>";
                echo "<th align=center>Nume ] [ </th>";
                echo "<th align=center>Prenume ] [ </th>";
                echo "<th align=center> CNP ] </th>";
                echo "<th align=center>[ NumarTelefon ] [  </th>";
                echo "<th align=center> NumeUtilizator ] [</th>";
                echo "<th align=center>Email ]</th>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr align=center>";
                echo "<td align=center>" . $row['ParticipantID'] . "</td>";
                echo "<td align=center>" . $row['Nume'] . "</td>";
                echo "<td align=center>" . $row['Prenume'] . "</td>";
                echo "<td align=center>" . $row['CNP'] . "</td>";
                echo "<td align=center>" . $row['NumarTelefon'] . "</td>";
                echo "<td align=center>" . $row['NumeUtilizator'] . "</td>";
                echo "<td align=center>" . $row['Email'] . "</td>";
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
   background-image: url('http://pavbca.com/walldb/original/4/6/4/289946.jpg');
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
  <h2>Participanti la licitatii pe site</h2>
  <p>
        <a href="welcome_admin.php" class="btn btn-warning">Inapoi la pagina principala</a>
    </p> 
</div>
</body>
</html>