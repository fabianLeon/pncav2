<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CEstudioDeCampoEstado{
    
    var $idEstadoEstudioDeCampo;
    var $descEstadoEstudioDeCampo; 
    
    function CEstudioDeCampoEstado($idEstadoEstudioDeCampo, $descEstadoEstudioDeCampo) {
        $this->idEstadoEstudioDeCampo = $idEstadoEstudioDeCampo;
        $this->descEstadoEstudioDeCampo = $descEstadoEstudioDeCampo;
    }
    
    function InitCEstadoEstudioDeCampo() {
        $this->idEstadoEstudioDeCampo = null;
        $this->descEstadoEstudioDeCampo = null;
    }
    
    public function getIdEstadoEstudioDeCampo() {
        return $this->idEstadoEstudioDeCampo;
    }

    public function getDescEstadoEstudioDeCampo() {
        return $this->descEstadoEstudioDeCampo;
    }
}
