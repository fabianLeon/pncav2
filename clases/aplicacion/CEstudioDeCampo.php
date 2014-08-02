<?php

/* 
 * Clase que modela un estudio de campo
 */
class CEstudiosDeCampo{
    
    var $idEstudioDeCampo;
    var $idBeneficiario;
    var $idEstado;
    var $fechaRealizacion;
    var $fechaValidacion;
    var $comunicado;
    
    function InitCEstudiosDeCampo() {
        $this->idEstudioDeCampo = null;
        $this->idBeneficiario = null;
        $this->idEstado = null;
        $this->fechaRealizacion = null;
        $this->fechaValidacion = null;
        $this->comunicado = null;
    }
    
    function CEstudiosDeCampo($idEstudioDeCampo, $idBeneficiario, $idEstado, $fechaRealizacion, $fechaValidacion, $comunicado) {
        $this->idEstudioDeCampo = $idEstudioDeCampo;
        $this->idBeneficiario = $idBeneficiario;
        $this->idEstado = $idEstado;
        $this->fechaRealizacion = $fechaRealizacion;
        $this->fechaValidacion = $fechaValidacion;
        $this->comunicado = $comunicado;
    }

    public function getIdEstudioDeCampo() {
        return $this->idEstudioDeCampo;
    }

    public function getIdBeneficiario() {
        return $this->idBeneficiario;
    }

    public function getIdEstado() {
        return $this->idEstado;
    }

    public function getFechaRealizacion() {
        return $this->fechaRealizacion;
    }

    public function getFechaValidacion() {
        return $this->fechaValidacion;
    }

    public function getComunicado() {
        return $this->comunicado;
    }
}
