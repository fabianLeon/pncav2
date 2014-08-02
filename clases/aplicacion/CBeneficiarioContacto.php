<?php

/* 
 * Clase que modela el contácto de un beneficiario
 */
class CBeneficiarioContacto{
    /**
     * identificador único del contácto
     * @var type integer
     */
    var $idContacto;
    /**
     *primer nombre del contácto
     * @var type string 
     */
    var $priNombre;
    /**
     *segundo nombre del contácto
     * @var type string 
     */
    var $segNombre;
    /**
     *primer apellido del contácto
     * @var type string 
     */
    var $priApellido;
    /**
     *segundo apellido del contácto
     * @var type string 
     */
    var $segApellido;
    /**
     *cargo en que trabaja el contácto
     * @var type string 
     */
    var $cargo;
    /**
     *número de celular del contácto
     * @var type string 
     */
    var $celular;
    
    /**
     * Constructor de la clase CBeneficiarioContacto crea un nuevo contácto 
     * @param type integer $idContacto identificador único del contacto
     * @param type string $priNombre primer nombre
     * @param type string $segNombre segundo nombre
     * @param type string $priApellido primer apellido
     * @param type string $segApellido segundo apellido
     * @param type string $cargo cargo del contácto
     * @param type string $celular celular del contácto
     */
    
    function CBeneficiarioContacto($idContacto, $priNombre, $segNombre, $priApellido, $segApellido, $cargo, $celular) {
        $this->idContacto = $idContacto;
        $this->priNombre = $priNombre;
        $this->segNombre = $segNombre;
        $this->priApellido = $priApellido;
        $this->segApellido = $segApellido;
        $this->cargo = $cargo;
        $this->celular = $celular;
    }
    
    /**
     * inicializa un contacto con todos sus valores en null
     */
    function InitCContactoBeneficiario() {
        $this->idContacto = null;
        $this->priNombre = null;
        $this->segNombre = null;
        $this->priApellido = null;
        $this->segApellido = null;
        $this->cargo = null;
        $this->celular = null;
    }
    /**
     * funcion que retorna el identificador unico del contácto
     * @return type integer $idContacto
     */
    public function getIdContacto() {
        return $this->idContacto;
    }
    /**
     * funcion que retorna el primer nombre de un contácto
     * @return type string
     */
    public function getPriNombre() {
        return $this->priNombre;
    }
    /**
     * funcion que retorna el segundo nombre de un contácto
     * @return type string
     */
    public function getSegNombre() {
        return $this->segNombre;
    }
    /**
     * funcion que retorna el primer apellido de un contácto
     * @return type string
     */
    public function getPriApellido() {
        return $this->priApellido;
    }
    /**
     * funcion que retorna el segundo apellido de un contácto
     * @return type string
     */
    public function getSegApellido() {
        return $this->segApellido;
    }
    /**
     * funcion que retorna el cargo de un contácto
     * @return type string
     */
    public function getCargo() {
        return $this->cargo;
    }
    /**
     * funcion que retorna el celular de un contácto
     * @return type string
     */
    public function getCelular() {
        return $this->celular;
    }
}