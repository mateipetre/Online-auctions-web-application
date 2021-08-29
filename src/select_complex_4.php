<?php

// Include config file
require_once "config.php";
 
 $durata = "";
 $durata_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate durata licitatie
    if(empty(trim($_POST["durata"]))){
        $durata_err = "Introduceti durata in minute dupa care sa inceapa cautarea.";     
    }else{
        $durata = trim($_POST["durata"]);
    }
    // Check input errors before inserting in database
    if(empty($durata_err)){
        
        /* Afiseaza licitatiile care dureaza mai putin de un nr. dat de minute, pt care participantii contin in email domeniul 'gmail' si au licitat macar pentru un telefon cu inca 10% in plus pe langa pretul maxim de pornire in lei */

        $sql = "SELECT l1.LicitatieID, l1.TipLicitatie, l1.DataLicitatie, l1.DurataLicitatie 
                FROM licitatie l1 WHERE l1.DurataLicitatie < '$durata' 
                AND l1.LicitatieID = (SELECT l.LicitatieID FROM licitatie l
                                      INNER JOIN participare_licitatie_tel plt ON l.LicitatieID = plt.LicitatieID
                                      INNER JOIN participant p ON plt.ParticipantID = p.ParticipantID
                                      INNER JOIN telefon t ON plt.TelefonID = t.TelefonID
                                      WHERE p.Email LIKE '%gmail%' AND
                                      plt.PretLicitat IN (SELECT (MAX(ps.ValoarePret) + 1/10*ps.ValoarePret)
                                                          FROM pret_start ps
                                                          INNER JOIN telefon t1
                                                          ON ps.PretID = t1.PretID
                                                          WHERE ps.TipMoneda = 'lei'
                                                          GROUP BY ps.ValoarePret))";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial>";
                    echo "<tr align=center>";
                        echo "<th align=center>[LicitatieID ] [ </th>";
                        echo "<th align=center>TipLicitatie ] [  </th>";
                        echo "<th align=center>DataLicitatie  ] [ </th>";
                        echo "<th align=center>DurataLicitatie ]</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial>";
                        echo "<td align=center>" . $row['LicitatieID'] . "</td>";
                        echo "<td align=center>" . $row['TipLicitatie'] . "</td>";
                        echo "<td align=center>" . $row['DataLicitatie'] . "</td>";
                        echo "<td align=center>" . $row['DurataLicitatie'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "Nu s-a gasit nicio licitatie care respecta cautarea!";
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
    <title>Adaugati durata</title>
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
        <h2><b>Adaugati durata licitatiei pentru cautare</b></h2>
        <p><i>Afiseaza licitatiile care dureaza mai putin de un nr. dat de minute, pt care participantii contin in email domeniul 'gmail' si au licitat macar pentru un telefon pretul maxim de pornire in lei.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($durata_err)) ? 'has-error' : ''; ?>">
                <label>Durata licitatie (in minute)<label>
                <input type="number" name="durata" class="form-control" value="<?php echo $durata; ?>">
                <span class="help-block"><?php echo $durata_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>