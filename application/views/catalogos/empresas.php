<?php
/*
 * Tabla Empresas
 *
*/
?>
<div class="content container">
<h2 class="page-title">Modulo - <span class="fw-semi-bold">Empresas</span></h2>
<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
  <li class="active">Empresas</li>
</ol>
<div class="row">
    <div class="col-md-12">
      <?php
      if(isset($config['tabla'])) {
        if($config['tabla']->bol_agregar) { ?>
          <section class="widget">
            <header>
              <h4>Nueva Empresas</h4>
              <div class="actions">
                <button type="button" class="btn btn-success btn-xs pull-right" onclick="location.href='<?php echo base_url2("FormularioEmpresa"); ?>'"><i class="fa fa-plus"></i> Agregar</button>
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
          <input type="hidden" name="orden[tipo]" id="tipo" value="tce.estatus_id">
          <input type="hidden" name="orden[order]" id="orden" value="ASC">
        </form>
            <div class="body">
              <div class="table-responsive">
                  <table class="table table-striped table-hover">
                      <thead>
                      <tr>
                          <th>Id</th>
                          <th>Descripcion</th>
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