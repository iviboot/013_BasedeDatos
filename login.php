<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $correct_password = "tu"; // Reemplaza "tu_contraseña" con la contraseña que desees usar

    if ($password == $correct_password) {
        $_SESSION['authenticated'] = true;
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Contraseña incorrecta. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Enlace a tu archivo CSS externo -->
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Entrar">
        </form>
        <?php
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
