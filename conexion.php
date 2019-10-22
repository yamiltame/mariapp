<?php
class mySQL{
        var $host;
        var $user;
        var $pass;
        var $base;
        public $dbc;

        public function conectar(){
                $this->host='localhost';
                $this->user='root';
                $this->pass='1220';
                $this->base='Base1';
                $this->dbc=mysqli_connect($this->host,$this->user,$this->pass,$this->base) or die('Error en la  conetzion \n');
                $acentos=$this->query("SET NAMES 'utf8'");
                }

        public function query($sql){
                $result=mysqli_query($this->dbc,$sql) or die('error en la consulta'.mysqli_error($this->dbc));
                return $result;
                }
        public function query_count($table,$condition){
                $sql="select count(*) as numr  from ".$table." ".$condition;
                $result =  $this->query($sql);
                $row=mysqli_fetch_array($result);
                return $row['numr'];
                }

	public function notlogged(){
		echo "<div class='alert alert-danger mt-4' role='alert'>
        	<h4>No has iniciado sesión.</h4>
        	<p><a href='index.html'>Inicia sesión!</a></p></div>";
        	exit;
		}

	public function checklogged($sesion,$permiso){
		if(!isset($sesion['loggedin'])){ $this->notlogged(); }
		else{
			$now=time();
			if($now > $sesion['expire']){
				session_destroy();
		        echo "<div class='alert alert-danger mt-4' role='alert'>
		        <h4>Tu sesión expiró!</h4>
    		    <p><a href='index.html'>Inicia Sesión</a></p></div>";
        		exit;
				}
			if($sesion['permiso']>$permiso){
				echo "<div class='alert alert-danger mt-4' role='alert'>
	            <h4>No tienes permiso para esta página.</h4>
    	        <p><a href='inicio.php'>Inicio</a></p>
    	        <p><a href='index.html'>Inicia sesión!</a></p>
				</div>";
    	        exit;
				}
			}
		}


        public function query_table($campos,$pseudonimos,$nombre,$condicion){
                $tabla="<table border><tr>";
                $sql="select ";
                $tabla.="</tr>";
                $max=sizeof($campos);
                for($i=0;$i<sizeof($pseudonimos);$i++){
                        $tabla.="<th>".$pseudonimos[$i]."</th>";
                        }
		for($i=0;$i<sizeof($campos);$i++){
                        $sql.=$campos[$i].",";
			}
                $sql.="'' from ".$nombre." ".$condicion;
                echo $sql."<br>";
                $result=$this->query($sql);
                while($row=mysqli_fetch_array($result)){
                        $tabla.="<tr>";
                        for($i=0;$i<$max;$i++){
                                $tabla.="<td>".$row[$i]."</td>";
                                }
                        $tabla.="</tr>";
                        }
                $tabla.="</table><br>";
                return $tabla;
                }

        public function make_link($file,$text,$opc){
                $link="<form action='".$file."' method=post><input type=hidden name=opcion value='".$opc."'><input type=submit value='".$text."'></form>";
                return $link;
                }


}

?>