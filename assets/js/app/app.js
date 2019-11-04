/**
* Funciones Generales para cargar formularios dinamicamente
*/
jQuery(document).ready(function() {

    /*var auto = $('#form-ajax').data('history');
        
    if(auto) {
        llenarCamposStorage();
    } else {
        destroyStorage();
    }*/

    $('.reset').click(function(event) {
        destroyStorage();
        $('#form-ajax input, #form-ajax select').each(function(index, el) {
            if ($(el).attr('id') != 'orden' && $(el).attr('id') != 'tipo') {
                if ($(el).attr('id') == 'page') {
                    $('#page').val(1);
                }
                $(el).val('');
            }
        });
    });

    //Funcion general para todos los formularios
    $('#form-ajax').submit(function(e) {
        e.preventDefault();
        main();
        return false;
    });

    $('#form-ajax').submit();

    $('.giro').keyup(function(event) {
        $('#page').val(1);
        buscar_registros(1);
    });

    $('.sel').change(function(event) {
        $('#page').val(1);
        buscar_registros(1);
    });

    //Por Revisar
    /*$('.obtenerCopia').change(function(event) {
        var el = $(this);

        $.post(base_url('Welcome/getExistente'), {campo: el.attr('id'), valor: el.val(), tabla: el.data('tbl')}, function(data) {
            console.log(data);
            if (data.data) {
                noti('Este nombre ya existe en base de dato!!', 'error');
                el.val('');
            }
        });
    });*/

    if ($('#Guardar').length) {
        llenarCamposStorageFormulario($('#Guardar').closest("form").attr('id'));
    }

    $('#Guardar').click(function() {
        var id = $(this).closest("form").attr('id');
        var data = [];
        $('#'+id+' input, #'+id+' select').each(function(index, el) {
            if ($(el).is(':visible')) {
                var idInput;
                if ($(el).hasClass('select2-offscreen'))
                    idInput = $(el).parent().next().attr('id')
                else
                    idInput = $(el).attr('id')
                
                data.push({id: idInput, value: $(el).val(), formulario: id});
            }
        });

        localStorage.setItem('historialFormulario', JSON.stringify(data));
    });

    $('.order').click(function() {
        var element = $(this);

        if(element.hasClass('sorting')) {
            $('.order').each(function() {
                $(this).removeClass($(this).attr('class')).addClass('order sorting');
            });

            element.removeClass('sorting').addClass('sorting_asc');
            $('#form-ajax #tipo').val(element.data('variable'));
            $('#form-ajax #orden').val('DESC');
        }

        if($(this).hasClass('sorting_asc')) {
            element.removeClass('sorting_asc').addClass('sorting_desc');
            $('#form-ajax #tipo').val(element.data('variable'));
            $('#form-ajax #orden').val('ASC');
        } else if($(this).hasClass('sorting_desc')) {
            element.removeClass('sorting_desc').addClass('sorting_asc');
            $('#form-ajax #tipo').val(element.data('variable'));
            $('#form-ajax #orden').val('DESC');
        }
        $('#page').val(1);
        buscar_registros(1,20);
    });

    $('.numeric').numeric();
    $('.numeric-integer').numeric({ decimal: false, negative: false });
    $('.numeric-double-integer').numeric({ negative: false });

    /***********************************Validar Formularios**********************************/

    /*var auto = $('#'+$('form').attr('id')).data('auto');
    var bit = $('#'+$('form').attr('id')).data('bit');

    $("#"+$('form').attr('id')).keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });

    if(auto == true) {
        for(var i in arrayRequeridos) {
            cadena += '#'+arrayRequeridos[i]+(parseInt(i) == (arrayRequeridos.length-1)?'':', ');
        }

        $(cadena).on('keyup change', function() {
            if($(this).val() != "") {
                $(this).removeClass("parsley-error");
                $(this).parent().find('ul').html('');
            }
        });

        $('#guardar').click(function() {
            var post = true;
            $('#'+$('form').attr('id')+' [name]').each(function(index, el) {
                if(jQuery.inArray($(el).attr('id'), arrayRequeridos) !== -1) {
                    if ($(el).val() == '') {
                        if (!$(el).hasClass("parsley-error")) {
                            $(el).addClass("parsley-error");
                            $(el).parent().append('<ul class="parsley-errors-list filed"><li class="parsley-required">Este campo no puede estar vacio</li></ul>');
                        }
                        post = false;
                    }
                }
            });
            return post;
        });
    }

    if (bit == true) {
        $('#btnBitacora').click(function() {
            var elemento = $(this).parent().next();

            if (elemento.css('display') == 'none') {
                $(this).html('<i class="fa fa-minus"></i> Ocultar');
                elemento.show();
            } else {
                $(this).html('<i class="fa fa-plus"></i> Mostrar');
                elemento.hide();
            }
        });

        $('#text_comentario').keyup(function() {
            $('#btnComment').prop('disabled', (!$(this).val() != ''));
        });
    }*/

});
    
