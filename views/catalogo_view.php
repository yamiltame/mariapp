<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title> Catálogo </title>
	</head>
	<body>
		<h1>Catálogo</h1>
        <div>
            <form action='catalogo.php' method='post'>
                <input type=text name='buscar' placeholder='buscar...'>
                <input type=submit value='Buscar'>
            </form>
        </div>
		<?php echo $busqueda; ?>
		<div><?php echo $tabla; ?></div>
        <div><?php echo $empaginamiento; ?></div>
		<a href='../controllers/inicio.php'>Inicio</a> <br>
	</body>
</html>
