<?php

namespace controlador;

use modelo\Usuario;
use modelo\UsuarioDao;
use validaciones\Validate;

require_once './modelo/Usuario.php';
require_once './modelo/UsuarioDao.php';
require_once './validaciones/validate.php';

class UsuarioControlador
{
    private $validarUsuario;
    private $usuarioDao;

    public function __construct()
    {
        $this->validarUsuario = new Validate();
        $this->usuarioDao = new UsuarioDao();
    }

    public function crearUsuario($datosUsuario)
    {
      
        $resultadoValidacion = $this->validarUsuario->validar($datosUsuario, false, -1);

        if ($resultadoValidacion['code'] === 301) {
            return $resultadoValidacion;
        }
        

        $usuario = new Usuario();

        $usuario->setIdentificacion($datosUsuario['identificacion']);
        $usuario->setNombres($datosUsuario['nombres']);
        $usuario->setApellidos($datosUsuario['apellidos']);
        $usuario->setFechaNacimiento($datosUsuario['fecha_nacimiento']);
        $usuario->setEmail($datosUsuario['email']);
        $usuario->setHoraRegistro($datosUsuario['hora_registro']);
        $usuario->setTiempoEvento($datosUsuario['tiempo_evento']);
        $usuario->setObservaciones($datosUsuario['observaciones']);
        $usuario->setCiudadId($datosUsuario['ciudad_id']);
        $usuario->setSexoId($datosUsuario['sexo_id']);
        $usuario->setTipoPersonaId($datosUsuario['persona_tipo_id']);

        $usuarioCreado = $this->usuarioDao->crearUsuario($usuario);


        if ($usuarioCreado ) {

            return array(
                'code' => 200,
                'message' => 'Registro guardado satisfactoriamente',
                'data' => $usuarioCreado->toString(),
                'status' => 'USER_INSERT_OK'
            );

        } else {
            return array(
                'code' => 301,
                'message' => 'Hubo un error al intentar almacenar la información del usuario',
                'data' => "",
                'status' => 'USER_INSERT_ERROR'
            );
        }
    }

    public function obtenerUsuarioPorId($id)
    {
        $usuario = $this->usuarioDao->obtenerUsuarioPorId($id);

        if ($usuario) {

            return array(
                'code' => 200,
                'message' => 'Usuario encontrado satisfactoriamente.',
                'data' => $usuario->toString(),
                'status' => 'USER_GET_ID_OK'
            );
        } else {
            return array(
                'code' => 404,
                'message' => 'El usuario con el número de identificación especificado no existe.',
                'data' => 'Registro no existente',
                'status' => 'USER_NOT_FOUND'
            );
        }
    }

    public function obtenerUsuarios()
    {
        $usuarios = $this->usuarioDao->obtenerUsuarios();

        return array(
            'code' => 200,
            'message' => 'Usuario encontrado satisfactoriamente.',
            'data' => $usuarios,
            'status' => 'USER_GET_ID_OK'
        );
    }


    public function actualizarUsuario($id, $datosUsuario)
    {
       
        $resultadoValidacion = $this->validarUsuario->validar($datosUsuario, true, $id);

        if ($resultadoValidacion['code'] === 301) {
            return $resultadoValidacion;
        }
        

        $usuarioExistente = $this->usuarioDao->obtenerUsuarioPorId($id);

        if (!$usuarioExistente) {
            return array(
                'code' => 404,
                'message' => 'El usuario con el número de identificación especificado no existe.',
                'data' => 'Registro no existente',
                'status' => 'USER_NOT_FOUND'
            );
        }

        $usuarioActualizado = new Usuario();

        $usuarioActualizado->setId($id);
        $usuarioActualizado->setIdentificacion($datosUsuario['identificacion']);
        $usuarioActualizado->setNombres($datosUsuario['nombres']);
        $usuarioActualizado->setApellidos($datosUsuario['apellidos']);
        $usuarioActualizado->setFechaNacimiento($datosUsuario['fecha_nacimiento']);
        $usuarioActualizado->setEmail($datosUsuario['email']);
        $usuarioActualizado->setHoraRegistro($datosUsuario['hora_registro']);
        $usuarioActualizado->setTiempoEvento($datosUsuario['tiempo_evento']);
        $usuarioActualizado->setObservaciones($datosUsuario['observaciones']);
        $usuarioActualizado->setCiudadId($datosUsuario['ciudad_id']);
        $usuarioActualizado->setSexoId($datosUsuario['sexo_id']);
        $usuarioActualizado->setTipoPersonaId($datosUsuario['persona_tipo_id']);


        $usuarioActualizado = $this->usuarioDao->actualizarUsuario($usuarioActualizado);

        if ($usuarioActualizado) {
            return array(
                'code' => 200,
                'message' => 'Usuario actualizado satisfactoriamente.',
                'data' => $usuarioActualizado->toString(),
                'status' => 'USER_UPDATE_OK'
            );
        } else {
            return array(
                'code' => 301,
                'message' => 'Hubo un error al intentar actualizar la información del usuario',
                'data' => "",
                'status' => 'USER_UPDATE_ERROR'
            );
        }
    }

    public function eliminarUsuario($id)
    {

        $usuario = $this->usuarioDao->eliminarUsuario($id);

        if ($usuario) {

            return array(
                'code' => 200,
                'message' => 'Usuario eliminado satisfactoriamente.',
                'data' => $usuario->toString(),
                'status' => 'USER_DELETE_OK'
            );

        } else {
            return array(
                'code' => 404,
                'message' => 'El usuario con el número de identificación especificado no existe.',
                'data' => 'Registro no existente',
                'status' => 'USER_NOT_FOUND'
            );
        }
    }
}
