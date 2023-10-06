<?php


use validaciones\Validate;
use controlador\UsuarioControlador;

require_once './validaciones/validate.php';
require_once './controlador/usuarioControlador.php';

$validador = new Validate();
$controlador = new UsuarioControlador();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['controller']) && isset($_GET['action'])) {
            $controller = $_GET['controller'];
            $action = $_GET['action'];

            if ($controller === 'user') {
                if ($action === 'get') {
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        echo json_encode($controlador->obtenerUsuarioPorId($id));
                    }  else {
                        echo json_encode(['estado' => 'error', 'mensaje' => 'El parámetro "id" es requerido para la acción "get".']);
                    }
                } else if($action === "list") {
                    
                    echo json_encode($controlador->obtenerUsuarios());

                } else {
                    echo json_encode(['estado' => 'error', 'mensaje' => 'Acción no válida.']);
                }
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Controlador no válido.']);
            }
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Los parámetros "controller" y "action" son requeridos en la URL.']);
        }
        break;
    case 'POST':
        if (isset($_GET['controller']) && isset($_GET['action'])) {
            $controller = $_GET['controller'];
            $action = $_GET['action'];

            if ($controller === 'user') {
                if ($action === 'insert') {
                    $requestData = json_decode(file_get_contents('php://input'), true);

                    echo json_encode($controlador->crearUsuario($requestData));

                } else {
                    echo json_encode(['estado' => 'error', 'mensaje' => 'Acción no válida.']);
                }
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Controlador no válido.']);
            }
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Los parámetros "controller" y "action" son requeridos en la URL.']);
        }
        break;
    case 'DELETE': 
        if (isset($_GET['controller']) && isset($_GET['action'])) {
            $controller = $_GET['controller'];
            $action = $_GET['action'];

            if ($controller === 'user') {
                if ($action === 'delete') {
                    $id = $_GET['id'];
                    
                    echo json_encode($controlador->eliminarUsuario($id));

                } else {
                    echo json_encode(['estado' => 'error', 'mensaje' => 'Acción no válida.']);
                }
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Controlador no válido.']);
            }
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Los parámetros "controller" y "action" son requeridos en la URL.']);
        }

        break;
    case 'PUT': 
        if (isset($_GET['controller']) && isset($_GET['action'])) {
            $controller = $_GET['controller'];
            $action = $_GET['action'];

            if ($controller === 'user') {
                if ($action === 'update') {
                    $id = $_GET['id'];

                    $requestData = json_decode(file_get_contents('php://input'), true);

                    echo json_encode($controlador->actualizarUsuario($id, $requestData));

                } else {
                    echo json_encode(['estado' => 'error', 'mensaje' => 'Acción no válida.']);
                }
            } else {
                echo json_encode(['estado' => 'error', 'mensaje' => 'Controlador no válido.']);
            }
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Los parámetros "controller" y "action" son requeridos en la URL.']);
        }

        break;
    default:
        echo json_encode(['estado' => 'error', 'mensaje' => 'Método no válido.']);
        break;
}
