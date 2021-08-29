<?php

// Include config file
require_once "config.php";
 
$zi_licitatie = $zi_licitatie_err = "";
$luna_licitatie = $luna_licitatie_err = "";
$pret_dat = $pret_dat_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate zi licitatie
    if(empty(trim($_POST["zi_licitatie"]))){
        $zi_licitatie_err = "Introduceti ziua licitatiei dupa care sa inceapa cautarea.";     
    }else{
        $zi_licitatie = trim($_POST["zi_licitatie"]);
    }
    // validate luna licitatie
    if(empty(trim($_POST["luna_licitatie"]))){
        $luna_licitatie_err = "Introduceti luna licitatiei dupa care sa inceapa cautarea.";     
    }else{
        $luna_licitatie = trim($_POST["luna_licitatie"]);
    }
    // validate pret de pornire
    if(empty(trim($_POST["pret_dat"]))){
        $pret_dat_err = "Introduceti pretul de pornire dupa care sa inceapa cautarea.";     
    }else{
        $pret_dat = trim($_POST["pret_dat"]);
    }
    // Check input errors before inserting in database
    if(empty($zi_licitatie_err) && empty($luna_licitatie_err) && empty($pret_dat_err)){
        
        /* Afiseaza nr. de licitatii care au loc in luna aleasa sau in ziua aleasa pentru telefoane cu pretul de pornire in lei, care este mai mic decat o valaore aleasa si afiseaza media preturilor licitate pentru aceste telefoane */
        
        $sql = "SELECT COUNT(plt.LicitatieID) AS NrLicitatii, AVG(plt.PretLicitat) AS MediaSumeLicitate
                FROM licitatie l INNER JOIN participare_licitatie_tel plt ON l.LicitatieID = plt.LicitatieID
                                 INNER JOIN telefon t ON plt.TelefonID = t.TelefonID
                                 INNER JOIN pret_start ps ON t.PretID = ps.PretID
                WHERE (MONTH(l.DataLicitatie) = '$luna_licitatie' OR DAY(l.DataLicitatie) = '$zi_licitatie') AND ps.TipMoneda = 'lei' 
                AND ps.ValoarePret < '$pret_dat'
                GROUP BY plt.LicitatieID";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial>";
                    echo "<tr align=center>";
                        echo "<th align=center>[ NrLicitatii ] [ </th>";
                        echo "<th align=center> MediaSumeLicitate ] </th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial font-size=16px>";
                        echo "<td align=center>" . $row['NrLicitatii'] . "</td>";
                        echo "<td align=center>" . $row['MediaSumeLicitate'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "Nu s-au gasit licitatii/telefoane care respecta cautarea!";
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
    <title>Adaugati ziua, luna si pretul ales</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 16px monospace;
            background-image: url('https://www.xmple.com/wallpaper/white-green-gradient-linear-1920x1080-c2-8fbc8f-ffffff-a-270-f-14.svg');
         }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper" style="width:300px; margin:0 auto;">
        <h2><b>Adaugati ziua, luna si pretul ales pentru cautare</b></h2>
        <p><i>Afiseaza nr. de licitatii care au loc in luna aleasa sau in ziua aleasa pentru telefoane cu pretul de pornire in lei, care este mai mic decat o valaore aleasa si afiseaza media preturilor licitate pentru aceste telefoane.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($zi_licitatie_err)) ? 'has-error' : ''; ?>">
                <label>Ziua aleasa (1-31)<label>
                <input type="number" name="zi_licitatie" class="form-control" value="<?php echo $zi_licitatie; ?>">
                <span class="help-block"><?php echo $zi_licitatie_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($luna_licitatie_err)) ? 'has-error' : ''; ?>">
                <label>Luna aleasa (1-12)<label>
                <input type="number" name="luna_licitatie" class="form-control" value="<?php echo $luna_licitatie; ?>">
                <span class="help-block"><?php echo $luna_licitatie_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($pret_dat_err)) ? 'has-error' : ''; ?>">
                <label>Pret ales (in lei)<label>
                <input type="number" name="pret_dat" class="form-control" value="<?php echo $pret_dat; ?>">
                <span class="help-block"><?php echo $pret_dat_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>