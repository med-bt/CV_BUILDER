<?php
include 'connectdb.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$situation = $_POST['situation'];
$whatsapp = $_POST['whatsapp'];
$linkedin = $_POST['linkedin'];
$email = $_POST['email'];
$about = $_POST['about'];
$formation  = $_POST["formation"];
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
$id = rand(1, 99999999999);

if (in_array($fileActualExt, $allowed)) {
    if ($file_size < 1000000) { 
        $image_content = file_get_contents($_FILES['image']['tmp_name']);
        $insert_query = "INSERT INTO info_personnels (id, nom, prenom, situation, photo) VALUES ($id, '$nom', '$prenom', '$situation', '$image_content')";

        if (mysqli_query($conn, $insert_query)) {
            echo "Image uploaded successfully!";
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Your file is too big!";
    }
} else {
    echo "You cannot upload files of this type!";
}
?>
// $sql_insert = "insert into info_personnels(id,nom,prenom,situation,photo) VALUES ($id,'$nom','$prenom','$situation','$targetFile')";
// if ($conn->query($sql_insert) === FALSE) {
//     echo "Error: " . $conn->error;
// }

// echo"<br>";
// $sql_insert = "insert into contact (whatsapp,linkedin,email,person_id) VALUES ('$whatsapp','$linkedin','$email','$id')";
// if ($conn->query($sql_insert) === TRUE) {
// } else {
//     echo "Error: " . $conn->error;
// }; 
/*$contact_select = "SELECT * FROM contact WHERE person_id = '$id' ";
$contact = mysqli_query($conn, $contact_select) or die("Error: " . mysqli_error($conn));
if ($contact) {
    $contact = mysqli_fetch_row($contact);
    print_r($contact);
} else {
    echo "Error: " . mysqli_error($conn);
}*/
// $about_insert = "insert into about (about_text,person_id) VALUES ('$about','$id')";
// if ($conn->query($about_insert) === TRUE) {
// } else {
//     echo "Error: " . $conn->error;
// }; 

// foreach($formation as $f)
// {
//     $add_for = "INSERT INTO formations(description,person_id) VALUES ('$f','$id')";
//     if ($conn->query($add_for) === TRUE) {
//     } else {
//         echo "Error: " . $conn->error;
//     };
// }

// foreach($skills as $sk)
// {
//     $add_skill = "INSERT INTO competance(name,person_id) VALUES ('$sk[skill]','$id')";
//     if ($conn->query($add_skill) === TRUE) {
//     } else {
//         echo "Error: " . $conn->error;
//     };
//     $comp_id = mysqli_query($conn,"SELECT id FROM competance where name = '$sk[skill]' and person_id ='$id'");
//     $n_l = mysqli_num_rows($comp_id);
//     $comp_id = mysqli_fetch_all($comp_id);
//     for($i=0;$i<$n_l;$i++)
//     {
//     $id_competance =$comp_id[$i][0] ;
//     foreach($sk['subskills'] as $sub)
//     {
//         $add_sub="INSERT INTO sous_comp(name,comp_id) VALUES ('$sub','$id_competance') ";
//         mysqli_query($conn,$add_sub);
//     };
//     }
// }

// foreach($certifs as $cert)
// {
//     $add_cert = "INSERT INTO certifications(cert_name,cert_platforme,person_id) VALUES ('$cert[certif]','$cert[platform]',$id) ";
//     if ($conn->query($add_cert) === TRUE) {
       
//     } else {
//         echo "Error: " . $conn->error;
//     };
// }
// foreach($langues as $lang)
// {
//     $add_lang = "INSERT INTO languages(langage,person_id) VALUES ('$lang',$id) ";
//     if ($conn->query($add_lang) === TRUE) {
//     } else {
//         echo "Error: " . $conn->error;
//     };
// }
$conn->close();
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
<form method="post" action="cv.php">
    <div class="container d-flex align-items-center justify-content-center" style="height: 50vh;">
        <input class=" btn-secondary btn-lg" type="submit" value="afficher le CV">
    </div>
    <input type="hidden" name="uniqueId" value="<?php echo $id; ?>">
</form>
</body>
</html>