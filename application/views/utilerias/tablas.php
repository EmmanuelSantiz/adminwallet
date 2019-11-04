<?php
/*
 * Tabla de Tablas
 *
*/
//var_dump($config);
?>
<div class="content container">
<h2 class="page-title">Modulo - <span class="fw-semi-bold">Tablas</span></h2>
<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
  <li class="active">Tablas</li>
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
          <input type="hidden" name="orden[tipo]" id="tipo" value="tcm.menus_id">
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
                          <th>Formularios</th>
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
var ajaxUrl = '<?php echo base_url("Menu/get_menus_tablas"); ?>';

function crear_elemento(data) {
	//console.log(data)
	var tr = jQuery('<tr></tr>');
	tr.append('<td>'+data.menus_id+'</td>');
	tr.append('<td>'+data.char_nombre+'</td>');
	tr.append('<td>'+data.char_url+'</td>');
  tr.append('<td>'+(data.formularios_id ? 'ver' : '<button class="btn btn-success crear_formulario" type="button" data-data='+JSON.stringify(data)+'><i class="fa fa-plus"></i></button>' )+'</td>')
  if (!data.tablas_id)
    tr.append('<td><a class="btn btn-success" onClick="crear_tabla('+data.menus_id+')"><i class="fa fa-plus"></i></a><button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></td>');
  else 
	  tr.append('<td><a class="btn btn-warning" href="<?php echo base_url("Utilerias/FormularioTabla/"); ?>'+data.tablas_id+'"><i class="fa fa-pencil"></i></a><button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></td>');
	$('#idAjaxForm').append(tr);
}

function crear_tabla(menus_id) {
  console.log(menus_id)
  $.post('<?php echo base_url("Utilerias/FormularioTabla/") ?>', {menus_id: menus_id}, function(data) {
    console.log(data)
    if (data.data) {
      $('#form-ajax').submit();
    }
  });
}

$('#idAjaxForm').on('click', '.crear_formulario', function() {
  var data = $(this).data('data');
  $.post('<?php echo base_url("Utilerias/crear_formulario/"); ?>', data, function (data) {
    console.log(data)
    $('#form-ajax').submit();
  })
});
</script>