<?php
/*
 * Formulario Usuarios
 *
*/
echo '<pre>';
var_dump($config);
var_dump($data);
echo '</pre>';
?>
<script src="<?php echo base_url("/assets/js/jstree/jstree.min.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("/assets/css/jstree/themes/default/style.min.css"); ?>" />
<div class="content container">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>">Inicio</a></li>
      <li><a href="<?php echo base_url2("Usuarios") ?>">Usuarios</a></li>
      <li class="active">Formulario Usuario</li>
    </ol>

    <form class="<?php echo $config["formulario"]->char_class; ?>" action="<?php echo base_url($config['formulario']->char_ubicacion.'/'.$id); ?>" method="post" id="<?php echo $config['formulario']->char_nombre; ?>">
        <input type="hidden" name="char_salt" id="char_salt" value="<?php echo ($data?$data->char_salt:temp_pass()); ?>">
        <input type="hidden" name="estatus_id" id="estatus_id" value="<?php echo ($data?$data->estatus_id:1); ?>">
        <?php if($data) {?>
        <section class="widget">
            <div class="body">
                <fieldset>
                    <legend class="section">Cambiar contraseña</legend>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="hint-field" class="col-sm-4 control-label">Contraseña Actual</label>
                            <div class="col-sm-7 input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="text" id="char_password_actual" name="char_password_actual" class="form-control input-transparent" placeholder="Contraseña Actual">
                            </div>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="hint-field" class="col-sm-4 control-label">Nueva Contraseña</label>
                            <div class="col-sm-7 input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="text" id="char_password_nueva" name="char_password_nueva" class="form-control input-transparent" placeholder="Nueva Contraseña">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="hint-field" class="col-sm-5 control-label">Confirmar Nueva Contraseña</label>
                            <div class="col-sm-7 input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="text" id="char_password_confirmar" name="char_password_confirmar" class="form-control input-transparent" placeholder="Confirmar Nueva Contraseña">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </section>
        <?php } ?>
        <section class="widget">
            <div class="body">
                <fieldset>
                    <legend class="section">Formulario de Usuarios</legend>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Usuario</label>
                        <div class="col-sm-7 input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="char_user" name="char_user" class="form-control input-transparent" placeholder="Usuario" value="<?php echo ($data?$data->char_user:''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Recordatorio de contraseña</label>
                        <div class="col-sm-7 input-group">
                            <span class="input-group-addon"><i class="fa fa-question-circle"></i></span>
                            <input type="text" id="char_password_recordatorio" name="char_password_recordatorio" class="form-control input-transparent" placeholder="Usuario" value="<?php echo ($data?$data->char_password_recordatorio:''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Nombre(s)</label>
                        <div class="col-sm-7 input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="char_nombres" name="char_nombres" class="form-control input-transparent" placeholder="Nombre(s)" value="<?php echo ($data?$data->char_nombres:''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Apellido Paterno</label>
                        <div class="col-sm-7 input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="char_app" name="char_app" class="form-control input-transparent" placeholder="Apellido Paterno" value="<?php echo ($data?$data->char_app:''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Apellido Materno</label>
                        <div class="col-sm-7 input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="char_apm" name="char_apm" class="form-control input-transparent" placeholder="Apellido Materno" value="<?php echo ($data?$data->char_apm:''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Fecha de Nacimiento</label>
                        <div class="col-sm-7">
                            <input type="text" id="date_fecha_nacimiento" name="date_fecha_nacimiento" class="form-control input-transparent" value="<?php echo ($data?$data->date_fecha_nacimiento:''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Correo</label>
                        <div class="col-sm-7 input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" id="char_correo" name="char_correo" class="form-control input-transparent" placeholder="Correo@correo.com" value="<?php echo ($data?$data->char_correo:''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Telefono</label>
                        <div class="col-sm-7 input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <input type="text" id="int_telefono" name="int_telefono" class="form-control input-transparent" placeholder="1234567890" value="<?php echo ($data?$data->int_telefono:''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint-field" class="col-sm-4 control-label">Tipo de Usuario</label>
                        <div class="col-sm-7">
                            <select class="select2 form-control" name="tipoUsuario_id" id="tipoUsuario_id">
                                <option value=""></option>
                                <?php
                                    foreach($Catalogos['TiposUsuarios'] as $key) {
                                        $select = '';
                                        if ($data) {
                                            if ($data->tipoUsuario_id == $key->tipoUsuario_id) {
                                                $select = 'selected="selected"';
                                            }
                                        }
                                        echo '<option value="'.$key->tipoUsuario_id.'" '.$select.'>'.$key->char_tipoUsuario.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="btn-toolbar">
                                <button type="submit" class="btn btn-primary" id="Guardar">Guardar Cambios</button>
                                <button type="button" class="btn btn-inverse" onclick="location.href='<?php echo base_url2("Usuarios") ?>'">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <h2><?php if(isset($mensaje)) echo $mensaje; ?></h2>
    <?php echo validation_errors(); ?>
    <?php if($data) {?>
    <section class="widget">
        <div class="body">
            <div id="frmt" class="demo"></div>
        </div>
    </section>
    <?php } ?>
</div>
<script>
$(function() {
    $.get('<?php echo base_url("Menu/get_menu_usuarios/").($data? $data->usuarios_id : ""); ?>', function(data) {
        console.log(data)
        var arbol = function(data) {
            var temp = [];
            for (var i in data) {
                var children = [];

                if (data[i].nivel.length > 0) {
                    for (var j in data[i].nivel) {
                        var children2 = [];

                        if (data[i].nivel[j].nivel.length > 0) {
                            for (var k in data[i].nivel[j].nivel) {
                                children2.push({text: data[i].nivel[j].nivel[k].char_nombre, state: {opened: false, selected: (data[i].nivel[j].nivel[k].encontrado)}, data: {id: data[i].nivel[j].nivel[k].menus_id}});
                            }                            
                        }

                        children.push({text: data[i].nivel[j].char_nombre, state: {opened: false, selected: (data[i].nivel[j].encontrado)}, children: children2, data: {id: data[i].nivel[j].menus_id}});
                    }
                }
                temp.push({text: data[i].char_nombre, state: {opened: false, selected: (data[i].encontrado)}, children: children, data: {id: data[i].menus_id}});
            }

            return temp;
        }

        $('#frmt').jstree({
            "plugins" : [ "wholerow", "checkbox" ],
            "checkbox": {
                "three_state" : false,
                "whole_node": true
            },
            'core' : {
              'data' : arbol(data.data)
            }
        }).on("changed.jstree", function (e, data) {
            console.log(data)
            //console.log(data.node.data.id)
            if (data.action === "select_node") {
                $.post('<?php echo base_url("Menu/asignar_pantallas"); ?>', {usuarios_id: '<?php echo $data->usuarios_id; ?>', menus_id: data.node.data.id, opt: 'add'}, function(data) {
                    console.log(data)
                });
            } else if(data.action === "deselect_node") {
                $.post('<?php echo base_url("Menu/asignar_pantallas"); ?>', {usuarios_id: '<?php echo $data->usuarios_id; ?>', menus_id: data.node.data.id, opt: 'delete'},function(data) {
                    console.log(data)
                });
            }
        });
    });
});

</script>