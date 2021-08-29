<?php

// Include config file
require_once "config.php";
 
$nr_telefoane = $nr_telefoane_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate nr. telefoane
    if(empty(trim($_POST["nr_telefoane"]))){
        $nr_telefoane_err = "Introduceti numarul de telefoane dupa care sa inceapa cautarea.";     
    }else{
        $nr_telefoane = trim($_POST["nr_telefoane"]);
    }
    // Check input errors before inserting in database
    if(empty($nr_telefoane_err)){
        
        /* Afiseaza participantii care liciteaza pentru macar un nr. ales de telefoane de la 'Samsung', in ordine descrescatoare dupa nr. de telefoane */

        $sql = "SELECT p.Nume, p.Prenume, p.NumeUtilizator, COUNT(plt.TelefonID) AS NrTelefoane
                FROM participant p INNER JOIN participare_licitatie_tel plt ON p.ParticipantID = plt.ParticipantID
                                   INNER JOIN telefon t ON plt.TelefonID = t.TelefonID
                                   INNER JOIN producator pr ON t.ProducatorID = pr.ProducatorID
                WHERE pr.NumeProducator = 'Samsung'
                GROUP BY p.Nume, p.Prenume, p.NumeUtilizator
                HAVING COUNT(plt.TelefonID) >= '$nr_telefoane'
                ORDER BY COUNT(plt.TelefonID) DESC";

        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table align=center font=Arial>";
                    echo "<tr align=center>";
                        echo "<th align=center>[ NumeParticipant ] [ </th>";
                        echo "<th align=center> PrenumeParticipant ] [ </th>";
                        echo "<th align=center> NumeUtilizator ] [</th>";
                        echo "<th align=center> NrTelefoane ] </th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial font-size=16px>";
                        echo "<td align=center>" . $row['Nume'] . "</td>";
                        echo "<td align=center>" . $row['Prenume'] . "</td>";
                        echo "<td align=center>" . $row['NumeUtilizator'] . "</td>";
                        echo "<td align=center>" . $row['NrTelefoane'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "Nu s-au gasit participanti care respecta cautarea!";
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
    <title>Adaugati nr. telefoane</title>
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
        <h2><b>Adaugati nr. telefoane pentru cautare</b></h2>
        <p><i>Afiseaza participantii care liciteaza pentru macar un nr. ales de telefoane de la 'Samsung', in ordine descrescatoare dupa nr. de telefoane.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($nr_telefoane_err)) ? 'has-error' : ''; ?>">
                <label>Nr. telefoane<label>
                <input type="number" name="nr_telefoane" class="form-control" value="<?php echo $nr_telefoane; ?>">
                <span class="help-block"><?php echo $nr_telefoane_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>