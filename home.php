<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <?php $title = 'Accueil'; require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/header.php'; ?>
    <link rel="stylesheet" type="text/css" href="inc/css/home.css"/>
    <script type="text/javascript" src="inc/js/home.js"></script>
</head>
<body>

<?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/nav.php'; ?>

<div id="Chemin" class="ml-4"><span class="btn-chemin">Hierarchie</span>/</div>

<div class="mr-4 row">
    <div id="Aliments" class="col">
        <div>
            <ul id="Categories" class=""></ul>
            <h4 style="color:darkslategray">Recherche par tag:</h4>
            <?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/listesDeroulantes.php'; ?>
            <button type="button" id="btn-rechercheParTag" class="btn btn-dark">Rechercher</button>
        </div>
        <div id="Recettes" class="container">
        </div>
        <div class="mx-auto">
          <?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/barreDeRecherche.php'; ?>
        </div>
    </div>

    <br>
</div>

</body>
</html>
