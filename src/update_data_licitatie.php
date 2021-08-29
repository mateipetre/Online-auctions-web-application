<?php

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$id_licitatie = $data_licitatie_noua = "";
$id_licitatie_err = $data_licitatie_noua_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // valideaza id-ul licitatiei
    if(empty(trim($_POST["id_licitatie"]))){
        $id_licitatie_err = "Introduceti licitatia, dupa ID, careia doriti sa-i schimbati data.";     
    }else{
        $id_licitatie = trim($_POST["id_licitatie"]);
    }
    // valideaza data noua a licitatiei
    if(empty(trim($_POST["data_licitatie_noua"]))){
        $data_licitatie_noua_err = "Introduceti noua data in care are loc licitatia aleasa.";     
    }else{
        $data_licitatie_noua = trim($_POST["data_licitatie_noua"]);
    }
        
    // Check input errors before updating the database
    if(empty($id_licitatie_err) && empty($data_licitatie_noua_err)){

        // schimba data unei licitatii aleasa dupa ID

        $sql = "UPDATE licitatie SET DataLicitatie = '$data_licitatie_noua' WHERE LicitatieID = '$id_licitatie'";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_id_licitatie, $param_data_licitatie_noua);
            
            // Set parameters
            $param_data_licitatie_noua = $data_licitatie_noua;
            $param_id_licitatie = $id_licitatie;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: licitatii.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Schimba data unei licitatii</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 16px monospace; 
              background-image: url('https://images8.alphacoders.com/380/380580.png');
        }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper" style="width:300px; margin:100px auto; position: center">
        <h2>Schimba data unei licitatii</h2>
        <p><i>Completati urmatoarele campuri pentru a schimba data in care are loc o anumita licitatie.</i></p>
        <p><i>Puteti consulta licitatiile active dupa ID <a href="licitatii.php" class="btn btn-success">aici</a></i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($id_licitatie_err)) ? 'has-error' : ''; ?>">
                <label>Licitatie (dupa ID)</label>
                <input type="number" name="id_licitatie" class="form-control" value="<?php echo $id_licitatie; ?>">
                <span class="help-block"><?php echo $id_licitatie_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($data_licitatie_noua_err)) ? 'has-error' : ''; ?>">
                <label>Data noua licitatie</label>
                <input type="datetime-local" name="data_licitatie_noua" class="form-control" value="<?php echo $data_licitatie_noua; ?>">
                <span class="help-block"><?php echo $data_licitatie_noua_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-danger" href="welcome_admin.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>