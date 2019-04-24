<?php
$conn = new mysqli( 'localhost', 'root', '', 'tienda' );

if ( $conn->connect_error ) {
  die( 'Error al conectarse a la base de datos' );
}

$res = array( 'error' => false );

$action = 'read';

if ( isset( $_GET['action'] ) ) {
  $action = $_GET['action'];
}

if ( $action == 'read' ) {
  $result = $conn->query( "SELECT * FROM productos" );
  $productos = array();

  while ( $row = $result->fetch_assoc() ) {
    array_push( $productos, $row );
  }

  $res['productos'] = $productos;  
}

if ( $action == 'create' ) {
  $name = $_POST['name'];
  $image = $_POST['image'];
  $description = $_POST['description'];

  $result = $conn->query( "INSERT INTO productos (nombre_producto, imagen, descripcion) VALUES ('$name', '$image', '$description')" );
  
  if ( $result ) {
    $res['message'] = 'Producto agregado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Error al tratar de agregar el producto.";
  }
}

if ( $action == 'update' ) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $image = $_POST['image'];
  $description = $_POST['description'];

  $result = $conn->query( "UPDATE productos SET nombre_producto = '$name', imagen = '$email', descripcion = '$web' WHERE id_productos = $id" );
  
  if ( $result ) {
    $res['message'] = 'Producto actualizado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Error al tratar de actualizar el producto.";
  }
}

if ( $action == 'delete' ) {
  $id = $_POST['id'];

  $result = $conn->query( "DELETE FROM productos WHERE id_productos = $id" );
  
  if ( $result ) {
    $res['message'] = 'Producto eliminado con éxito.';
  } else{
    $res['error'] = true;
    $res['message'] = "Error al tratar de eliminar el producto.";
  }
}

$conn->close();

header( 'Content-type: application/json' );
echo json_encode($res);