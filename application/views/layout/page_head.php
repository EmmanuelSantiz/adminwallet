<?php
/**
 * page_head.php
 *
 * Author: Emmanuel Santiz
 *
 * Header and Sidebar of each page
 *
 */
?>
</head>
<body>
    <div class="logo">
        <h4><a href="<?php echo base_url(); ?>">Light <strong>Blue</strong></a></h4>
    </div>
<nav id="sidebar" class="sidebar nav-collapse collapse">
    <ul id="side-nav" class="side-nav"></ul>
</nav>

<div class="wrap">
        <header class="page-header">
            <div class="navbar">
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="visible-phone-landscape">
                        <a href="#" id="search-toggle">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" title="Messages" id="messages"
                           class="dropdown-toggle"
                           data-toggle="dropdown">
                            <i class="glyphicon glyphicon-comment"></i>
                        </a>
                        <ul id="messages-menu" class="dropdown-menu messages" role="menu">
                            <li role="presentation">
                                <a href="#" class="message">
                                    <!--img src="img/1.png" alt=""-->
                                    <div class="details">
                                        <div class="sender">Jane Hew</div>
                                        <div class="text">
                                            Hey, John! How is it going? ...
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="message">
                                    <!--img src="img/2.png" alt=""-->
                                    <div class="details">
                                        <div class="sender">Alies Rumiancaŭ</div>
                                        <div class="text">
                                            I'll definitely buy this template
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="message">
                                    <!--img src="img/3.png" alt=""-->
                                    <div class="details">
                                        <div class="sender">Michał Rumiancaŭ</div>
                                        <div class="text">
                                            Is it really Lore ipsum? Lore ...
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="text-align-center see-all">
                                    See all messages <i class="fa fa-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" title="8 support tickets"
                           class="dropdown-toggle"
                           data-toggle="dropdown">
                            <i class="glyphicon glyphicon-globe"></i>
                            <span class="count">8</span>
                        </a>
                        <ul id="support-menu" class="dropdown-menu support" role="menu">
                            <li role="presentation">
                                <a href="#" class="support-ticket">
                                    <div class="picture">
                                        <span class="label label-important"><i class="fa fa-bell-o"></i></span>
                                    </div>
                                    <div class="details">
                                        Check out this awesome ticket
                                    </div>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="support-ticket">
                                    <div class="picture">
                                        <span class="label label-warning"><i class="fa fa-question-circle"></i></span>
                                    </div>
                                    <div class="details">
                                        "What is the best way to get ...
                                    </div>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="support-ticket">
                                    <div class="picture">
                                        <span class="label label-success"><i class="fa fa-tag"></i></span>
                                    </div>
                                    <div class="details">
                                        This is just a simple notification
                                    </div>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="support-ticket">
                                    <div class="picture">
                                        <span class="label label-info"><i class="fa fa-info-circle"></i></span>
                                    </div>
                                    <div class="details">
                                        12 new orders has arrived today
                                    </div>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="support-ticket">
                                    <div class="picture">
                                        <span class="label label-important"><i class="fa fa-plus"></i></span>
                                    </div>
                                    <div class="details">
                                        One more thing that just happened
                                    </div>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="text-align-center see-all">
                                    See all tickets <i class="fa fa-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <li class="hidden-xs">
                        <a href="#" id="settings"
                           title="Settings"
                           data-toggle="popover"
                           data-placement="bottom">
                            <i class="glyphicon glyphicon-cog"></i>
                        </a>
                    </li>
                    <li class="hidden-xs dropdown">
                        <a href="#" title="Account" id="account"
                           class="dropdown-toggle"
                           data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                        </a>
                        <ul id="account-menu" class="dropdown-menu account" role="menu">
                            <li role="presentation" class="account-picture">
                                <!--img src="img/2.png" alt=""-->
                                Philip Daineka
                            </li>
                            <li role="presentation">
                                <a href="form_account.html" class="link">
                                    <i class="fa fa-user"></i>
                                    Profile
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="component_calendar.html" class="link">
                                    <i class="fa fa-calendar"></i>
                                    Calendar
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="link">
                                    <i class="fa fa-inbox"></i>
                                    Inbox
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="visible-xs">
                        <a href="#" class="btn-navbar" data-toggle="collapse" data-target=".sidebar" title="">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <li class="hidden-xs"><a href="<?php echo base_url("Welcome/logout")?>"><i class="glyphicon glyphicon-off"></i></a></li>
                </ul>
                <form id="search-form" class="navbar-form pull-right" role="search">
                    <input type="search" class="form-control search-query" placeholder="Search...">
                </form>
                <div class="notifications pull-right">
                    <div class="alert pull-right">
                        <a href="#" class="close ml-xs" data-dismiss="alert">&times;</a>
                        <i class="fa fa-info-circle mr-xs"></i> Check out Light Blue <a id="notification-link" href="#">settings</a> on the right!
                    </div>
                </div>
            </div>
        </header>
    <div class="content container">
    <!--input type="hidden" value="<?php echo $this->security->get_csrf_hash(); ?>" id="token_hash"-->
