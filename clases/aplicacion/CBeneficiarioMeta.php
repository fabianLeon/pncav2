<?php

/* 
 * Clase que modela la meta de un beneficiario
 * los posibles valores actualmente son 1, 2, 3, 4 y 
 */

class CBeneficiarioMeta{
    /**
     * identificador único de la meta del beneficiario
     * @var type integer
     */
    var $idMetaBeneficiario;
    /**
     * descripcion de la meta del beneficiario
     * @var type string
     */
    var $desMetaBeneficiario;
    
    /**
     * contructor de la clase CBeneficiarioMeta
     * @param type $idMetaBeneficiario
     * @param type $descMetaBeneficiario
     */
    function CBeneficiarioMeta($idMetaBeneficiario, $descMetaBeneficiario) {
        $this->idMetaBeneficiario = $idMetaBeneficiario;
        $this->desMetaBeneficiario = $descMetaBeneficiario;
    }
    /**
     * funcion que inicializa todos los valores de una meta en null
     */
    function InitCMetaBeneficiario() {
        $this->idMetaBeneficiario = null;
        $this->desMetaBeneficiario = null;
    }
    /**
     * funcion que retorna id único de una meta
     * @return type integer
     */
    public function getIdMetaBeneficiario() {
        return $this->idMetaBeneficiario;
    }
    /**
     * funcion que retorna la descripcion de una meta
     * @return type string
     */
    public function getDescMetaBeneficiario() {
        return $this->desMetaBeneficiario;
    }

}
