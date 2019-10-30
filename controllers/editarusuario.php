<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
require_once('../models/usuarios_model.php');

if(isset($_POST['multiple'])){
    get_ids($_POST,$IDS);
    if($_POST['multiple']==0){
        $formulario=formulario_multiples_usuarios($IDS);
        }
    else if($_POST['multiple']==1){
        //multiple=1, hacer la edicion
        editar_seleccion($conexion,$IDS);
		$conexion->desconectar();
        header('Location: usuarios.php');
        exit;
        }
    else{
        echo $_POST['multiple']."<br>";
        borrar_seleccion($conexion,$IDS);
		$conexion->desconectar();
        header('Location: usuarios.php');
        exit;
        //multiples=2 borrar
        }
    }
else{
    if(isset($_POST['opcion'])){ $id=$_POST['opcion'];}
    else if(isset($_POST['id'])){$id=$_POST['id'];}
    $formulario=formulario_editar_usuario($conexion,$id);
    //formulario sencillo
    }


if(isset($_POST['borrar'])){
	$sql="delete from Usuarios where id=".$_POST['borrar'];
	$conexion->query($sql);
	$conexion->desconectar();
	header('Location: ../controllers/usuarios.php');
    exit;
	}

else if(isset($_POST['id'])){
	$sql="update Usuarios set nombre='".$_POST['nombre']."', email='".$_POST['email']."', permiso=".$_POST['permiso']." where id=".$_POST['id'];
	$conexion->query($sql);
	$conexion->desconectar();
	header('Location: ../controllers/usuarios.php');
    exit;
	}

require_once('../views/editarusuario_view.php');
$conexion->desconectar();
?>
