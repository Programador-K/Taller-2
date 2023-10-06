<?php

namespace modelo;

use PDO;
use modelo\Usuario;
use conexion\Database;


require_once './conexion/database.php';
require_once './modelo/usuario.php';


class UsuarioDao
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function validateIdentificacion(int $identificacion): bool
    {
        $query = "SELECT * FROM usuarios WHERE identificacion = :identificacion";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':identificacion', $identificacion);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($usuario !== false);
    }

    public function validateEmail(string $email): bool
    {
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($usuario !== false);
    }

    public function validateCiudadId(int $id): bool
    {
        $query = "SELECT COUNT(*) as count FROM ciudades WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function validateSexoId(int $id): bool
    {
        $query = "SELECT COUNT(*) as count FROM sexos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function validateTipoPersonaId(int $id): bool
    {
        $query = "SELECT COUNT(*) as count FROM tipos_persona WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function validateActualizarEmail(string $email, $userId): bool
    {
        $query = "SELECT COUNT(*) FROM usuarios WHERE email = :email AND id <> :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }

    public function validateActualizarIdentificacion(int $identificacion, $userId): bool
    {
        $query = "SELECT COUNT(*) FROM usuarios WHERE identificacion = :identificacion AND id <> :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':identificacion', $identificacion, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }

    public function obtenerUsuarios(): array
    {
        $query = "SELECT U.*, G.id AS sexo_id, G.nombre AS sexo_nombre, C.id AS ciudad_id, C.nombre AS ciudad_nombre, T.id AS tipo_persona_id, T.nombre AS tipo_persona_nombre
              FROM usuarios AS U
              INNER JOIN sexos AS G ON U.sexo_id = G.id
              INNER JOIN tipos_persona AS T ON U.tipo_persona_id = T.id
              INNER JOIN ciudades AS C ON U.ciudad_id = C.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $usuarios = [];

        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new Usuario();
            $usuario->setId($result['id']);
            $usuario->setIdentificacion($result['identificacion']);
            $usuario->setNombres($result['nombres']);
            $usuario->setApellidos($result['apellidos']);
            $usuario->setEmail($result['email']);
            $usuario->setObservaciones($result['observaciones']);
            $usuario->setFechaNacimiento($result['fecha_nacimiento']);
            $usuario->setHoraRegistro($result['hora_registro']);
            $usuario->setTiempoEvento($result['tiempo_evento']);
            $usuario->setCiudadId($result['ciudad_id']);
            $usuario->setCiudadNombre($result['ciudad_nombre']);
            $usuario->setSexoId($result['sexo_id']);
            $usuario->setSexoNombre($result['sexo_nombre']);
            $usuario->setTipoPersonaId($result['tipo_persona_id']);
            $usuario->setTipoPersonaNombre($result['tipo_persona_nombre']);

            $usuarios[] = $usuario->toString();
        }

        return $usuarios;
    }

    public function obtenerUsuarioPorId(int $id): ?Usuario
    {
        $query = "SELECT U.*, G.id AS sexo_id, G.nombre AS sexo_nombre, C.id AS ciudad_id, C.nombre AS ciudad_nombre, T.id AS tipo_persona_id, T.nombre AS tipo_persona_nombre
        FROM usuarios AS U
        INNER JOIN sexos AS G ON U.sexo_id = G.id
        INNER JOIN tipos_persona AS T ON U.tipo_persona_id = T.id
        INNER JOIN ciudades AS C ON U.ciudad_id = C.id
        WHERE U.id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $usuario = new Usuario();
        $usuario->setId($result['id']);
        $usuario->setIdentificacion($result['identificacion']);
        $usuario->setNombres($result['nombres']);
        $usuario->setApellidos($result['apellidos']);
        $usuario->setEmail($result['email']);
        $usuario->setObservaciones($result['observaciones']);
        $usuario->setFechaNacimiento($result['fecha_nacimiento']);
        $usuario->setHoraRegistro($result['hora_registro']);
        $usuario->setTiempoEvento($result['tiempo_evento']);
        $usuario->setCiudadId($result['ciudad_id']);
        $usuario->setCiudadNombre($result['ciudad_nombre']);
        $usuario->setSexoId($result['sexo_id']);
        $usuario->setSexoNombre($result['sexo_nombre']);
        $usuario->setTipoPersonaId($result['tipo_persona_id']);
        $usuario->setTipoPersonaNombre($result['tipo_persona_nombre']);

        return $usuario;
    }

    public function crearUsuario(Usuario $usuario): ?Usuario
    {
        $query = "INSERT INTO usuarios (identificacion, nombres, apellidos, email, observaciones, fecha_nacimiento, tiempo_evento, hora_registro, sexo_id, ciudad_id, tipo_persona_id) 
              VALUES (:identificacion, :nombres, :apellidos, :email, :observaciones, :fecha_nacimiento, :tiempo_evento, :hora_registro, :sexo_id, :ciudad_id, :tipo_persona_id)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':identificacion', $usuario->getIdentificacion());
        $stmt->bindValue(':nombres', $usuario->getNombres());
        $stmt->bindValue(':apellidos', $usuario->getApellidos());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':observaciones', $usuario->getObservaciones());
        $stmt->bindValue(':fecha_nacimiento', $usuario->getFechaNacimiento());
        $stmt->bindValue(':tiempo_evento', $usuario->getTiempoEvento());
        $stmt->bindValue(':hora_registro', $usuario->getHoraRegistro());
        $stmt->bindValue(':sexo_id', $usuario->getSexoId());
        $stmt->bindValue(':ciudad_id', $usuario->getCiudadId());
        $stmt->bindValue(':tipo_persona_id', $usuario->getTipoPersonaId());

        if($stmt->execute()){

            $lastInsertedId = $this->db->lastInsertId();
            return $this->obtenerUsuarioPorId($lastInsertedId);
        }

        return null;
    }

    public function eliminarUsuario(int $id): ?Usuario
    {
        $usuario = $this->obtenerUsuarioPorId($id);
        
        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $usuario;
    }

    public function actualizarUsuario(Usuario $usuario): ?Usuario
    {
        $query = "UPDATE usuarios 
              SET identificacion = :identificacion, 
                  nombres = :nombres, 
                  apellidos = :apellidos, 
                  email = :email, 
                  observaciones = :observaciones, 
                  fecha_nacimiento = :fecha_nacimiento, 
                  tiempo_evento = :tiempo_evento, 
                  hora_registro = :hora_registro, 
                  sexo_id = :sexo_id, 
                  ciudad_id = :ciudad_id, 
                  tipo_persona_id = :tipo_persona_id
              WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $usuario->getId());
        $stmt->bindValue(':identificacion', $usuario->getIdentificacion());
        $stmt->bindValue(':nombres', $usuario->getNombres());
        $stmt->bindValue(':apellidos', $usuario->getApellidos());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':observaciones', $usuario->getObservaciones());
        $stmt->bindValue(':fecha_nacimiento', $usuario->getFechaNacimiento());
        $stmt->bindValue(':tiempo_evento', $usuario->getTiempoEvento());
        $stmt->bindValue(':hora_registro', $usuario->getHoraRegistro());
        $stmt->bindValue(':sexo_id', $usuario->getSexoId());
        $stmt->bindValue(':ciudad_id', $usuario->getCiudadId());
        $stmt->bindValue(':tipo_persona_id', $usuario->getTipoPersonaId());

        if ($stmt->execute()) {
            return $this->obtenerUsuarioPorId($usuario->getId());
        }

        return null;
    }

}