<?php
//if($this->session->flashdata('message')) { ?>
  <!--script>
    $(function() {
      noti('<?php echo $this->session->flashdata('message'); ?>');
    })
  </script-->
<?php //} ?>

<script>
var ajaxUrlPage_head = '<?php echo base_url("Menu/get_menu"); ?>';

function base_url(cadena = "") {
    var base = window.location.href.split('/');
    return base[0]+'//'+base[2]+'/erp/'+cadena;
}

function get_page_header() {
    $.post(ajaxUrlPage_head, function(data) {
        //console.log(data)
        $('#sidebar').html('');
        if(data.data !== undefined) {
            $("#sidebar").append(crear_menu(data.data));

            if (data.customer != undefined) {
                $('#sidebar').append(crear_customer(data.customer));
            }
        }

        $(".link").on('click', function(event) {
            event.preventDefault();
            sessionStorage.clear();
            var elem = $(this);
            console.log(elem)

            if (elem.data('id') !== undefined) {
                sessionStorage.setItem('id', elem.data('id'));
            }

            if (elem.data('id1') !== undefined) {
                sessionStorage.setItem('id1', elem.data('id1'));
            }

            if (elem.data('id2') !== undefined) {
                sessionStorage.setItem('id2', elem.data('id2'));
            }

            window.location = base_url(elem.data('url'));
        });
    });
}

