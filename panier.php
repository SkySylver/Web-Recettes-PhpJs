<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/class/User.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/class/Panier.php';
use App\User;
use App\Panier;
use function App\isConnected;
session_start();

    if(!isset($_SESSION['panier'])) $_SESSION['panier'] = new Panier();

?>

<!DOCTYPE html>
<html>
<head>
<?php $title='Panier'; require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/header.php'; ?>
</head>

<?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/nav.php'; ?>
<body>

<div id="panier">

<?php
$_SESSION['panier']->afficher(-1);
?>
</div>

<button onclick="AjouterPanier(0);">ffff</button>
</body>

</html>