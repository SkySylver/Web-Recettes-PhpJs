<?php
    require $_SERVER["DOCUMENT_ROOT"].'Projet/inc/php/Donnees.inc.php';

if(isset($_POST['arrMust']) && isset($_POST['arrMustNot'])){
  // Initalisation du tableau des scores
  $score = array();
  foreach($Recettes as $r){
    $score[$r['titre']]=0;
  }
  $arrMust=json_decode($_POST['arrMust'], true);
  $arrMustNot=json_decode($_POST['arrMustNot']);
  foreach ($Recettes as $r) {
    foreach ($arrMust as $i) {
      if(contient($r, $i, $Hierarchie))
        $score[$r['titre']]++;
      else
        $score[$r['titre']]--;
    }
    foreach ($arrMustNot as $i) {
      if(!contient($r, $i, $Hierarchie))
        $score[$r['titre']]++;
      else
        $score[$r['titre']]--;
    }
  }

  krsort($score);
  print_r($score);
}

/**
* Renvoie true si la recette $r contient l'ingredient $i
*/
function contient($r, $i, $Hierarchie){
  //tableau des categories peres des ingredients de $r
  $catPeres = array();
  $catPeres = getSC($i, $Hierarchie);
  print_r($catPeres);
  if(in_array($i, $catPeres))
    return true;
  else
    return false;
}

/**
* Renvoie les super categories
*/
function getSC($cat, $Hierarchie){
  $res = array();
  if($Hierarchie[$cat]['super-categorie'][0] == "Aliment"){
    return array($cat);
	}else{
    foreach(($Hierarchie[$cat]['super-categorie']) as $sc){
			$res = array_merge($res, getSC($sc, $Hierarchie));
		}
  }
  return $res;
}
?>
