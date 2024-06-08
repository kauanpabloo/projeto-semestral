<?php
session_start();
if (!isset($_SESSION['usuario'])) {
	header("Location: ../index.html");
	exit();
}
?>

<?php
session_start();
$email = "";
$senha = "";

if (isset($_SESSION["email"]) && isset($_SESSION["senha"])) {
	$email   = $_SESSION["email"];
	$senha = $_SESSION["senha"];
} else {
	header("Location: ../index.html");
}
?>