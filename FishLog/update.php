<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$species = $weight = $length = $date_caught = "";
$id_err = $species_err = $weight_err = $length_err = $date_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

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
        $sql = "UPDATE fishinfo.fish SET species=?, weight=?, length=?, date_caught=? WHERE id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sddsi", $param_species, $param_weight, $param_length, $param_date, $param_id);

            // Set parameters           
            $param_species = $species;
            $param_weight = $weight;
            $param_length = $length;
            $param_date = $date_caught;
            $param_id = $id;


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updates successfully. Redirect to landing page
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

} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM fish WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $species = $row["species"];
                    $weight = $row["weight"];
                    $length = $row["length"];
                    $date_caught = $row["date_caught"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();

                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                            <span class="invalid-feedback"><?php echo $species_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Weight (lbs. oz)</label>
                            <input type="text" name="weight"
                                class="form-control <?php echo (!empty($weight_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $weight; ?>">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


</html>