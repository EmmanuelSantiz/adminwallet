<?php
echo '<pre>';
var_dump($config);
var_dump($data);
echo '</pre>';
?>
<div class="content container">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>">Inicio</a></li>
      <li><a href="<?php echo base_url("General/Sucursales"); ?>">Sucursales</a></li>
      <li class="active"><?php echo $config['formulario']->char_nombre; ?></li>
    </ol>
    <form class="<?php echo $config['formulario']->char_class; ?>" action="<?php echo base_url($config['formulario']->char_ubicacion.(isset($data) ? '/'.$data->sucursales_id : null)); ?>" method="post" id="<?php echo $config['formulario']->char_nombre; ?>">
    	<?php
    		if (!isset($data)) {
    			echo '<input type="hidden" name="date_registro" value="'.date('Y-m-d H:i:s').'"><input type="hidden" name="usuarios_id" value="'.$this->session->userdata('usuarios_id').'"><input type="hidden" name="usuarios_id" value=1>';
    		}
    	?>
        <section class="widget">
            <div class="body">
                <fieldset>
                    <legend class="section"><?php echo $config['formulario']->char_nombre; ?></legend>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Empresa</label>
                        <div class="col-sm-7">
                            <select name="empresas_id" id="empresas_id" class="select2 form-control">
                                <option value=""></option>
                                <?php
                                    foreach($empresas as $empresa) {
                                        $select = $empresa->empresas_id == $data->empresas_id ? 'selected="selected"' : '';
                                        echo '<option value="'.$empresa->empresas_id.'" '.$select.'>'.$empresa->char_nombre.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Nombre</label>
                        <div class="col-sm-7">
                            <input type="text" id="char_nombre" name="char_nombre" class="form-control input-transparent" placeholder="Nombre" value="<?php echo (isset($data) ? $data->char_nombre : ''); ?>" data-tbl="tbl_cat_tipousuario">
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="btn-toolbar">
                                <button type="submit" class="btn btn-primary" id="Guardar">Guardar Cambios</button>
                                <button type="button" class="btn btn-inverse" onclick="location.href='<?php echo base_url("General/Sucursales"); ?>'">Cancelar</button>
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