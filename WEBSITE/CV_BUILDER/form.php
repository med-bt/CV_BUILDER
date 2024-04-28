<?php
include 'connectdb.php';

$user_id= $_GET['id'];
$query = "SELECT id, name FROM langues";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $langues = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $langues[] = $row;
    }
} else {
    $langues = array();}
$query = "SELECT id, name FROM cert_provid";
$result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $providers = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $providers[] = $row;
        }
    } else {
        $providers = array();
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <title>Form</title>
</head>
<body>
    <div class="container m-5 p-5" style="background-color:#d3d3d3">
        <h1 class="text-center">CV constructeur</h1>
        <p class="text-center">Remplissez les champs ci-dessous avec vos informations</p>
        <form action="process.php" method="post" enctype="multipart/form-data" class="form-group container">
            <div class="form-group">
                <h2>Informations personnelles :</h2>
                <label class="form-label" for="lname">Le nom:</label><input class="form-control" type="text" name="nom" id="lname" required><br>
                <label for="fname">Le prénom:</label><input class="form-control" type="text" name="prenom" id="fname" required><br>
                <label for="situation">La situation:</label><input class="form-control" type="text" name="situation" id="situation" required><br>
                <label for="image">Image :</label><input class="form-control" type="file" name="image" id="image" enctype="multipart/form-data" accept="image/*" class="form-control form-control-lg m-3 container" required><br>
            </div>
            <div>
                <h2>Contact :</h2>
                <label for="photo">Numéro WhatsApp :</label><input class="form-control" type="tel" name="whatsapp" id="whatsapp" pattern="[0-9]{10}" placeholder="Enter a 10-digit phone number" required><br>
                <label for="photo">Email :</label><input class="form-control" type="email" name="email" id="email"><br>
                <label for="photo">Linkedin :</label><input class="form-control" type="text" name="linkedin" id="linkedin"><br>
            </div>
            <div>
                <h2>À propos de moi :</h2>
                <label for="about"></label><textarea class="form-control" name="about" id="about" cols="30" rows="10"></textarea>
            </div>
            <div>
                <h2>Formation Académique</h2>
                <div id="formation-container">
                    <div class="formation-entry">
                        <label for="formation_description1">Description :</label>
                        <input type="text" name="formation[1][description]" id="formation_description1" required>
                        <label for="formation_etablissement1">Établissement :</label>
                        <input type="text" name="formation[1][etablissement]" id="formation_etablissement1" required>
                        <label for="formation_date_debut1">Date de début :</label>
                        <input type="date" name="formation[1][date_debut]" id="formation_date_debut1" required>
                        <label for="formation_date_fin1">Date de fin :</label>
                        <input type="date" name="formation[1][date_fin]" id="formation_date_fin1" required>
                    </div>
                </div>
                <button type="button" onclick="ajouterFormation()">Ajouter Formation</button>
            </div>
            <div>
                <h2>Les compétences</h2>
                <div id="skillsContainer">  
                    <div class="skillEntry">
                        <label for="skill">Compétence :</label>
                        <input class="form-control" style="width : 50%;" type="text" name="skills[][skill]" required>
                        <button class="btn-primary" type="button" onclick="addSubskill(this)">Ajouter Sous-compétence</button>
                        <div class="subskills"></div>
                    </div>
                </div>
                <button type="button" onclick="addSkill()">Ajouter Compétence</button>
            </div>
            <div id="certification-container">
                <h2>Les certifications</h2>
                <div class="certification">
                    <label for="certif1">Certification :</label>
                    <input type="text" name="certifs[1][certif]" id="certif1" required>
                    <label for="platform1">Plateforme :</label>
                    <input type="text" name="certifs[1][platform]" id="platform1" required>
                    <label for="date_recu1">Date de réception :</label>
                    <input type="date" name="certifs[1][date_recu]" id="date_recu1" required>
                    <label for="provider1">Fournisseur :</label>
                    <select name="certifs[1][provider]" id="provider1" required>
                        <?php
                        foreach ($providers as $provider) {
                            echo '<option value="' . $provider['id'] . '">' . $provider['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="button" onclick="ajouterCertif()">Ajouter Certif</button>
            <br>  
            <div>
                <h2>Les Langues</h2>
                <?php
                foreach ($langues as $langue) {
                    echo '<input type="checkbox" name="langues[]" value="' . $langue['id'] . '"> ' . $langue['name'] . '<br>';
                }
                ?>
            </div>
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id, ENT_QUOTES); ?>">
            <br><input type="submit" name="submit" class="btn-primary">
        </form>
    </div>
    <script>
      function addSubskill(button) {
    var skillEntry = button.closest('.skillEntry');
    var subskillsDiv = skillEntry.querySelector('.subskills');

    var subskillInput = document.createElement('input');
    subskillInput.type = 'text';
    subskillInput.name = 'skills[' + skillsCount + '][subskills][]';
    subskillInput.required = true;

    subskillsDiv.appendChild(subskillInput);
}

function addSkill() {
    var newSkillEntry = document.querySelector('.skillEntry').cloneNode(true);
    newSkillEntry.querySelector('input').value = '';
    var subskillsDiv = newSkillEntry.querySelector('.subskills');
    subskillsDiv.innerHTML = '';

    var skillsContainer = document.getElementById('skillsContainer');
    skillsContainer.appendChild(newSkillEntry);
    skillsCount++;
}

var skillsCount = 0;
let certifCount = 1;

function ajouterCertif() {
    certifCount++;

    const container = document.getElementById('certification-container');
    const nouvelleCertif = document.createElement('div');
    nouvelleCertif.className = 'certification';

    nouvelleCertif.innerHTML = `
        <label for="certif${certifCount}">Certification:</label>
        <input type="text" name="certifs[${certifCount}][certif]" id="certif${certifCount}" required>
        <label for="platform${certifCount}">Plateforme:</label>
        <input type="text" name="certifs[${certifCount}][platform]" id="platform${certifCount}" required>
        <label for="date_recu${certifCount}">Date de réception:</label>
        <input type="date" name="certifs[${certifCount}][date_recu]" id="date_recu${certifCount}" required>
        <label for="provider${certifCount}">Fournisseur:</label>
        <select name="certifs[${certifCount}][provider]" id="provider${certifCount}" required>
            <?php
            foreach ($providers as $provider) {
                echo '<option value="' . $provider['id'] . '">' . $provider['name'] . '</option>';
            }
            ?>
        </select>
    `;

    container.appendChild(nouvelleCertif);
}

let formationCount = 1;

function ajouterFormation() {
    formationCount++;

    const container = document.getElementById('formation-container');
    const nouvelleFormation = document.createElement('div');
    nouvelleFormation.className = 'formation-entry';

    nouvelleFormation.innerHTML = `
        <label for="formation_description${formationCount}">Description:</label>
        <input type="text" name="formation[${formationCount}][description]" id="formation_description${formationCount}" required>
        <label for="formation_etablissement${formationCount}">Établissement:</label>
        <input type="text" name="formation[${formationCount}][etablissement]" id="formation_etablissement${formationCount}" required>
        <label for="formation_date_debut${formationCount}">Date de début:</label>
        <input type="date" name="formation[${formationCount}][date_debut]" id="formation_date_debut${formationCount}" required>
        <label for="formation_date_fin${formationCount}">Date de fin:</label>
        <input type="date" name="formation[${formationCount}][date_fin]" id="formation_date_fin${formationCount}" required>
    `;

    container.appendChild(nouvelleFormation);
}
    </script>
</body>
</html>
