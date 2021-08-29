<?php

// Include config file
require_once "config.php";
 
$nr_participanti = $nr_participanti_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate nr. participanti
    if(empty(trim($_POST["nr_participanti"]))){
        $nr_participanti_err = "Introduceti numarul de participanti dupa care sa inceapa cautarea.";     
    }else{
        $nr_participanti = trim($_POST["nr_participanti"]);
    }
    // Check input errors before inserting in database
    if(empty($nr_participanti_err)){
        
        /* Afiseaza tipul si durata licitatiilor la care participa un nr. ales de utilizatori */
        
        $sql = "SELECT DISTINCT l.TipLicitatie, l.DurataLicitatie, COUNT(plt.ParticipantID) AS NrParticipanti_Licitatie
                FROM licitatie l INNER JOIN participare_licitatie_tel plt ON l.LicitatieID = plt.LicitatieID
                                 INNER JOIN participant p ON plt.ParticipantID = p.ParticipantID
                GROUP BY l.DurataLicitatie, l.TipLicitatie
                HAVING COUNT(plt.ParticipantID) = '$nr_participanti'";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial>";
                    echo "<tr align=center>";
                        echo "<th align=center>[ TipLicitatie ] [ </th>";
                        echo "<th align=center> DurataLicitatie ] [ </th>";
                        echo "<th align=center> NrParticipanti_Licitatie ]</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial font-size=16px>";
                        echo "<td align=center>" . $row['TipLicitatie'] . "</td>";
                        echo "<td align=center>" . $row['DurataLicitatie'] . "</td>";
                        echo "<td align=center>" . $row['NrParticipanti_Licitatie'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "Nu s-au gasit licitatii care respecta cautarea!";
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
    <title>Adaugati nr. participanti</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 16px monospace;
            background-image: url('https://www.teahub.io/photos/full/21-215135_free-bamboo-high-quality-wallpaper-id-nature-green.jpg');
         }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper" style="width:300px; margin:0 auto;">
        <h2><b>Adaugati nr. participanti pentru cautare</b></h2>
        <p><i>Afiseaza tipul si durata licitatiilor la care participa un nr. ales de utilizatori.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($nr_participanti_err)) ? 'has-error' : ''; ?>">
                <label>Nr. participanti<label>
                <input type="number" name="nr_participanti" class="form-control" value="<?php echo $nr_participanti; ?>">
                <span class="help-block"><?php echo $nr_participanti_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>