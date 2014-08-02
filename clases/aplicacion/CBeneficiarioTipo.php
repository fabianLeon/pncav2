<?php

/* 
 *Clase que modela el tipo de beneficiario de un estudio de campo
 * actualmente solo existe A y B.
 */

class CBeneficiarioTipo{
    
    var $idTipoBeneficiario;
    var $desTipoBeneficiario;
    
    function CBeneficiarioTipo($idTipoBeneficiario, $descTipoBeneficiario) {
        $this->idTipoBeneficiario = $idTipoBeneficiario;
        $this->desTipoBeneficiario = $descTipoBeneficiario;
    }
    
    function InitCTipoBeneficiario() {
        $this->idTipoBeneficiario = null;
        $this->desTipoBeneficiario = null;
    }
    
    public function getIdTipoBeneficiario() {
        return $this->idTipoBeneficiario;
    }

    public function getDescTipoBeneficiario() {
        return $this->desTipoBeneficiario;
    }

}
