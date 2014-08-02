<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


defined('_VALID_PRY') or die('Restricted access');
$docData = new CEstudiosDeCampoData($db);
$planData = new CPlaneacionData($db);
$operador = $_REQUEST['operador'];
$task = $_REQUEST['task'];

if (empty($task)) {
    $task = 'list';
}

switch ($task) {

    case 'list':
        
        $codigo             = $_REQUEST['txt_numero'];
        $region             = $_REQUEST['txt_region'];
        $departamento       = $_REQUEST['txt_departamento'];
        $municipio          = $_REQUEST['txt_municipio'];
        $grupo              = $_REQUEST['txt_grupo'];
        $meta               = $_REQUEST['txt_meta'];
        $tipo_b             = $_REQUEST['txt_tipo_b'];
        $estado             = $_REQUEST['txt_estado'];
        $elegibilidad       = $_REQUEST['txt_elegibilidad'];
        
        $criterio = "b.codigoBeneficiario like'$codigo%'";
        $form = new CHtmlForm();

        $form->setTitle(TITULO_ESTUDIOS_DE_CAMPO);
        $form->setId('frm_list_estudio_campo');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        //filtro por código
        $form->addEtiqueta(CODIGO_BENEFICIARIO);
        $form->addInputText('text', 'txt_numero', 'txt_numero', '30', '30',
                $codigo, '', '');
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar',
                BTN_ACEPTAR, 'button', 'onClick=submit();');
        
        //filtro por tipo
        $opciones = null;
        $form -> addEtiqueta(TIPO_BENEFICIO);
        $tiposB = $docData->getTipoBeneficiario('idtipoBeneficiario');
        
        if (isset($tiposB)) {
            foreach ($tiposB as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_tipo_b', 'txt_tipo_b', $opciones, 
                SELECCION_TIPO, $tipo_b, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_tipo_b\');"');
        if($tipo_b != -1){
        $criterio = $criterio." and t.idTipoBeneficiario like'$tipo_b%'";}
        
        //filtro por grupos
        $opciones = null;
        $form -> addEtiqueta(GRUPO_BENEFICIO);
        $grupos = $docData->getGrupoBeneficiario('desGrupoBeneficiario');
        
        if (isset($grupos)) {
            foreach ($grupos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        
        $form->addSelect('select', 'txt_grupo', 'txt_grupo', $opciones,
                SELECCION_GRUPO, $grupo, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_grupo\');"');
        if($grupo != -1){
        $criterio = $criterio." and g.idGrupoBeneficiario like'$grupo%'";}
        
        //filtro por regiones
        $opciones = null;
        $form->addEtiqueta(PLANEACION_REGION);
        $regiones = $planData->getRegiones(' der_nombre');

        if (isset($regiones)) {
            foreach ($regiones as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }        
        
        $form->addSelect('select', 'txt_region', 'txt_region', $opciones, 
                PLANEACION_REGION, $region, '', 'onChange=submit();',
                'onkeypress="ocultarDiv(\'error_region\');"');
        
        if(isset($region)){
            $lugar = null;
            foreach ($regiones as $t) {
                if($t['id'] == $region){
                    $lugar = $t['nombre'];
                }
            }
            $criterio = $criterio." and r.der_nombre like '$lugar%'";
        }
        
        //filtro por Departamento
        
        $opciones = null;
        $form->addEtiqueta(PLANEACION_DEPARTAMENTO);
        $departamentos = $planData->getDepartamento($region, ' dep_nombre');
        if (isset($departamentos)) {
            foreach ($departamentos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_departamento', 'txt_departamento', 
                $opciones, PLANEACION_DEPARTAMENTO, $departamento, '', 'onChange=submit();',
                'onkeypress="ocultarDiv(\'error_departamento\');"');
        
        if(isset($departamento)){
            $lugar = null;
            foreach ($departamentos as $t) {
                if($t['id'] == $departamento){
                    $lugar = $t['nombre'];
                }
            }
            $criterio = $criterio." and d.dep_nombre like '$lugar%'";
        }
        //filtro por municipio
        $form->addEtiqueta(PLANEACION_MUNICIPIO);
        $opciones = null;
        $municipios = $planData->getMunicipio($departamento, ' mun_nombre');
        if (isset($municipios)) {
            foreach ($municipios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        
        $form->addSelect('select', 'txt_municipio', 'txt_municipio', $opciones,
                PLANEACION_MUNICIPIO, $municipio, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_municipio\');"');
        
        if(isset($municipio)){
            $lugar = null;
            foreach ($municipios as $t) {
                if($t['id'] == $municipio){
                    $lugar = $t['nombre'];
                }
            }
            $criterio = $criterio." and m.mun_nombre like '$lugar%'";
        }
        
        //filtro por estado
        $form->addEtiqueta(ESTADO_ESTUDIO);
        $opciones = null;
        $estados = $docData->getEstado('idEstadoEstudioDeCampo');
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_estado', 'txt_estado', $opciones,
                SELECCION_ESTADO, $estado, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_estado\');"');
        
        if($estado != -1){
        $criterio = $criterio." and ee.idEstadoEstudioDeCampo like'$estado%'";}
        
        //filtro por elegibilidad
        
        $form->addEtiqueta(ELEGIBILIDAD);
        $elegibilidades[0]['value'] = 'Si';$elegibilidades[0]['texto'] = "Si";
        $elegibilidades[1]['value'] = 'No';$elegibilidades[1]['texto'] = "No";
        $form->addSelect('select', 'txt_elegibilidad', 'txt_elegibilidad', $elegibilidades,
                INGRESE_ELEGIBILIDAD, $elegibilidad, '', 'onChange=submit();',
                'onkeypress="ocultarDiv(\'error_elegibilidad\');"');
        $form->addError('error_elegibilidad', ERROR_ELEGIBILIDAD); 
        
        if($elegibilidad != -1){
        $criterio = $criterio." and b.elegibilidad like'$elegibilidad%'";}
        
        $form->writeForm();
        $EstudioDeCampo = $docData->getEstudioDeCampo($criterio, 'e.idEstudioDeCampo');
        $dt = new CHtmlDataTableAlignable();
        
        $titulos = array(CODIGO_BENEFICIARIO,TIPO_BENEFICIO,GRUPO_BENEFICIO,
            META_BENEFICIO,NOMBRE_SEDE,UBICACION,ELEGIBILIDAD,
            NOMBRE_CONTACTO_BENEFICIARIO,CONTACTO_CARGO,CONTACTO_CELULAR,
            ESTADO_ESTUDIO,FECHA_REALIZACION, FECHA_VALIDACION,COMUNICADO);
        
        $dt->setDataRows($EstudioDeCampo);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TITULO_ESTUDIOS_DE_CAMPO);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add");

        $dt->setType(1);
        $dt->setPag(1);
        $dt->writeDataTable($niv);

        break;
    /**
     * la variable add, permite mostrar el formulario de adicion de 
     * estudios de campo
     */
    case 'add':
         
        $codigo             = $_REQUEST['txt_codigo'];
        $region             = $_REQUEST['txt_region'];
        $departamento       = $_REQUEST['txt_departamento'];
        $municipio          = $_REQUEST['txt_municipio'];
        $grupo              = $_REQUEST['txt_grupo'];
        $meta               = $_REQUEST['txt_meta'];
        $tipo_b             = $_REQUEST['txt_tipo_b'];
        $nombreSede         = $_REQUEST['txt_nombreSede'];
        $direccionSede      = $_REQUEST['txt_direccion_sede'];
        $elegibilidad       = $_REQUEST['txt_elegibilidad'];
        $fecha_realizacion  = $_REQUEST['txt_fecha_real'];
        $fecha_validacion   = $_REQUEST['txt_fecha_val'];
        $comunicadoFile     = $_FILES['file_comunicado_add'];
        $pri_nombre         = $_REQUEST['txt_pri_nombre'];
        $pri_apellido       = $_REQUEST['txt_pri_apellido'];
        $seg_nombre         = $_REQUEST['txt_seg_nombre'];
        $seg_apellido       = $_REQUEST['txt_seg_apellido'];
        $cargo              = $_REQUEST['txt_cargo'];
        $celular            = $_REQUEST['txt_celular'];
        $estado            = $_REQUEST['txt_estado'];
        $cont = 0;
                
        $form = new CHtmlForm();
        $form->setTitle(TITULO_AGREGAR_ESTUDIOS_DE_CAMPO);
        $form->setId('frm_add_estudio_campo');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        //codigo estudio de campo
        $form->addEtiqueta(CODIGO_BENEFICIARIO);
        $form->addInputText('text', 'txt_codigo', 'txt_codigo', '30', '10', 
                $codigo, '','onkeypress="ocultarDiv(\'error_codigo\');"');
        $form->addError('error_codigo', ERROR_CODIGO);
        
        //tipo beneficiario
        $opciones = null;
        $form -> addEtiqueta(TIPO_BENEFICIO);
        $tiposB = $docData->getTipoBeneficiario('idtipoBeneficiario');
        
        if (isset($tiposB)) {
            foreach ($tiposB as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_tipo_b', 'txt_tipo_b', $opciones, 
                SELECCION_TIPO, $tipo_b, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_tipo_b\');"');
        $form->addError('error_tipo_b', ERROR_TIPO_B);
        
        //grupo beneficiario
        $opciones = null;
        $form -> addEtiqueta(GRUPO_BENEFICIO);
        $grupos = $docData->getGrupoBeneficiario('desGrupoBeneficiario');
        
        if (isset($grupos)) {
            foreach ($grupos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_grupo', 'txt_grupo', $opciones,
                SELECCION_GRUPO, $grupo, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_grupo\');"');
        $form->addError('error_grupo', ERROR_GRUPO);
        
        //meta beneficiario
        $opciones = null;
        $form -> addEtiqueta(META_BENEFICIO);
        $metas = $docData->getMetaBeneficiario('idMetaBeneficiario');
        
        if (isset($metas)) {
            foreach ($metas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_meta', 'txt_meta', $opciones,
                SELECCION_META, $meta, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_meta\');"');
        $form->addError('error_meta', ERROR_META);    
        
        //nombre de la sede
        $form->addEtiqueta(NOMBRE_SEDE);
        $form->addInputText('text', 'txt_nombreSede', 'txt_nombreSede', 
                '30', '30', $nombreSede, '','onkeypress="ocultarDiv(\'error_nombreSede\');"');
        $form->addError('error_nombreSede', ERROR_NOMBRE_SEDE);
          
        //direccion de la sede
        $form->addEtiqueta(DIRECCION_SEDE);
        $form->addInputText('text', 'txt_direccion_sede', 'txt_direccion_sede',
                '30', '30', $direccionSede, '','onkeypress="ocultarDiv(\'error_direccion_sede\');"');
        $form->addError('error_direccion_sede', ERROR_DIRECCION_SEDE);
        
        //Regiones
        $opciones = null;
        $form->addEtiqueta(PLANEACION_REGION);
        $regiones = $planData->getRegiones(' der_nombre');

        if (isset($regiones)) {
            foreach ($regiones as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_region', 'txt_region', $opciones, 
                PLANEACION_REGION, $region, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_region\');"');
        $form->addError('error_region', ERROR_REGION);   

        //Departamento
        $opciones = null;
        $form->addEtiqueta(PLANEACION_DEPARTAMENTO);
        $departamentos = $planData->getDepartamento($region, ' dep_nombre');
        if (isset($departamentos)) {
            foreach ($departamentos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_departamento', 'txt_departamento', 
                $opciones, PLANEACION_DEPARTAMENTO, $departamento, '', 'onChange=submit();',
                'onkeypress="ocultarDiv(\'error_departamento\');"');
        $form->addError('error_departamento', ERROR_DEPARTAMENTO);

        //Municipio
        $form->addEtiqueta(PLANEACION_MUNICIPIO);
        $opciones = null;
        $municipios = $planData->getMunicipio($departamento, ' mun_nombre');
        if (isset($municipios)) {
        foreach ($municipios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        
        $form->addSelect('select', 'txt_municipio', 'txt_municipio', $opciones,
                PLANEACION_MUNICIPIO, $municipio, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_municipio\');"');
        $form->addError('error_municipio', ERROR_MUNICIPIO);
        
        //elegibilidad list
        $form->addEtiqueta(ELEGIBILIDAD);
        $elegibilidades[0]['value'] = 'Si';$elegibilidades[0]['texto'] = "Si";
        $elegibilidades[1]['value'] = 'No';$elegibilidades[1]['texto'] = "No";
        $form->addSelect('select', 'txt_elegibilidad', 'txt_elegibilidad', $elegibilidades,
                INGRESE_ELEGIBILIDAD, $elegibilidad, '', 'onChange=submit();',
                'onkeypress="ocultarDiv(\'error_elegibilidad\');"');
        $form->addError('error_elegibilidad', ERROR_ELEGIBILIDAD); 
            
        //estado
        $form->addEtiqueta(ESTADO_ESTUDIO);
        $opciones = null;
        $estados = $docData->getEstado('idEstadoEstudioDeCampo');
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_estado', 'txt_estado', $opciones,
                SELECCION_ESTADO, $estado, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_estado\');"');
        $form->addError('error_estado', ERROR_ESTADO);
        
        //fecha de realizacion
        $form->addEtiqueta(FECHA_REALIZACION_ESTUDIO);
        $form->addInputDate('date', 'txt_fecha_real', 'txt_fecha_real',
                $fecha_realizacion, '%Y-%m-%d', '16', '16', '',
                'onChange="ocultarDiv(\'error_fecha_real\');"');
        $form->addError('error_fecha_real', ERROR_FECHA_REAL);
        
        //fecha de validacion
        $form->addEtiqueta(FECHA_VALIDACION_ESTUDIO);
        $form->addInputDate('date', 'txt_fecha_val', 'txt_fecha_val',
                $fecha_validacion, '%Y-%m-%d', '16', '16', '',
                'onChange="ocultarDiv(\'error_fecha_val\');"');
        $form->addError('error_fecha_val', ERROR_FECHA_VAL);
        
        
        $form->addEtiqueta(COMUNICADO_VALIDACION_ESTUDIO);
        $form->addInputFile('file','file_comunicado_add','file_comunicado_add',
                '25','file','onChange="ocultarDiv(\'error_soporte\');"');
        $form->addError('error_soporte',ERROR_COMUNICADO_ARCHIVO);
        
        //nombre del contacto
        $form->addEtiqueta(INGRESE_PRINOMBRE_CONTACTO);
        $form->addInputText('text', 'txt_pri_nombre', 'txt_pri_nombre',
                '30', '15', $pri_nombre, '','onkeypress="ocultarDiv(\'error_pri_nombre\');"');
        $form->addError('error_pri_nombre', ERROR_PRI_NOMBRE);
        
        $form->addEtiqueta(INGRESE_SEGNOMBRE_CONTACTO);
        $form->addInputText('text', 'txt_seg_nombre', 'txt_seg_nombre',
                '30', '15', $seg_nombre, '', 'onkeypress="ocultarDiv(\'error_seg_nombre\');"');
        $form->addError('error_seg_nombre', ERROR_SEG_NOMBRE);
        
        //apellido del contacto
        $form->addEtiqueta(INGRESE_PRIAPELLIDO_CONTACTO);
        $form->addInputText('text', 'txt_pri_apellido', 'txt_pri_apellido',
                '30', '15', $pri_apellido, '','onkeypress="ocultarDiv(\'error_pri_apellido\');"');
        $form->addError('error_pri_apellido', ERROR_PRI_APELLIDO);
        
        $form->addEtiqueta(INGRESE_SEGAPELLIDO_CONTACTO);
        $form->addInputText('text', 'txt_seg_apellido', 'txt_seg_apellido',
                '30', '15', $seg_apellido, '','onkeypress="ocultarDiv(\'error_seg_apellido\');"');
        $form->addError('error_seg_apellido', ERROR_SEG_APELLIDO);
        
        $form->addEtiqueta(INGRESE_CARGO_CONTACTO);
        $form->addInputText('text', 'txt_cargo', 'txt_cargo', '30', '30',
                $cargo, '','onkeypress="ocultarDiv(\'error_cargo\');"');
        $form->addError('error_cargo', ERROR_CARGO);
        
        $form->addEtiqueta(INGRESE_CELULAR_CONTACTO);
        $form->addInputText('text', 'txt_celular', 'txt_celular', '30', '10',
                $celular, '','onkeypress="ocultarDiv(\'error_celular\');"');
        $form->addError('error_celular', ERROR_CELULAR);
        
        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button',
                'onclick="validar_agregar_estudio(\'frm_add_estudio_campo\',\'?mod=' .
                $modulo . '&task=guardarPersonas&niv=' . $niv . '\');"');
        
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR,
                'button', 'onclick="cancelar_estudio_campo(\'frm_add_estudio_campo\',\'?mod=' .
                $modulo . '&task=list&niv=' . $niv . '\');"');
        
        $form->writeForm();

        break;

    case 'guardarPersonas':
        
        $codigo             = $_REQUEST['txt_codigo'];
        $tipo_b             = $_REQUEST['txt_tipo_b'];
        $region             = $_REQUEST['txt_region'];
        $departamento       = $_REQUEST['txt_departamento'];
        $municipio          = $_REQUEST['txt_municipio'];
        $grupo              = $_REQUEST['txt_grupo'];
        $meta               = $_REQUEST['txt_meta'];
        $nombreSede         = $_REQUEST['txt_nombreSede'];
        $direccionSede      = $_REQUEST['txt_direccion_sede'];
        $elegibilidad       = $_REQUEST['txt_elegibilidad'];
        
        $fecha_realizacion  = $_REQUEST['txt_fecha_real'];
        $fecha_validacion   = $_REQUEST['txt_fecha_val'];
        
        $archivo            = $_FILES['file_comunicado_add'];
        $pri_nombre         = $_REQUEST['txt_pri_nombre'];
        $pri_apellido       = $_REQUEST['txt_pri_apellido'];
        $seg_nombre         = $_REQUEST['txt_seg_nombre'];
        $seg_apellido       = $_REQUEST['txt_seg_apellido'];
        $cargo              = $_REQUEST['txt_cargo'];
        $celular            = $_REQUEST['txt_celular'];
        $estado            = $_REQUEST['txt_estado'];
        
              
        $contacto = new CBeneficiarioContacto("", $pri_nombre,
                $seg_nombre, $pri_apellido, $seg_apellido, $cargo, $celular);
        
        $beneficiario = new CBeneficiario("", $codigo,
            $tipo_b, $grupo, $meta, $nombreSede, $direccionSede, $municipio, 
                $elegibilidad, $idContacto);
        
        $estCampo = new CEstudiosDeCampo("", "", $estado, $fecha_realizacion, 
                $fecha_validacion, $archivo);
        
        $iCont = $docData->insertContacto($contacto);
        $iBen = $docData->insertBeneficiario($beneficiario);
        if($iBen == "true"){
            $iEst = $docData->insertEstudioCampo($estCampo);
            $est = $iCont && $iBen && $iEst;
        }else{
            $docData->borrarUltimoContacto();
            $est = "0";
        }
        if ($est) {
            echo $html->generaAviso(EXITO_INSERTAR_ESTUDIO, "?mod=" . 
                    $modulo . "&niv=" . $niv . "&task=list");
        } else {
            echo $html->generaAviso(ERROR_INSERTAR_ESTUDIO, "?mod=" . 
                    $modulo . "&niv=" . $niv . "&task=list");
        }
        break;

    case 'edit':
        $id = $_REQUEST['id_element'];
        $estC = $docData->getEstudioDeCampoBiId($id);
        
        if(!isset($_POST['txt_codigo']))
            $codigo = $estC['codigo'];    
        else
            $codigo=$_REQUEST['txt_codigo'];
        
        if(!isset($_POST['txt_tipo_b']))
            $tipo_b = $estC['tipo'];
        else
            $tipo_b=$_REQUEST['txt_tipo_b'];
                
        if(!isset($_POST['txt_region']))
            $region = $estC['region'];    
        else
            $region=$_REQUEST['txt_region'];
        
        if(!isset($_POST['txt_departamento']))
            $departamento = $estC['departamento'];
        else
            $departamento=$_REQUEST['txt_departamento'];
        if(!isset($_POST['txt_municipio']))
            $municipio = $estC['municipio'];
        else
            $municipio=$_REQUEST['txt_municipio'];
        
        if(!isset($_POST['txt_grupo']))
            $grupo = $estC['grupo'];
        else
            $grupo=$_REQUEST['txt_grupo'];
        
        if(!isset($_POST['txt_meta']))
            $meta = $estC['meta'];
        else
            $meta=$_REQUEST['txt_meta'];
        
        if(!isset($_POST['txt_nombreSede']))
            $nombreSede = $estC['nombreSede'];
        else
            $nombreSede=$_REQUEST['txt_nombreSede'];
        
        if(!isset($_POST['txt_direccion_sede']))
            $direccionSede = $estC['direccion'];
        else
            $direccionSede=$_REQUEST['txt_direccion_sede'];
        if(!isset($_POST['txt_elegibilidad']))
            $elegibilidad = $estC['elegibilidad'];
        else
            $elegibilidad=$_REQUEST['txt_elegibilidad'];
        if(!isset($_POST['txt_fecha_real']))
            $fecha_realizacion = $estC['fecha_r'];
        else
            $fecha_realizacion=$_REQUEST['txt_fecha_real'];
        if(!isset($_POST['txt_fecha_val']))
            $fecha_validacion = $estC['fecha_v'];
        else
            $fecha_validacion=$_REQUEST['txt_fecha_val'];
        if(!isset($_POST['file_comunicado_add']))
            $comunicadoFile = $estC['comunicado'];
        else
            $comunicadoFile=$_FILES['file_comunicado_add'];
        if(!isset($_POST['txt_pri_nombre']))
            $pri_nombre = $estC['pri_nombre'];
        else
            $pri_nombre=$_REQUEST['txt_pri_nombre'];
        if(!isset($_POST['txt_pri_apellido']))
            $pri_apellido = $estC['pri_apellido'];
        else
            $pri_apellido=$_REQUEST['txt_pri_apellido'];
        if(!isset($_POST['txt_seg_nombre']))
            $seg_nombre = $estC['seg_nombre'];
        else
            $seg_nombre=$_REQUEST['txt_seg_nombre'];
        if(!isset($_POST['txt_seg_apellido']))
            $seg_apellido = $estC['seg_apellido'];
        else
            $seg_apellido=$_REQUEST['txt_seg_apellido'];
        
        if(!isset($_POST['txt_cargo']))
            $cargo = $estC['cargo'];
        else
            $cargo=$_REQUEST['txt_cargo'];
        
        if(!isset($_POST['txt_celular']))
            $celular = $estC['celular'];
        else
            $celular=$_REQUEST['txt_celular'];
        
        if(!isset($_POST['txt_estado']))
            $estado = $estC['estado'];
        else
            $estado=$_REQUEST['txt_estado'];
        $cont = 0;
        $form = new CHtmlForm();
        $form->setTitle(TITULO_EDITAR_ESTUDIOS_DE_CAMPO);
        $form->setId('frm_edit_estudio_campo');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        //codigo estudio de campo
        $form->addEtiqueta(CODIGO_BENEFICIARIO);
        $form->addInputText('text', 'txt_codigo', 'txt_codigo', '30', '10', 
                $codigo,'onkeypress="ocultarDiv(\'error_codigo\');"');
        $form->addError('error_codigo', ERROR_CODIGO);
        
        //tipo beneficiario
        $opciones = null;
        $form -> addEtiqueta(TIPO_BENEFICIO);
        $tiposB = $docData->getTipoBeneficiario('idtipoBeneficiario');
        
        if (isset($tiposB)) {
            foreach ($tiposB as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_tipo_b', 'txt_tipo_b', $opciones, 
                SELECCION_TIPO, $tipo_b, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_tipo_b\');"');
        $form->addError('error_tipo_b', ERROR_TIPO_B);
        
        //grupo beneficiario
        $opciones = null;
        $form -> addEtiqueta(GRUPO_BENEFICIO);
        $grupos = $docData->getGrupoBeneficiario('desGrupoBeneficiario');
        
        if (isset($grupos)) {
            foreach ($grupos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_grupo', 'txt_grupo', $opciones,
                SELECCION_GRUPO, $grupo, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_grupo\');"');
        $form->addError('error_grupo', ERROR_GRUPO);
        
        //meta beneficiario
        $opciones = null;
        $form -> addEtiqueta(META_BENEFICIO);
        $metas = $docData->getMetaBeneficiario('idMetaBeneficiario');
        
        if (isset($metas)) {
            foreach ($metas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_meta', 'txt_meta', $opciones,
                SELECCION_META, $meta, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_meta\');"');
        $form->addError('error_meta', ERROR_META);    
        
        //nombre de la sede
        $form->addEtiqueta(NOMBRE_SEDE);
        $form->addInputText('text', 'txt_nombreSede', 'txt_nombreSede', 
                '30', '30', $nombreSede, '','onkeypress="ocultarDiv(\'error_nombreSede\');"');
        $form->addError('error_nombreSede', ERROR_NOMBRE_SEDE);
          
        //direccion de la sede
        $form->addEtiqueta(DIRECCION_SEDE);
        $form->addInputText('text', 'txt_direccion_sede', 'txt_direccion_sede',
                '30', '30', $direccionSede, '','onkeypress="ocultarDiv(\'error_direccion_sede\');"');
        $form->addError('error_direccion_sede', ERROR_DIRECCION_SEDE);
        
        //Regiones
        $opciones = null;
        $form->addEtiqueta(PLANEACION_REGION);
        $regiones = $planData->getRegiones(' der_nombre');

        if (isset($regiones)) {
            foreach ($regiones as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_region', 'txt_region', $opciones, 
                PLANEACION_REGION, $region, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_region\');"');
        $form->addError('error_region', ERROR_REGION);   

        //Departamento
        $opciones = null;
        $form->addEtiqueta(PLANEACION_DEPARTAMENTO);
        $departamentos = $planData->getDepartamento($region, ' dep_nombre');
        if (isset($departamentos)) {
            foreach ($departamentos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_departamento', 'txt_departamento', 
                $opciones, PLANEACION_DEPARTAMENTO, $departamento, '', 'onChange=submit();',
                'onkeypress="ocultarDiv(\'error_departamento\');"');
        $form->addError('error_departamento', ERROR_DEPARTAMENTO);

        //Municipio
        $form->addEtiqueta(PLANEACION_MUNICIPIO);
        $opciones = null;
        $municipios = $planData->getMunicipio($departamento, ' mun_nombre');
        if (isset($municipios)) {
            foreach ($municipios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        
        $form->addSelect('select', 'txt_municipio', 'txt_municipio', $opciones,
                PLANEACION_MUNICIPIO, $municipio, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_municipio\');"');
        $form->addError('error_municipio', ERROR_MUNICIPIO);
        
        //elegibilidad list
        $form->addEtiqueta(ELEGIBILIDAD);
        $elegibilidades[0]['value'] = 'Si';$elegibilidades[0]['texto'] = "Si";
        $elegibilidades[1]['value'] = 'No';$elegibilidades[1]['texto'] = "No";
        $form->addSelect('select', 'txt_elegibilidad', 'txt_elegibilidad', $elegibilidades,
                INGRESE_ELEGIBILIDAD, $elegibilidad, '', 'onChange=submit();',
                'onkeypress="ocultarDiv(\'error_elegibilidad\');"');
        $form->addError('error_elegibilidad', ERROR_ELEGIBILIDAD); 
        
        //estado
        $form->addEtiqueta(ESTADO_ESTUDIO);
        $opciones = null;
        $estados = $docData->getEstado('idEstadoEstudioDeCampo');
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'],
                    'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_estado', 'txt_estado', $opciones,
                SELECCION_ESTADO, $estado, '', 'onChange=submit();','onkeypress="ocultarDiv(\'error_estado\');"');
        $form->addError('error_estado', ERROR_ESTADO);
        
        //fecha de realizacion
        $form->addEtiqueta(FECHA_REALIZACION_ESTUDIO);
        $form->addInputDate('date', 'txt_fecha_real', 'txt_fecha_real',
                $fecha_realizacion, '%Y-%m-%d', '16', '16', '',
                'onChange="ocultarDiv(\'error_fecha_real\');"');
        $form->addError('error_fecha_real', ERROR_FECHA_REAL);
        
        //fecha de validacion
        $form->addEtiqueta(FECHA_VALIDACION_ESTUDIO);
        $form->addInputDate('date', 'txt_fecha_val', 'txt_fecha_val',
                $fecha_validacion, '%Y-%m-%d', '16', '16', '',
                'onChange="ocultarDiv(\'error_fecha_val\');"');
        $form->addError('error_fecha_val', ERROR_FECHA_VAL);
        
        
        $form->addEtiqueta(COMUNICADO_VALIDACION_ESTUDIO);
        $form->addInputFile('file','file_comunicado_add','file_comunicado_add',
                '25','file','onChange="ocultarDiv(\'error_soporte\');"');
        $form->addError('error_soporte',ERROR_COMUNICADO_ARCHIVO);
        
        //nombre del contacto
        $form->addEtiqueta(INGRESE_PRINOMBRE_CONTACTO);
        $form->addInputText('text', 'txt_pri_nombre', 'txt_pri_nombre',
                '30', '15', $pri_nombre, '','onkeypress="ocultarDiv(\'error_pri_nombre\');"');
        $form->addError('error_pri_nombre', ERROR_PRI_NOMBRE);
        
        $form->addEtiqueta(INGRESE_SEGNOMBRE_CONTACTO);
        $form->addInputText('text', 'txt_seg_nombre', 'txt_seg_nombre',
                '30', '15', $seg_nombre, '', 'onkeypress="ocultarDiv(\'error_seg_nombre\');"');
        $form->addError('error_seg_nombre', ERROR_SEG_NOMBRE);
        
        //apellido del contacto
        $form->addEtiqueta(INGRESE_PRIAPELLIDO_CONTACTO);
        $form->addInputText('text', 'txt_pri_apellido', 'txt_pri_apellido',
                '30', '15', $pri_apellido, '','onkeypress="ocultarDiv(\'error_pri_apellido\');"');
        $form->addError('error_pri_apellido', ERROR_PRI_APELLIDO);
        
        $form->addEtiqueta(INGRESE_SEGAPELLIDO_CONTACTO);
        $form->addInputText('text', 'txt_seg_apellido', 'txt_seg_apellido',
                '30', '15', $seg_apellido, '','onkeypress="ocultarDiv(\'error_seg_apellido\');"');
        $form->addError('error_seg_apellido', ERROR_SEG_APELLIDO);
        
        $form->addEtiqueta(INGRESE_CARGO_CONTACTO);
        $form->addInputText('text', 'txt_cargo', 'txt_cargo', '30', '30',
                $cargo, '','onkeypress="ocultarDiv(\'error_cargo\');"');
        $form->addError('error_cargo', ERROR_CARGO);
        
        $form->addEtiqueta(INGRESE_CELULAR_CONTACTO);
        $form->addInputText('text', 'txt_celular', 'txt_celular', '30', '10',
                $celular, '','onkeypress="ocultarDiv(\'error_celular\');"');
        $form->addError('error_celular', ERROR_CELULAR);
        
        $form->addInputButton('button', 'ok_edit', 'ok_edit', BOTON_EDITAR, 'button',
                'onclick="validar_agregar_estudio(\'frm_edit_estudio_campo\',\'?mod=' .
                $modulo . '&task=saveEdit&id_element='.$id.'&niv=' . $niv . '\');"');
        
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR,
                'button', 'onclick="cancelar_estudio_campo(\'frm_edit_estudio_campo\',\'?mod=' .
                $modulo . '&task=list&niv=' . $niv . '\');"');
        
        $form->writeForm();

        break;
    case 'saveEdit':
        $id = $_REQUEST['id_element'];
        $codigo = $_REQUEST['txt_codigo'];
        $tipo_b = $_REQUEST['txt_tipo_b'];
        $region = $_REQUEST['txt_region'];
        $departamento = $_REQUEST['txt_departamento'];
        $municipio = $_REQUEST['txt_municipio'];
        $grupo = $_REQUEST['txt_grupo'];
        $meta = $_REQUEST['txt_meta'];
        $nombreSede = $_REQUEST['txt_nombreSede'];
        $direccionSede = $_REQUEST['txt_direccion_sede'];
        $elegibilidad = $_REQUEST['txt_elegibilidad'];
        $fecha_realizacion = $_REQUEST['txt_fecha_real'];
        $fecha_validacion = $_REQUEST['txt_fecha_val'];
        $comunicadoFile = $_FILES['file_comunicado_add'];
        $pri_nombre = $_REQUEST['txt_pri_nombre'];
        $pri_apellido = $_REQUEST['txt_pri_apellido'];
        $seg_nombre = $_REQUEST['txt_seg_nombre'];
        $seg_apellido = $_REQUEST['txt_seg_apellido'];
        $cargo = $_REQUEST['txt_cargo'];
        $celular = $_REQUEST['txt_celular'];
        $estado = $_REQUEST['txt_estado'];
        
        $contacto = new CBeneficiarioContacto("", $pri_nombre,
                $seg_nombre, $pri_apellido, $seg_apellido, $cargo, $celular);
        
        $beneficiario = new CBeneficiario("", $codigo,
            $tipo_b, $grupo, $meta, $nombreSede, $direccionSede, $municipio, 
                $elegibilidad, "");
        
        $estCampo = new CEstudiosDeCampo("", "", $estado, $fecha_realizacion, 
                $fecha_validacion, $comunicadoFile);
        
        $est = $docData->actualizarEstudioDeCampo($id,$contacto,$beneficiario,$estCampo);
        if ($est == "true") {
            echo $html->generaAviso(EXITO_EDITAR_ESTUDIO_CAMPO, "?mod=" . $modulo .
                    "&niv=" . $niv . "&task=list");
        } else {
            echo $html->generaAviso(ERROR_EDITAR_ESTUDIO_CAMPO, "?mod=" . $modulo .
                    "&niv=" . $niv . "&task=list");
        }
        break;
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        $form = new CHtmlForm();
        $form->setId('frm_delet_correspondencia');
        $form->setMethod('post');
        $form->writeForm();

        echo $html->generaAdvertencia(BORRAR_ESTUDIO_CAMPO, '?mod=' . $modulo .
                '&niv=' . $niv . '&task=confirmDelete&id_element=' . $id_delete, 
                'cancelarAccion(\'frm_delet_correspondencia\',\'?mod=' .
                $modulo . '&task=list&niv=' . $niv . '\');"');
        break;

    case 'confirmDelete':
        $id = $_REQUEST['id_element'];
        $m = $docData->deleteEstudioDeCampo($id);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv .
                "&task=list");

        break;

    default:
        include('templates/html/under.html');

        break;
}
