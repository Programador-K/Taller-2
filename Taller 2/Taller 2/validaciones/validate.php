<?php

namespace validaciones;

use modelo\UsuarioDAO;

require_once './modelo/usuarioDAO.php';

class Validate
{

    private $usuarioDAO;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
    }

    private function enviarError($campo, $mensaje)
    {
        return [
            $campo => $mensaje,
        ];
    }

    private function validarAtributos($requestData, $atributos)
    {
        $errores = [];

        foreach ($atributos as $atributo => $validaciones) {
            if (!isset($requestData[$atributo])) {
                $errores = array_merge($errores, $this->enviarError($atributo, "El campo '{$atributo}' es requerido."));
                continue; // Continuar con el siguiente atributo si falta
            }

            $valor = $requestData[$atributo];

            foreach ($validaciones as $validacion) {
                $tipoValidacion = $validacion['tipo'];
                $mensajeError = $validacion['mensajeError'];

                switch ($tipoValidacion) {
                    case 'string':
                        if (!is_string($valor)) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        } elseif (isset($validacion['minLongitud']) && strlen($valor) < $validacion['minLongitud']) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        } elseif (isset($validacion['maxLongitud']) && strlen($valor) > $validacion['maxLongitud']) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        }
                        break;
                    case 'int':
                        if (!is_numeric($valor) || intval($valor) <= 0) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        }
                        break;
                    case 'email':
                        if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        } elseif (isset($validacion['maxLongitud']) && strlen($valor) > $validacion['maxLongitud']) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        }
                        break;
                    case 'date':
                        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $valor)) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        }
                        break;
                    case 'in_array':
                        if (!in_array(strtoupper($valor), $validacion['opciones'])) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        }
                        break;
                    case 'time':
                        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $valor)) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        }
                        break;
                    case 'datetime':
                        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $valor)) {
                            $errores = array_merge($errores, $this->enviarError($atributo, $mensajeError));
                        }
                        break;
                }
            }
        }

        return $errores;
    }


    public function validar($requestData, $actualizar, $id)
    {
        $atributos = [
            'identificacion' => [
                ['tipo' => 'int', 'minLongitud' => 5, 'maxLongitud' => 15, 'mensajeError' => 'El campo \'identificacion\' debe ser una cadena de 5 a 15 caracteres.']
            ],
            'nombres' => [
                ['tipo' => 'string', 'minLongitud' => 5, 'maxLongitud' => 30, 'mensajeError' => 'El campo \'nombres\' debe ser una cadena de 5 a 30 caracteres.']
            ],
            'apellidos' => [
                ['tipo' => 'string', 'minLongitud' => 5, 'maxLongitud' => 30, 'mensajeError' => 'El campo \'apellidos\' debe ser una cadena de 5 a 30 caracteres.']
            ],
            'fecha_nacimiento' => [
                ['tipo' => 'date', 'mensajeError' => 'El campo \'fecha_nacimiento\' debe tener el formato AAAA-MM-DD.']
            ],
            'email' => [
                ['tipo' => 'email', 'maxLongitud' => 100, 'mensajeError' => 'El campo \'email\' no es un correo electrónico válido.']
            ],
            'ciudad_id' => [
                ['tipo' => 'int', 'minLongitud' => 0, 'maxLongitud' => 20, 'mensajeError' => 'El campo \'ciudad_id\' debe ser un valor númerico.']
            ],
            'persona_tipo_id' => [
                ['tipo' => 'int', 'minLongitud' => 0, 'maxLongitud' => 20, 'mensajeError' => 'El campo \'persona_tipo_id\' debe ser un valor númerico.']
            ],
            'sexo_id' => [
                ['tipo' => 'int', 'minLongitud' => 0, 'maxLongitud' => 20, 'mensajeError' => 'El campo \'sexo_id\' debe ser un valor númerico.']
            ],
            'hora_registro' => [
                ['tipo' => 'time', 'mensajeError' => 'El campo \'hora_registro\' debe tener el formato HH:MM:SS.']
            ],
            'tiempo_evento' => [
                ['tipo' => 'datetime', 'mensajeError' => 'El campo \'tiempo_accion\' debe tener el formato AAAA-MM-DD HH:MM:SS.']
            ],
            'observaciones' => [
                ['tipo' => 'string', 'minLongitud' => 0, 'maxLongitud' => 300, 'mensajeError' => 'El campo \'observaciones\' debe ser una cadena.']
            ]
        ];

        $errores = $this->validarAtributos($requestData, $atributos);


        if ($actualizar) {

            if (!$this->usuarioDAO->validateActualizarEmail($requestData['email'], $id)) {
                $errores['email'] = 'el email ya existe para su registro.';
            }

            if (!$this->usuarioDAO->validateActualizarIdentificacion($requestData['identificacion'], $id)) {
                $errores['identificacion'] = 'La identificación ya existe para su registro.';
            }

        } else {

            if ($this->usuarioDAO->validateIdentificacion($requestData['identificacion'])) {
                $errores['identificacion'] = 'La identificación ya existe en la base de datos.';
            } 
            if ($this->usuarioDAO->validateEmail($requestData['email'])) {
                $errores['email'] = 'El email ya existe en la base de datos.';
            }

        }


        if (!$this->usuarioDAO->validateCiudadId(intval($requestData['ciudad_id']))) {
            $errores['ciudad_id'] = 'El ID de la ciudad no es válido.';
        }

        if (!$this->usuarioDAO->validateSexoId(intval($requestData['sexo_id']))) {
            $errores['sexo_id'] = 'El ID del género no es válido.';
        }

        if (!$this->usuarioDAO->validateTipoPersonaId(intval($requestData['persona_tipo_id']))) {
            $errores['persona_tipo_id'] = 'El ID del tipo de persona no es válido.';
        }

        if (!empty($errores)) {
            return [
                'code' => 301,
                'message' => 'Existen errores en los campos del registro',
                'data' => $errores,
                'status' => 'USER_INSERT_ERROR'
            ];
        }

        return [
            'code' => 200
        ];
    }
}
