
<?php
session_start();

// Reiniciar la partida
if (isset($_GET['reiniciar']) && $_GET['reiniciar'] == 1) {
    unset($_SESSION['palabra'], $_SESSION['vidas'], $_SESSION['letras_acertadas'], $_SESSION['letras_usadas']);
    header('Location: index.php');
    exit();
}

// Lista de palabras
$palabras = ['elefante', 'jirafa', 'hipopotamo', 'rinoceronte', 'cocodrilo', 'camello', 'chimpance', 'leopardo', 'tortuga', 'delfin'];

// Iniciar el juego
if (!isset($_SESSION['palabra'])) {
    $_SESSION['palabra'] = $palabras[array_rand($palabras)];
    $_SESSION['vidas'] = 6;
    $_SESSION['letras_acertadas'] = str_repeat('?', strlen($_SESSION['palabra']));
    $_SESSION['letras_usadas'] = [];
}

// Comprobar la letra
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['letra'])) {
    $letra = strtolower(trim($_POST['letra']));

    if (!preg_match('/^[a-z]$/', $letra)) {
        $mensaje = 'Introduce una sola letra.';
    } elseif (in_array($letra, $_SESSION['letras_usadas'], true)) {
        $mensaje = 'Ya has usado esa letra.';
    } else {
        $_SESSION['letras_usadas'][] = $letra;

        if (strpos($_SESSION['palabra'], $letra) !== false) {
            for ($i = 0; $i < strlen($_SESSION['palabra']); $i++) {
                if ($_SESSION['palabra'][$i] === $letra) {
                    $_SESSION['letras_acertadas'][$i] = $letra;
                }
            }
        } else {
            $_SESSION['vidas']--;
        }
    }
}

// Comprobar si ha ganado o perdido
if ($_SESSION['letras_acertadas'] === $_SESSION['palabra']) {
    header('Location: ganar.php');
    exit();
}

if ($_SESSION['vidas'] <= 0) {
    header('Location: perder.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego del Ahorcado</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <main class="contenedor">
        <h1>Juego del Ahorcado</h1>

        <?php if ($mensaje !== ''): ?>
            <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <p>Palabra secreta:
            <strong class="palabra">
                <?php echo htmlspecialchars($_SESSION['letras_acertadas']); ?>
            </strong>
        </p>

        <p>Vidas restantes: <?php echo $_SESSION['vidas']; ?></p>

        <form method="post">
            <label for="letra">Introduce una letra:</label>
            <input type="text" name="letra" id="letra"
                   maxlength="1" pattern="[A-Za-z]" required autofocus>
            <button type="submit">Adivinar</button>
        </form>

        <p>Letras usadas:
            <?php echo htmlspecialchars(implode(', ', $_SESSION['letras_usadas'])); ?>
        </p>
    </main>

</body>
</html>
