<div class="content container">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>">Inicio</a></li>
      <li><a href="<?php echo base_url("Productos/Productos"); ?>">Empresas</a></li>
      <li class="active"><?php echo $config['formulario']->char_nombre; ?></li>
    </ol>
    <form class="<?php echo $config['formulario']->char_class; ?>" action="<?php echo base_url($config['formulario']->char_ubicacion.(isset($data) ? '/'.$data->producto_id : null)); ?>" method="post" id="<?php echo $config['formulario']->char_nombre; ?>">
    	<?php
    		if (!isset($data)) {
    			echo '<input type="hidden" name="date_fecha_alta" value="'.date('Y-m-d H:i:s').'"><input type="hidden" name="usuario_id_alta" value="'.$this->session->userdata('usuarios_id').'"><input type="hidden" name="int_estatus" value=1>';
    		}
    	?>
        <section class="widget">
            <div class="body">
                <fieldset>
                    <legend class="section"><?php echo $config['formulario']->char_nombre; ?></legend>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Nombre</label>
                        <div class="col-sm-7">
                            <input type="text" id="char_nombre" name="char_nombre" class="form-control input-transparent" placeholder="Nombre" value="<?php echo (isset($data) ? $data->char_nombre : ''); ?>" data-tbl="tbl_cat_productos">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Codigó de barras</label>
                        <div class="col-sm-7">
                            <input type="text" id="char_codigo_barras" name="char_codigo_barras" class="form-control input-transparent" placeholder="Codigó de barras" value="<?php echo (isset($data) ? $data->char_codigo_barras : ''); ?>" data-tbl="tbl_cat_productos">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Precio</label>
                        <div class="col-sm-7">
                            <input type="text" id="double_precio" name="double_precio" class="form-control input-transparent" placeholder="Precio" value="<?php echo (isset($data) ? $data->double_precio : ''); ?>" data-tbl="tbl_cat_productos">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">imagen</label>
                        <div class="col-sm-7">
                            <input type="text" id="char_nombre" name="char_nombre" class="form-control input-transparent" placeholder="imagen" value="<?php echo (isset($data) ? $data->char_nombre : ''); ?>" data-tbl="tbl_cat_tipousuario">
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Ancho</label>
                        <div class="col-sm-7">
                            <input type="text" id="int_ancho" name="int_ancho" class="form-control input-transparent" placeholder="Ancho" value="<?php echo (isset($data) ? $data->int_ancho : ''); ?>" data-tbl="tbl_cat_productos">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Largo</label>
                        <div class="col-sm-7">
                            <input type="text" id="int_largo" name="int_largo" class="form-control input-transparent" placeholder="Largo" value="<?php echo (isset($data) ? $data->int_largo : ''); ?>" data-tbl="tbl_cat_productos">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Longitud</label>
                        <div class="col-sm-7">
                            <input type="text" id="int_longitud" name="int_longitud" class="form-control input-transparent" placeholder="Longitud" value="<?php echo (isset($data) ? $data->int_longitud : ''); ?>" data-tbl="tbl_cat_productos">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Empresa</label>
                        <div class="col-sm-7">
                         <select style='color:black' class="select2" name="empresa_id" id="empresa_id"> 
                                <option value=''>seleccionar</option>
                                <?php for($i = 0;$i<count($empresas);$i++){ ?>
                                    <option <?php echo (isset($data) && $data->empresa_id==$empresas[$i]->empresas_id ?  'selected':'' ); ?> 
                                    value="<?php echo $empresas[$i]->empresas_id; ?>" ><?php echo $empresas[$i]->char_nombre;?></option>
                                <?php  } ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="btn-toolbar">
                                <button type="submit" class="btn btn-primary" id="Guardar">Guardar Cambios</button>
                                <button type="button" class="btn btn-inverse" onclick="location.href='<?php echo base_url("Productos/Productos"); ?>'">Cancelar</button>
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