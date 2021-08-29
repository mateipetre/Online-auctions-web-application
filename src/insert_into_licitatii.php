<?php

// porneste conexiunea cu baza de date
require_once "config.php";
 
// variabile initializate cu valori nule 
$tip_licitatie = $tip_licitatie_err = "";
$data_licitatie = $data_licitatie_err = "";
$durata_licitatie = $durata_licitatie_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Valideaza tip licitatie
    if(empty(trim($_POST["tip_licitatie"]))){
        $tip_licitatie_err = "Introduceti tipul licitatiei.";     
    }else{
        $tip_licitatie = trim($_POST["tip_licitatie"]);
    }
    // Valideaza data licitatie
    if(empty(trim($_POST["data_licitatie"]))){
        $data_licitatie_err = "Introduceti data la care are loc licitatia.";     
    }else{
        $data_licitatie = trim($_POST["data_licitatie"]);
    }
    // Valideaza durata licitatie
    if(empty(trim($_POST["durata_licitatie"]))){
        $durata_licitatie_err = "Introduceti durata licitatiei in minute.";     
    }else{
        $durata_licitatie = trim($_POST["durata_licitatie"]);
    }
    // Check input errors before inserting in database
    if(empty($tip_licitatie_err) && empty($data_licitatie_err) && empty($durata_licitatie_err)){
        
        // insereaza o licitatie cu valorile introduse de catre utilizator pt campuri

        $sql = "INSERT INTO licitatie (TipLicitatie, DataLicitatie, DurataLicitatie) VALUES ('$tip_licitatie', '$data_licitatie', '$durata_licitatie')";
        
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_tip_licitatie, $param_data_licitatie, $param_durata_licitatie);
            
            // Set parameters
            $param_tip_licitatie = $tip_licitatie;
            $param_data_licitatie = $data_licitatie;
            $param_durata_licitatie = $durata_licitatie;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to licitatii page
                header("location: licitatii.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adaugati licitatie</title>
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
        <h2><b>Adaugati licitatie</b></h2>
        <p><i>Completati fiecare camp pentru a crea o licitatie noua pe site.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($tip_licitatie_err)) ? 'has-error' : ''; ?>">
                <label>Tipul licitatiei</label>
                <input type="text" name="tip_licitatie" class="form-control" value="<?php echo $tip_licitatie; ?>">
                <span class="help-block"><?php echo $tip_licitatie_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($data_licitatie_err)) ? 'has-error' : ''; ?>">
                <label>Data licitatiei</label>
                <input type="datetime-local" name="data_licitatie" class="form-control" value="<?php echo $data_licitatie; ?>">
                <span class="help-block"><?php echo $data_licitatie_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($durata_licitatie_err)) ? 'has-error' : ''; ?>">
                <label>Durata licitatie (in minute)</label>
                <input type="number" name="durata_licitatie" class="form-control" value="<?php echo $durata_licitatie; ?>">
                <span class="help-block"><?php echo $durata_licitatie_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Doriti sa vedeti licitatiile active pe site? <a href="licitatii.php">Apasati aici.</p>
        </form>
    </div>    
</body>
</html>