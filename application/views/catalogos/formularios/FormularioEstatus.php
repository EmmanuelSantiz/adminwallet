<?php
/*
 * Formulario Estatus
 *
*/
echo '<pre>';
var_dump($config);
var_dump($data);
echo '</pre>';
?>
<div class="content container">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>">Inicio</a></li>
      <li><a href="<?php echo base_url2("Estatus") ?>">Estatus</a></li>
      <li class="active">Formulario Estatus</li>
    </ol>

    <form class="<?php echo $config["formulario"]->char_class; ?>" action="<?php echo base_url($config['formulario']->char_ubicacion.'/'.$id); ?>" method="post" id="<?php echo $config['formulario']->char_nombre; ?>">
        <section class="widget">
            <div class="body">
                <fieldset>
                    <legend class="section">Formulario de Estatus</legend>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Nombre del Estatus</label>
                        <div class="col-sm-7">
                            <input type="text" id="char_nombre" name="char_nombre" class="form-control input-transparent obtenerCopia" placeholder="Nombre del Estatus" value="<?php echo ($data?$data->char_nombre:''); ?>" data-tbl="tbl_cat_estatus">
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="btn-toolbar">
                                <button type="submit" class="btn btn-primary" id="Guardar">Guardar Cambios</button>
                                <button type="button" class="btn btn-inverse" onclick="location.href='<?php echo base_url2("Estatus") ?>'">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <h2><?php if(isset($mensaje)) echo $mensaje; ?></h2>
    <?php echo validation_errors(); ?>
</div>