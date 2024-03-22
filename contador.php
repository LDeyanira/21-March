<?php
// Obtener o generar un identificador único para el usuario
if (!isset($_COOKIE['user_id'])) {
    $user_id = uniqid(); // Genera un identificador único
    setcookie('user_id', $user_id, time() + (86400 * 30), "/"); // Establece una cookie válida por 30 días
} else {
    $user_id = $_COOKIE['user_id'];
}

// Establecer la conexión con la base de datos (reemplaza las credenciales con las tuyas)
$dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "upiih";
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Incrementar el contador de descargas para este usuario
$result = $mysqli->query("UPDATE downloads SET count = count + 1 WHERE user_id = '$user_id'");

// Verificar si la consulta fue exitosa
if ($result === FALSE) {
    die("Error al actualizar el contador: " . $mysqli->error);
}

// Obtener el contador actualizado para este usuario
$count_result = $mysqli->query("SELECT count FROM downloads WHERE user_id = '$user_id'");
if ($count_result === FALSE) {
    die("Error al obtener el contador de descargas: " . $mysqli->error);
}
$row = $count_result->fetch_assoc();
$download_count = $row['count'];

// Cerrar la conexión
$mysqli->close();
?>
