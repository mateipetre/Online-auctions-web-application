<?php

// Include config file
require_once "config.php";
 
$mem_ext_min = $mem_ext_max= "";
$mem_ext_min_err = $mem_ext_max_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate memorie externa minima
    if(empty(trim($_POST["mem_ext_min"]))){
        $mem_ext_min_err = "Introduceti valoarea minima a memoriei externe dupa care sa inceapa cautarea.";     
    }else{
        $mem_ext_min = trim($_POST["mem_ext_min"]);
    }
    // validate memorie externa maxima
    if(empty(trim($_POST["mem_ext_max"]))){
        $mem_ext_max_err = "Introduceti valoarea maxima a memoriei externe dupa care sa inceapa cautarea.";     
    }else{
        $mem_ext_max = trim($_POST["mem_ext_max"]);
    }
    // Check input errors before inserting in database
    if(empty($mem_ext_min_err) && empty($mem_ext_max_err)){
        
        /* Afiseaza telefoanele pentru care numele tarii de origine al producatorului incepe cu 'S', valoarea memoriei externe nu se afla in intervalul ales de GB si culoarea este verde, ordonate descrescator dupa anul infiintarii firmei producatoare */
        
        $sql = "SELECT t.NumeModel, t.Culoare, t.Procesor, t.MemorieExterna, t.MemorieRAM, pr.NumeProducator, pr.TaraOrigine, pr.AnInfiintare 
                FROM telefon t INNER JOIN producator pr ON t.ProducatorID = pr.ProducatorID
                WHERE pr.TaraOrigine LIKE 'S%' AND (t.MemorieExterna NOT BETWEEN '$mem_ext_min' AND '$mem_ext_max')
                AND t.Culoare = 'verde'
                ORDER BY pr.AnInfiintare DESC";

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
                        echo "<th align=center> TaraOrigine] [</th>";
                        echo "<th align=center> AnInfiintare ]</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr align=center font=Arial font-size=16px>";
                        echo "<td align=center>" . $row['NumeModel'] . "</td>";
                        echo "<td align=center>" . $row['Culoare'] . "</td>";
                        echo "<td align=center>" . $row['Procesor'] . "</td>";
                        echo "<td align=center>" . $row['MemorieExterna'] . "</td>";
                        echo "<td align=center>" . $row['MemorieRAM'] . "</td>";
                        echo "<td align=center>" . $row['NumeProducator'] . "</td>";
                        echo "<td align=center>" . $row['TaraOrigine'] . "</td>";
                        echo "<td align=center>" . $row['AnInfiintare'] . "</td>";
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
    <title>Adaugati valorile maxima si minima pt. memoria externa</title>
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
        <h2><b>Adaugati valoarea minima si maxima a memoriei externe pentru cautare</b></h2>
        <p><i>Afiseaza telefoanele pentru care numele tarii de origine al producatorului incepe cu 'S', valoarea memoriei externe nu se afla in intervalul ales de GB si culoarea este verde, ordonate descrescator dupa anul infiintarii firmei producatoare.</i></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($mem_ext_min_err)) ? 'has-error' : ''; ?>">
                <label>Valoare minima memorie externa (in GB)<label>
                <input type="number" name="mem_ext_min" class="form-control" value="<?php echo $mem_ext_min; ?>">
                <span class="help-block"><?php echo $mem_ext_min_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($mem_ext_max_err)) ? 'has-error' : ''; ?>">
                <label>Valoare maxima memorie externa (in GB)<label>
                <input type="number" name="mem_ext_max" class="form-control" value="<?php echo $mem_ext_max; ?>">
                <span class="help-block"><?php echo $mem_ext_max_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>