
<?php
session_start();

// Comprobar si ha perdido
if (!isset($_SESSION['palabra'], $_SESSION['vidas']) ||
    $_SESSION['vidas'] > 0) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Has perdido</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <main class="contenedor">
        <h1>Has perdido</h1>

        <p>Te has quedado sin vidas.</p>

        <p>La palabra era:
            <strong><?php echo htmlspecialchars($_SESSION['palabra']); ?></strong>
        </p>

        <a class="boton" href="index.php?reiniciar=1">Jugar de nuevo</a>
    </main>

</body>
</html>
