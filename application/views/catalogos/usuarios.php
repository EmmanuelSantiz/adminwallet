<?php
/*
 * Tabla Usuarios
 *
*/
echo '<pre>';
var_dump($config);
echo '</pre>';
if($this->session->flashdata('message')){?>
<script>
  $(function() {
    noti('<?php echo $this->session->flashdata('message')?>');
  })
</script>
<?php } ?>
<h2 class="page-title">Modulo - <span class="fw-semi-bold">Usuarios</span></h2>
<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
  <li class="active">Usuarios</li>
</ol>
<div class="row">
  <div class="col-md-12">
    <?php
    if(isset($config['tabla'])) {
      if($config['tabla']->bol_agregar) { ?>
        <section class="widget">
          <header>
            <h4>Nuevo Usuario</h4>
            <div class="actions">
              <button type="button" class="btn btn-success btn-xs pull-right" onclick="location.href='<?php echo base_url($config['tabla']->char_ubicacion_formulario); ?>'"><i class="fa fa-plus"></i> Agregar</button>
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
        <input type="hidden" name="orden[tipo]" id="tipo" value="tcu.char_nombres">
        <input type="hidden" name="orden[order]" id="orden" value="ASC">
      </form>
      <div class="body">
        <div class="table-responsive">
          <table class="table <?php echo $config["tabla"]->char_class; ?>">
            <thead>
              <tr>
                <th>Nombre</th>
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
<script>
var ajaxUrl = '<?php echo base_url2("Usuarios"); ?>';

function crear_elemento(data) {
  var tr = jQuery('<tr></tr>');
  tr.append('<td>'+data.char_nombres+'</td>');
  tr.append('<td>'+data.estatus_id+'</td>');
  tr.append('<td><a class="btn btn-warning" href="<?php echo base_url2("FormularioUsuario/"); ?>'+data.usuarios_id+'"><i class="fa fa-pencil"></i></a><button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></td>');
  $('#idAjaxForm').append(tr);
}
</script>