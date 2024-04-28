<?php
include 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id  = $_POST['user_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $situation = $_POST['situation'];
    $whatsapp = $_POST['whatsapp'];
    $linkedin = $_POST['linkedin'];
    $email = $_POST['email'];
    $about_text = $_POST['about'];
    $formation = $_POST["formation"];
    $skills = $_POST["skills"];
    $langues = $_POST["langues"];
    $certifs = $_POST["certifs"];

    $file_name = $_FILES["image"]["name"];
    $file_size = $_FILES["image"]["size"];
    $file_tmp = $_FILES["image"]["tmp_name"];
    $file_type = $_FILES["image"]["type"];
    $fileExt = explode(".", $file_name);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array("jpg", "jpeg", "png");

    if (in_array($fileActualExt, $allowed)) {
        
        if ($file_size < 1000000) {
            $image_content = file_get_contents($file_tmp);
            $image_content = mysqli_real_escape_string($conn, $image_content);

            $insert_cv_query = "INSERT INTO cv (id_user) VALUES ($user_id)";
            mysqli_query($conn, $insert_cv_query);
            $cv_id = mysqli_insert_id($conn); 

            $insert_info_query = "INSERT INTO info_personnels (nom, prenom, photo, cv_id, situation) 
                                  VALUES ('$nom', '$prenom', '$image_content', $cv_id, '$situation')";
            mysqli_query($conn, $insert_info_query);

            $insert_about_query = "INSERT INTO about (about_text, cv_id) VALUES ('$about_text', $cv_id)";
            mysqli_query($conn, $insert_about_query);

            $insert_contact_query = "INSERT INTO contact (whatsapp, email, linkedin, cv_id) 
                                     VALUES ('$whatsapp', '$email', '$linkedin', $cv_id)";
            mysqli_query($conn, $insert_contact_query);

            foreach ($formation as $form) {
                $description = $form['description'];
                $etablissement = $form['etablissement'];
                $date_debut = $form['date_debut'];
                $date_fin = $form['date_fin'];
                $insert_formation_query = "INSERT INTO formation (description, etablissement, date_debut, date_fin, cv_id) 
                                           VALUES ('$description', '$etablissement', '$date_debut', '$date_fin', $cv_id)";
                mysqli_query($conn, $insert_formation_query);
            }

            foreach ($langues as $lang_id) {
                $insert_lang_query = "INSERT INTO lang_cv (cv_id, lang_id) VALUES ($cv_id, $lang_id)";
                mysqli_query($conn, $insert_lang_query);
            }

            foreach ($certifs as $certif) {
                $name = $certif['certif'];
                $date_recu = $certif['date_recu'];
                $id_provid = $certif['provider'];
                $insert_certif_query = "INSERT INTO certification (name, date_recu, id_provid, cv_id) 
                                        VALUES ('$name', '$date_recu', $id_provid, $cv_id)";
                mysqli_query($conn, $insert_certif_query);
            }

            foreach ($skills as $skill) {
                $competance = $skill['skill'];
                $insert_skill_query = "INSERT INTO competance (competance, cv_id) VALUES ('$competance', $cv_id)";
                mysqli_query($conn, $insert_skill_query);
                $comp_id = mysqli_insert_id($conn); 

                foreach ($skill['subskills'] as $subskill) {
                    $sous_comp = $subskill;
                    $insert_subskill_query = "INSERT INTO sous_competance (sous_comp, comp_id) 
                                              VALUES ('$sous_comp', $comp_id)";
                    mysqli_query($conn, $insert_subskill_query);
                }
            }
            echo "<h3 class='text-center alert-success'>CV information submitted successfully!</h3>";
        } else {
            echo "Your file is too big!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"  href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>
<body>
<form method="post" action="cv_b.php">
    <div class="container d-flex align-items-center justify-content-center" style="height: 50vh;">
        <input class=" btn-secondary btn-lg" type="submit" value="afficher le CV">
    </div>
</form>
</body>
</html>