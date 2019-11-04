<?php
/*
 * Tabla de Formularios
 *
*/
var_dump($config);
?>
<div class="content container">
<h2 class="page-title">Modulo - <span class="fw-semi-bold">Formularios</span></h2>
<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
  <li class="active">Formularios</li>
</ol>
<div class="row">
    <div class="col-md-12">
      <?php
      if(isset($config['tabla'])) {
        if($config['tabla']->bol_agregar) { ?>
          <section class="widget">
            <header>
              <h4>Nuevo Tabla</h4>
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
          <input type="hidden" name="orden[tipo]" id="tipo" value="tcf.formularios_id">
          <input type="hidden" name="orden[order]" id="orden" value="ASC">
        </form>
            <div class="body">
              <div class="table-responsive">
                  <table class="table <?php echo $config["tabla"]->char_class; ?>">
                      <thead>
                      <tr>
                          <th>Id</th>
                          <th>Nombre</th>
                          <th>Url</th>
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
var ajaxUrl = '<?php echo base_url("Menu/get_formularios"); ?>';

function crear_elemento(data) {
	var tr = jQuery('<tr></tr>');
	tr.append('<td>'+data.formularios_id+'</td>');
	tr.append('<td>'+data.char_nombre+'</td>');
	tr.append('<td>'+data.char_ubicacion+'</td>');
	$('#idAjaxForm').append(tr);
}

function crear_vacio() {
	var tr = jQuery('<tr></tr>');
  	tr.append('<td class="text-center" colspan=6 rowspan=2 style="text-align: center;font-size: large; font-weight: bold; text-decoration: underline; width: 100%; height: 100px;"></br> SIN DATOS </br></td>');
  	$('#idAjaxForm').append(tr);
}
</script>