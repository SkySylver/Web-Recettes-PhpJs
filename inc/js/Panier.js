/*
 * Fonctions liées à la classe Panier
 *
 */


/**
 * Ajoute la recette $recette au panier de l'utilisateur actuel
 * @param $recette: id de la recette
 */
function AjouterPanier($recette){
    $.post('inc/ajax/modifPanier.php', {methode: "ajouter", id: $recette}, function () {
    });
}

/**
 * Supprime la recette $recette du panier de recettes préférées
 * @param $recette
 */
function SupprimerPanier($recette){
    $.post('inc/ajax/modifPanier.php', {methode: "supprimer", id: $recette});
}

function afficherPanier() {
    
}

function MajPanier($div){

}