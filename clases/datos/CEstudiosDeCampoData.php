<?php

/**
 * Redcom Ltda
 * <ul> Desarrollado por
 * <li> Camaleon Multimedia ltda <www.camaleon.com.co></li>
 * <li> Copyright Redcom</li>
 * <li> Redcom Ltda</li>
 * </ul>
 */

/**
 * Usada para todas las funciones de acceso a datos referente a desembolsos para el modulo financiero
 *
 * @package  clases
 * @subpackage datos
 */
Class CEstudiosDeCampoData {

    var $db = null;

    function CEstudiosDeCampoData($db) {
        $this->db = $db;
    }
    
    function getEstudioDeCampo($criterio, $orden) {
        $eC = null;
        $sql = 
        "SELECT 
           e.idEstudioDeCampo id, b.codigoBeneficiario codigo, 
           t.desTipoBeneficiario tipo, g.desGrupoBeneficiario grupo
           , mb.desMetaBeneficiario meta, b.nombreSede nombre,
           concat(r.der_nombre,'-',d.dep_nombre,'-',m.mun_nombre,'-',b.direccionSede) ubicacion, 
           b.elegibilidad elegibilidad, concat(c.priNombre,' ',c.priApellido) contacto,
           c.cargo cargo, c.celular celular,ee.descEstado estado,
           e.fechaRealizacion fecha_r, e.fechaValidacion fecha_v
           , e.comunicado comunicado
        FROM
           beneficiario b, tipo_beneficiario t, grupo_beneficiario g,
           meta_beneficiario mb, contacto_beneficiario c,
           estado_estudio_de_campo ee, estudio_de_campo e,
           departamento_region r, departamento d, municipio m
        WHERE
           e.idBeneficiario = b.idBeneficiario and
           e.idEstado = ee.idEstadoEstudioDeCampo and
           b.idTipoBeneficiario = t.idTipoBeneficiario and
           b.idGrupoBeneficiario = g.idGrupoBeneficiario and
           b.idMetaBeneficiario = mb.idMetaBeneficiario and
           b.contactoBeneficiario_idContacto= c.idContacto and
           b.municipio = m.mun_id and
           m.dep_id = d.dep_id and
           d.der_id = r.der_id and ".
           $criterio. " order by ".$orden;
        //echo $sql;     
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $eC[$cont]['id']                = $w['id'];
                $eC[$cont]['codigoBeneficiario']= $w['codigo'];
                $eC[$cont]['tipoBeneficio']     = $w['tipo'];
                $eC[$cont]['grupoBeneficio']    = $w['grupo'];
                $eC[$cont]['metaBeneficio']     = $w['meta'];
                $eC[$cont]['nombreSede']        = $w['nombre'];
                $eC[$cont]['ubicacion']         = $w['ubicacion'];
                $eC[$cont]['elegibilidad']      = $w['elegibilidad'];
                $eC[$cont]['contacto']          = $w['contacto'];
                $eC[$cont]['contactoCargo']     = $w['cargo'];
                $eC[$cont]['contactoCelular']   = $w['celular'];
                $eC[$cont]['estadoEstudio']     = $w['estado'];
                $eC[$cont]['fechaRealizacion']  = $w['fecha_r'];
                $eC[$cont]['fechaValidacion']   = $w['fecha_v'];
                $eC[$cont]['comunicado']   = "<a href='".RUTA_DOCUMENTOS_ESTUDIOS .
                        "/".$w['comunicado']."' target='_blank'>{$w['comunicado']}</a>";
                $cont++;
            } 
             
        }
        return $eC;
    }

    function getEstudioDeCampoBiId($id) {
        $eC = null;
        $sql = 
        "SELECT 
           e.idEstudioDeCampo id, b.codigoBeneficiario codigo, 
           t.idTipoBeneficiario tipo, g.idGrupoBeneficiario grupo
           , mb.idMetaBeneficiario meta, b.nombreSede nombre,
           r.der_id region, d.dep_id departamento,
           m.mun_id municipio, b.direccionSede direccion, 
           b.elegibilidad elegibilidad, c.priNombre priNombre,
           c.priApellido priApellido, c.segNombre segNombre, c.segApellido segApellido,
           c.cargo cargo, c.celular celular,ee.idEstadoEstudioDeCampo estado,
           e.fechaRealizacion fecha_r, e.fechaValidacion fecha_v
           , e.comunicado comunicado
        FROM
           beneficiario b, tipo_beneficiario t, grupo_beneficiario g,
           meta_beneficiario mb, contacto_beneficiario c,
           estado_estudio_de_campo ee, estudio_de_campo e,
           departamento_region r, departamento d, municipio m
        WHERE
           e.idEstudioDeCampo = ".$id." and
           e.idBeneficiario = b.idBeneficiario and
           e.idEstado = ee.idEstadoEstudioDeCampo and
           b.idTipoBeneficiario = t.idTipoBeneficiario and
           b.idGrupoBeneficiario = g.idGrupoBeneficiario and
           b.idMetaBeneficiario = mb.idMetaBeneficiario and
           b.contactoBeneficiario_idContacto= c.idContacto and
           b.municipio = m.mun_id and
           m.dep_id = d.dep_id and
           d.der_id = r.der_id";
        
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            $eC['codigo']               = $w['codigo'];
            $eC['tipo']                 = $w['tipo'];
            $eC['grupo']                = $w['grupo'];
            $eC['meta']                 = $w['meta'];
            $eC['nombreSede']           = $w['nombre'];
            $eC['region']               = $w['region'];
            $eC['municipio']            = $w['municipio'];
            $eC['departamento']         = $w['departamento'];
            $eC['direccion']            = $w['direccion'];
            $eC['elegibilidad']         = $w['elegibilidad'];
            $eC['contacto']             = $w['contacto'];
            $eC['cargo']                = $w['cargo'];
            $eC['celular']              = $w['celular'];
            $eC['estado']               = $w['estado'];
            $eC['fecha_r']              = $w['fecha_r'];
            $eC['fecha_v']              = $w['fecha_v'];
            $eC['comunicado']           = $w['comunicado'];
            $eC['pri_nombre']           = $w['priNombre'];
            $eC['pri_apellido']         = $w['priApellido'];
            $eC['seg_nombre']           = $w['segNombre'];
            $eC['seg_apellido']         = $w['segApellido'];
        }
        return $eC;
    }
    
    /**
     * funcion que obtiene el beneficiario por el id
     * @param $id id del beneficiario
     * @return $beneficiario objeto CBeneficiario
     */
    function getBeneficiarioById($id) {
        $beneficiario = null;

        $sql = "select * from beneficiario where idBeneficiario=" . $id;
        //echo ("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            $beneficiario = new CBeneficiario($w['idBeneficiario'], 
                    $w['codigoBeneficiario'], $w['idTipoBeneficiario'], 
                    $w['idGrupoBeneficiario'], $w['idMetaBeneficiario'],
                    $w['nombreSede'], $w['direccionSede'], $w['municipio'],
                    $w['elegibilidad'], $w['ContactoBeneficiario_idContacto']);

            return $beneficiario;
        }
    }

    /**
     * funcion que obtiene el contacto del beneficiario por el id
     * @param $id id del contacto de beneficiario
     * @return $contactoBeneficiario objeto CEstudioDeCampo
     */
    function getContactoBeneficiarioById($id) {
        $contactoBeneficiario = null;
        $sql = "select * from contacto_beneficiario where idContacto=" . $id;
        //echo ("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            $contactoBeneficiario = new CBeneficiarioContacto($w['idContacto'], 
                    $w['priNombre'], $w['segNombre'], $w['priApellido'], 
                    $w['segApellido'], $w['cargo'], $w['celular']);
            return $contactoBeneficiario;
        }
    }

    /**
     * funcion que obtiene el tipo de beneficiario por el id
     * @param $id id del tipo de beneficiario
     * @return $tipoBeneficiario objeto CTipoBeneficiario
     */
    function getTipoBeneficiarioById($id) {
        $tipoBeneficiario = null;
        $sql = "select * from tipo_beneficiario where idTipoBeneficiario=" . $id;
        //echo ("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            $tipoBeneficiario = new CBeneficiarioTipo($w['idTipoBeneficiario'], 
                    $w['desTipoBeneficiario']);
            return $tipoBeneficiario;
        }
    }
    /**
     * funcion que obtiene la tabla de tipos de beneficiario
     * @return $tipoBeneficiario objeto CTipoBeneficiario
     */
    function getTipoBeneficiario($orden) {
        $sql = "select * from tipo_beneficiario order by ".$orden;
        $r = $this->db->ejecutarConsulta($sql);
        $tipoB = null;

        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $tipoB[$cont]['id'] = $w['idtipoBeneficiario'];
                $tipoB[$cont]['nombre'] = $w['desTipoBeneficiario'];
                $cont++;
            }
        }
        return $tipoB;
    }
    /**
     * funcion que obtiene la tabla de grupos de beneficiario
     * @return $tipoBeneficiario objeto CTipoBeneficiario
     */
    function getGrupoBeneficiario($orden) {
        $sql = "select * from grupo_beneficiario order by ".$orden;;
        $r = $this->db->ejecutarConsulta($sql);
        $grupo = null;

        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $grupo[$cont]['id'] = $w['idGrupoBeneficiario'];
                $grupo[$cont]['nombre'] = $w['desGrupoBeneficiario'];
                $cont++;
            }
        }
        return $grupo;
    }
    
    /**
     * funcion que obtiene el grupo del beneficiario por el id
     * @param $id id del tipo de beneficiario
     * @return $tipoBeneficiario objeto CTipoBeneficiario
     */
    function getGrupoBeneficiarioById($id) {
        $grupoBeneficiario = null;
        $sql = "select * from grupo_beneficiario where idGrupoBeneficiario=" . $id;
        //echo ("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            $grupoBeneficiario = new CBeneficiarioGrupo($w['idGrupoBeneficiario'], 
                    $w['desGrupoBeneficiario']);
        }
        return $grupoBeneficiario;
    }
    
    /**
     * funcion que obtiene la meta del beneficiario por el id
     * @param $id id de la meta del beneficiario
     * @return $tipoBeneficiario objeto CTipoBeneficiario
     */
    function getMetaBeneficiarioById($id) {
        $metaBeneficiario = null;
        $sql = "select * from meta_beneficiario where idMetaBeneficiario=" . $id;
        //echo ("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            $metaBeneficiario = new CBeneficiarioMeta($w['idMetaBeneficiario'], 
                    $w['desMetaBeneficiario']);
            return $metaBeneficiario;
        }
    }
    
    /**
     * funcion que obtiene la tabla de grupos de beneficiario
     * @return $tipoBeneficiario lista de todos los tipos de beneficiario
     */
    function getMetaBeneficiario($orden) {
        $sql = "select * from meta_beneficiario order by ".$orden;;
        $r = $this->db->ejecutarConsulta($sql);
        $tipo = null;

        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $tipo[$cont]['id'] = $w['idMetaBeneficiario'];
                $tipo[$cont]['nombre'] = $w['desMetaBeneficiario'];
                $cont++;
            }
        }
        return $tipo;
    }
    
    /**
     * funcion que obtiene la tabla del estado del estudio de campo
     * @return $estado lista de todos los estados posibles
     */
    function getEstado($orden) {
        $sql = "select * from estado_estudio_de_campo order by ".$orden;;
        $r = $this->db->ejecutarConsulta($sql);
        $estado = null;

        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $estado[$cont]['id'] = $w['idEstadoEstudioDeCampo'];
                $estado[$cont]['nombre'] = $w['descEstado'];
                $cont++;
            }
        }
        //var_dump($estado);
        return $estado;
    }
    
     /**
     * funcion que obtiene la meta del beneficiario por el id
     * @param $id id de la meta del beneficiario
     * @return $tipoBeneficiario objeto CTipoBeneficiario
     */
    function getEstadoEstudioById($id) {
        $estadoEstudio = null;
        $sql = "select * from estado_estudio_de_campo "
                . "where idEstadoEstudioDeCampo=" . $id;
        //echo ("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            $estadoEstudio = new CEstudioDeCampoEstado(
                $w['idEstadoEstudioDeCampo'], $w['descEstado']);
            return $estadoEstudio;
        }
    }
    
    function insertContacto($c){
        
        $tabla = "contacto_beneficiario";
        $campos = "priNombre,segNombre,priApellido,segApellido,cargo,celular";
       
        $valores ="'"  .$c->getPriNombre()."','".$c->getSegNombre().
                  "','".$c->getPriApellido()."','".$c->getSegApellido().
                  "','".$c->getCargo()."','" .$c->getCelular()."'";
        
         $i = $this->db->insertarRegistro($tabla,$campos,$valores);
        return $i;
    }
    
    function insertBeneficiario($b){
        $sql = "SELECT max(idContacto) FROM contacto_beneficiario";
        $r = mysql_fetch_array($this->db->ejecutarConsulta($sql));
        
        $tabla = "beneficiario";
        $campos = "codigoBeneficiario,idTipoBeneficiario,"
                . "idGrupoBeneficiario,idMetaBeneficiario,nombreSede,"
                . "direccionSede,municipio,elegibilidad,"
                . "ContactoBeneficiario_idContacto";
       
        $valores ="'".$b->getCodigoBeneficiario()."','".$b->getIdtipoBeneficiario().
                  "','".$b->getIdGrupoBeneficiario()."','".$b->getIdmetaBeneficiario().
                  "','".$b->getNombreSede()."','" .$b->getDireccionSede().
                  "','".$b->getMunicipio()."','" .$b->getElegibilidad().
                  "',".($r[0])."";                  
        $i = $this->db->insertarRegistro($tabla,$campos,$valores);
        return $i;
    }
    
        
    function getIds($id){
        $sql = 
        "select 
            e.idEstudioDeCampo estudio_id, 
            b.idBeneficiario beneficiario_id, c.idContacto contacto_id
        from 
            beneficiario b, contacto_beneficiario c, estudio_de_campo e
        where
            e.idEstudioDeCampo = ".$id." and
            b.idBeneficiario = e.idBeneficiario and
            c.idContacto = b.contactoBeneficiario_idContacto";
        $r = mysql_fetch_array($this->db->ejecutarConsulta($sql));
        return $r;
    }
    
    function deleteTabla($tb,$predicado){
        $r = $this->db->borrarRegistro($tb,$predicado);
        return $r;
    }
    
    function borrarUltimoContacto(){
        $sql = "SELECT max(idContacto) FROM contacto_beneficiario";
        $r = mysql_fetch_array($this->db->ejecutarConsulta($sql));
        $predicado = $tEPredicado = "idContacto = ".$r[0];
        $this->deleteTabla("contacto_beneficiario", $predicado);
    }
    
    function deleteEstudioDeCampo($id){
        $r = $this->getIds($id);
        $tBeneficiario = "beneficiario";
        $tBPredicado = "idBeneficiario = ".$r['beneficiario_id'];
        $tEcampo = "estudio_de_campo";
        $tEPredicado = "idEstudioDeCampo = ".$r['estudio_id'];
        $tCBeneficiario = "contacto_beneficiario";
        $tCPredicado = "idContacto = ".$r['contacto_id'];
        $e= $this->deleteTabla($tEcampo,$tEPredicado);
        $b= $this->deleteTabla($tBeneficiario,$tBPredicado);
        $c= $this->deleteTabla($tCBeneficiario,$tCPredicado);
        return($e && $b && $c);
    }
    
    function actualizarEstudioDeCampo($id,$contacto,$beneficiario,$estCampo){
        $r = $this->getIds($id);
        $e = $this->updateEstudioDeCampo($id, $estCampo);
        $b = $this->updateBeneficiario($r['beneficiario_id'], $beneficiario);
        $c = $this->updateContacto($r['contacto_id'],$contacto);
        if ($e == "true" && $b == "true" && $c == "true"){
            return "true";
        }
        else 
            return "false";
    }
    
    function updateEstudioDeCampo($id,$e){
        $tabla = "estudio_de_campo";
        $campos = array("idEstado","fechaRealizacion",
                "fechaValidacion");
        $comunicado = $e->getComunicado();
        $valores = array($e->getIdEstado(),"'".$e->getFechaRealizacion().
                "'","'".$e->getFechaValidacion()."'",);
        $condicion = "idEstudioDeCampo = ".$id;
        $noMatch = 1;
        
        if($comunicado['name']!=null){
            if($noMatch==1){
                array_push($campos, "comunicado");
                array_push($valores, "'".$comunicado['name']."'");
                    if($comunicado['size'] < MAX_SIZE_DOCUMENTOS){
                            $ruta = RUTA_DOCUMENTOS_ESTUDIOS."/";
                            $ruta = str_replace("\\",'/' , $ruta);
			    //echo ("<br>ruta: ".$ruta);
                            //echo ("<br>nombre: ".$comunicado['name']);                            
                            $carpetas = explode("/",substr($ruta,0,strlen($ruta)-1));
                            $cad = $_SERVER['DOCUMENT_ROOT'];
                            $ruta_destino = $cad;
                            //echo ("<br>cad: $cad");

                            foreach($carpetas as $c){
                                    //echo ("<br>ruta: $ruta_destino");
                                    $ruta_destino .= strtolower($c)."/";
                                    
                                    if(!is_dir($ruta_destino)) {
                                            mkdir($ruta_destino,0777);
                                            //echo ("creando: $c");
                                    }
                                    else {
                                            chmod($ruta_destino, 0777);
                                            //echo ("visitando: $c");
                                    }
                            }
                            $ruta_destino=$ruta_destino."/";
                            if(!is_dir($ruta_destino)) {
                                            mkdir($ruta_destino,0777);}
                                    else {
                                            chmod($ruta_destino, 0777);
                                    }
                                    //echo ("<br>ruta: ".$ruta_destino);
                            if(!(move_uploaded_file($comunicado['tmp_name'], strtolower($ruta_destino).$comunicado['name']))){
                                    $r = ERROR_COPIAR_ARCHIVO;
                            }else{
                                    $i = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
                            }
                    }else{
                            $r = ERROR_SIZE_ARCHIVO;
                    }
            }else{
                    $r = ERROR_FORMATO_ARCHIVO;
            }
    }   
        $i = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $i;
    }
    
    function updateBeneficiario($id,$b){
        $tabla = "beneficiario";
        $campos = array("codigoBeneficiario","idTipoBeneficiario",
                "idGrupoBeneficiario","idMetaBeneficiario","nombreSede",
                 "direccionSede","municipio","elegibilidad");
       
        $valores =array("'".$b->getCodigoBeneficiario()."'",$b->getIdtipoBeneficiario(),
                  $b->getIdGrupoBeneficiario(),$b->getIdmetaBeneficiario(),
                  "'".$b->getNombreSede()."'","'" .$b->getDireccionSede().
                  "'",$b->getMunicipio(),"'" .$b->getElegibilidad()."'");
        
        $condicion = "idBeneficiario = ".$id;        
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
        }
    
    function updateContacto($id,$c){
        
        $tabla = "contacto_beneficiario";
        $campos = array("priNombre","segNombre","priApellido","segApellido",
            "cargo","celular");
       
        $valores = array("'".$c->getPriNombre()."'","'".$c->getSegNombre().
                  "'","'".$c->getPriApellido()."'","'".$c->getSegApellido().
                  "'","'".$c->getCargo()."'","'" .$c->getCelular()."'");
        
        $condicion = "idContacto = ".$id;
        
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }
    
    function insertEstudioCampo($e){
        
        $sql = "SELECT max(idBeneficiario) FROM beneficiario";
        $r = mysql_fetch_array($this->db->ejecutarConsulta($sql));
        $tabla = "estudio_de_campo";
        $campos = "idBeneficiario,idEstado,fechaRealizacion,"
                ."fechaValidacion,comunicado";
        $comunicado = $e->getComunicado();
        $valores = $r[0].",'".$e->getIdEstado()."','".$e->getFechaRealizacion().
                "','".$e->getFechaValidacion()."','".$comunicado['name']."'";
        echo "comunicado:".$comunicado['name'];
        if($comunicado['name']!=null){
            if($comunicado['size'] < MAX_SIZE_DOCUMENTOS){
                $ruta = RUTA_DOCUMENTOS_ESTUDIOS."/";
                $ruta = str_replace("\\",'/' , $ruta);
                //echo ("<br>ruta: ".$ruta);
                //echo ("<br>nombre: ".$comunicado['name']);                            
                $carpetas = explode("/",substr($ruta,0,strlen($ruta)-1));
                $cad = $_SERVER['DOCUMENT_ROOT'];
                $ruta_destino = $cad;
                //echo ("<br>cad: $cad");

                foreach($carpetas as $c){
                    //echo ("<br>ruta: $ruta_destino");
                    $ruta_destino .= strtolower($c)."/";

                    if(!is_dir($ruta_destino)) {
                            mkdir($ruta_destino,0777);
                            //echo ("creando: $c");
                    }
                    else {
                            chmod($ruta_destino, 0777);
                            //echo ("visitando: $c");
                    }
                }
                $ruta_destino=$ruta_destino."/";
                if(!is_dir($ruta_destino)) {
                        mkdir($ruta_destino,0777);}
                else {
                        chmod($ruta_destino, 0777);
                }
                //echo ("<br>ruta: ".$ruta_destino);
                if(!(move_uploaded_file($comunicado['tmp_name'], 
                        strtolower($ruta_destino).$comunicado['name']))){
                        $r = ERROR_COPIAR_ARCHIVO;
                }else{
                        $i = $this->db->insertarRegistro($tabla, $campos, $valores);
                }
            }else{
                    $r = ERROR_SIZE_ARCHIVO;
            }
        }
        return $i;
    }
}
