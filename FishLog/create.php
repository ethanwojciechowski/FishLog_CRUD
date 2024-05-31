<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$species = $weight = $length = $date_caught = "";
$id_err = $species_err = $weight_err = $length_err = $date_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate species
    $input_species = trim($_POST["species"]);
    if (empty($input_species)) {
        $species_err = "Please enter a fish species.";
    } else {
        $species = $input_species;
    }

    // Validate weight
    $input_weight = trim($_POST["weight"]);
    if (empty($input_weight)) {
        $weight_err = "Please enter the weight.";
    } else {
        $weight = $input_weight;
    }

    // Validate length
    $input_length = trim($_POST["length"]);
    if (empty($input_length)) {
        $length_err = "Please enter the length.";
    } else {
        $length = $input_length;
    }

    // Validate date_caught
    $input_dateCaught = trim($_POST["date"]);
    if (empty($input_dateCaught)) {
        $date_err = "Please enter the date caught.";
    } else {
        $date_caught = $input_dateCaught;
    }


    // Check input errors before inserting in database
    if (empty($species_err) && empty($weight_err) && empty($length_err) && empty($date_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO fishinfo.fish (species, weight, length, date_caught) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sdds", $param_species, $param_weight, $param_length, $param_date);

            // Set parameters           
            $param_species = $species;
            $param_weight = $weight;
            $param_length = $length;
            $param_date = $date_caught;


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add a catch record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Species</label>
                            <input type="text" name="species"
                                class="form-control <?php echo (!empty($species_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $species; ?>">
                            <span class="invalid-feedback"><?php echo $speciese_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Weight (lbs. oz)</label>
                            <input type="text" name="weight"
                                class="form-control <?php echo (!empty($weight_err)) ? 'is-invalid' : ''; ?>"><?php echo $weight; ?></input>
                            <span class="invalid-feedback"><?php echo $weight_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Length (in)</label>
                            <input type="text" name="length"
                                class="form-control <?php echo (!empty($length_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $length; ?>">
                            <span class="invalid-feedback"><?php echo $length_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Date Caught</label>
                            <input type="text" name="date"
                                class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $date_caught; ?>">
                            <span class="invalid-feedback"><?php echo $date_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>