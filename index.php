<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "solicitudes"; // La base de datos 

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
//echo "Conexión exitosa<br>";//

// Inicializar variables de consulta
$consulta_nombre = '';
$consulta_ciudad = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Recoger los datos del formulario de inserción
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $domicilio = $_POST['domicilio'];
        $ciudad = $_POST['ciudad'];
        $zona = $_POST['zona'];
        $vacante = $_POST['vacante'];

        // Insertar datos en la tabla 'clientes'
        $sql = "INSERT INTO clientes (nombre, edad, domicilio, ciudad, zona, vacante) VALUES ('$nombre', '$edad', '$domicilio', '$ciudad', '$zona', '$vacante')";
        
        if ($conexion->query($sql) === TRUE) {
            echo "Nuevo registro creado con éxito<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }

    if (isset($_POST['consultar'])) {
        // Recoger los datos del formulario de consulta
        $consulta_nombre = $_POST['consulta_nombre'];
        $consulta_ciudad = $_POST['consulta_ciudad'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <h1>Formulario de Clientes</h1>

    <form action="index.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required><br><br>

        <label for="domicilio">Domicilio:</label>
        <input type="text" id="domicilio" name="domicilio" required><br><br>

        <label for="ciudad">Ciudad:</label>
        <input type="text" id="ciudad" name="ciudad" required><br><br>

        <label for="zona">Zona:</label>
        <input type="text" id="zona" name="zona" required><br><br>

        <label for="vacante">Vacante:</label>
        <input type="text" id="vacante" name="vacante" required><br><br>

        <input type="submit" name="submit" value="Agregar Cliente">
    </form>

    <h2>Consultar Clientes</h2>

    <form action="index.php" method="post">
        <label for="consulta_nombre">Nombre:</label>
        <input type="text" id="consulta_nombre" name="consulta_nombre" value="<?php echo htmlspecialchars($consulta_nombre); ?>"><br><br>

        <label for="consulta_ciudad">Ciudad:</label>
        <input type="text" id="consulta_ciudad" name="consulta_ciudad" value="<?php echo htmlspecialchars($consulta_ciudad); ?>"><br><br>

        <input type="submit" name="consultar" value="Consultar">
    </form>

    <h2>Lista de Clientes</h2>

    <?php
    // Construir la consulta SQL basada en los filtros de consulta
    $sql = "SELECT id, nombre, edad, domicilio, ciudad, zona, vacante FROM clientes WHERE 1=1";

    if (!empty($consulta_nombre)) {
        $sql .= " AND nombre LIKE '%$consulta_nombre%'";
    }
    if (!empty($consulta_ciudad)) {
        $sql .= " AND ciudad LIKE '%$consulta_ciudad%'";
    }

    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Nombre</th><th>Edad</th><th>Domicilio</th><th>Ciudad</th><th>Zona</th><th>Vacante</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nombre"] . "</td><td>" . $row["edad"] . "</td><td>" . $row["domicilio"] . "</td><td>" . $row["ciudad"] . "</td><td>" . $row["zona"] . "</td><td>" . $row["vacante"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 resultados";
    }

    $conexion->close();
    ?>
</body>
</html>
