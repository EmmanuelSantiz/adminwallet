<?php
echo '<pre>';
var_dump($config);
echo '</pre>';
?>
<script src="<?php echo base_url("assets/lib/jquery-ui/ui/core.js"); ?>"></script>
<script src="<?php echo base_url("assets/lib/jquery-ui/ui/widget.js"); ?>"></script>
<script src="<?php echo base_url("assets/lib/jquery-ui/ui/mouse.js"); ?>"></script>
<script src="<?php echo base_url("assets/lib/jquery-ui/ui/sortable.js"); ?>"></script>
<script src="<?php echo base_url("assets/lib/jquery.nestable/jquery.nestable.js"); ?>"></script>

<!-- page application js -->
<div class="row">
    <div class="col-md-12">
        <h4>Orden de Menus</h4>
        <?php
            if($config['tabla']->bol_agregar) {
        ?>
        <section class="widget">
        <header>
          <h4>Nuevo Menu</h4>
          <div class="actions">
            <button type="button" class="btn btn-success btn-xs pull-right" id="nuevoPadre"><i class="fa fa-plus"></i> Agregar</button>
          </div>
        </header>
      </section>
        <?php
            }
        ?>
        <ol class="list-group list-group-outer sortable list-group-sortable" id="padres"></ol>
        <br>
        <!--Nivel 1-->
        <div class="row" id="configuraciones" style="display: none;">
            <section class="widget">
                <div id="datosPadre">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="char_folio">Nombre del Menu</label>
                        <div class="col-sm-8">
                            <input type="hidden" id="menus_id">
                            <input type="hidden" id="int_orden">
                            <input type="text" id="char_nombre" class="form-control input-transparent" >
                        </div>
                    </div>
                    <div class="form-group" id="url">
                        <label class="col-sm-4 control-label" for="char_url">Url</label>
                        <div class="col-sm-8">
                            <input type="text" id="char_url" class="form-control input-transparent">
                        </div>
                    </div>
                </div>
                <br></br>
                <div class="body">
                    <div class="row">
                        <br><br>
                        <div class="col-md-4">
                            <button class="btn btn-success" type="button" id="addN1">Agregar</button>
                            <ol class="list-group list-group-outer sortable list-group-sortable" id="nivel1"></ol>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" id="padreN1">
                            <button class="btn btn-success" type="button" id="addN2">Agregar</button>
                            <ol class="list-group list-group-outer sortable list-group-sortable" id="nivel2"></ol>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" id="padreN2">
                            <button class="btn btn-success" type="button" id="addN3">Agregar</button>
                            <ol class="list-group list-group-outer sortable list-group-sortable" id="nivel3"></ol>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-offset-4 col-sm-7">
                                <div class="btn-toolbar">
                                    <button type="button" class="btn btn-default" name="boton" id="guardarMenu">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <form name="<?php echo $config['formulario']->char_nombre; ?>" id="<?php echo $config['formulario']->char_nombre; ?>" action="<?php echo base_url($config['formulario']->char_ubicacion); ?>" method="POST">
            <div class="form-actions">
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-7">
                        <div class="btn-toolbar">
                            <button type="button" class="btn btn-primary" id="Guardar">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
var urlMenus = '<?php echo base_url("Menu/get_menu/"); ?>';

$(function() {
    get();

    $(".sortable").sortable({
        placeholder: 'list-group-item list-group-item-placeholder',
        forcePlaceholderSize: true
    });
});

$('#nuevoPadre').click(function() {
    var li = jQuery('<li></li>');
    li.addClass('list-group-item');
    li.append('<i class="fa fa-sort"></i>');
    var data = {menus_id: null, int_orden: ($('#padres li').size() + 1), char_nombre: '', char_url: '', nivel: []};
    li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>');
    li.append('&nbsp;&nbsp;&nbsp; '+data.int_orden+' &nbsp;&nbsp;&nbsp;'+data.char_nombre+' &nbsp;&nbsp;&nbsp;');     
    li.append('<a class="close editar"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;');
    li.data({data: data})
    $('#padres').append(li);
});

function get() {
    $('#padres').html('');
    $.get(urlMenus, function(data) {
        //console.log(data)
        if (data.data) {
            for(var i in data.data) {
                var li = jQuery('<li></li>');
                li.addClass('list-group-item');
                li.append('<i class="fa fa-sort"></i>');
                
                if (data.data[i].nivel.length == 0)
                    li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>');

                li.append('&nbsp;&nbsp;&nbsp; '+data.data[i].int_orden+' &nbsp;&nbsp;&nbsp;'+data.data[i].char_nombre+' &nbsp;&nbsp;&nbsp;');     
                li.append('<a class="close editar"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;');
                li.data({data: data.data[i]})
                $('#padres').append(li);
            }
        }
    });
}

