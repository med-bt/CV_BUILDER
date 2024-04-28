<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_builder";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$id = $_POST['uniqueId'];

$personal_q = mysqli_query($conn, "SELECT nom, prenom, situation, photo FROM info_personnels WHERE id=$id");
$personal_inf = mysqli_fetch_row($personal_q);
$nom = $personal_inf[0];
$prenom = $personal_inf[1];
$situation = $personal_inf[2];
$photo = $personal_inf[3];

$contact_q = mysqli_query($conn, "SELECT whatsapp, linkedin, email FROM contact WHERE cv_id=$id");
$contact = mysqli_fetch_row($contact_q);
$wtsp = $contact[0];
$linkedin = $contact[1];
$email = $contact[2];

$about_q = mysqli_query($conn, "SELECT about_text FROM about WHERE cv_id=$id");
$about = mysqli_fetch_row($about_q);
$about_txt = $about[0];

$formation_q = mysqli_query($conn, "SELECT description FROM formation WHERE cv_id=$id");
$n = mysqli_num_rows($formation_q);
$formation = mysqli_fetch_all($formation_q);

$certif_q = mysqli_query($conn, "SELECT name, date_recu FROM certification WHERE cv_id=$id");
$n_c = mysqli_num_rows($certif_q);
$certif = mysqli_fetch_all($certif_q);

$lang_q = mysqli_query($conn, "SELECT name FROM langues INNER JOIN lang_cv ON langues.id = lang_cv.lang_id WHERE lang_cv.cv_id=$id");
$n_l = mysqli_num_rows($lang_q);
$lang = mysqli_fetch_all($lang_q);

$comp_q = mysqli_query($conn, "SELECT competance FROM competance WHERE cv_id=$id");
$n_p = mysqli_num_rows($comp_q);
$competances = mysqli_fetch_all($comp_q);

$sous_comp_q = mysqli_query($conn, "SELECT sous_comp FROM sous_competance WHERE comp_id=$id");
$n_s = mysqli_num_rows($sous_comp_q);
$sous_comp = mysqli_fetch_all($sous_comp_q);

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
            <img class="photo"src="<?php echo $photo ?>" alt="picture">
            <div class="principale">
                <h1 ><?php echo $nom . " " . $prenom ;?></h1>
                <h2 ><?php echo $situation ?></h2>
            </div>
            </div>
            <h1 class="section">contact</h1>
            <div class="icons">    
                <a target="_blank" href="https://<?php echo $email ?>.com"><img src="images/email.png" alt="email icon" class="small_icon" ></a>
                <a target="_blank" href="https://<?php echo $linkedin ?>"><img src="images/linkedin.png" alt="linkedin icon" class="small_icon" ></a>
                <a target="_blank" href="https://wa.me/<?php echo $wtsp ?>"><img src="images/what.png" alt="whatsapp icon" class="small_icon" ></a>
            </div>       
        </div>
        <div class="gauche">
            <h1 class="section">à propos de moi</h1>
                <p class="profil"><?php echo $about_txt ?></p>
            <h1 class="section">Formation Academique</h1>
            <ul>
                <?php
                for ($i = 0; $i < $n; $i++) {
                    echo '<li>'.$formation[$i][0].'</li>';
                }
                ?>
            </ul>
            <h1 class="section">Compétences</h1>
            <?php
              for ($i = 0; $i < $n_p; $i++) {
                $compet_name = $competances[$i][0] .'<br>';   
                echo "<p class='comp'>".$compet_name.":"."</p>";
                echo "<div class='competence'>";
                echo "<ul>";
                for ($j = 0; $j < $n_s; $j++) {
                    echo "<li>".$sous_comp[$j][0] ."</li>";
                };
                echo "</ul>";
                echo "<img class='icon' src='images/images.png' alt='networking icon'>";
                echo "</div>";
              }
              
            ?>
            <h1 class="section">certifications</h1>
               <?php
                for ($i = 0; $i < $n_c; $i++) {
                    echo '<div class="competence">';
                    echo '<h3>'.$certif[$i][0].'par '.$certif[$i][1].'</h3>';
                    echo '<img class="icon"src="images/ibm-vector.jpg" alt="logo">';
                    echo '</div>';
                }
                ?>    
            <h1 class="section">Langues</h1>
            <div class="competence">
                <ul>
                <?php
                for ($i = 0; $i < $n_l; $i++) {
                    echo '<li>'.$lang[$i][0].'</li>';
                }
                ?>                
                </ul>
                <img class="icon"src="images/langues.png" alt="icon langages">
            </div>
        </div>    
    </div>
</body>
</html>

<!-- <?php
//     $servername = "localhost";
//     $username = "root";
//     $password = "";
//     $dbname = "cv";
    
