<?php
    require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/Donnees.inc.php';
    $MAX = 36; //nb de recettes à afficher max

if(isset($_POST['arrMust']) && isset($_POST['arrMustNot'])){
  // Initalisation du tableau des scores
  $score = array();
  foreach($Recettes as $r){
    $score[$r['titre']] = 0;
  }
  $arrMust=json_decode($_POST['arrMust']);
  $arrMustNot=json_decode($_POST['arrMustNot']);

  foreach ($Recettes as $r) {
    foreach ($arrMust as $i) {
      if(contient($r, $i, $Hierarchie))
        $score[$r['titre']] = $score[$r['titre']] + 1;
      else
        $score[$r['titre']] = $score[$r['titre']] - 1;
    }
    foreach ($arrMustNot as $i) {
      if(!contient($r, $i, $Hierarchie))
        $score[$r['titre']] = $score[$r['titre']] + 1;
      else
        $score[$r['titre']] = $score[$r['titre']] - 1;
    }
  }
  arsort($score);
  $i = 1;
  echo '<div class="row">';
  foreach ($score as $key => $s) {
    if($i>$MAX) break;
    afficherRecette($key, $Recettes);
    $i++;
  }
  echo '</div>';

}

/**
* Renvoie true si la recette $r contient l'ingredient $i
*/
function contient($r, $i, $Hierarchie){
  //tableau des categories peres des ingredients de $r
  $ing = getIngredients($i, $Hierarchie);
  foreach ($r['index'] as $ind) {
    if(in_array($ind, $ing))
      return true;
  }
  return false;
}

/**
* Retourne les ingrédients d'une catégorie
*/
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

/**
* Affiche la recette
*/
function afficherRecette($recette, $Recettes){
  foreach($Recettes as $indice => $r){
    if($r['titre']==$recette){
      afficherCodeHTML($r,$indice);
      return true;
    }
  }
  return false;
}


/**
*Affiche le code HTML de présentation d'une recette
*/
function afficherCodeHTML($r,$i){
  $newTitre = str_replace(' ', '_', $r['titre']) .'.jpg';
  ?>
  <div class="recette col-sm-12 border-top border-primary">
      <p class="h3"><?=$r['titre'];?></p>
      <p class="p">Ingredients : <?=$r['ingredients']; ?></p>
      <p>Preparation : <?=$r['preparation']; ?></p>
      <?php if(file_exists('../img/Photos/'.$newTitre)) {
        echo '<img src="inc/img/Photos/' .$newTitre .'"/>';
      }?>
      <div class="my-1">
          <button class="btn btn-primary" onclick="AjouterPanier(<?= $i?>);">Ajouter</button>
          <button class="btn btn-primary" onclick="SupprimerPanier(<?= $i ?>);">Retirer</button>
      </div>
  </div>
  <?php
}
