<?php
if (isset($_POST['accion']) && $_POST['accion'] == "ListarReportes") {
    require_once('../config/conexion.php');

    $fechainicio = $_POST['fechainicio'] ?? '';
    $fechafin = $_POST['fechafin'] ?? '';

    // Validación de fechas para evitar SQL Injection
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fechainicio) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $fechafin)) {
        echo json_encode(["error" => "Formato de fecha inválido"]);
        die();
    }

    $sql = "SELECT t.estado_turno, t.turno, s.nombre_servicio, 
            CONCAT(c.documento, '-', c.numero) AS numero,
            CONCAT(c.pnombre, ' ', c.papellido, ' ', c.sapellido) AS nombre,
            t.tiempo_ingreso, t.tiempo_salida,
            TIMEDIFF(t.tiempo_salida, t.tiempo_ingreso) AS diferencia
            FROM db_turnos t
            INNER JOIN db_clientes c ON t.documento = c.numero
            INNER JOIN db_servicios s ON t.tipo_servicio = s.id
            WHERE DATE_FORMAT(t.tiempo_ingreso, '%Y-%m-%d') BETWEEN ? AND ?";

    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $fechainicio, $fechafin);
        $stmt->execute();
        $result = $stmt->get_result();

        $arrTurnos = [];
        while ($row = $result->fetch_assoc()) {
            // Asignación del estado con etiquetas de Bootstrap
            switch ($row["estado_turno"]) {
                case "A":
                    $row["estado_turno"] = '<span class="badge bg-success">Activo</span>';
                    break;
                case "M":
                    $row["estado_turno"] = '<span class="badge bg-primary">Llamado</span>';
                    break;
                default:
                    $row["estado_turno"] = '<span class="badge bg-danger">Finalizado</span>';
                    break;
            }
            $arrTurnos[] = $row;
        }

        echo json_encode(["data" => $arrTurnos]);
        $stmt->close();
    } else {
        echo json_encode(["error" => "Error en la consulta"]);
    }

    $mysqli->close();
    die();
}
?>