function main() {
    var fin = $('#registros').val() != '' ? $('#registros').val() : 20;
    buscar_registros(1, fin);
    $("div .body").on("click",".paginacion li a", function(e) {
        e.preventDefault();
        if($(this).parent().hasClass('disabled'))
            return false;

        console.log($(this).attr('href'))
        valorhref = $(this).attr("href");
        valorBuscar = '';// $("input[name=busqueda]").val();
        valoroption = fin;
        buscar_registros(valorhref, valoroption);
    });
}

var myVar;
//function buscar_registros(valorhref = null, valoroption = null) {
function buscar_registros(valorhref = null) {
    clearTimeout(myVar);
    var nropagina = valorhref ? valorhref : 1;
    var cantidad = $('#registros').val() ? $('#registros').val() : 20;
    var data = $('#form-ajax').serialize();

    $.ajax({
        url: ajaxUrl,
        type: 'post',
        data: {data: data, nropagina: nropagina, cantidad: cantidad},
        beforeSend: function() {
            var spiner = jQuery('<div></div>');
            spiner.addClass('loader animated fadeIn handle');
            spiner.append('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span>');
            $('#idAjaxForm').html(spiner);
        },
        success: function(data) {
            console.log(data);
            $('#idAjaxForm').html('');

            if (data.data === undefined) {
                crear_vacio();
                $('.paginacion').html('');
                $('.paginacion').append('<p class="paginas text-center">P&aacute;gina'+(data.total_paginas > 1 ? 's' : '')+': '+data.total_paginas+'</p>');
                return;
            }

            if(data.data.length > 0) {
                for(var i in data.data) {
                    crear_elemento(data.data[i]);
                }

                linkseleccionado = Number(valorhref);
                totalregistros = data.total_registros;
                cantidadregistros = cantidad;//response.cantidad;

                numerolinks = Math.ceil(totalregistros / cantidadregistros);
                paginador = "<ul class='pagination'>";

                if(linkseleccionado > 1) {
                    paginador += "<li><a href='1'>&laquo;</a></li>";
                    paginador += "<li><a href='"+(linkseleccionado - 1)+"' '>&lsaquo;</a></li>";
                } else {
                    paginador += "<li class='disabled'><a href='#'>&laquo;</a></li>";
                    paginador += "<li class='disabled'><a href='#'>&lsaquo;</a></li>";
                }

                cant = $('#cant').val() != '' ? $('#cant').val() : 5;
                pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;

                if (numerolinks > cant) {
                    pagRestantes = numerolinks - linkseleccionado;
                    pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
                } else
                    pagFin = numerolinks;

                for(var i = pagInicio; i <= pagFin; i++) {
                    paginador += "<li "+(i == linkseleccionado ? 'class="active"': '')+"><a href='"+i+"'>"+i+"</a></li>";
                }
                
                //condicion para mostrar el boton sigueinte y ultimo
                if(linkseleccionado < numerolinks) {
                    paginador += "<li><a href='"+(linkseleccionado + 1)+"' >&rsaquo;</a></li>";
                    paginador += "<li><a href='"+numerolinks+"'>&raquo;</a></li>";
                } else {
                    paginador += "<li class='disabled'><a href='#'>&rsaquo;</a></li>";
                    paginador += "<li class='disabled'><a href='#'>&raquo;</a></li>";
                }
        
                paginador += "</ul>";
                paginador += '<p class="paginas text-center">'+data.total_registros+' registro'+(data.total_registros > 1 ? 's' : '')+' en '+data.total_paginas+' p&aacute;gina'+(data.total_paginas > 1 ? 's' : '')+'</p>';
                $(".paginacion").html(paginador);        
            } else {
                crear_vacio();
                $('.paginacion').html('');
                $('.paginacion').append('<p class="paginas text-center">P&aacute;gina'+(data.total_paginas > 1 ? 's' : '')+': '+data.total_paginas+'</p>');
            }

        }, error: function(req, status, err) {
            console.log('something went wrong', status, err);
        }
    });
}

