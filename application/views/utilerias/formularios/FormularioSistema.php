<?php
/*
 * Formulario Sistema
 *
*/
?>
<div class="content container">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>">Inicio</a></li>
      <li><a href="<?php echo base_url2("Sistemas") ?>">Sistemas</a></li>
      <li class="active">Formulario Sistema</li>
    </ol>

    <form class="form-horizontal" action="<?php echo onToy($id); ?>" method="post">
        <input type="hidden" name="date_registro" id="date_registro" value="<?php echo ($data?$data->date_registro:date('Y-m-d H:i:s')); ?>">
        <input type="hidden" name="estatus_id" id="estatus_id" value="<?php echo ($data?$data->estatus_id:1); ?>">
        <!--input type="hidden" name="plantilla_id" id="plantilla_id" value="<?php echo ($data?$data->plantilla_id:null); ?>"-->
        <section class="widget">
            <div class="body">
                <fieldset>
                    <legend class="section">Formulario de Sistemas</legend>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Nombre del Sistema</label>
                        <div class="col-sm-7">
                            <input type="text" id="char_nombre" name="char_nombre" class="form-control input-transparent obtenerCopia" placeholder="Nombre del Sistema" value="<?php echo ($data?$data->char_nombre:''); ?>" data-tbl="tbl_cat_sistemas">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Descripcion del Sistema</label>
                        <div class="col-sm-7">
                            <textarea class="form-control input-transparent" name="text_descripcion" id="text_descripcion"><?php echo $data?$data->text_descripcion:''; ?></textarea>
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="btn-toolbar">
                                <button type="submit" class="btn btn-primary" id="Guardar">Guardar Cambios</button>
                                <button type="button" class="btn btn-inverse" onclick="location.href='<?php echo base_url2("Sistemas") ?>'">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>
<script>
    $('#Guardar').click(function() {
        /*if ($('#char_nombre').val() == '') {
            noti('Llenar Nombre');
        } else {
            console.log($('#char_nombre').val())
        }
        
        return false;*/
    });
</script>