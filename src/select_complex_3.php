<?php

// Include config file
require_once "config.php";
 
 $an_dat = "";
 $an_dat_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate anul licitatiei
    if(empty(trim($_POST["an_dat"]))){
        $an_dat_err = "Introduceti anul dupa care sa inceapa cautarea.";     
    }else{
        $an_dat = trim($_POST["an_dat"]);
    }
    // Check input errors before inserting in database
    if(empty($an_dat_err)){
        
        /* Afiseaza telefonul/telefoanele pt care media preturilor licitate pt el/ele, in anul ales, este mai mic decat media preturilor de pornire al tuturor telefoanelor de pe site (preturi in euro), al carui/caror producator nu este Allview sau Nokia */

        $sql = "SELECT t.NumeModel, p.NumeProducator, ps.ValoarePret, ps.TipMoneda FROM telefon t INNER JOIN producator p
                ON t.ProducatorID = p.ProducatorID
                                                                                                  INNER JOIN pret_start ps
                ON t.PretID = ps.PretID
                                                                                                  INNER JOIN participare_licitatie_tel plt
                ON plt.TelefonID = t.TelefonID                                                    
                                                                                                  INNER JOIN licitatie l
                ON l.LicitatieID = plt.LicitatieID
                WHERE (p.NumeProducator != 'Allview' OR p.NumeProducator != 'Nokia') AND YEAR(l.DataLicitatie) = '$an_dat' 
                AND ps.TipMoneda = 'euro'
                GROUP BY t.NumeModel, p.NumeProducator, ps.ValoarePret, ps.TipMoneda, YEAR(l.DataLicitatie)
                HAVING AVG(plt.PretLicitat) < (SELECT AVG(ps1.ValoarePret) FROM pret_start ps1 WHERE ps1.TipMoneda = 'euro')";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial>";
                    echo "<tr align=center>";
                        echo "<th align=center>[ NumeModel ] [ </th>";
                        echo "<th align=center>NumeProducator ] [  </th>";
                        echo "<th align=center>ValoarePret    ] [  </th>";
                        echo "<th align=center>TipMoneda ]</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial>";
                        echo "<td align=center>" . $row['NumeModel'] . "</td>";
                        echo "<td align=center>" . $row['NumeProducator'] . "</td>";
                        echo "<td align=center>" . $row['ValoarePret'] . "</td>";
                        echo "<td align=center>" . $row['TipMoneda'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "Nu s-a gasit niciun telefon care respecta cautarea!";
            }
        }
        else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        
    } 
} 
    // Close connection
    mysqli_close($link);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adaugati anul</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 16px monospace;
            background-image: url('https://wallpapercave.com/wp/gWML7Jw.jpg');
         }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper" style="width:300px; margin:0 auto;">
        <h2><b>Adaugati un an pentru cautare</b></h2>
        <p><i>Afiseaza telefonul/telefoanele pt care media preturilor licitate pt el/ele, in anul ales, este mai mic decat media preturilor de pornire al tuturor telefoanelor de pe site (preturi in euro), al carui/caror producator nu este Allview sau Nokia.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($an_dat_err)) ? 'has-error' : ''; ?>">
                <label>Anul ales<label>
                <input type="number" name="an_dat" class="form-control" value="<?php echo $an_dat; ?>">
                <span class="help-block"><?php echo $an_dat_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>