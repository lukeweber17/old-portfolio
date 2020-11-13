<?php
require_once('includes/config.php');
require_once('includes/functions_base.php');
require_once('includes/Session.php');
//for checking is the user is already loggedin to prevent this page from always displaying
if(!isset($_SESSION["is_logged_in"]) || $_SESSION['is_logged_in'] !="auth")
{redirect_to("index.php"); die();}
?>
<!-- Header -->
<?php require_once("components/header.php"); ?>

<!-- Page content section -->
<?php require_once("components/sidebar.php"); ?>
<?php require_once("components/center_content.php"); ?>
        
<!-- Footer -->
<?php require_once("components/footer.php"); ?>