<?php

/*
*	Muestra el contenido de la parte central de la página
*	E:
*	S:
*	SQL:
*/
function show_content() {
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {	// GET
		if (!isset($_GET['cmd'])){				// carga inicial de la página
			show_loging();
		}
		else {
			switch ($_GET['cmd']) {
				case 'start':
					show_loging();
					break;

				case 'chat':
					show_chats();
					break;

				case 'ver_chat':
					show_contacto_chat();
					break;

				case 'perfil':
					show_perfil();
					break;

				case 'ajustes':
					show_ajustes();
					break;

				case 'logout':
					show_loging();
					show_msg("Ha cerrado la sesión");
					break;	

				default:
					"error de conexión";
					break;
			}

		}
	}
	else {										// POST
		if (isset($_POST['login'])) {

			if (login_ok()) {
					show_chats();
				}
			else {
				show_msg("Fallo en autentificación");
				show_loging();
			}
			
		}

		//Muestra el registro al pulsar el botón del Login.
		if (isset ($_POST['registro'])) {
			show_registro();
		}

		//Si se ha registrado el usuario en la base de datos, vuleve al login  para que se pueda logear.
		if (isset ($_POST['registrado'])) {
			comprobarCamposRegistro();
		}

		if (isset($_POST['contestar'])) {
			
			if (tamaño_img()) {

				if (guardar_mensaje()) {
					show_msg("Mensaje enviado");
					show_chats();
				}
				else {
					show_msg("Error no enviado");
				}
				
			}

			else {
				show_msg("Error imagen demasiado grande 20mb como maximo");
			}
		}

		if (isset($_POST['editar'])) {
			
			if (maximo_caracteres_estado()) {
				
				if (editar_perfil()) {
					show_msg("Perfil editado");
					show_chats();
				}
				else {
					show_msg("Error no editado");
				}

			}
			else {
				show_msg("Error máximo de caracteres");
			}

			
		}

		if (isset($_POST['guardar_color'])) {
			
			if (color_seleccionado()) {
				show_msg("Color cambiado");
				show_chats();
			}
			else {
				show_msg("Error no se cambio de color");
			}
		}

		if (isset($_POST['backup'])) {
			
			if (backup_chat()) {
				show_msg("backup guardado");
				show_chats();
			}
			else {
				show_msg("Error no realizar el backup");
			}
		}
		
	}
}

/*
* Comprueba que los datos del registro están bien
* E: 
* S: 
* SQL:
*/
function comprobarCamposRegistro() {
	if(!usuario_registrado()) {
		if($_POST['registro_pass1'] == $_POST['registro_pass2']){
			if(registrar_usuario()) {
				show_loging();
			}else{
				show_msg("Error en al guardar la información en la base de datos");
			}
		}else{
			show_msg("Las contraseñas no son identicas");
		}
	}else{
		show_msg("El numero de telefono introducido ya está registrado");
	}
	
}

/*
* Realiza algunas acciones según esté la sesión abierta o no
* E: 
* S: 
* SQL:
*/
function actualizar_sesion() {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['login'])) {

			if (login_ok()) {
				$_SESSION['user'] = $_POST['numero'];
			}

		}

	} else {

		if (isset($_GET['cmd'])) {

			if  ($_GET['cmd'] == 'logout') {

				unset($_SESSION);
				session_destroy();
			}

		}
	}
}


?>
