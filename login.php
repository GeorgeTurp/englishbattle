<?php

require_once 'includes/dbconnect.php';

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = 'Veuillez renseigner votre email.';
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['motDePasse']))){
        $password_err = 'Veuillez renseigner votre mot de passe.';
    } else {
        $password = trim($_POST['motDePasse']);
    }

    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT email, motDePasse FROM joueur WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $email, $password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(trim($_POST['motDePasse']) == $password){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['email'] = $email;
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = 'Le mot de passe renseigné n\'est pas valide.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $email_err = 'Aucun compte ne correspond à cette adresse email.';
                }
            } else{
                echo "Il y a eu un problème, veuillez réessayer.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE>
<html>
<head>
  <title>English Battle - Connexion</title>
  <?php include 'includes/head.php'; ?>
</head>
<body class="login-page">
  <div class="content-wrapper">
    <h1 class="website-title">English Battle</h1>
    <h2 class="login-title">Connectez-vous</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group">
              <label for="email">Email :</label>
              <input class="form-input" type="email" id="email" name="email" value="<?php echo $email; ?>">
              <span class="help-block"><?php echo $email_err; ?></span>
          </div>
          <div class="form-group">
              <label for="motDePasse">Mot de passe :</label>
              <input class="form-input" type="password" id="motDePasse" name="motDePasse">
              <span class="help-block"><?php echo $password_err; ?></span>
          </div>
          <button type="submit" class="btn btn-success login-btn">Connexion</button>
          <p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous ici</a>.</p>
        </div>
    </form>
  </div>
  <?php include 'includes/body-scripts.php'; ?>
</body>
</html>
