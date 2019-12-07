<?php
require $_SERVER["DOCUMENT_ROOT"].'/Projet/class/User.php';
session_start();
if(!(\App\isConnected())) Header('Location:login.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php $title = 'Login'; require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/header.php'; ?>
</head>
<body>

<?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/nav.php'; ?>

<div>
    <h4>Mes informations personnelles</h4>

    <?php
        $usr = $_SESSION['user'];
        echo 'Nom prenom adresse ...';
    ?>
</div>


<div id="Recettes" class="container">
</div>
</body>
</html>
