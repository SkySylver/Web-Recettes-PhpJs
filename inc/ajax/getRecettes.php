<?php
    require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/Donnees.inc.php';

if(isset($_POST['cat'])){
	$cat = $_POST['cat'];
    echo '<div class="row">';
  //Si la categorie est Hierarchie on affiche tout
	if($cat == 'Hierarchie'){
      traiterHierarchie($Recettes);
    }
    else{
      $trouve = traiterRecette($cat, $Recettes);
        if(!$trouve){
          $ing = getIngredients($cat, $Hierarchie);
          traiterIngredients($ing, $Recettes);
        }
    }
    echo '</div>';

}

// Traite le cas où l'utilisateur a cliqué sur le bouton Hierarchie
function traiterHierarchie($Recettes){
  foreach ($Recettes as $r){
      $newTitre = str_replace(' ', '_', $r['titre']) .'.jpg';
      ?>
      <div class="border border-primary rounded px-1 text-center offset-md-1 col-3 mr-auto">
          <p class="h3"><?=$r['titre'];?></p>
          <p class="p">Ingredients : <?=$r['ingredients']; ?></p>
          <p>Preparation : <?=$r['preparation']; ?></p>
          <?php if(file_exists('../img/Photos/'.$newTitre)) {
            echo '<img src="inc/img/Photos/' .$newTitre .'"/>';
          }?>
      </div>
      <?php
  }
}

// Traite le cas où la recherche est une recette
function traiterRecette($recette, $Recettes){
  foreach($Recettes as $r){
    if($r['titre']==$recette){
      afficherCodeHTML($r);
      return true;
    }
  }
  return false;
}

// Renvoie les ingrédients d'une catégorie
function getIngredients($cat, $Hierarchie){
	$res = array();
  //Si $cat n'est pas un tableau, alors c'est un ingrédient
	if(!isset($Hierarchie[$cat]['sous-categorie'])){
		return array($cat);
	}else{//Sinon c'est une categorie
		foreach(($Hierarchie[$cat]['sous-categorie']) as $sousCat){
			$res = array_merge($res, getIngredients($sousCat, $Hierarchie));
		}
	}
	return $res;
}

// Traite le cas où la recherche est un ingrédient
function traiterIngredients($ing, $Recettes){
  foreach($ing as $i){
      foreach ($Recettes as $r){
          if(in_array($i, $r['index'])){
              afficherCodeHTML($r);
          }
      }
  }
}

//Affiche le code HTML de présentation d'une recette
function afficherCodeHTML($r){
  $newTitre = str_replace(' ', '_', $r['titre']) .'.jpg';
  ?>
  <div class="border border-primary rounded px-1 text-center col-3 ">
      <p class="h3"><?=$r['titre'];?></p>
      <p class="p">Ingredients : <?=$r['ingredients']; ?></p>
      <p>Preparation : <?=$r['preparation']; ?></p>
      <?php if(file_exists('../img/Photos/'.$newTitre)) {
        echo '<img src="inc/img/Photos/' .$newTitre .'"/>';
      }?>
  </div>
  <?php
}
