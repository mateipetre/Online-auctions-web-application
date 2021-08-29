<?php

// Include config file
require_once "config.php";
 
$numar_licitatii = $pret_dat = "";
$numar_licitatii_err = $pret_dat_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate nr. licitatii
    if(empty(trim($_POST["numar_licitatii"]))){
        $numar_licitatii_err = "Introduceti numarul minim de licitatii pentru care sa inceapa cautarea.";     
    }else{
        $numar_licitatii = trim($_POST["numar_licitatii"]);
    }
    // Validate pret de pornire 
    if(empty(trim($_POST["pret_dat"]))){
        $pret_dat_err = "Introduceti pretul minim dupa care sa inceapa cautarea.";     
    }else{
        $pret_dat = trim($_POST["pret_dat"]);
    }
    // Check input errors before inserting in database
    if(empty($numar_licitatii_err) && empty($pret_dat_err)){
        
        /* Afiseaza utilizatorii care participa la cel putin un nr. dat de licitatii in care pretul de pornire al telefoanelor licitate (macar unul) in euro este mai mare decat o suma data (tot in euro) */
        
        $sql = "SELECT p.Nume, p.Prenume, p.NumeUtilizator, COUNT(plt.LicitatieID) AS NrLicitatii FROM participant p 
                INNER JOIN participare_licitatie_tel plt ON p.ParticipantID = plt.ParticipantID
                INNER JOIN licitatie l ON plt.LicitatieID = l.LicitatieID
                WHERE plt.LicitatieID IN (SELECT l1.LicitatieID FROM licitatie l1 INNER JOIN participare_licitatie_tel plt1
                                          ON l1.LicitatieID = plt1.LicitatieID
                                                                                  INNER JOIN telefon t
                                          ON plt1.TelefonID = t.TelefonID
                                                                                  INNER JOIN pret_start ps 
                                          ON t.PretID = ps.PretID
                                          WHERE ps.TipMoneda = 'euro' AND ps.ValoarePret >= '$pret_dat')
                GROUP BY p.Nume, p.Prenume, p.NumeUtilizator
                HAVING COUNT(plt.LicitatieID) >= '$numar_licitatii'";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial font-size=20px>";
                    echo "<tr align=center>";
                        echo "<th align=center>[ NumeParticipant ] [ </th>";
                        echo "<th align=center>PrenumeParticipant ] [  </th>";
                        echo "<th align=center>NumeUtilizator    ] [  </th>";
                        echo "<th align=center>NumarLicitatii ]</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial>";
                        echo "<td align=center>" . $row['Nume'] . "</td>";
                        echo "<td align=center>" . $row['Prenume'] . "</td>";
                        echo "<td align=center>" . $row['NumeUtilizator'] . "</td>";
                        echo "<td align=center>" . $row['NrLicitatii'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "Nu s-a gasit niciun participant care respecta cautarea!";
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
        <h2><b>Adaugati un numar de licitatii si un pret de pornire pentru cautare</b></h2>
        <p><i>Afiseaza utilizatorii care participa la cel putin un nr. dat de licitatii in care pretul de pornire al telefoanelor licitate (macar unul) in euro este mai mare decat o suma data (tot in euro).</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($nume_producator_err)) ? 'has-error' : ''; ?>">
                <label>Nr. licitatii ales<label>
                <input type="number" name="numar_licitatii" class="form-control" value="<?php echo $numar_licitatii; ?>">
                <span class="help-block"><?php echo $numar_licitatii_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($pret_dat_err)) ? 'has-error' : ''; ?>">
                <label>Pretul ales (in euro)<label>
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