////////////////////////////////////////////////////////////////////
// Fonctions de la hierarchie et de la liste de categorie cliquable
////////////////////////////////////////////////////////////////////
/**
 * Initialisation des evenements
 */
$(function () {
    $(".btn-rec").on('click', parcourirCategories);
    $(".btn-chemin").off("click").on('click', parcourirChemin);
    afficherRecettes("Hierarchie");
    $('.btn-chemin:eq(0)').trigger("click");
});



/**
 * Affiche les recettes d'une categorie
 */
function afficherRecettes($categorie) {
    $.post('inc/ajax/getRecettes.php',
        {
            cat: $categorie
        }, function (data, status) {
            $("#Recettes").html(data);
        });
}


/**
 * Met a jour la liste de categories
 * @param $id: Categorie selectionnee
 */
function majListeCategories($id) {
    $.post('inc/ajax/getSousCat.php',
        {
            id: $id
        }, function (data, status) {
            $('#Chemin').append('<span class="btn-chemin">' + $chemin + "</span>/");
            $('#Categories').html(data);
            $(".btn-rec").on('click', parcourirCategories);
        });
}

/**
 * fonction definie pour la navigation a travers la liste de Hierarchie
 */
function parcourirCategories() {
    $chemin = $(this).text();
    majListeCategories($chemin);
    $(this).parent().children().css({"background-color": "", "color": "black"});
    $(this).css({"background-color": "purple", "color": "white"});
    $(".btn-chemin").off("click").on('click', parcourirChemin);
    afficherRecettes($chemin);
}

/**
 *
 */
function parcourirChemin() {
    // On affiche les catégories
    $.post('inc/ajax/getSousCat.php',
        {
            id: $(this).text()
        }, function (data, status) {
            $('#Categories').html(data);
            $(".btn-rec").on('click', parcourirCategories);
        });

    // On efface le chemin à droite du noeud cliqué
    var left = $('#Chemin').html().split($(this).text());
    left[0] += $(this).text();
    $('#Chemin').html(left[0]);
    $('#Chemin').append("/");

    // On réaffecte les event aux noeuds du chemin
    $(".btn-chemin").off("click").on('click', parcourirChemin);
    afficherRecettes($(this).text());
}


//////////////////////////////////////
// Fonctions de la barre de recherche
//////////////////////////////////////
/**
 * Initialisation de la barre de recherche
 */
$(function () {

    var input = document.getElementById("recherche");
    var suggestions = document.getElementById("suggestions");
    $("#recherche").on('keyup', afficherSuggestions);
    $(".btn-rechercher").on('mousedown', traiterRecherche);

    //Si l'utilisateur appuie sur Entrée
    $("#barre").submit(function(event){
      traiterRecherche();
      return false;
    });

    //quand la barre de recherche n'est plus sélectionnée
    input.onblur = function(){
        //on affihce plus la barre de recherche
        suggestions.style.display = "none";
        if(this.value=="")
            viderBarre();
    };

    //quand la barre de recherche est sélectionnée
    input.onfocus = function(){
      //On affiche la liste de suggestion
      suggestions.style.display = "block";
    };

    //Vide la liste de suggestions
    function viderBarre(){
      suggestions.innerHTML='<ul id="suggestions"></ul>';
    }

    /**
     * Affiche les suggestions pendant que l'utilisateur tape
     * dans la barre de recherche
     */
    function afficherSuggestions() {
        var str =  $.trim(input.value);
        if(str != ""){
          $.post('inc/ajax/getSuggestions.php',
          {
              q: str
          }, function (data, status) {
              $("#suggestions").html(data);
              $(".btn-suggestion").off('mousedown').on('mousedown', traiterSuggestion);
          });
        }else{
          viderBarre();
        }
    }

    /**
    * Remplace la valeur de la barre par la suggestion cliquée
    * Ajouter traiterRecherche(); si envie
    */
    function traiterSuggestion(){
      input.value = this.innerHTML;
      //traiterRecherche();
    }

    /**
     * Traite la recherche cliquée par l'utilisateur
     */
    function traiterRecherche(){
        var str = $.trim(input.value);
        if(str !=""){
          afficherRecettes(str);
        }
    }
});

//////////////////////////////////////
// Fonctions des listes déroulantes, recherche par tag
//////////////////////////////////////
/**
 * Initialisation des listes déroulantes
 */
$(function () {
  //on remplit les listes must include et must not include
  $.post('inc/ajax/getListesCat.php',
      {
      }, function (data, status) {
          $('#mustInclude').html(data);
          $('#mustNotInclude').html(data);
      });

      //L'utilisateur ajoute un tag
      $("#formMustInclude").submit(function(event){
        var str =  $.trim($("input[name='inputMust']").val());
        if(str != "") {
          $("#listeMustInclude").append('<li class="liMust">' + str + '</li>');
          str = str.replace(/ /g,'');
          $("#mustInclude option").remove("#" + RemoveAccents(str));
          $("#mustNotInclude option").remove("#" + RemoveAccents(str));
          $("input[name='inputMust']").val("");
          $("#btn-rechercheParTag").off('mousedown').on('mousedown', traiterTag);
        }
        return false;
      });

      //L'utilisateur ajoute un tag
      $("#formMustNotInclude").submit(function(event){
        var str =  $.trim($("input[name='inputMustNot']").val());
        if(str != "") {
          $("#listeMustNotInclude").append('<li class="liMustNot">' + str + '</li>');
          str = str.replace(/ /g,'');
          $("#mustInclude option").remove("#" + RemoveAccents(str));
          $("#mustNotInclude option").remove("#" + RemoveAccents(str));
          $("input[name='inputMustNot']").val("");
          $("#btn-rechercheParTag").off('mousedown').on('mousedown', traiterTag);
        }
        return false;
      });


      function traiterTag(){
        // On met les tag dans des tableaux
        var liMust = $(".liMust").toArray();
        var arrMust = [];
        for ( var i = 0; i < liMust.length; i++ ) {
          arrMust.push( liMust[ i ].innerHTML );
        }
        var liMustNot = $(".liMustNot").toArray();
        var arrMustNot = [];
        for ( var i = 0; i < liMustNot.length; i++ ) {
          arrMustNot.push( liMustNot[ i ].innerHTML );
        }
        //console.log(arrMust);

        $.post('inc/ajax/getRecettesParTag.php',
            {
              arrMust: JSON.stringify(arrMust),
              arrMustNot: JSON.stringify(arrMustNot)
            }, function (data, status) {
              $("#Recettes").html(data);
            });
      }
});

function RemoveAccents(str) {
  var accents    = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
  var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";
  str = str.split('');
  var strLen = str.length;
  var i, x;
  for (i = 0; i < strLen; i++) {
    if ((x = accents.indexOf(str[i])) != -1) {
      str[i] = accentsOut[x];
    }
  }
  return str.join('');
}