$('#padres').on('click', '.editar', function() {
    data = $(this).parent().data('data');
    console.log(data)
    $('#char_url').val('').val(data.char_url).prop('disabled', false);
    $('#menus_id').val('').val(data.menus_id);
    $('#char_nombre').val('').val(data.char_nombre);
    $('#int_orden').val('').val(data.int_orden);
    $('#padreN1, #padreN2').val('')

    $('#nivel1, #nivel2, #nivel3').html('');
    if (data.nivel.length > 0) {
        $('#char_url').val('').prop('disabled', true);
        for(var i in data.nivel) {
            var li = jQuery('<li></li>');
            li.addClass('list-group-item');
            li.append('<i class="fa fa-sort"></i>');
            li.append('<a class="close editar"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;');

            if (data.nivel[i].nivel.length == 0) {
                li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>');
            }

            li.append('&nbsp;&nbsp;&nbsp; '+data.nivel[i].int_orden);
            li.append('&nbsp;&nbsp;&nbsp; <input type="text" class="form-control input-transparent" value="'+data.nivel[i].char_nombre+'"> &nbsp;&nbsp;&nbsp;');

            if (data.nivel[i].nivel.length == 0) {
                li.append('&nbsp;&nbsp;&nbsp; <input type="text" class="form-control input-transparent" value="'+(data.nivel[i].char_url?data.nivel[i].char_url:'')+'"> &nbsp;&nbsp;&nbsp;');
            }
            
            li.data({data: data.nivel[i]});
            $('#nivel1').append(li);
        }
    }

    $('#configuraciones').show();
});

$('#nivel1').on('click', '.editar', function() {
    data = $(this).parent().data('data');
    console.log(data)
    $('#nivel2').html('')
    $('#padreN1').val('').val(data.int_orden)
    if (data.nivel.length > 0) {
        for(var i in data.nivel) {
            var li = jQuery('<li></li>');
            li.addClass('list-group-item');
            li.append('<i class="fa fa-sort"></i>');
            li.append('<a class="close editar"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;');
            li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>&nbsp;&nbsp;&nbsp; '+data.nivel[i].int_orden+' &nbsp;&nbsp;&nbsp;<input type="text" class="form-control input-transparent" value="'+data.nivel[i].char_nombre+'"> &nbsp;&nbsp;&nbsp;');
            li.data({data: data.nivel[i]})
            $('#nivel2').append(li);
        }
    } /*else{
        console.log('sin datos')
    }*/
});

$('#nivel2').on('click', '.editar', function() {
    data = $(this).parent().data('data');
    console.log(data)
    $('#nivel3').html('');
    $('#padreN2').val('').val(data.int_orden)
    if (data.nivel.length > 0) {
        for(var i in data.nivel) {
            var li = jQuery('<li></li>');
            li.addClass('list-group-item');
            li.append('<i class="fa fa-sort"></i>');
            li.append('<a class="close editar"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;');
            li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>&nbsp;&nbsp;&nbsp; '+data.nivel[i].int_orden+' &nbsp;&nbsp;&nbsp;<input type="text" class="form-control input-transparent" value="'+data.nivel[i].char_nombre+'"> &nbsp;&nbsp;&nbsp;');
            li.data({data: data.nivel[i]})
            $('#nivel3').append(li);
        }
    }
});

