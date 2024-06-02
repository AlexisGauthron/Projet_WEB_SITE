<?php
session_start();
session_destroy();
header("Location: ../menu_front/Votre_compte.php");
exit();
?>