function crear_menu(data) {
    var id = sessionStorage.getItem('id') ? sessionStorage.getItem('id') : '';
    var id1 = sessionStorage.getItem('id1') ? sessionStorage.getItem('id1') : '';
    var id2 = sessionStorage.getItem('id2') ? sessionStorage.getItem('id2') : '';

    //Se crea el contenedor principal y se agrega una listo por defecto
    var ul = jQuery("<ul id='side-nav'></ul>");
    ul.addClass('side-nav');

    //Si contiene datos se recorre los menus
    if (data.length > 0) {
        for(var i in data) {
            id = id == '' ? data[0].menus_id : id;
            var li = jQuery('<li></li>');

            if(data[i].nivel.length > 0) {
                li.addClass('panel '+(id == data[i].id_menu?'active':''));
                li.append('<a class="accordion-toggle'+(id == data[i].menus_id?'':' collapsed')+'" data-toggle="collapse" data-parent="#side-nav" href="#'+data[i].char_nombre.split(" ").join('_')+'-collapse"><i class="'+data[i].char_icon+'"></i><span class="name">'+data[i].char_nombre+'</span></a>');

                var subUl = jQuery('<ul id="'+data[i].char_nombre.split(" ").join('_')+'-collapse"></ul>');
                subUl.addClass("panel-collapse collapse"+(id == data[i].menus_id?' in':''));

                for(var j in data[i].nivel) {
                    if (data[i].nivel[j].nivel.length == 0) {
                        subUl.append('<li '+(id1 == data[i].nivel[j].menus_id?'class="active"':'')+'><a class="link" class="link" data-id="'+data[i].menus_id+'" data-id1="'+data[i].nivel[j].menus_id+'" data-url="'+data[i].nivel[j].char_url+'" href="javascript:void(0);">'+data[i].nivel[j].char_nombre+'</a></li>');
                    } else {
                        var liNivel2 = jQuery('<li></li>');

                        liNivel2.addClass('panel '+(id1 == data[i].nivel[j].menus_id?'active':''));
                        liNivel2.append('<a class="accordion-toggle'+(id1 == data[i].nivel[j].menus_id?'':' collapsed')+'" data-toggle="collapse" data-parent="#'+data[i].char_nombre.split(" ").join('_')+'-collapse" href="#sub-menu-'+data[i].nivel[j].menus_id+'-collapse">'+data[i].nivel[j].char_nombre+'</a>');
                        var ulNivel2 = jQuery('<ul id="sub-menu-'+data[i].nivel[j].menus_id+'-collapse"></ul>');
                        ulNivel2.addClass((id1 == data[i].nivel[j].menus_id)?'panel-collapse open collapse in':'panel-collapse collapse');

                        for(var k in data[i].nivel[j].nivel) {
                            if (data[i].nivel[j].nivel[k].nivel.length == 0) {
                                ulNivel2.append('<li '+(id2 == data[i].nivel[j].nivel[k].menus_id?'class="active"':'')+'><a class="link" data-id="'+data[i].menus_id+'" data-id1="'+data[i].nivel[j].menus_id+'" data-id2="'+data[i].nivel[j].nivel[k].menus_id+'" data-url="'+data[i].nivel[j].nivel[k].char_url+'" href="javascript:void(0);">'+data[i].nivel[j].nivel[k].char_nombre+'</a></li>');
                            } else {

                                var liNivel3 = jQuery('<li></li>');
                                liNivel3.addClass('panel');

                                liNivel3.append('<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#sub-menu-'+data[i].nivel[j].menus_id+'-collapse" href="#sub-menu-'+data[i].nivel[j].nivel[k].menus_id+'-collapse">'+data[i].nivel[j].nivel[k].char_nombre+'</a>');

                                var ulNivel3 = jQuery('<ul id="sub-menu-'+data[i].nivel[j].nivel[k].menus_id+'-collapse"></ul>');
                                ulNivel3.addClass('panel-collapse collapse');

                                for(var l in data[i].nivel[j].nivel[k].nivel) {
                                    ulNivel3.append('<li><a href="'+data[i].nivel[j].nivel[k].nivel[l].char_url+'">'+data[i].nivel[j].nivel[k].nivel[l].char_nombre+'</a></li>');
                                }

                                liNivel3.append(ulNivel3);
                                ulNivel2.append(liNivel3);

                            }
                            
                        }

                        liNivel2.append(ulNivel2);
                        subUl.append(liNivel2);
                    }
                }

                li.append(subUl);

            } else {
                if(id == data[i].menus_id) {
                    li.addClass('active');
                }
                li.addClass(' link');
                li.append('<a data-id="'+data[i].menus_id+'" data-url="'+data[i].char_url+'" href="javascript:void(0);"><i class="'+data[i].char_icon+'"></i> <span class="name">'+data[i].char_nombre+'</span></a>');
            }
            
            ul.append(li);
        }
    }

    var liFinal = jQuery('<li></li>');
    liFinal.addClass('visible-xs');
    liFinal.append('<a href="<?php echo base_url("Welcome/logout"); ?>"><i class="fa fa-sign-out"></i> <span class="name">Sign Out</span></a>');
    ul.append(liFinal);
    return ul;
}

function crear_customer(data) {
    $('#side-nav').append('<h5 class="sidebar-nav-title">Labels <a class="action-link" href="#"><i class="glyphicon glyphicon-plus"></i></a></h5>');
}
</script>