//     $conn =new mysqli($servername,$username,$password,$dbname);
//     if ($conn->connect_error) {
//         die("Échec de la connexion à la base de données : " . $conn->connect_error);
//     }
//     $id = $_POST['uniqueId'];
//     $personal_q = mysqli_query($conn,"select nom , prenom ,situation,photo from personal_inf where id=$id");
//     $personal_inf= mysqli_fetch_row($personal_q);
//     $nom = $personal_inf[0];
//     $prenom = $personal_inf[1];
//     $situation = $personal_inf[2];  
//     $photo = $personal_inf[3];  
//     ###############################
//     $contact_q = mysqli_query($conn,"select whatsapp,linkedin,email from contact where person_id=$id ");
//     $contact = mysqli_fetch_row($contact_q);
//     $wtsp = $contact[0];
//     $linkedin = $contact[1];
//     $email = $contact[2];
//     ################################
//     $about_q = mysqli_query($conn,"select about_text from about where person_id=$id ");
//     $about = mysqli_fetch_row($about_q);
//     $about_txt = $about[0];
//     ###############################
//     $about_q = mysqli_query($conn,"select about_text from about where person_id=$id ");
//     $about = mysqli_fetch_row($about_q);
//     $about_txt = $about[0];
//     #################################################
//     $formation_q = mysqli_query($conn,"select description from formations where person_id=$id ");
//     $n = mysqli_num_rows($formation_q);
//     $formation = mysqli_fetch_all($formation_q);
//     ################################################
//     $certif_q = mysqli_query($conn,"select cert_name,cert_platforme from certifications where person_id=$id ");
//     $n_c = mysqli_num_rows($certif_q);
//     $certif = mysqli_fetch_all($certif_q);
//     ################################################
//     $lang_q = mysqli_query($conn,"select langage,person_id from languages where person_id=$id ");
//     $n_l = mysqli_num_rows($lang_q);
//     $lang = mysqli_fetch_all($lang_q);
//     ################################################
//     $comp_q = mysqli_query($conn,"select id,name,person_id from competance where person_id=$id ");
//     $n_p = mysqli_num_rows($comp_q);
//     $competances = mysqli_fetch_all($comp_q);
//     for($i=0;$i<$n_p;$i++)
//     {
//       $compet_name = $competances[$i][1] .'<br>';   
//       $comp_id = $competances[$i][0];
//       $sous_q = mysqli_query($conn,"select name from sous_comp where comp_id = $comp_id");
//       $sous = mysqli_fetch_row($sous_q);
//       $sous_comp_name = $sous[0];
//     }


// ?>
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
            <img class="photo"src=<?php echo $photo?> alt="picture">
            <div class="principale">
                <h1 ><?php echo $nom . " " .$prenom ;?></h1>
                <h2 ><?php echo $situation ?></h2>
            </div>
            </div>
            <h1 class="section">contact</h1>
            <div class="icons">    
                <a target="_blank" href="https://<?php echo $email?>.com"><img src="images/email.png" alt="email icon" class="small_icon" ></a>
                <a target="_blank" href="https://<?php echo $linkedin?>"><img src="images/linkedin.png" alt="linkedin icon" class="small_icon" ></a>
                <a target="_blank" href="https://wa.me/<?php echo $wtsp?>"><img src="images/what.png" alt="whatsapp icon" class="small_icon" ></a>
            </div>       
        </div>
        <div class="gauche">
            <h1 class="section">à propos de moi</h1>
                <p class="profil"><?php echo $about_txt?></p>
            <h1 class="section">Formation Academique</h1>
            <ul>
                <?php
                for($i=0;$i<$n;$i++)
                {
                    echo '<li>'.$formation[$i][0].'</li>';
                }
                ?>
            </ul>
            <h1 class="section">Compétences</h1>
            <?php
              for($i=0;$i<$n_p;$i++)
              {
                $compet_name = $competances[$i][1] .'<br>';   
                echo "<p class='comp'>".$compet_name.":"."</p>";
                echo "<div class='competence'>";
                $comp_id = $competances[$i][0];
                echo "<ul>";
                $sous_q = mysqli_query($conn,"select name from sous_comp where comp_id = $comp_id");
                $n_s =mysqli_num_rows($sous_q);
                $sous = mysqli_fetch_all($sous_q);
                for($j=0;$j<$n_s;$j++)
                {
                    echo "<li>".$sous_comp_name = $sous[$j][0] ."</li>";
                };
                echo "</ul>";
                echo "<img class='icon' src='images/images.png' alt='networking icon'>";
                echo "</div>";
              }
              
            ?>
            <h1 class="section">certifications</h1>
               <?php
                for($i=0;$i<$n_c;$i++)
                {
                    echo'<div class="competence">';
                    echo '<h3>'.$certif[$i][0].'par '.$certif[$i][1].'</h3>';
                    echo '<img class="icon"src="images/ibm-vector.jpg" alt="logo">';
                    echo '</div>';
                }
                ?>    
            <h1 class="section">Langues</h1>
            <div class="competence">
                <ul>
                <?php
                for($i=0;$i<$n_l;$i++)
                {
                    echo '<li>'.$lang[$i][0].'</li>';
                }
                ?>                
                </ul>
                <img class="icon"src="images/langues.png" alt="icon langages">
            </div>
        </div>    
    </div>
</body>
</html> -->