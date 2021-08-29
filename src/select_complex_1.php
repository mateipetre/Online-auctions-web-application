<?php

// Include config file
require_once "config.php";
 
$nume_producator = $pret_dat = "";
$nume_producator_err = $pret_dat_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate nume producator
    if(empty(trim($_POST["nume_producator"]))){
        $nume_producator_err = "Introduceti numele producatorului dupa care sa inceapa cautarea.";     
    }else{
        $nume_producator = trim($_POST["nume_producator"]);
    }
    // Validate pret de pornire 
    if(empty(trim($_POST["pret_dat"]))){
        $pret_dat_err = "Introduceti pretul dupa care sa inceapa cautarea.";     
    }else{
        $pret_dat = trim($_POST["pret_dat"]);
    }
    // Check input errors before inserting in database
    if(empty($nume_producator_err) && empty($pret_dat_err)){
        
        /* Afiseaza telefoanele produse de un anumit producator ales, licitate in lei, al caror pret de pornire este mai mic
        decat un anumit pret ales (tot in lei) */
        
        $sql = "SELECT t.NumeModel, ps.ValoarePret, ps.TipMoneda FROM telefon t INNER JOIN pret_start ps ON t.PretID = ps.PretID
                WHERE ps.TipMoneda = 'lei' AND t.ProducatorID = (SELECT p.ProducatorID FROM producator p 
                                                                 WHERE p.NumeProducator = '$nume_producator')
                AND ps.ValoarePret <= '$pret_dat'
                ORDER BY ps.ValoarePret DESC";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial>";
                    echo "<tr align=center>";
                        echo "<th align=center>[ NumeModel ] [ </th>";
                        echo "<th align=center>ValoarePret ] [  </th>";
                        echo "<th align=center>TipMoneda ]</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial font-size=16px>";
                        echo "<td align=center>" . $row['NumeModel'] . "</td>";
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
    <title>Adaugati producatorul</title>
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
        <h2><b>Adaugati un producator si un pret de pornire pentru cautare</b></h2>
        <p><i>Afiseaza telefoanele produse de un anumit producator ales, licitate in lei, al caror pret de pornire este mai mic
        decat un anumit pret ales (tot in lei).</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($nume_producator_err)) ? 'has-error' : ''; ?>">
                <label>Producator ales<label>
                <input type="text" name="nume_producator" class="form-control" value="<?php echo $nume_producator; ?>">
                <span class="help-block"><?php echo $nume_producator_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($pret_dat_err)) ? 'has-error' : ''; ?>">
                <label>Pretul ales (in lei)<label>
                <input type="number" step="0.1" name="pret_dat" class="form-control" value="<?php echo $pret_dat; ?>">
                <span class="help-block"><?php echo $pret_dat_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>