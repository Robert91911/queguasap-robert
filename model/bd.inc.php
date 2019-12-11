<?php


/*
*	Conexión a la base de datos
*	E:
*	S: conn (variable de tipo connection)
*	SQL:
*/

function connection() {
		try{
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'queguasap';
		$DATABASE_PASS = 'QueGuaSap';
		$DATABASE_NAME = 'queguasap';
			
		// Crear la conexión
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	
		//Devuelve una variable tipo conexión
		return $con;

	}catch(Exception $e) {

        die('Error: ' . $e->GetMessage());

    }
	
}

/*
*	Comprueba login
*	E:
*	S: booleano: conexión correcta
*	SQL: select * from usuarios WHERE ...
*/
function login_ok()	{
	
	$mysqli = connection();
	
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}
	$consulta = "SELECT num_tel FROM usuario WHERE num_tel = ? and pass = ?";
	$sentencia = $mysqli->prepare($consulta);
	$sentencia->bind_param("ss", $val1, $val2_hash);

	$val1 = $_POST['numero'];
	$val2 = $_POST['pass_user'];
	$val2_hash= hash('sha256', $val2);
	
	$sentencia->execute();
	$sentencia->store_result();
	$count = $sentencia->num_rows;

	if($count == 1) {
		return true;
	}
	else {
		return false;
	}
	
}

/*
*	Funcion que registra un nuevo usuario en la base de datos
*	E: Stirng NumTel,  String contraseña, String nomUsuario, String estado.
*	S: booleano: guardado correctamente
*	SQL: [insert]
*/
function registrar_usuario() {

	$mysqli = connection();
	
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}
	$consulta = "INSERT INTO usuario (num_tel, pass, nombre_usuario, estado) values (?,?,?,?)";
	$sentencia = $mysqli->prepare($consulta);
	$sentencia->bind_param("ssss", $val1, $val2_hash, $val3, $val4);

	$val1 = $_POST['numero'];
	$val2 = $_POST['registro_pass1'];
	$val2_hash= hash('sha256', $val2);
	$val3 = $_POST['registro_nom_usuario'];
	$val4 = $_POST['registro_estado'];
	
	$sentencia->execute();
	$sentencia->store_result();
	$count = $sentencia->num_rows;

	if($count == 1) {
		return true;
	}
	else {
		return false;
	}
}
/*
*	Comprueba login
*	E:
*	S: booleano: conexión correcta
*	SQL: select * from usuarios WHERE ...
*/
function usuario_registrado(){
	$mysqli = connection();
	
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}
	$consulta = "SELECT num_tel FROM usuario WHERE num_tel = ?";
	$sentencia = $mysqli->prepare($consulta);
	$sentencia->bind_param("s", $val1);

	$val1 = $_POST['numero'];
	
	$sentencia->execute();
	$sentencia->store_result();
	$count = $sentencia->num_rows;

	if($count == 1) {
		return true;
	}
	else {
		return false;
	}
}


/*
*	Función para terminar la sesión
*	E:
*	S:
*	SQL:
*/
function unset_session() {
	unset($_SESSION['user']);
}

/*
*	Guardar el mensaje en la BD
*	E:
*	S:boolean: operación correcta
*	SQL: 	INSERT into Mensaje (texto) values (?);	
		SELECT idMensaje, texto, fecha, hora, fichero, telefono from Mensajes
*/
function guardar_mensaje() {
	return true;
}

/*
*	Funcion que modifica el perfil
*	E:
*	S:
*	SQL: UPDATE into usuario ...
*/
function editar_perfil() {
	return true;
}

/*
*	Muestra el estado del usuario logeado
*	E:
*	S: String
*	SQL: UPDATE into usuario ...
*/
function mostrar_estado(){
	$mysqli = connection();
	$usuario = $_SESSION['user'];
	$consulta = "SELECT estado FROM usuario WHERE num_tel = $usuario";

	if ($resultado = $mysqli->query($consulta)) {

    /* obtener el array de objetos */
    if ($fila = $resultado->fetch_row()) {
        return $fila[0];
	}else
		return "Error al obtener el estado	";
    /* liberar el conjunto de resultados */
    $resultado->close();
}

/* cerrar la conexión */
$mysqli->close();
	
	/*
	$consulta = "SELECT estado FROM usuario WHERE num_tel = ?";
	$sentencia = $mysqli->prepare($consulta);
	$sentencia->bind_param("s", $val1);

	$val1 = $_SESSION['user'];
	
	$sentencia->execute();
	$sentencia->store_result();
	$count = $sentencia->num_rows;

	if($fila = $resultado->fetch_row())
	echo $fila['campo1'];
	else
	show_msg("Error");
	$estado="null";
*/
	return $estado;
}

/*
*	Comprueba el máximo número de caracteres del texto del estado del 
* 	usurario, configurable 
*	E:
*	S: booleano: número correcto
*	SQL: 
*/
function maximo_caracteres_estado() {
	if(strlen($_POST['estado_usuario'])>=$LONG_ESTADO){
		return true;
	}
	return false;
}

/*
*	Guarda el color seleccionado en el fichero de configuración
*	E:
*	S: c
*	SQL:
*/
function color_seleccionado() {
	return true;
}

/*
*	Comprueba el tamaño de la imagen seleccionada, el tamaño de la 
* 	imagen estara en el fichero de configuración
*	E:
*	S: booleano: tamaño correcto
*	SQL: 
*/
function tamaño_img() {
	return true;
}


/*
*	Funcion que guarda el chat en un fichero backup.txt
*	E:
*	S: booleano: guardado correctamente
*	SQL:
*/
function backup_chat() {
	return true;
}




?>
