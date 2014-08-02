function addRow(idTable) {
    var table = document.getElementById(idTable);
    var lastPosition = table.rows.length - 1;
    var row = table.insertRow(lastPosition);
    var cell = row.insertCell(0);
    cell.innerHTML = lastPosition;
    cell = row.insertCell(1);
    cell.innerHTML = "<input type='text' class='form-control'"
            + " id='nombreSeccion" + lastPosition + "'"
            + " name = 'nombreSeccion" + lastPosition + "'"
            + " size='45' maxlength='45'"
            + " placeholder='Escribe el nombre de la secci&oacute;n'"
            + " autofocus required/>";
    var input = document.getElementById("numeroSecciones");
    input.value = lastPosition;
}

function deleteRow(idTable) {
    var table = document.getElementById(idTable);
    var lastPosition = table.rows.length - 2;
    if (lastPosition !== 1) {
        document.getElementById(idTable).deleteRow(lastPosition);
    }
}

