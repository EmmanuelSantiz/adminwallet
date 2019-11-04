<?php
echo '<pre>';
var_dump($config);
echo '<pre>';
echo '</pre>';
var_dump($data);
echo '</pre>';
$stylos = array(
    array('name' => 'Stripped', 'value' => 'table-striped'), 
    array('name' => 'Bordered', 'value' => 'table-bordered'),
    array('name' => 'Hover', 'value' => 'table-hover'),
    array('name' => 'Stripped Hover', 'value' => 'table-striped table-hover')
);
?>
<div class="content container">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>">Inicio</a></li>
      <li><a href="<?php echo base_url("Utilerias/Tablas"); ?>">Tablas</a></li>
      <li class="active"><?php echo $config['formulario']->char_nombre; ?></li>
    </ol>
    <form class="<?php echo $config['formulario']->char_class; ?>" action="<?php echo base_url($config['formulario']->char_ubicacion.(isset($data) ? '/'.$data->tablas_id : null)); ?>" method="post" id="<?php echo $config['formulario']->char_nombre; ?>">
        <section class="widget">
            <div class="body">
                <fieldset>
                    <legend class="section"><?php echo $config['formulario']->char_nombre; ?></legend>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Nombre</label>
                        <div class="col-sm-7">
                            <input type="text" id="char_nombre" name="char_nombre" class="form-control input-transparent" placeholder="Nombre" value="<?php echo (isset($data) ? $data->char_nombre : ''); ?>" data-tbl="tbl_cat_tipousuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Clase</label>
                        <div class="col-sm-7">
                            <select name="char_class" id="char_class" class="select2 form-control">
                                <option value=""></option>
                                <option value=" ">Sin Clase</option>
                                <?php
                                    foreach($stylos as $class) {
                                        $select = $class['value'] == $data->char_class ? 'selected="selected"' : '';
                                        echo '<option value="'.$class['value'].'" '.$select.'>'.$class['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Registros por Pagina</label>
                        <div class="col-sm-7">
                            <input type="text" id="int_registros" name="int_registros" class="form-control input-transparent" placeholder="Registros" value="<?php echo (isset($data) ? $data->int_registros : ''); ?>" data-tbl="tbl_cat_tipousuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Paginas</label>
                        <div class="col-sm-7">
                            <input type="text" id="int_paginas" name="int_paginas" class="form-control input-transparent" placeholder="Registros" value="<?php echo (isset($data) ? $data->int_paginas : ''); ?>" data-tbl="tbl_cat_tipousuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Boton Agregar</label>
                        <div class="col-sm-8">
                        <?php
                        if(isset($data)) {
                            if ($data->bol_agregar == 1) { ?>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_agregar" value=1> SI
                                </label>
                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_agregar" value=0> NO 
                                </label>
                            </div>
                        <?php } else { ?>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_agregar" value=1> SI
                                </label>
                                <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_agregar" value=0> NO 
                                </label>
                        </div>
                        <?php    }
                        } else { ?>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_agregar" value=1> SI
                                </label>
                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_agregar" value=0> NO 
                                </label>
                            </div>
                        <?php }?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Filtros</label>
                        <div class="col-sm-8">
                        <?php
                            if(isset($data)) {
                                if ($data->bol_filtros == 1) { ?>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_filtros" value=1> SI
                                </label>
                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_filtros" value=0> NO 
                                </label>
                            </div>
                        <?php } else { ?>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_filtros" value=1> SI
                                </label>
                                <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_filtros" value=0> NO 
                                </label>
                            </div>
                        <?php }
                            } else { ?>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_filtros" value=1> SI
                                </label>
                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="bol_filtros" value=0> NO 
                                </label>
                            </div>
                        <?php }
                        ?>
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="btn-toolbar">
                                <button type="submit" class="btn btn-primary" id="Guardar">Guardar Cambios</button>
                                <button type="button" class="btn btn-inverse" onclick="location.href='<?php echo base_url("Utilerias/Tablas"); ?>'">Cancelar</button>
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