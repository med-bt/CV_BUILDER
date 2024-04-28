
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <title>register</title>
</head>
<body>
<div class= "container d-flex justify-content-center align-items-center vh-100" style="width:80%">
<form action="register.php" method="post">
  <div class="form-group">
    <h1 class="container text-center mb-5">S'ENREGISTRER</h1>
    <label for="exampleInputEmail1">Adresse email</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">votre informations sont securises.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">mot de pass</label>
    <input name="pass1" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">  
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">valider le mot de pass</label>
    <input name="pass2" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">  
  </div>
  <div style="display: flex;">
    <button type="submit" class="btn btn-primary">Envoyer</button>
  </div>
</form>
</div>
    
</body>
</html>
<?php
include "connectdb.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value);
}
$email = $_POST['email'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
if ($pass1 != $pass2) {
    echo "<h3>Mot de passe invalide</h3>";
} else {
    $result = mysqli_query($conn, "SELECT email FROM utilisateur WHERE email = '$email'");
    if (mysqli_num_rows($result) > 0) {
        echo "<h3>email deja existant</h3>";
    } else {
        $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
        $random_id = rand(1, 99999999999);
        $query = "INSERT INTO utilisateur (id,email, password) VALUES ($random_id,'$email', '$hashed_password')"; 
        if (mysqli_query($conn, $query)) {
            echo "<h3>Registration successful</h3>";
            header("location:index.php?signup=success");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
}
$conn->close();

?>