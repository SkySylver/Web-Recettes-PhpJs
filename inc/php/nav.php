<?php require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/class/User.php';?>
<div class="navbar">
<ul class="nav mb-2">
    <li class="nav-item">
        <a class="nav-link" href="home.php">Recettes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="panier.php">Panier</a>
    </li>
    <?php
        if(\App\isConnected()) {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="account.php">Mon espace</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Projet/inc/php/disconnect.php">Déconnexion</a>
            </li>
            <?php
        }
        else{
            ?>
            <li class="nav-item">
                <a class="nav-link" href="register.php">S'inscrire</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Connexion</a>
            </li>
            <?php
        }
    ?>

</ul>
</div>
<script type="text/javascript">
    var href = '.nav-item .nav-link[href="'+window.location.pathname.split("/").pop()+'"]';

    $(href).css('background-color','purple');
    $(href).css('color','white');
</script>

<style type="text/css">
    .nav-item .nav-link:hover{
        color: white;
    }
</style>
