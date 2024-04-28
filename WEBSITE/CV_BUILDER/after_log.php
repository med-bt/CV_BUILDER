<?php
if (isset($_GET['login']) && $_GET['login'] === 'success') {
  echo "<h3 class='text-center alert-success'>Bienvenue sur CV builder:</h3>";
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <title>CV BUILDER</title>
</head>
<body>
     <div class="container mt-5" style="width:50%">
     <button class="btn btn-primary btn-lg btn-block">
            <?php 
              $user_id = $_GET['id'];
              echo "<a href='form.php&id={$user_id}' class='btn btn-primary btn-lg btn-block' style='color: white; text-decoration: none;'>Remplir le formulaire</a>";
          ?>
    </button>
    <button class="btn btn-secondary btn-lg btn-block" disabled>
            <a href="" style="color: white; text-decoration: none;">afficher le CV</a>
    </button>
    </div>

    
</body>
</html>