<?php
/*
 * Tabla Sistemas
 *
*/
?>
<h2 class="page-title">Modulo - <span class="fw-semi-bold">Sistemas</span></h2>
<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
  <li class="active">Sistemas</li>
</ol>
<div class="row">
  <div class="col-md-12">
    <section class="widget">
      <header>
        <h4>Nuevo Sistema</h4>
        <div class="actions">
          <button type="button" class="btn btn-success btn-xs pull-right" onclick="location.href='<?php echo base_url2("FormularioSistema"); ?>'"><i class="fa fa-plus"></i> Agregar</button>
        </div>
      </header>
    </section>
        
    <section class="widget">
      <input type="hidden" id="cant" value="<?php echo $config['tabla']->int_paginas; ?>">
      <input type="hidden" id="registros" value="<?php echo $config['tabla']->int_registros; ?>">
      <form role="form" class="form-horizontal form-label-left" id="form-ajax">
        <input type="hidden" value="1" name="page" id="page">
        <input type="hidden" name="orden[tipo]" id="tipo" value="tcs.char_nombre">
        <input type="hidden" name="orden[order]" id="orden" value="ASC">
      </form>
      <div class="body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <div class="text-center paginacion" id="paginacion"></div>
        </div>
      </div>
    </section>
  </div>
</div>
<script>
var ajaxUrl = '<?php echo base_url2("Sistemas"); ?>';

function crear_elemento(data) {
  var tr = jQuery('<tr></tr>');
  tr.append('<td>'+data.char_nombre+'</td>');
  tr.append('<td>'+data.estatus_id+'</td>');
  tr.append('<td class="text-right"><a class="btn btn-warning" href="<?php echo base_url2("FormularioSistema/"); ?>'+data.sistemas_id+'"><i class="fa fa-pencil"></i></a><button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></td>');
  $('tbody').append(tr);
}

function crear_vacio() {
  var tr = jQuery('<tr></tr>');
  tr.append('<td class="text-center" colspan=2 style="text-align: center;font-size: large; font-weight: bold; text-decoration: underline; width: 100%; height: 100px;"></br> LA CONSULTA GENERADA NO REGRESO NINGUN DATO!! </br></td>');
  $('tbody').append(tr);
}
</script>