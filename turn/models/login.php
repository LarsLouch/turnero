<?php 
session_start();
header('Content-Type: application/json'); // 🔥 Respuesta en formato JSON

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Método no permitido']);
    exit;
}

// 🔍 Verificar si se recibe 'accion'
if (!isset($_POST['accion']) || $_POST['accion'] !== 'LoginUsuario') {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Acción inválida']);
    exit;
}

// 🔍 Verificar si usuario y contraseña están vacíos
$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($usuario) || empty($password)) {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Usuario y contraseña son obligatorios']);
    exit;
}

require_once('../config/conexion.php');

// 🔍 Obtener el usuario de la base de datos
$stmt = $mysqli->prepare("SELECT usuario, nombres, apellidos, password, modulo, servicio, nivel, estado FROM db_usuarios WHERE usuario = ?");
if (!$stmt) {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error en la consulta SQL']);
    exit;
}

$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Usuario no encontrado']);
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();

// 🚫 Verificar si el usuario está inactivo
if ($row['estado'] === 'I') {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Este usuario está desactivado']);
    exit;
}

// 🔑 Verificar la contraseña
if (password_verify($password, $row['password'])) {
    // ✅ Iniciar sesión
    $_SESSION['usuario'] = $row['usuario'];
    $_SESSION['nombre'] = $row['nombres'] . ' ' . $row['apellidos'];
    $_SESSION['modulo'] = $row['modulo'];
    $_SESSION['servicio'] = $row['servicio'];
    $_SESSION['nivel'] = $row['nivel'];

    echo json_encode([
        'codigo' => 0,
        'mensaje' => $row['nombres'] . ' ' . $row['apellidos'],
        'usuario' => $row['usuario'],
        'modulo' => $row['modulo'],
        'servicio' => $row['servicio'],
        'nivel' => $row['nivel']
    ]);
} else {
    echo json_encode(['codigo' => 1, 'mensaje' => 'Usuario o contraseña incorrectos']);
}

$mysqli->close();
exit;
?>
