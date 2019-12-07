<?php require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/Donnees.inc.php';

$q = $_POST["q"];
$hint = "";
//nombre max de suggestions affichées et i son compteur
$maxDisplay = 5;
$i = 0;

//Tab de booleens pour ne pas afficher plusiseurs fois le meme mot
$trouve = array();

if ($q !== "") {
  $q = sansAccents($q);
  premiereRecherche($Recettes, $Hierarchie);
  deuxiemeRecherche($Recettes, $Hierarchie);
}

echo $hint;

// Première recherche, on vérifie si le mot tapé est le commencent du titre
//d'une recette ou d'une catégorie
function premiereRecherche($Recettes, $Hierarchie){
  global $i, $maxDisplay, $hint, $q, $trouve;
  $len=strlen($q);
  foreach($Recettes as $r) {
    if($i > $maxDisplay) break;
    $titre = $r["titre"];
    if (stristr($q, substr(sansAccents($titre), 0, $len))) {
      $trouve[$titre] = true;
      $i++;
      $hint .= '<li class="btn-suggestion">'.$titre.'</li>';
    }
  }
  if($i <= $maxDisplay){
    foreach($Hierarchie as $cat=>$h) {
      if($i > $maxDisplay) break;
      if (stristr($q, substr(sansAccents($cat), 0, $len))) {
        $trouve[$cat] = true;
        $i++;
        $hint .= '<li class="btn-suggestion">'.$cat.'</li>';
      }
    }
  }
}

//Deuxième recherche, on regarde si le mot tapé figure dans un titre ou
// dans le nom d'une catégorie
function deuxiemeRecherche($Recettes, $Hierarchie){
  global $i, $maxDisplay, $hint, $q, $trouve;
  if ($i <= $maxDisplay){
    foreach($Recettes as $r) {
      if($i > $maxDisplay) break;
      $titre = $r["titre"];
      if (!isset($trouve[$titre]) && stristr(sansAccents($titre), $q)) {
        $i++;
        $hint .= '<li class="btn-suggestion">'.$titre.'</li>';
      }
    }
    if($i <= $maxDisplay){
      foreach($Hierarchie as $cat=>$h) {
        if($i > $maxDisplay) break;
        if (!isset($trouve[$cat]) && stristr(sansAccents($cat), $q)) {
          $i++;
          $hint .= '<li class="btn-suggestion">'.$cat.'</li>';
        }
      }
    }
  }
}

function sansAccents($str){
  $str = preg_replace('#Ç#', 'C', $str);
  $str = preg_replace('#ç#', 'c', $str);
  $str = preg_replace('#è|é|ê|ë#', 'e', $str);
  $str = preg_replace('#È|É|Ê|Ë#', 'E', $str);
  $str = preg_replace('#à|á|â|ã|ä|å#', 'a', $str);
  $str = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $str);
  $str = preg_replace('#ì|í|î|ï#', 'i', $str);
  $str = preg_replace('#Ì|Í|Î|Ï#', 'I', $str);
  $str = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $str);
  $str = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $str);
  $str = preg_replace('#ù|ú|û|ü#', 'u', $str);
  $str = preg_replace('#Ù|Ú|Û|Ü#', 'U', $str);
  $str = preg_replace('#ý|ÿ#', 'y', $str);
  $str = preg_replace('#Ý#', 'Y', $str);

  return ($str);
}
?>
