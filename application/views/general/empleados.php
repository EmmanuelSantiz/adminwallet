<?php
/*
 * Tabla Empleados
 *
*/
if($this->session->flashdata('message')) { ?>
<script>
  $(function() {
    noti('<?php echo $this->session->flashdata('message')?>');
  })
</script>
<?php } ?>
<div class="content container">
<h2 class="page-title">Modulo - <span class="fw-semi-bold">Empleados</span></h2>
<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
  <li class="active">Empleados</li>
</ol>
<div class="row">
    <div class="col-md-12">
      <?php
      if(isset($config['tabla'])) {
        if($config['tabla']->bol_agregar) { ?>
          <section class="widget">
            <header>
              <h4>Nuevo Empleado</h4>
              <div class="actions">
                <button type="button" class="btn btn-success btn-xs pull-right" onclick="location.href='<?php echo base_url2("FormularioEmpleado"); ?>'"><i class="fa fa-plus"></i> Agregar</button>
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
        <form role="form" class="form-horizontal form-label-left" id="form-ajax">
          <input type="hidden" value="1" name="page" id="page">
          <input type="hidden" name="orden[tipo]" id="tipo" value="tc.id_compra">
          <input type="hidden" name="orden[order]" id="orden" value="ASC">
        </form>
            <div class="body">
              <div class="table-responsive">
                  <table class="table table-striped table-hover">
                      <thead>
                      <tr>
                          <th>Id</th>
                          <!--th>Nombre (s)</th>
                          <th>Ape Pat</th>
                          <th>Ape Mat</th>
                          <th>Empresa</th-->
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
var ajaxUrl = '<?php echo base_url("General/Empleados/")?>';

function crear_vacio() {
	var tr = jQuery('<tr></tr>');
  tr.append('<td class="text-center" colspan=1 rowspan=2 style="text-align: center;font-size: large; font-weight: bold; text-decoration: underline; width: 100%; height: 100px;"></br> SIN DATOS </br></td>');
  $('#idAjaxForm').append(tr);
}

function crear_elemento(data) {
  var tr = jQuery('<tr></tr>');
  /*var url = '<?php echo base_url2("FormularioEmpleado/"); ?>' + data.empresas_id;
  tr.append('<td><a href="'+url+'">'+data.empresas_id+'</a></td>');
  tr.append('<td>'+data.char_nombres+'</td>');
  tr.append('<td>'+data.char_ape_pat+'</td>');
  tr.append('<td>'+data.char_ape_mat+'</td>');
  tr.append('<td>'+data.empresa+'</td>');*/
  tr.append('<td>'+data.empresas_id+'</td>');
  $('#idAjaxForm').append(tr);
}
</script>