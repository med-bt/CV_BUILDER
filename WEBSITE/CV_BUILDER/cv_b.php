<?php
include "connectdb.php";
$id = 29;

$personal_q = mysqli_query($conn, "SELECT nom, prenom,situation, photo FROM info_personnels WHERE cv_id=$id");
$personal_inf = mysqli_fetch_assoc($personal_q);
$nom = $personal_inf['nom'];
$prenom = $personal_inf['prenom'];
$situation = $personal_inf['situation'];
$photo = $personal_inf['photo'];


$contact_q = mysqli_query($conn, "SELECT whatsapp, email, linkedin FROM contact WHERE cv_id=$id");
$contact = mysqli_fetch_assoc($contact_q);
$whatsapp = $contact['whatsapp'];
$email = $contact['email'];
$linkedin = $contact['linkedin'];


$about_q = mysqli_query($conn, "SELECT about_text FROM about WHERE cv_id=$id");
$about = mysqli_fetch_assoc($about_q);
$about_txt = $about['about_text'];


$formation_q = mysqli_query($conn, "SELECT description, etablissement, date_debut, date_fin FROM formation WHERE cv_id=$id");
$formations = mysqli_fetch_all($formation_q, MYSQLI_ASSOC);


$certif_q = mysqli_query($conn, "SELECT certification.name, cert_provid.name AS provider_name
                                  FROM certification
                                  INNER JOIN cert_provid ON certification.id_provid = cert_provid.id
                                  WHERE cv_id=$id");
$certifications = mysqli_fetch_all($certif_q, MYSQLI_ASSOC);


$lang_q = mysqli_query($conn, "SELECT langues.name
                               FROM lang_cv
                               INNER JOIN langues ON lang_cv.lang_id = langues.id
                               WHERE cv_id=$id");
$langues = mysqli_fetch_all($lang_q, MYSQLI_ASSOC);


$comp_q = mysqli_query($conn, "SELECT competance, id FROM competance WHERE cv_id=$id");
$competences = mysqli_fetch_all($comp_q, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cv.css">
</head>
<body>
    <div class="container"> 
        <div class="droit">
            <div class="photo_text">
            <img class="photo" src="data:image/jpeg;base64,".base64_encode($photo) alt="picture">
            <div class="principale">
                <h1><?php echo $nom . " " . $prenom ;?></h1>
            </div>
            </div>
            <h1 class="section">Contact</h1>
            <div class="icons">    
                <a target="_blank" href="https://<?php echo $email ?>"><img src="images/email.png" alt="email icon" class="small_icon"></a>
                <a target="_blank" href="https://<?php echo $linkedin ?>"><img src="images/linkedin.png" alt="linkedin icon" class="small_icon"></a>
                <a target="_blank" href="https://wa.me/<?php echo $whatsapp ?>"><img src="images/what.png" alt="whatsapp icon" class="small_icon"></a>
            </div>       
        </div>
        <div class="gauche">
            <h1 class="section">À propos de moi</h1>
            <p class="profil"><?php echo $about_txt ?></p>
            <h1 class="section">Formation Académique</h1>
            <ul>
                <?php foreach ($formations as $formation): ?>
                    <li><?php echo $formation['description'] . ' - ' . $formation['etablissement'] . ' (' . $formation['date_debut'] . ' - ' . $formation['date_fin'] . ')' ?></li>
                <?php endforeach; ?>
            </ul>
            <h1 class="section">Compétences</h1>
            <?php foreach ($competences as $competence): ?>
                <p class="comp"><?php echo $competence['competance'] ?>:</p>
                <div class="competence">
                    <ul>
                        <?php 
                        $comp_id = $competence['id'];
                        $sous_q = mysqli_query($conn, "SELECT sous_comp FROM sous_competance WHERE comp_id = $comp_id");
                        $sous_comp = mysqli_fetch_all($sous_q, MYSQLI_ASSOC);
                        foreach ($sous_comp as $sous): ?>
                            <li><?php echo $sous['sous_comp'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <img class="icon" src="images/images.png" alt="networking icon">
                </div>
            <?php endforeach; ?>

            <h1 class="section">Certifications</h1>
            <?php foreach ($certifications as $certification): ?>
                <div class="competence">
                    <h3><?php echo $certification['name'] ?> par <?php echo $certification['provider_name'] ?></h3>
                    <img class="icon" src="images/ibm-vector.jpg" alt="logo">
                </div>
            <?php endforeach; ?>

            <h1 class="section">Langues</h1>
            <div class="competence">
                <ul>
                    <?php foreach ($langues as $langue): ?>
                        <li><?php echo $langue['name'] ?></li>
                    <?php endforeach; ?>
                </ul>
                <img class="icon" src="images/langues.png" alt="icon langages">
            </div>
        </div>    
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
