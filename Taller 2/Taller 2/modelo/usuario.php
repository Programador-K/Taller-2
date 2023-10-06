<?php

namespace modelo;

class Usuario
{
    private int $id;
    private string $identificacion;
    private string $nombres;
    private string $apellidos;
    private string $email;
    private string $observaciones;
    private string $fechaNacimiento;
    private string $horaRegistro;
    private string $tiempoEvento;
    private int $ciudadId;
    private string $ciudadNombre;
    private int $sexoId;
    private string $sexoNombre;
    private int $tipoPersonaId;
    private string $tipoPersonaNombre;

    public function __construct()
    {
        $this->id = -1;
        $this->identificacion = "";
        $this->nombres = "";
        $this->apellidos = "";
        $this->email = "";
        $this->observaciones = "";
        $this->fechaNacimiento = "";
        $this->horaRegistro = "";
        $this->tiempoEvento = "";
        $this->ciudadId = -1;
        $this->ciudadNombre = "";
        $this->sexoId = -1;
        $this->sexoNombre = "";
        $this->tipoPersonaId = -1;
        $this->tipoPersonaNombre = "";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdentificacion(): string
    {
        return $this->identificacion;
    }

    public function setIdentificacion(string $identificacion): void
    {
        $this->identificacion = $identificacion;
    }

    public function getNombres(): string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getObservaciones(): string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    public function getFechaNacimiento(): string
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(string $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getHoraRegistro(): string
    {
        return $this->horaRegistro;
    }

    public function setHoraRegistro(string $horaRegistro): void
    {
        $this->horaRegistro = $horaRegistro;
    }

    public function getTiempoEvento(): string
    {
        return $this->tiempoEvento;
    }

    public function setTiempoEvento(string $tiempoEvento): void
    {
        $this->tiempoEvento = $tiempoEvento;
    }

    public function getCiudadId(): int
    {
        return $this->ciudadId;
    }

    public function setCiudadId(int $ciudadId): void
    {
        $this->ciudadId = $ciudadId;
    }

    public function getCiudadNombre(): string
    {
        return $this->ciudadNombre;
    }

    public function setCiudadNombre(string $ciudadNombre): void
    {
        $this->ciudadNombre = $ciudadNombre;
    }

    public function getSexoId(): int
    {
        return $this->sexoId;
    }

    public function setSexoId(int $sexoId): void
    {
        $this->sexoId = $sexoId;
    }

    public function getSexoNombre(): string
    {
        return $this->sexoNombre;
    }

    public function setSexoNombre(string $sexoNombre): void
    {
        $this->sexoNombre = $sexoNombre;
    }

    public function getTipoPersonaId(): int
    {
        return $this->tipoPersonaId;
    }

    public function setTipoPersonaId(int $tipoPersonaId): void
    {
        $this->tipoPersonaId = $tipoPersonaId;
    }

    public function getTipoPersonaNombre(): string
    {
        return $this->tipoPersonaNombre;
    }

    public function setTipoPersonaNombre(string $tipoPersonaNombre): void
    {
        $this->tipoPersonaNombre = $tipoPersonaNombre;
    }

    public function toString()
    {
        return array(
            'id' => $this->getId(),
            'ciudad_id' => $this->getCiudadId(),
            'persona_tipo_id' => $this->getTipoPersonaId(),
            'sexo_id' => $this->getSexoId(),
            'identificacion' => $this->getIdentificacion(),
            'nombres' => $this->getNombres(),
            'apellidos' => $this->getApellidos(),
            'email' => $this->getEmail(),
            'fecha_nacimiento' => $this->getFechaNacimiento(),
            'hora_registro' => $this->getHoraRegistro(),
            'tiempo_evento' => $this->getTiempoEvento(),
            'observaciones' => $this->getObservaciones(),
            'ciudad' => array('id' => $this->getCiudadId(), 'nombre' => $this->getCiudadNombre()),
            'sexo' => array('id' => $this->getSexoId(), 'nombre' => $this->getSexoNombre()),
            'tipo' => array('id' => $this->getTipoPersonaId(), 'nombre' => $this->getTipoPersonaNombre())
        );
    }
}
