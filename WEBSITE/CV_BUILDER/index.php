<?php
if (isset($_GET['signup']) && $_GET['signup'] === 'success') {
  echo '<h3 class="text-center">Welcome! You have successfully signed up!</h3>';
}
include "connectdb.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  foreach ($_POST as $key => $value) {
  $_POST[$key] = htmlspecialchars($value);
  }
  $username = $_POST["username"];
  $password = $_POST["password"];
  $login_q = mysqli_query($conn,"select email,password,id from utilisateur where email = '$username'");
  if (mysqli_num_rows($login_q) == 0) {
    echo "<h3 class='text-center alert-danger'> email ou mot de passe invalide </h3>";
  } else {
    $login = mysqli_fetch_row($login_q);
    if(password_verify($password, $login[1]))
    {
     $user_id = $login[2];
     header("location:after_log.php?login=success&id=".urlencode($user_id));
    }
    else{
      echo "<h3 class='text-center alert-danger'> mot de passe invalide <h3>";
    };
  }
  }
  $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <title>welcome</title>
</head>
<body>
<div class= "container d-flex justify-content-center align-items-center vh-100" style="width:80%">
<form action="index.php" method="post">
  <div class="form-group">
    <h1 class="container text-center mb-5">SE CONNECTER</h1>
    <label for="exampleInputEmail1">Adresse email</label>
    <input name="username" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">mot de pass</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
  </div>
  <div style="display: flex;">
    <button type="submit" class="btn btn-primary">envoyer</button>
    <a href="register.php" class="btn btn-secondary ml-auto">s'enregitrer</a>
</div>
</form>
</div>

</body>

</html>