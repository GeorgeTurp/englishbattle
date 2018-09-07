<?php

require_once 'includes/dbconnect.php';

$email = $password = $first = $last = $city = $cityId = $confirm_password = "";
$email_err = $password_err = $first_err = $last_err = $city_err = $level_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Veuillez renseigner une adresse email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM joueur WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "Cette adresse email est déjà utilisée.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Il y a eu un problème, veuillez réessayer plus tard.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = "Veuillez renseigner un mot de passe.";
    } elseif(strlen(trim($_POST['password'])) <= 3) {
        $password_err = "Votre mot de passe doit contenir au moins 3 caractères.";
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = 'Veuillez confirmer votre mot de passe.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Les deux mots de passe ne correspondent pas.';
        }
    }

    // Validate last
    if (empty(trim($_POST['last']))) {
        $last_err = "Veuillez renseigner votre nom de famille.";
    }  else {
        $last = trim($_POST['last']);
    }

    // Validate first
    if (empty(trim($_POST['first']))) {
        $first_err = "Veuillez renseigner votre prénom.";
    }  else {
        $first = trim($_POST['first']);
    }

    // Validate first
    if (empty(trim($_POST['city']))) {
        $city_err = "Veuillez renseigner une ville.";
    }  else {
        $city = trim($_POST['city']);
    }

    // Validate first
    if (empty(trim($_POST['cityId']))) {
        $cityId_err = "Veuillez renseigner une ville.";
    }  else {
        $cityId = trim($_POST['cityId']);
    }

    // Validate first
    if (empty(trim($_POST['level']))) {
        $level_err = "Veuillez renseigner un niveau.";
    }  else {
        $level = trim($_POST['level']);
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($last_err) && empty($first_err) && empty($city_err) && empty($level_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO joueur (email, motDePasse, nom, prenom, idVille, niveau) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_email, $param_password, $param_last, $param_first, $param_cityId, $param_level);

            // Set parameters
            $param_email = $email;
            $param_password = $password;
            $param_last = $last;
            $param_first = $first;
            $param_cityId = $cityId;
            $param_level = $level;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
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
  <title>English Battle - Inscription</title>
  <?php include 'includes/head.php'; ?>
</head>
<body class="register-page">
  <div class="content-wrapper">
    <h1 class="website-title">English Battle</h1>
    <h2 class="register-title">Inscrivez-vous</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="form-group form-group-inline register-form-group">
        <label for="last">Nom :</label>
        <input class="form-input" type="text" id="last" name="last" value="<?php echo $last; ?>">
        <span class="help-block"><?php echo $last_err; ?></span>
      </div>
      <div class="form-group form-group-inline register-form-group">
        <label for="first">Prenom :</label>
        <input class="form-input" type="text" id="first" name="first" value="<?php echo $first; ?>">
        <span class="help-block"><?php echo $first_err; ?></span>
      </div>
      <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" class="form-input" value="<?php echo $email; ?>">
        <span class="help-block"><?php echo $email_err; ?></span>
      </div>
      <div class="form-group">
      <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" class="form-input" value="<?php echo $password; ?>">
        <span class="help-block"><?php echo $password_err; ?></span>
      </div>
      <div class="form-group">
      <label for="confirm_password">Confirmez votre mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" class="form-input" value="<?php echo $confirm_password; ?>">
        <span class="help-block"><?php echo $confirm_password_err; ?></span>
      </div>
      <div class="form-group">
        <div class="frmSearch">
          <label for="search-box">Ville :</label>
        	<input type="text" name="city" class="form-input" id="search-box" value="<?php echo $city; ?>" placeholder="Ne pas utiliser l'autocomplétion du navigateur..." autocomplete="new-field"/>
        	<input type="hidden" name="cityId" id="search-box-city-id" value="<?php echo $cityId; ?>"/>
          <span class="help-block"><?php echo $city_err; ?></span>
          <div id="suggestion-box"></div>
        </div>
      </div>
      <div class="form-group">
        <label for="level">Niveau :</label>
        <select class="form-input" id="level" name="level">
          <option value=""></option>
          <option value="débutant">Débutant</option>
          <option value="intermédiaire">Intermédiaire</option>
          <option value="expert">Expert</option>
        </select>
        <span class="help-block"><?php echo $level_err; ?></span>
      </div>
      <div class="btn-register-container">
        <input type="submit" class="btn btn-success login-btn" value="Inscription">
      </div>
      <p class="existing-account">Vous avez déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    </form>
  </div>
  <?php include 'includes/body-scripts.php'; ?>
</body>
</html>
