<?php
	function tabla_usuarios($conexion,$condicion,$orden,$last,$usertype,$pag,$buscar){
		$campos= array("id","nombre","email","permiso");
		$titulos= array("select","Nombre","Email","Permiso","");
        $tabla="<form id='multiples' action='editarusuario.php' method=post><input type='hidden' name='multiple' form='multiples' value=0></form><table border><tr>";
		$tabla.="<td>select</td>";
		$sql="select ";
		foreach ($campos as $c){ $sql.=$c.",";}
		foreach ($titulos as $t){
			if($t!="" && $t!="select"){
				if($last==0){
					$tabla.="<th><a href='?orden=$t&last=1&usertype=$usertype&buscar=$buscar'>".$t."</a></th>";
					}
				else{
					$tabla.="<th><a href='?orden=$t&last=0&usertype=$usertype&buscar=$buscar'>".$t."</a></th>";
					}
				}
			}
		$tabla.="</tr>";
		$sql.="'' from Usuarios ".$condicion;
		$result=$conexion->query($sql);
		while($row=mysqli_fetch_array($result)){
        		$tabla.="<tr>";
        		$tabla.="<td><input type='checkbox' name='".$row['id']."' form='multiples' value=".$row['id']."></td><td>".$row['nombre']."</td>"."<td>".$row['email']."</td>";
        		if($row['permiso']==0){ $tabla.="<td>Administrador</td>";}
        		else if($row['permiso']==1){ $tabla.="<td>Ver y Comprar </td>";}
        		else{
					$tabla.="<td>Sólo ver <form action='aceptarusuario.php?pag=$pag&orden=$orden&last=$last&usertype=$usertype' method='post'><input type='hidden' name='opcion' value=".$row['id'].">
						<input type='submit' value='aceptar'></form></td>";
					}
        		$tabla.="<td>".$conexion->make_link("editarusuario.php","Editar",$row['id'])."</td></tr>";
    		}
		$tabla.="</table><br>";
        $tabla.="<input type='submit' form='multiples' value='Editar selección'></table><br>";
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

    function get_ids($post,&$IDS){
        foreach($post as $P => $i){
            if(is_numeric($P)){
                $IDS[]=$i;
                }
            }
        }

    function formulario_multiples_usuarios($IDS){
        $formulario="Editar usuarios <br><form action='editarusuario.php' method='post'>";
        foreach($IDS as $id){
            $formulario.="<input type='hidden' name=$id value=$id>";
            }
        $formulario.="<input type='hidden' name='multiple' value=1>";
        $formulario.="Permiso:<br><select name='permiso'><option value=0>Administrador</option><option value=1>Ver y Comprar</option><option value=2>Sólo ver</option><br><input type='submit' value='editar'></form>";
        $formulario.="<form action='editarusuario.php' method='post'>";
        foreach($IDS as $id){
            $formulario.="<input type='hidden' name=$id value=$id>";
            }
        $formulario.="<input type='hidden' name='multiple' value=2><input type='submit' value='borrar'></form>";
        return $formulario;
        }

    function editar_seleccion($conexion,$IDS){
        $sql="update Usuarios set permiso='".$_POST['permiso']."' where id in (";
        if(is_array($IDS)){
            foreach($IDS as $i){ $sql.="$i,"; }
            $sql.="0)";
            }
        else{ $sql.="$IDS)"; }
        $conexion->query($sql);
        }

    function borrar_seleccion($conexion,$IDS){
        $sql="delete from Usuarios where id in (";
        if(is_array($IDS)){
            foreach($IDS as $i){ echo $i."<br>"; $sql.="$i,"; }
            $sql.="0)";
            }
        else{ $sql.="$IDS)"; }
        echo $sql."<br>";
        $conexion->query($sql);
        }

    function empaginamiento_usuarios($conexion,$sql,$compag,$cantidadmostrar,$extras){
        $line="";
        //la variable extras debe ser un array con las claves para los parametros...
        foreach ($extras as $clave => $valor){
            $line.=$clave."=".$valor."&";
            }
        $registros=$conexion->query($sql);
        $paginas=ceil($registros->num_rows/$cantidadmostrar);
        $increment=(($compag +1) <= $paginas) ? ($compag +1): $paginas;
        $decrement=(($compag -1) < 1) ? 1: ($compag-1);
        $desde=$compag - 4;
        $hasta=$compag +5;
        $desde=($desde<1)? 1 : $desde;
        $hasta=($hasta>$paginas)? $paginas : $hasta;
        $empaginamiento="<ul><a href='?pag=$decrement&$line'>atrás</a>";
        for($i=$desde;$i<=$hasta;$i++){
            if($i==$compag){ $empaginamiento.="<a href='?pag=$i&$line'><b>($i)</b></a>";}
            else{ $empaginamiento.="<a href='?pag=$i&$line'>($i)</a>";}
            }
        $empaginamiento.="<a href='?pag=$increment&$line'>Siguiente</a></ul>";
        return $empaginamiento;
        }

?>
