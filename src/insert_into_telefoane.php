<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nume_model = $nume_model_err = "";
$culoare = $culoare_err = "";
$procesor = $procesor_err = "";
$memorie_externa = $memorie_externa_err = "";
$memorie_ram = $memorie_ram_err = "";
$dimensiune_ecran = $dimensiune_ecran_err = "";
$greutate = $greutate_err = "";
$anul_producerii = $anul_producerii_err = "";
$producator_id = $producator_id_err = "";
$pret_id = $pret_id_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate nume model telefon
    if(empty(trim($_POST["nume_model"]))){
        $nume_model_err = "Introduceti numele modelului de telefon.";     
    }else{
        $nume_model = trim($_POST["nume_model"]);
    }
    // Validate culoare tel
    if(empty(trim($_POST["culoare"]))){
        $culoare_err = "Introduceti culoarea telefonului.";     
    }else{
        $culoare = trim($_POST["culoare"]);
    }
    // Validate procesor tel
    if(empty(trim($_POST["procesor"]))){
        $procesor_err = "Introduceti tipul de procesor.";     
    }else{
        $procesor = trim($_POST["procesor"]);
    }
    // Validate memorie externa tel
    if(empty(trim($_POST["memorie_externa"]))){
        $memorie_externa_err = "Introduceti dimensiunea memoriei externe in GB.";     
    }else{
        $memorie_externa = trim($_POST["memorie_externa"]);
    }
    // Validate memorie ram tel
    if(empty(trim($_POST["memorie_ram"]))){
        $memorie_ram_err = "Introduceti dimensiunea memoriei RAM in GB.";     
    }else{
        $memorie_ram = trim($_POST["memorie_ram"]);
    }
    // Validate dimensiune ecran tel
    if(empty(trim($_POST["dimensiune_ecran"]))){
        $dimensiune_ecran_err = "Introduceti dimensiunea ecranului in inchi.";     
    }else{
        $dimensiune_ecran = trim($_POST["dimensiune_ecran"]);
    }
    // validate greutate tel
    if(empty(trim($_POST["greutate"]))){
        $greutate_err = "Introduceti greutatea telefonului in grame.";     
    }else{
        $greutate = trim($_POST["greutate"]);
    }
    //validate anul producerii tel
    if(empty(trim($_POST["anul_producerii"]))){
        $anul_producerii_err = "Introduceti anul producerii telefonului.";     
    }else{
        $anul_producerii = trim($_POST["anul_producerii"]);
    }
    // validate id-ul producatorului pt tel
    if(empty(trim($_POST["producator_id"]))){
        $producator_id_err = "Introduceti producatorul dupa id, conform listei cu producatori impliciti.";     
    }else{
        $producator_id = trim($_POST["producator_id"]);
    }
    // validate id-ul pretului de pornire pt tel
    if(empty(trim($_POST["pret_id"]))){
        $pret_id_err = "Introduceti pretul de pornire dupa id, conform listei cu preturi implicite.";     
    }else{
        $pret_id = trim($_POST["pret_id"]);
    }
    // Check input errors before inserting in database
    if(empty($nume_model_err) && empty($culoare_err) && empty($procesor_err) && empty($memorie_externa_err) && empty($memorie_ram_err) && empty($dimensiune_ecran_err) && empty($greutate_err) && empty($anul_producerii_err) && empty($producator_id_err) && empty($pret_id_err)){
        
        // insereaza un telefon cu valorile introduse de catre utilizator pt campuri
        
        $sql = "INSERT INTO telefon (NumeModel, Culoare, Procesor, MemorieExterna, MemorieRAM, DimensiuneEcran, Greutate, AnulProducerii, ProducatorID, PretID) VALUES ('$nume_model', '$culoare', '$procesor', '$memorie_externa', '$memorie_ram', '$dimensiune_ecran', '$greutate', '$anul_producerii', '$producator_id', '$pret_id')";
   
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_nume_model, $param_culoare, $param_memorie_externa, $param_memorie_ram, $param_dimensiune_ecran, $param_greutate, $param_anul_producerii, $param_producator_id, $param_pret_id);
            
            // Set parameters
            $param_nume_model = $nume_model;
            $param_culoare  = $culoare;
            $param_memorie_externa = $memorie_externa;
            $param_memorie_ram = $memorie_ram;
            $param_dimensiune_ecran = $dimensiune_ecran;
            $param_greutate = $greutate;
            $param_anul_producerii = $anul_producerii;
            $param_producator_id  = $producator_id;
            $param_pret_id = $pret_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to licitatii page
                header("location: telefoane.php");
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
    <title>Adaugati telefon</title>
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
        <h2><b>Adaugati telefon</b></h2>
        <p><i>Completati fiecare camp pentru a adauga un telefon nou pe site.</i></p>
        <p><i>Puteti consulta producatorii si preturile de start disponibile pe acest site dupa ID <a href="producatori_si_preturi_start.php" class="btn btn-success">aici</a></i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($nume_model_err)) ? 'has-error' : ''; ?>">
                <label>Nume model</label>
                <input type="text" name="nume_model" class="form-control" value="<?php echo $nume_model; ?>">
                <span class="help-block"><?php echo $nume_model_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($culoare_err)) ? 'has-error' : ''; ?>">
                <label>Culoare</label>
                <input type="text" name="culoare" class="form-control" value="<?php echo $culoare; ?>">
                <span class="help-block"><?php echo $culoare_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($procesor_err)) ? 'has-error' : ''; ?>">
                <label>Procesor</label>
                <input type="text" name="procesor" class="form-control" value="<?php echo $procesor; ?>">
                <span class="help-block"><?php echo $procesor_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($memorie_externa_err)) ? 'has-error' : ''; ?>">
                <label>Memorie externa (GB)</label>
                <input type="number" name="memorie_externa" class="form-control" value="<?php echo $memorie_externa; ?>">
                <span class="help-block"><?php echo $memorie_externa_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($memorie_ram_err)) ? 'has-error' : ''; ?>">
                <label>Memorie RAM (GB)</label>
                <input type="number" step="0.1" name="memorie_ram" class="form-control" value="<?php echo $memorie_ram; ?>">
                <span class="help-block"><?php echo $memorie_ram_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($dimensiune_ecran_err)) ? 'has-error' : ''; ?>">
                <label>Dimensiune ecran (inchi)</label>
                <input type="number" step="0.1" name="dimensiune_ecran" class="form-control" value="<?php echo $dimensiune_ecran; ?>">
                <span class="help-block"><?php echo $dimensiune_ecran_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($greutate_err)) ? 'has-error' : ''; ?>">
                <label>Greutate (grame)</label>
                <input type="number" name="greutate" class="form-control" value="<?php echo $greutate; ?>">
                <span class="help-block"><?php echo $greutate_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($anul_producerii_err)) ? 'has-error' : ''; ?>">
                <label>Anul producerii<label>
                <input type="number" name="anul_producerii" class="form-control" value="<?php echo $anul_producerii; ?>">
                <span class="help-block"><?php echo $anul_producerii_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($producator_id_err)) ? 'has-error' : ''; ?>">
                <label>Producator (ales dupa ID-urile din lista)<label>
                <input type="number" name="producator_id" class="form-control" value="<?php echo $producator_id; ?>">
                <span class="help-block"><?php echo $producator_id_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($pret_id_err)) ? 'has-error' : ''; ?>">
                <label>Pret de pornire (ales dupa ID-urile din lista)<label>
                <input type="number" name="pret_id" class="form-control" value="<?php echo $pret_id; ?>">
                <span class="help-block"><?php echo $pret_id_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Doriti sa vedeti telefoanele puse la licitatie pe site? <a href="telefoane.php">Apasati aici.</p>
        </form>
    </div>    
</body>
</html>