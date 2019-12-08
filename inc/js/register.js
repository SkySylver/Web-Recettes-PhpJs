////////////////////////////////////////////////////////////////////////////////////
//  Fonctions pour des vérifications plus ergonomiques du formulaire d'inscription
///////////////////////////////////////////////////////////////////////////////////

/**
 *  Affiche l'invalide feedback d'un input voulu
 * @param obj : input concerné
 */
function disable(obj){
    $(obj).removeClass('is-valid');
    $(obj).addClass('is-invalid');
}

/**
 * Affiche le valide feedback d'un input voulu
 * @param obj: input concerné
 */
function validate(obj){
    $(obj).removeClass('is-invalid');
    $(obj).addClass('is-valid');
}

/**
 * Rend neutre les feedback d'un input voulu
 * @param obj: input concerné
 */
function neutralize(obj){
    $(obj).removeClass('is-invalid');
    $(obj).removeClass('is-valid');
}

$(function () {

    /**
     * Vérification du Login
     */
    $('#login').change(function () {
        if (/[a-zA-Z0-9]{3,29}/.test(this.value)) validate(this);
        else {
            $(this).siblings('.invalid-feedback').text('Votre Login doit contenir entre 3 et 29 caracteres, qui ne peuvent etre que des chiffres et des lettres.');
            disable(this);
        }
        $.get("existLogin.php?log=" + this.value, function (data) {
            if (data == "true") {
                disable(this);
                $(this).siblings('.invalid-feedback').text('Votre Login doit contenir entre 3 et 29 caracteres, qui ne peuvent etre que des chiffres et des lettres.');
            }
        });
    });

// Password
    $("#password").keyup(function () {
        if ((/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/.test(this.value))) validate(this);
        else {
            disable(this);
            $(this).siblings('.invalid-feedback').text('Votre mot de passe doit contenir au minimum, 8 caractères, dont 2 chiffres, et un caractère spécial !@#$%^&*');
        }
        $("#confirm_password").trigger('keyup');
    });

// Confirm password
    $("#confirm_password").keyup(function () {
        if (this.value == $('#password').val()) validate(this);
        else {
            disable(this);
            $(this).siblings('.invalid-feedback').text('Veuillez ressaisir votre mot de passe.');
        }
    });

    /**
     * Vérification du Nom de famille
     */
    $('#name').keyup(function () {
        if ((/^[a-zA-ZàáâäãčćèéêëėìíîïńòóôöõùúûüūÿýżźñçčšžÀÁÂÄÃÅĆČĖÈÉÊËÌÍÎÏŃÒÓÔÖÕÙÚÛÜŪŸÝŻŹÑÇŒÆČŠŽ]*$/).test(this.value)) validate(this);
        else if (/^$/.test(this.value)) neutralize(this);
        else {
            disable(this);
            $(this).siblings('.invalid-feedback').text('Les caractères spéciaux ne sont pas autorisés.');
        }
    });

    /**
     * En soit j'ai confondu name et surname mais bon...
     */
    $('#surname').keyup(function () {
        if ((/^[a-zA-ZàáâäãčćèéêëėìíîïńòóôöõùúûüūÿýżźñçčšžÀÁÂÄÃÅĆČĖÈÉÊËÌÍÎÏŃÒÓÔÖÕÙÚÛÜŪŸÝŻŹÑÇŒÆČŠŽ]*$/).test(this.value)) validate(this);
        else if (/^$/.test(this.value)) neutralize(this);
        else {
            $(this).siblings('.invalid-feedback').text('Les caractères spéciaux ne sont pas autorisés.');
        }
    });


    /**
     * Vérification du format de l'adresse Email valide
     */
    $('#mail').keyup(function () {
        if ((/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/).test(this.value)) validate(this);
        else {
            disable(this);
            $(this).siblings('.invalid-feedback').text('Veuillez saisir une adresse mail valide.');
        }
    });


    /**
     * Vérification de la date de naissance valide
     */
    $('#naissance').change(function () {
        var a = new Date().toJSON().slice(0, 10);
        if (this.value < a) validate(this);
        else disable(this);
        $(this).siblings('.invalid-feedback').text('Vous n\'êtes pas encore né ?');
    });


// Genre : Pas besoin de validation (Au pire PHP vérifie si c'est bien Monsieur ou Madame)

    // Adresse

    /**
     * Vérification du numéro de rue
     */
    $('#number').keyup(function () {
        if ((/^[0-9]+$/).test(this.value)) validate(this);
        else if (/^$/.test(this.value)) neutralize(this);
        else disable(this);

    });

    /**
     * Vérification du nom de la rue
     */
    $('#street').keyup(function () {
        if ((/^[a-zA-Z ]+$/).test(this.value)) validate(this);
        else if (/^$/.test(this.value)) neutralize(this);
        else disable(this);
    });

    /**
     * Vérification du code postal
     */
    $('#CP').keyup(function () {
        if ((/^[0-9]+$/).test(this.value)) validate(this);
        else if (/^$/.test(this.value)) neutralize(this);
        else disable(this);

    });

    /**
     * Vérification du nom de la vile
     */
    $('#city').keyup(function () {
        if ((/^[a-zA-Z ]*$/).test(this.value)) validate(this);
        else if (/^$/.test(this.value)) neutralize(this);
        else disable(this);
    });


    /**
     * Vérification du numéro de téléphone
     */
    $('#tel').keyup(function () {
        if ((/^[0-9]{10}$/).test(this.value)) validate(this);
        else if (/^$/.test(this.value)) {
            neutralize(this);
            console.log('neutre');
        } else {
            disable(this);
            $(this).siblings('.invalid-feedback').text('Numéro de téléphone invalide.');
        }
    });


    /**
     * Verification lors de l'envoi
     */
    $('#form').submit(function (e) {
        if ($(".is-invalid")[0] && $(".is-invalid")[0].id != 'submit') {
            disable($('#submit'));
            $('#submit').siblings('.invalid-feedback').text('Veuillez correctement compléter les champs invalides.');
            e.preventDefault();
        }
    });

    $('.trig').change(function () {
        $('.trig').trigger('keyup');
    });
});
