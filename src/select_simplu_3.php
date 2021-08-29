<?php

// Include config file
require_once "config.php";
 
$pret_dat = $pret_dat_err = "";
$durata_data = $durata_data_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate pret de pornire
    if(empty(trim($_POST["pret_dat"]))){
        $pret_dat_err = "Introduceti pretul dupa care sa inceapa cautarea.";     
    }else{
        $pret_dat = trim($_POST["pret_dat"]);
    }
    // validate durata licitatie
    if(empty(trim($_POST["durata_data"]))){
        $durata_data_err = "Introduceti durata de timp dupa care sa inceapa cautarea.";     
    }else{
        $durata_data = trim($_POST["durata_data"]);
    }
    // Check input errors before inserting in database
    if(empty($pret_dat_err) && empty($durata_data_err)){
        
        /* Afiseaza telefoanele al caror pret de pornire(in lire) este mai mare decat o suma data, la care liciteaza doar 1 participant si suma duratelor licitatiilor la care sunt puse telefoanele este mai mica decat o durata data */
        
        $sql = "SELECT DISTINCT t.NumeModel, t.Culoare, t.Procesor, t.MemorieExterna, t.MemorieRAM, pr.NumeProducator, ps.ValoarePret
                FROM telefon t INNER JOIN pret_start ps ON t.PretID = ps.PretID
                               INNER JOIN participare_licitatie_tel plt ON t.TelefonID = plt.TelefonID
                               INNER JOIN participant p ON plt.ParticipantID = p.ParticipantID
                               INNER JOIN producator pr ON t.ProducatorID = pr.ProducatorID
                               INNER JOIN licitatie l ON plt.LicitatieID = l.LicitatieID
                WHERE ps.TipMoneda = 'lire' AND ps.ValoarePret > '$pret_dat'
                GROUP BY plt.TelefonID, plt.LicitatieID
                HAVING COUNT(plt.ParticipantID) = 1 AND SUM(l.DurataLicitatie) < '$durata_data'";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial>";
                    echo "<tr align=center>";
                        echo "<th align=center>[ NumeModel ] [ </th>";
                        echo "<th align=center> Culoare ] [ </th>";
                        echo "<th align=center> Procesor ] [ </th>";
                        echo "<th align=center> MemorieExterna ] [ </th>";
                        echo "<th align=center> MemorieRAM ] [ </th>";
                        echo "<th align=center> NumeProducator ] [ </th>";
                        echo "<th align=center> ValoarePret ] </th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial font-size=16px>";
                        echo "<td align=center>" . $row['NumeModel'] . "</td>";
                        echo "<td align=center>" . $row['Culoare'] . "</td>";
                        echo "<td align=center>" . $row['Procesor'] . "</td>";
                        echo "<td align=center>" . $row['MemorieExterna'] . "</td>";
                        echo "<td align=center>" . $row['MemorieRAM'] . "</td>";
                        echo "<td align=center>" . $row['NumeProducator'] . "</td>";
                        echo "<td align=center>" . $row['ValoarePret'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "Nu s-au gasit telefoane care respecta cautarea!";
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
    <title>Adaugati pretul si durata</title>
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
        <h2><b>Adaugati pretul si durata pentru cautare</b></h2>
        <p><i>Afiseaza telefoanele al caror pret de pornire(in lire) este mai mare decat o suma data, la care liciteaza doar 1 participant si suma duratelor licitatiilor la care sunt puse telefoanele este mai mica decat o durata data.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($pret_dat_err)) ? 'has-error' : ''; ?>">
                <label>Pretul ales (lire)<label>
                <input type="number" step="0.1" name="pret_dat" class="form-control" value="<?php echo $pret_dat; ?>">
                <span class="help-block"><?php echo $pret_dat_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($durata_data_err)) ? 'has-error' : ''; ?>">
                <label>Durata aleasa (minute)<label>
                <input type="number" name="durata_data" class="form-control" value="<?php echo $durata_data; ?>">
                <span class="help-block"><?php echo $durata_data_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>