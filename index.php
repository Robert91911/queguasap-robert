<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

include_once 'model/bd.inc.php';

include_once 'view/header.inc.php';
include_once 'view/footer.inc.php';

include_once 'controller/controller.inc.php';

include_once 'view/show_view.php';

include_once 'config.php';

actualizar_sesion();

//Muestra el código HTML del header de la página web
show_header();

//
show_menu();

//
show_content();

//Muestra el códico HTML del footer de la página web
show_footer();


?>
