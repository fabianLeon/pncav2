<?php

/* 
 * Clase que modela el beneficiario de un estudio de campo
 */

class CBeneficiario {
    
    var $idBeneficiario;
    var $codigoBeneficiario;
    var $idtipoBeneficiario;
    var $idGrupoBeneficiario;
    var $idmetaBeneficiario;
    var $nombreSede;
    var $direccionSede;
    var $municipio;
    var $elegibilidad;
    var $idContacto;
    
    function CBeneficiario($idBeneficiario, $codigoBeneficiario, $idtipoBeneficiario, $idGrupoBeneficiario, $idmetaBeneficiario, $nombreSede, $direccionSede, $municipio, $elegibilidad, $idContacto) {
        $this->idBeneficiario = $idBeneficiario;
        $this->codigoBeneficiario = $codigoBeneficiario;
        $this->idtipoBeneficiario = $idtipoBeneficiario;
        $this->idGrupoBeneficiario = $idGrupoBeneficiario;
        $this->idmetaBeneficiario = $idmetaBeneficiario;
        $this->nombreSede = $nombreSede;
        $this->direccionSede = $direccionSede;
        $this->municipio = $municipio;
        $this->elegibilidad = $elegibilidad;
        $this->idContacto = $idContacto;
    }

    function InitCBeneficiario() {
            $this->idBeneficiario = null;
            $this->codigoBeneficiario = null;
            $this->idtipoBeneficiario = null;
            $this->idGrupoBeneficiario = null;
            $this->idmetaBeneficiario = null;
            $this->nombreSede = null;
            $this->direccionSede = null;
            $this->municipio = null;
            $this->elegibilidad = null;
            $this->idContacto = null;
    }
    
    public function getIdBeneficiario() {
        return $this->idBeneficiario;
    }

    public function getCodigoBeneficiario() {
        return $this->codigoBeneficiario;
    }

    public function getIdtipoBeneficiario() {
        return $this->idtipoBeneficiario;
    }

    public function getIdGrupoBeneficiario() {
        return $this->idGrupoBeneficiario;
    }

    public function getIdmetaBeneficiario() {
        return $this->idmetaBeneficiario;
    }

    public function getNombreSede() {
        return $this->nombreSede;
    }

    public function getDireccionSede() {
        return $this->direccionSede;
    }

    public function getMunicipio() {
        return $this->municipio;
    }

    public function getElegibilidad() {
        return $this->elegibilidad;
    }

    public function getIdContacto() {
        return $this->idContacto;
    }  
}
 
