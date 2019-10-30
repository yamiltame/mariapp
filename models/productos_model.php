<?php

	function select_catego($conexion,$def){
		$select="<select name='categoria'>";
		$sql="select distinct categoria from Productos";
		$result=$conexion->query($sql);
        while($row=mysqli_fetch_array($result)){
			if($row['categoria']==$def){
				$select.="<option value=".$row['categoria']." selected>".$row['categoria']."</option>";
				}
			else{
				$select.="<option value=".$row['categoria'].">".$row['categoria']."</option>";
				}
			}
		$select.="</select>";
		return $select;
		}

	function set_opt_from_user($usertype,$op0,$op1,$op2){
		if($usertype==0){ return $op0;}
		else if($usertype==1){ return $op1;}
		else{ return $op2;}
		}

	function tabla_productos($conexion,$condicion,$orden,$last,$usertype,$pag,$buscar){
		$campos= array("id","descripcion","precio","categoria");
		$titulos= ($usertype<2) ? array("select","Descripcion","Precio","Categoria","") : array("select","Descripcion","Precio","Categoria");
		$tabla=set_opt_from_user($usertype,
			"<form id='multiples' action='editarproducto.php' method=post><input type='hidden' name='multiple' form='multiples' value=0></form><table border><tr><td>select</td>",
			"<form id='multiples' action='comprar.php' method=post><input type='hidden' name='multiple' form='multiples' value=0></form><table border><tr><td>select</td>",
			"<table border><tr>");
		$sql="select ";
		foreach ($campos as $c){ $sql.=$c.",";}
		foreach ($titulos as $t){
            if($t!="" && $t!="select"){
                if($last==0){
                    $tabla.="<th><a href='?orden=$t&last=1&buscar=$buscar'>".$t."</a></th>";
                    }
                else{
                    $tabla.="<th><a href='?orden=$t&last=0&buscar=$buscar'>".$t."</a></th>";
                    }
                }
            }
		$tabla.="</tr>";
		$sql.="'' from Productos ".$condicion;
		$result=$conexion->query($sql);
		while($row=mysqli_fetch_array($result)){
    		    $tabla.="<tr>";
        		$tabla.= ($usertype<2) ? "<td><input type='checkbox' name='".$row['id']."' form='multiples' value=".$row['id']."></td>": "";
				$tabla.="<td>".$row['descripcion']."</td><td>".$row['precio']."</td><td>".$row['categoria']."</td>";
				$tabla.=set_opt_from_user($usertype,"<td>".$conexion->make_link("editarproducto.php","Editar",$row['id'])."</td></tr>","<td>".$conexion->make_link('comprar.php','Comprar',$row['id'])."</td></tr>","</tr>");
    			}
		$tabla.=set_opt_from_user($usertype,"<input type='submit' form='multiples' value='Editar selección'></table><br>","<input type='submit' form='multiples' value='Comprar seleccion'></table><br>","</table><br>");
		return $tabla;
		}

	function formulario_registro_producto($conexion){
		$formulario="<form action='registroproductos.php' method='post'>
            Descripcion:<br>
            <input type='text' name='descripcion' required><br>
            Precio:<br>
            <input type='number' step='0.01' name='precio' required><br>
            Categoria:<br>";
		$formulario.=select_catego($conexion,"");
		$formulario.="<br><input type='submit' value='registrar'><br></form>";
		return $formulario;
		}

	function registrar_producto($conexion,$desc,$precio,$cate){
	    $producto=$conexion->query_count("Productos","where descripcion='$desc'");
	    if($producto==0){
	        $registro="insert into Productos values(null,'$desc',$precio,'$cate')";
	        $conexion->query($registro);
			$mensaje=0;
			//exito
	        }
	    else{
			$mensaje=1;
	        }
		return $mensaje;
		}

	function formulario_editar_producto($conexion,$id){
		$sql="select * from Productos where id=".$id;
		$result=$conexion->query($sql);
		$row=mysqli_fetch_array($result);
		$formulario="<form action='editarproducto.php' method='post'>
    		<input type='hidden' name='id' value=".$id.">
    		Descripcion:<br>
    		<input type='text' name='descripcion' value=".$row['descripcion']."><br>
    		Precio:<br><input type='number' step='0.01' name='precio' value=".$row['precio']."><br>
    		Categoría:<br>
    		<input type='text' name='categoria' value=".$row['categoria']."><br>
    		<input type='submit' value='editar'></form>";
		$formulario.="<form action='editarproducto.php' method=post><input type=hidden name=borrar value=$id><input type='submit' value='borrar'></form>";

		return $formulario;
		}

	function formulario_multiples_productos($IDS){
		$formulario="Editar productos <br><form action='editarproducto.php' method='post'>";
		foreach($IDS as $id){
			$formulario.="<input type='hidden' name=$id value=$id>";
			}
		$formulario.="<input type='hidden' name='multiple' value=1>";
		$formulario.="Categoría:<br><input type='text' name='categoria'><br><input type='submit' value='editar'></form>";
		$formulario.="<form action='editarproducto.php' method='post'>";
		foreach($IDS as $id){
			$formulario.="<input type='hidden' name=$id value=$id>";
			}
		$formulario.="<input type='hidden' name='multiple' value=2><input type='submit' value='borrar'></form>";
		return $formulario;
		}

	function get_ids($post,&$IDS){
		foreach($post as $P => $i){
        	if(is_numeric($P)){
            	$IDS[]=$i;
            	}
			}
		}

	function editar_producto($conexion,$desc,$precio,$cate,$id){
		$sql="update Productos set descripcion='$desc', precio=$precio, categoria='$cate' where id=$id";
	    $conexion->query($sql);
		}

	function editar_seleccion($conexion,$IDS){
		$sql="update Productos set categoria='".$_POST['categoria']."' where id in (";
		if(is_array($IDS)){
	        foreach($IDS as $i){ $sql.="$i,"; }
	        $sql.="0)";
			}
		else{ $sql.="$IDS)"; }
        $conexion->query($sql);
		}

	function borrar_seleccion($conexion,$IDS){
        $sql="delete from Productos where id in (";
		if(is_array($IDS)){
	        foreach($IDS as $i){ echo $i."<br>"; $sql.="$i,"; }
	        $sql.="0)";
			}
		else{ $sql.="$IDS)"; }
		echo $sql."<br>";
        $conexion->query($sql);
		}

	function empaginamiento_productos($conexion,$sql,$compag,$cantidadmostrar,$extras){
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
