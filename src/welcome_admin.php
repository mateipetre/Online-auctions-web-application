<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
   text-align: center;
   background-image: url('https://www.azure365pro.com/wp-content/uploads/2012/01/pink-white-free-backgrounds.jpg');
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
   <div class="topnav">
  <a class="active" href="#home">Acasa</a>
  <a href="licitatii.php">Licitatii</a>
  <a href="telefoane.php">Telefoane</a>
  <a href="participanti.php">Participanti licitatii</a>
  <div class="search-container">
    <form action="/action_page.php">
      <input type="text" placeholder="Search..." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>

<div class="page-header">
  <h2>Salut, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. De aici poti face modificari sau cautari.</h2>
  <p>
        <a href="reset-password.php" class="btn btn-warning">UPDATE parola</a>
        <a href="update_data_licitatie.php" class="btn btn-warning">UPDATE data licitatie</a>
    </p> 
  <p>
        <a href="insert_into_licitatii.php" class="btn btn-primary">INSERT licitatie</a>
        <a href="insert_into_telefoane.php" class="btn btn-primary">INSERT telefon</a>
  </p>
  <p>
        <a href="delete_licitatie.php" class="btn btn-success">DELETE licitatie</a>
        <a href="delete_telefon.php" class="btn btn-success">DELETE telefon</a>
  </p>
  <p>
        <a href="select_complex_1.php" class="btn btn-info">SELECT COMPLEX 1 telefon </a>
        <a href="select_complex_2.php" class="btn btn-info">SELECT COMPLEX 2 participant </a>
  </p>
  <p>
        <a href="select_complex_3.php" class="btn btn-info">SELECT COMPLEX 3 telefon </a>
        <a href="select_complex_4.php" class="btn btn-info">SELECT COMPLEX 4 licitatie </a>
  </p>
  <p>
        <a href="select_simplu_1.php" class="btn btn-danger">SELECT SIMPLU 1 durata licitatii </a>
        <a href="select_simplu_2.php" class="btn btn-danger">SELECT SIMPLU 2 participanti </a>
  </p>
  <p>
        <a href="select_simplu_3.php" class="btn btn-danger">SELECT SIMPLU 3 telefoane </a>
        <a href="select_simplu_4.php" class="btn btn-danger">SELECT SIMPLU 4 telefoane </a>
  </p>
  <p>
        <a href="select_simplu_5.php" class="btn btn-danger">SELECT SIMPLU 5 nr_licitatii, medie_preturi_licitate </a>
        <a href="select_simplu_6.php" class="btn btn-danger">SELECT SIMPLU 6 pret_max_licitat, participant </a>
  </p>
  <p>
        <a href="logout.php" class="btn btn-warning">Iesi din cont</a>
  </p>
</div>
</body>
</html>