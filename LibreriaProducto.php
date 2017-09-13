<?php
define('DBSERVER', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '12345678');
define('DBNAME', 'id2703260_baloopizzeria');
$DBSERVER = 'localhost';
$DBUSER = 'test';
$DBPASS = '12345678';
$DBNAME = 'id2703260_baloopizzeria';
function conectarDB(){
	$conn = new mysqli("localhost","test","12345678","id2703260_baloopizzeria");
	if ($conn->connect_error){
		echo "conectado";	
		die("Connection failed: ".$conn->connect_error);
	}
	return $conn;
}
function existeProducto($descripcion){
//devuelve verdadero si ya existe un producto con ese nombre
	$conn = conectarDB();
	$sql = "SELECT * from productos where descripcion = '$descripcion'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	 	return true;
	}else{
		return false;
	}
	$conn->close(); 
}
function insertarProducto($descripcion,$precio){
	$conn = conectarDB();
	$sql = "INSERT INTO productos(descripcion, precio) values ('$descripcion','$precio')";
	if (!existeProducto($descripcion)) {
		if($conn->query($sql) === true){
			echo "Producto agregado correctamente";
		}else{
			echo "Error".$sql."<br>".$conn->error;	
		}
	}else{
		echo "Lo siento, ya existe un producto con el mismo nombre";
	}
	$conn->close();
}
function modificarProducto($nombre,$precio){
	$conn = conectarDB();
	$sql = "UPDATE productos SET precio = '$precio' WHERE descripcion = '$nombre'";
	if ($conn->query($sql)===true) {
		echo "Producto modificado con exito";
	}else{
		echo "Error al modificar ".$conn->error;
	}
	$conn->close();
}
function borrarProducto($nombre){
	$conn = conectarDB();
	$sql = "DELETE FROM productos WHERE descripcion = '$nombre'";
	if ($conn->query($sql) === true) {
		echo "Producto eliminado con exito";
	}else{
		echo "Error al borrar: ".$conn->error;
	}
	$conn->close();
}
function mostrarProducto($nombre){
	//devuelve array con id,descripcion y precio de producto. Busqueda por nombre
	$conn = conectarDB();
	$sql = "SELECT * FROM productos WHERE descripcion = '$nombre'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return [$row['id_producto'], $row['descripcion'], $row['precio']];		
	}else{
		echo "llegamos hasta el else";
	}
	$conn->close();	
}
function listarProductos(){
	$conn = conectarDB();
	$sql = "SELECT * FROM productos";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$devolucion = array();
		while ($row = $result->fetch_assoc()) {
			array_push($devolucion, $row);
		}
	}
	return $devolucion;
	$conn->close();
}
?>