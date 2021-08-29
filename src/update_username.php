<?php

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$old_username = $new_username = "";
$old_username_err = $new_username_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // valideaza vechiul username
    if(empty(trim($_POST["old_username"]))){
        $old_username_err = "Introduceti numele de utilizator vechi.";     
    }else{
        $old_username = trim($_POST["old_username"]);
    }
    // valideaza noul username
    if(empty(trim($_POST["new_username"]))){
        $new_username_err = "Introduceti numele de utilizator nou.";     
    }else{
        $new_username = trim($_POST["new_username"]);
    }
        
    // Check input errors before updating the database
    if(empty($old_username_err) && empty($new_username_err)){

        // schimba username-ul unui utilizator, identificat dupa vechiul username
        
        $sql = "UPDATE participant SET NumeUtilizator = '$new_username' WHERE NumeUtilizator = '$old_username'";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_old_username, $param_new_username);
            
            // Set parameters
            $param_old_username = $old_username;
            $param_new_username = $new_username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: participanti.php");
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
    <title>Schimba numele de utilizator al unui participant</title>
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
        <h2>Schimba numele de utilizator al unui participant</h2>
        <p><i>Completati urmatoarele campuri pentru a schimba numele de utilizator.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($old_username_err)) ? 'has-error' : ''; ?>">
                <label>Nume vechi utilizator</label>
                <input type="text" name="old_username" class="form-control" value="<?php echo $old_username; ?>">
                <span class="help-block"><?php echo $old_username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_username_err)) ? 'has-error' : ''; ?>">
                <label>Nume nou utilizator</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $new_username; ?>">
                <span class="help-block"><?php echo $new_username_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-danger" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>