/*$('#addN1').click(function() {
    var li = jQuery('<li></li>');
    var data = {menus_id: null, int_orden: ($("#nivel1 li").size() + 1), char_nombre: '', char_url: '', nivel1: []};
    li.addClass('list-group-item');
    li.append('<i class="fa fa-sort"></i>');
    li.append('<a class="close editar"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;');
    li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>&nbsp;&nbsp;&nbsp; '+data.int_orden+' &nbsp;&nbsp;&nbsp;<input type="text" class="form-control input-transparent" value="'+data.char_nombre+'"> &nbsp;&nbsp;&nbsp;');
    li.append('&nbsp;&nbsp;&nbsp; <input type="text" class="form-control input-transparent" value="'+data.char_url+'"> &nbsp;&nbsp;&nbsp;');
    li.data({data: data});
    $('#nivel1').append(li);
});

$('#addN2').click(function() {
    var li = jQuery('<li></li>');
    var data = {menus_id: null, int_orden: ($('#nivel2 li').size() + 1), char_nombre: '', char_url: '', nivel2: []};
    li.addClass('list-group-item');
    li.append('<i class="fa fa-sort"></i>');
    li.append('<a class="close editar"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;');
    li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>&nbsp;&nbsp;&nbsp; '+data.int_orden+' &nbsp;&nbsp;&nbsp;<input type="text" class="form-control input-transparent" value="'+data.char_nombre+'"> &nbsp;&nbsp;&nbsp;');
    li.append('&nbsp;&nbsp;&nbsp; <input type="text" class="form-control input-transparent" value="'+data.char_url+'"> &nbsp;&nbsp;&nbsp;');
    li.data({data: data});
    $('#nivel2').append(li);
});

$('#addN3').click(function() {
    var li = jQuery('<li></li>');
    var data = {menus_id: null, int_orden: ($('#nivel3 li').size() + 1), char_nombre: '', char_url: ''};
    li.addClass('list-group-item');
    li.append('<i class="fa fa-sort"></i>');
    li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>&nbsp;&nbsp;&nbsp; '+data.int_orden+' &nbsp;&nbsp;&nbsp;<input type="text" class="form-control input-transparent" value="'+data.char_nombre+'"> &nbsp;&nbsp;&nbsp;');
    li.append('&nbsp;&nbsp;&nbsp; <input type="text" class="form-control input-transparent" value="'+data.char_url+'"> &nbsp;&nbsp;&nbsp;');
    li.data({data: data});
    $('#nivel3').append(li);
});*/

$('#addN1, #addN2, #addN3').click(function() {
    var li = jQuery('<li></li>');
    id = $(this).next().attr('id');
    var data = {menus_id: null, int_orden: ($('#'+id+' li').size() + 1), char_nombre: '', char_url: '', nivel: []};
    li.addClass('list-group-item');
    li.append('<i class="fa fa-sort"></i>');
    li.append('<a class="close closeM" href="javascript:void(0);">&times;</a>&nbsp;&nbsp;&nbsp; '+data.int_orden+' &nbsp;&nbsp;&nbsp;<input type="text" class="form-control input-transparent" value="'+data.char_nombre+'"> &nbsp;&nbsp;&nbsp;');
    li.append('&nbsp;&nbsp;&nbsp; <input type="text" class="form-control input-transparent" value="'+data.char_url+'"> &nbsp;&nbsp;&nbsp;');
    li.data({data: data});
    $('#'+id).append(li);
});

$('#Guardar').click(function() {
    var idFormulaior = "<?php echo $config['formulario']->char_nombre; ?>";

    $('#padres').find("li").each(function(index, el) {
        console.log(index)
        data = $(el).data('data');
        $('#'+idFormulaior).append('<input type="text" name="padres['+(index+1)+']" value="'+data.menus_id+'">');
    });

    //$('#'+idFormulaior).submit();
    return false;
});

$('#guardarMenu').click(function() {
    var data = {menus_id: $('#menus_id').val(),
                char_nombre: $('#char_nombre').val(),
                int_orden: $('#int_orden').val()};

    if ($("#char_url").length > 0)
        data.char_url = $('#char_url').val();

    data.nivel1 = [];
    $('#nivel1').find("li").each(function(index, el) {
        var temp = $(el).data('data')
        data.nivel1.push({menus_id: temp.menus_id, int_orden: (index + 1), char_nombre: $(el).find("input:eq(0)").val(), char_url: $(el).find("input:eq(1)").val()})
    });

    for(var i in data.nivel1) {
        if (i == ($('#padreN1').val() - 1)) {
            data.nivel1[i].nivel2 = [];
            $('#nivel2').find("li").each(function(index, el) {
                var temp = $(el).data('data');
                data.nivel1[i].nivel2.push({menus_id: temp.menus_id, int_orden: (index + 1), char_nombre: $(el).find("input:eq(0)").val(), char_url: $(el).find("input:eq(1)").val()});
            });
        }
    }

    $.post('<?php echo base_url("Menu/guardarMenu/"); ?>', data, function(data) {
        console.log(data)
        var tipo = 'success';
        if (data.error) {
            tipo = 'error';
        } else {
            get();
            $('#configuraciones').hide();
        }
        noti(data.mensaje, tipo);
    });
});

$('body').on('click', '.closeM', function() {
    var data = $(this).parent().data('data');
    if(data.menus_id) {
        $.post('<?php echo base_url("Menu/deleteMenus/"); ?>'+data.menus_id, function(data) {
            console.log(data)
            var tipo = 'success';
            if (data.error) {
                tipo = 'error';
            } else {
                get();
            }
            noti(data.mensaje, tipo);
        });
    }
    $(this).parent('li').remove();
});

/*$('#padreN1').change(function() {
    $('#addN2').prop('disabled', (!$(this).val() != ''))
});*/
</script>