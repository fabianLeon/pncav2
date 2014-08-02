<?php
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');

$operador = OPERADOR_DEFECTO;

$task = $_REQUEST['task'];

if (empty($task)) {
    $task = 'add';
}

switch ($task) {

    case 'add':
        $session = 0;
        if (isset($_REQUEST['seccion'])) {
            $seccion = $_REQUEST['seccion'];
        }
        $seccion += 0;
        ?>
        <ul class="nav nav-tabs nav-justified">
            <li <?php
            if ($seccion === 0) {
                echo 'class="active"';
            }
            if ($seccion > 0) {
                echo 'class="disabled"';
            }
            ?>><a href="#">Instrumento</a></li>
            <li <?php
            if ($seccion === 1) {
                echo 'class="active"';
            }
            if ($seccion > 1) {
                echo 'class="disabled"';
            }
            ?>><a href="#">Secciones</a></li>
            <li <?php
            if ($seccion === 2) {
                echo 'class="active"';
            }
            if ($seccion > 2) {
                echo 'class="disabled"';
            }
            ?>><a href="#">Preguntas</a></li>
        </ul>
        <?php
        switch ($seccion) {
            case 0:
                ?> 
                <form class="form-horizontal" action="index.php?mod=<?php echo $_REQUEST['mod']; ?>&niv=<?php echo $_REQUEST['niv']; ?>&operador=<?php echo $_REQUEST['operador']; ?>&seccion=1" method="post" role="form">
                    <div class="form-group">
                        <label for="nombreIntrumento" class="col-lg-2 control-label">Nombre Instrumento:</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" 
                                   id="nombreIntrumento" name = "nombreInstrumento"
                                   placeholder="Escribe el nombre del Intrumento"
                                   autofocus required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-10 col-lg-10">
                            <button type="submit" class="btn btn-default">Siguiente</button>
                        </div>
                    </div>
                </form>
                <?php
                break;

            case 1:
                ?>
                <form class="form-horizontal" action="index.php?mod=<?php echo $_REQUEST['mod']; ?>&niv=<?php echo $_REQUEST['niv']; ?>&operador=<?php echo $_REQUEST['operador']; ?>&seccion=2" method="post" role="form">
                    <table id="secciones">
                        <thead>
                            <tr>
                                <th>N&uacute;mero</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><input type="text" class="form-control" 
                                           id="nombreSeccion1" name = "nombreSeccion1"
                                           size="45" maxlength="45"
                                           placeholder="Escribe el nombre de la secci&oacute;n"
                                           autofocus required/></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><button type="button" onclick="addRow('secciones')" class="btn btn-default">Agregar</button></td>
                                <td><button type="button" onclick="deleteRow('secciones')" class="btn btn-default">Eliminar</button></td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden" id="numeroSecciones" name="numeroSecciones" value="1"/>
                    <div class="form-group">
                        <div class="col-lg-offset-10 col-lg-10">
                            <button type="submit" class="btn btn-default">Siguiente</button>
                        </div>
                    </div>
                </form>
                <?php
                break;

            case 2:
                $numeroSecciones = $_REQUEST['numeroSecciones'];
                $seccionActual = $_REQUEST['seccionActual'];
                $seccionActual += 0;
                ?>
                <ul class="nav nav-tabs nav-justified">
                    <?php for ($index = 0; $index < $numeroSecciones; $index++) { ?>
                        <li <?php
                        if ($seccionActual === $index) {
                            echo 'class="active"';
                        }
                        if ($seccionActual > $index) {
                            echo 'class="disabled"';
                        }
                        ?>><a href="#">Secci&oacute;n <?php echo ($index + 1) ?></a></li>
                        <?php } ?>
                </ul>
                <form class="form-horizontal" action="index.php?mod=<?php echo $_REQUEST['mod']; ?>&niv=<?php echo $_REQUEST['niv']; ?>&operador=<?php echo $_REQUEST['operador']; ?>&seccion=2&seccionActual=<?php echo $seccionActual ?>" method="post" role="form">
                    <table id="secciones">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">@</span>
                                        <input type="text" class="form-control" placeholder="Nombre de usuario">
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon">.00</span>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><button type="button" onclick="addRow('secciones')" class="btn btn-default">Agregar</button></td>
                                <td><button type="button" onclick="deleteRow('secciones')" class="btn btn-default">Eliminar</button></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="form-group">
                        <div class="col-lg-offset-10 col-lg-10">
                            <button type="submit" class="btn btn-default">Siguiente</button>
                        </div>
                    </div>
                </form>

                <?php
                break;

            default:
                break;
        }
        ?>

        <?php
        break;

    default:
        include('templates/html/under.html');
        break;
}
