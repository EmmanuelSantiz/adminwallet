<?php
/*
 * Tabla Sucursales
 *
*/
?>
<div class="content container">
<h2 class="page-title">Modulo - <span class="fw-semi-bold">Sucursales</span></h2>
<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
  <li class="active">Sucursales</li>
</ol>
<div class="row">
    <div class="col-md-12">
      <?php
      if(isset($config['tabla'])) {
        if($config['tabla']->bol_agregar) { ?>
          <section class="widget">
            <header>
              <h4>Nueva Sucursal</h4>
              <div class="actions">
                <button type="button" class="btn btn-success btn-xs pull-right" onclick="location.href='<?php echo base_url2("FormularioSucursal"); ?>'"><i class="fa fa-plus"></i> Agregar</button>
              </div>
            </header>
          </section>
      <?php  }
      }
      ?>

      <?php
      if(isset($config['tabla'])) {
        if($config['tabla']->bol_filtros) { ?>
          <section class="widget">
            <header>
              <h4>Filtros</h4>
            </header>
          </section>
      <?php  }
        }
      ?>
      
      <section class="widget">
        <input type="hidden" id="cant" value="<?php echo $config["tabla"]->int_paginas; ?>">
        <input type="hidden" id="registros" value="<?php echo $config["tabla"]->int_registros; ?>">
        <form role="form" class="form-horizontal form-label-left" id="form-ajax">
          <input type="hidden" value="1" name="page" id="page">
          <input type="hidden" name="orden[tipo]" id="tipo" value="ts.sucursales_id">
          <input type="hidden" name="orden[order]" id="orden" value="ASC">
        </form>
            <div class="body">
              <div class="table-responsive">
                  <table class="table <?php echo $config["tabla"]->char_class; ?>">
                      <thead>
                      <tr>
                          <th>Id</th>
                          <th>Nombre</th>
                          <th>Empresa</th>
                          <th>Estatus</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody id="idAjaxForm"></tbody>
                  </table>
                   <div class="text-center paginacion" id="paginacion"></div>
              </div>
            </div>
        </section>
    </div>
</div>
</div>
<script>
var ajaxUrl = '<?php echo base_url("General/Sucursales/")?>';
function crear_elemento(data) {
  var tr = jQuery('<tr></tr>');
  var url = '<?php echo base_url2("FormularioSucursal/"); ?>' + data.sucursales_id;
  tr.append('<td><a href="'+url+'">'+data.sucursales_id+'</a></td>');
  tr.append('<td>'+data.char_nombre+'</td>');
  tr.append('<td>'+data.empresa+'</td>');
  tr.append('<td>'+data.estatus_id+'</td>');
  $('#idAjaxForm').append(tr);
}

function crear_vacio() {
	var tr = jQuery('<tr></tr>');
  tr.append('<td class="text-center" colspan=4 rowspan=2 style="text-align: center;font-size: large; font-weight: bold; text-decoration: underline; width: 100%; height: 100px;"></br> SIN DATOS </br></td>');
  $('#idAjaxForm').append(tr);
}
</script>