<?php
	function tabla_usuarios($conexion){
		$sql="select * from Usuarios";
		$result=$conexion->query($sql);
		$campos= array("id","nombre","email","permiso");
		$titulos= array("Nombre","Email","Permiso","---");
		$tabla="<table border><tr>";
		$sql="select ";
		$tabla.="</tr>";
		foreach ($campos as $c){ $sql.=$c.",";}
		foreach ($titulos as $t){ $tabla.="<th>".$t."</th>";}
		$sql.="'' from Usuarios";
		$result=$conexion->query($sql);
		while($row=mysqli_fetch_array($result)){
        		$tabla.="<tr>";
        		$tabla.="<td>".$row['nombre']."</td>"."<td>".$row['email']."</td>";
        		if($row['permiso']==0){ $tabla.="<td>Administrador</td>";}
        		else if($row['permiso']==1){ $tabla.="<td>Ver y Comprar </td>";}
        		else{ $tabla.="<td>Sólo ver".$conexion->make_link('aceptarusuario.php','Aceptar',$row['id'])."</td>";}
        		$tabla.="<td>".$conexion->make_link("editarusuario.php","Editar",$row['id'])."</td></tr>";
    		}
		$tabla.="</table><br>";
		return $tabla;
		}

	function formulario_registro_usuario($permiso){
		if($permiso==0){
			$formulario="
        		<form action='registrousuarios.php' method='post'>
            		Nombre:<br>
            		<input type='text' name='nombre' required><br>
            		Email:<br>
            		<input type='text' name='email' required><br>
            		Password:<br>
            		<input type='password' name='pas' required><br>
           			Confirmar Password:<br>
            		<input type='password' name='cpas' required><br>
            		Permiso:<br>
            		<select name='permiso'>
                		<option value=0>Administrador</option>
                		<option value=1>Ver y comprar</option>
                		<option value=2>Sólo ver</option>
            		</select>
            		<input type='submit' value='registrar'><br>
        		</form>";
			}
		else{
			$formulario="
    			<form action='registrousuarios.php' method='post'>
            		Nombre:<br>
            		<input type='text' name='nombre' required><br>
            		Email:<br>
            		<input type='text' name='email' required><br>
            		Password:<br>
            		<input type='password' name='pas' required><br>
            		Confirmar Password:<br>
            		<input type='password' name='cpas' required><br>
            		<input type='submit' value='registrar'><br>
        		</form>";
			}
		return $formulario;
		}

	function registrar_usuario($conexion,$email,$nombre,$pas,$cpas,$permiso){
    	$user=$conexion->query_count("Usuarios","where email='$email'");
    	if($pas!=""){
        	if($pas==$cpas){
            	if($user==0){
            	    $passhash=password_hash($pas, PASSWORD_DEFAULT);
            	    $registro="insert into Usuarios values(null,'$nombre','$email','$passhash',$permiso)";
            	    $conexion->query($registro);
            	    return 0;
            		}
            	else{
            	    return 1;
            		}
        		}
        	else{
        	    return 2;
        		}
    		}
   		else{
        	return 3;
    		}
		}

	function formulario_editar_usuario($conexion,$id){
		$sql="select * from Usuarios where id=".$id;
		$result=$conexion->query($sql);
		$row=mysqli_fetch_array($result);
		$formulario="Editar usuario <br><form action='editarusuario.php' method='post'>
    		<input type='hidden' name='id' value='$id'>
    		Nombre:<br>
    		<input type='text' name='nombre' value=".$row['nombre']."><br>
    		Email:<br><input type='text' name='email' value=".$row['email']."><br>
    		Permiso:<br><select name='permiso'>";
		if($row['permiso']==0){
    		$formulario.="<option value=0 selected>Administrador</option>
        		<option value=1>Ver y comprar</option>
        		<option value=2>sólo ver</option></select>
        		<input type='submit' value='editar'></form>";
    		}
		if($row['permiso']==1){
    		$formulario.="<option value=0>Administrador</option>
        		<option value=1 selected>Ver y comprar</option>
        		<option value=2>sólo ver</option></select>
        		<input type='submit' value='editar'></form>";
    		}
		if($row['permiso']==2){
    		$formulario.="<option value=0>Administrador</option>
        		<option value=1>Ver y comprar</option>
        		<option value=2 selected>sólo ver</option></select>
        		<input type='submit' value='editar'></form>";
    		}
		$formulario.="<form action='editarusuario.php' method=post><input type=hidden name=borrar value=$id><input type='submit' value='borrar'></form>";
		return $formulario;
		}
?>
