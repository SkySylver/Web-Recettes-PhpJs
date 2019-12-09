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

<div class="container mx-auto">
	<div class="row">
		<div id="Aliments" class="col-sm-2">
			<div>
				<div id="Chemin" class="ml-4"><span class="btn-chemin">Hierarchie</span>/</div>
				<div><ul id="Categories" class=""></ul></div>
				<br>
				<h4 style="color:darkslategray">Recherche par tag:</h4>
				<?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/listesDeroulantes.php'; ?>
				<button type="button" id="btn-rechercheParTag" class="btn btn-dark btn-rechercher">Rechercher</button>
			</div>
		</div>
		<div class="col-sm-10">
		  <div class="float-right">
			<?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/barreDeRecherche.php'; ?>
		  </div>
		  <div >
			<div id="Recettes" class="container "></div>
		  </div>
		</div>
	</div>
</div>

</body>
</html>
