<?php

/* 
 * Clase que modela a que grupo pertenece un beneficiario
 * los posibles valores actualmente son A y B
 */

class CBeneficiarioGrupo{
    /**
     * Identificador unico del grupo
     * @var type integer 
     */
    var $idGrupoBeneficiario;
    var $descGrupoBeneficiario; 
    /**
     * Constructor de la clase CBeneficiarioGrupo
     * @param type integer $idGrupoBeneficiario
     * @param type string $descGrupoBeneficiario
     */
    function CBeneficiarioGrupo($idGrupoBeneficiario, $descGrupoBeneficiario) {
        $this->idGrupoBeneficiario = $idGrupoBeneficiario;
        $this->descGrupoBeneficiario = $descGrupoBeneficiario;
    }
    /**
     * inicializa un grupo con todos sus variables en null
     */
    function InitCGrupoBeneficiario() {
        $this->idGrupoBeneficiario = null;
        $this->descGrupoBeneficiario = null;
    }   
    /**
     * función que retorna el identificador único del grupo
     * @return type integer
     */
    public function getIdGrupoBeneficiario() {
        return $this->idGrupoBeneficiario;
    }
    /**
     * función que retorna la descripcion del grupo
     */
    public function getDescGrupoBeneficiario() {
        return $this->descGrupoBeneficiario;
    }       
}