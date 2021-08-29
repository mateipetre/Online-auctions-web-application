<?php

// Include config file
require_once "config.php";
 
$tip_moneda = $tip_moneda_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate tip moneda
    if(empty(trim($_POST["tip_moneda"]))){
        $tip_moneda_err = "Introduceti tipul monedei dupa care sa inceapa cautarea.";     
    }else{
        $tip_moneda = trim($_POST["tip_moneda"]);
    }
    // Check input errors before inserting in database
    if(empty($tip_moneda_err)){
        
        /* Afiseaza suma maxima licitata pe site in moneda aleasa si participantul care a licitat-o */
        
        $sql = "SELECT plt.PretLicitat AS PretMaxLicitat, p.Nume, p.Prenume, p.NumeUtilizator
                FROM participare_licitatie_tel plt INNER JOIN participant p ON plt.ParticipantID = p.ParticipantID
                                                   INNER JOIN licitatie l ON plt.LicitatieID = l.LicitatieID
                                                   INNER JOIN telefon t ON plt.TelefonID = t.TelefonID
                                                   INNER JOIN pret_start ps ON t.PretID = ps.PretID
                WHERE ps.TipMoneda = '$tip_moneda'
                ORDER BY plt.PretLicitat DESC
                LIMIT 1";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial>";
                    echo "<tr align=center>";
                        echo "<th align=center>[ PretMaxLicitat ] [</th>";
                        echo "<th align=center> NumeParticipant ] [</th>";
                        echo "<th align=center> PrenumeParticipant ] [</th>";
                        echo "<th align=center> NumeUtilizator ] </th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial font-size=16px>";
                        echo "<td align=center>" . $row['PretMaxLicitat'] . "</td>";
                        echo "<td align=center>" . $row['Nume'] . "</td>";
                        echo "<td align=center>" . $row['Prenume'] . "</td>";
                        echo "<td align=center>" . $row['NumeUtilizator'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "Nu s-au gasit licitatii/participanti care respecta cautarea!";
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
    <title>Adaugati moneda</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 16px monospace;
            background-image: url('https://www.wallpapertip.com/wmimgs/79-791349_wallpaper-purple-white-background-bright-spots-purple-and.jpg');
         }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper" style="width:300px; margin:0 auto;">
        <h2><b>Adaugati tipul monedei pentru cautare</b></h2>
        <p><i>Afiseaza suma maxima licitata pe site in moneda aleasa si participantul care a licitat-o.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($tip_moneda_err)) ? 'has-error' : ''; ?>">
                <label>Tipul monedei (alegeti intre 'lei', 'euro' si 'lire')<label>
                <input type="text" name="tip_moneda" class="form-control" value="<?php echo $tip_moneda; ?>">
                <span class="help-block"><?php echo $tip_moneda_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>