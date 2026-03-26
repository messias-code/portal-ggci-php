<?php
session_start();
session_destroy(); // Apaga tudo da memória
header("Location: index.php"); // Manda de volta pro login
exit;
?>