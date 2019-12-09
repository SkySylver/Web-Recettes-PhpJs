/*
 * Fonctions liées à la classe Panier
 *
 * ID de la balise panier :#panier
 */


/**
 * Ajoute la recette $recette au panier de l'utilisateur actuel
 * @param $recette: id de la recette
 */
function AjouterPanier($recette){
    $.post('inc/ajax/modifPanier.php', {methode: "ajouter", id: $recette}, function () {
    });
    afficherPanier(-1);
}

/**
 * Supprime la recette $recette du panier de recettes préférées
 * @param $recette
 */
function SupprimerPanier($recette){
    $.post('inc/ajax/modifPanier.php', {methode: "supprimer", id: $recette});
    afficherPanier(-1);
}

/**
 *
 * @param $id : Recette a afficher
 * Si $id == -1 : affiche tout le panier
 */
function afficherPanier($id) {
    $.post('inc/ajax/getPanier.php',{id: $id}, function (data) {
        $('#panier').html(data);
    });
}