/*function paginador(page, total_paginas) {
    $('#pagination').twbsPagination({
            visiblePages: 5,
            totalPages: total_paginas,
            first:'&laquo;',
            last:'&raquo;',
            prev:'<',
            next:'>',
        onPageClick: function (event, page) {
            if ($('#page').val() != page) {
                $('#page').val(page);
                buscar_registros();
            }
        }
    });
}*/

function MASK(form, n, mask, format) {
    if (format == "undefined") format = false;
    if (format || NUM(n)) {
        dec = 0, point = 0;
        x = mask.indexOf(".") + 1;
        if (x) { dec = mask.length - x; }

        if (dec) {
            n = NUM(n, dec) + "";
            x = n.indexOf(".") + 1;
            if (x) { point = n.length - x; } else { n += "."; }
        } else
            n = NUM(n, 0)+"";

        for (var x = point; x < dec ; x++) {
            n += "0";
        }

        x = n.length, y = mask.length, XMASK = "";
        while (x || y) {
            if (x) {
                while ( y && "#0.".indexOf(mask.charAt(y-1)) == -1 ) {
                    if ( n.charAt(x-1) != "-")
                        XMASK = mask.charAt(y-1) + XMASK;
                        y--;
                }                    
                XMASK = n.charAt(x-1) + XMASK, x--;
            } else if ( y && "$0".indexOf(mask.charAt(y-1))+1 )
                XMASK = mask.charAt(y-1) + XMASK;
            
            if ( y ) { y-- }
        }
    } else
        XMASK = "";
    
    if (form) { 
        form.val(XMASK);
    }

    return XMASK;
}

function NUM(s, dec) {
    for (var s = s+"", num = "", x = 0 ; x < s.length ; x++) {
        c = s.charAt(x);
        if (".-+/*".indexOf(c)+1 || c != " " && !isNaN(c)) { num+=c; }
    }

    if (isNaN(num)) { num = eval(num); }
    if (num == "")  { num = 0; } else { num = parseFloat(num); }
    if (dec != undefined) {
        r = .5; if (num<0) r=-r;
        e = Math.pow(10, (dec>0) ? dec : 0);
        return parseInt(num * e + r) / e;
    } else
        return num;
}

function number_format(amount, decimals) {
    amount += '';
    amount = parseFloat(amount.replace(/[^0-9\.]/g, ''));
    decimals = decimals || 0;

    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    amount = '' + amount.toFixed(decimals);
    var amount_parts = amount.split('.'),
    regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

/*function llenarStorage() {
    var history = [];
    var temp = null;
    $('#form-ajax input, #form-ajax select').each(function(index, el) {
        if (localStorage.getItem('historial')) 
            temp = localStorage.getItem('historial');              

        var element = $(el);
        var name = element.attr('name');
        if (name && name != 'tipo_nomina') {
            var valor = element.val();
            if(valor!='') {
                if(temp) {
                    history = JSON.parse(temp); 
                }
                var value = $.trim(valor);
                if(value.length > 0) {
                    if($.inArray(value,history) != -1){
                    } else {
                        if (history) {
                            history.push({name,valor});
                        }
                    }
                }
            }
        }
    });
    localStorage.setItem('historial', JSON.stringify(history)); 
}

function destroyStorage() {
    localStorage.setItem('historial', null);
}

function llenarCamposStorage() {        
    if($('#form-ajax').data('history')) {
        var temp = localStorage.getItem('historial'); 
        var history = JSON.parse(temp);
        if (history) {
            for (var i = history.length - 1; i >= 0; i--) {
                if(history[i].name == 'page') {
                    $('#form-ajax').find('[name="'+history[i].name+'"]').val(history[i].valor);
                } else {
                    $('#form-ajax').find('[name="'+history[i].name+'"]').val(history[i].valor).prop('disabled',false);  
                }
            }
        }
    }
}*/

function llenarCamposStorageFormulario(form) {
    console.log(form)
    if (form === undefined)
        noti('Este Formulario no tiene un ID, Storage no Funcionara correctamente!!', 'error');
    
    if (localStorage.getItem('historialFormulario')) {
        var historial = JSON.parse(localStorage.getItem('historialFormulario'));
        if (historial) {
            for (var i in historial) {
                if (form == historial[i].formulario) {
                    $('#'+historial[i].id).val(historial[i].value);
                }
            }
        }

        localStorage.removeItem('historialFormulario');
    }
}

/*function noti(mensaje,$tipo = 'success') {
    var theme = 'air';

    $.globalMessenger({theme:theme, extraClasses:'messenger-fixed messenger-on-top'});
    Messenger.options = {theme:theme, extraClasses:'messenger-fixed messenger-on-top'};
    Messenger().post({message: mensaje, type:$tipo, showCloseButton:true});
}*/