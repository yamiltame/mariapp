<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title> Productos </title>
	</head>
	<body>
		<h1>Productos</h1>
        <div>
            <form action='productos.php' method='post'>
                <input type=text name='buscar' placeholder='buscar...'>
                <input type=submit value='Buscar'>
            </form>
        </div>
        <?php echo $busqueda; ?>
		<div><?php echo $tabla; ?></div>
        <div><?php echo $empaginamiento; ?></div>
		<a href='inicio.php'>Inicio</a> <br>
		<a href='registroproductos.php'>Registrar nuevo producto</a> <br>
	</body>
</html>
