
<?php
session_start();

// Comprobar si ha ganado
if (!isset($_SESSION['palabra'], $_SESSION['letras_acertadas']) ||
    $_SESSION['letras_acertadas'] !== $_SESSION['palabra']) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Has ganado</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <main class="contenedor">
        <h1>¡Has ganado!</h1>

        <p>Has adivinado la palabra:
            <strong><?php echo htmlspecialchars($_SESSION['palabra']); ?></strong>
        </p>

        <a class="boton" href="index.php?reiniciar=1">Jugar de nuevo</a>
    </main>

</body>
</html>
