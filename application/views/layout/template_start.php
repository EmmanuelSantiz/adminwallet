<?php
/**
 * template_start.php
 *
 * Author: Emmanuel Santiz
 *
 * The first block of code used in every page of the template
 *
 */
?>
<!DOCTYPE html>
<html>
<head>
  <title>ERP</title>

  <link href="<?php echo base_url("assets/css/application.css"); ?>" rel="stylesheet">
  <link href="<?php echo base_url("assets/css/stylesMenu.css"); ?>" rel="stylesheet">
  <link href="<?php echo base_url("assets/css/datepicker.css"); ?>" rel="stylesheet">
  <link href="<?php echo base_url("assets/css/jquery.gritter.css"); ?>" rel="stylesheet">

  <link rel="shortcut icon" href="<?php echo base_url("assets/img/favicon.png"); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="ERP 1.0">
  <meta name="author" content="Emmanuel Sántiz">
  <meta charset="utf-8">

  <!--Include de scripts generales de la pagina-->
  <script src="<?php echo base_url("assets/lib/jquery/dist/jquery.min.js"); ?>"></script>
  <script src="<?php echo base_url("assets/lib/jquery-pjax/jquery.pjax.js"); ?>"></script>
  <script src="<?php echo base_url("assets/lib/bootstrap-sass/assets/javascripts/bootstrap.min.js") ?>"></script>
  <script src="<?php echo base_url("assets/lib/widgster/widgster.js"); ?>"></script>
  <script src="<?php echo base_url("assets/lib/underscore/underscore.js"); ?>"></script>
  <script src="<?php echo base_url("assets/lib/messenger/build/js/messenger.js"); ?>"></script>
  <script src="<?php echo base_url("assets/js/datepicker/bootstrap-datepicker.js"); ?>"></script>

  <!--Include del script general-->
  <script src="<?php echo base_url("assets/js/app.js"); ?>"></script>
  <script src="<?php echo base_url("assets/js/app/app.js"); ?>"></script>
  <script src="<?php echo base_url("assets/js/settings.js"); ?>"></script>
  <script src="<?php echo base_url("assets/js/numeric.js"); ?>"></script>
  <script src="<?php echo base_url("assets/lib/select2/select2.min.js") ?>"></script>

  <script src="<?php echo base_url("assets/js/zebraDate/zebra_datepicker.min.js"); ?>"></script>

  <script src="<?php echo base_url("assets/js/jquery.gritter.min.js"); ?>"></script>

  <!-- Pusher -->
  <script src="https://js.pusher.com/4.4/pusher.min.js"></script>

  <!--NodeJS-->
  <!--script src="http://34.224.174.138/node_modules/socket.io/node_modules/socket.io-client/socket.io.js"></script-->
</head>
<body>
<script>
Pusher.logToConsole = false;

var pusher = new Pusher('ca54c63c06b5c1310546', {
  cluster: 'us2',
  encrypted: true
});

var channel = pusher.subscribe("Globales");

channel.bind('Global', function(data) {
  console.log('socket')
  console.log(data)
});

$(function() {
  $('.datepicker').Zebra_DatePicker({
    format: 'Y-m-d'
  });

  $(".select2").each(function() {
    $(this).select2();
  });
});

function noti(mensaje, tipo = 'success') {
  var theme = 'air';

  $.globalMessenger({theme: theme, extraClasses: 'messenger-fixed messenger-on-top'});
  Messenger.options = {theme: theme, extraClasses: 'messenger-fixed messenger-on-top'};
  Messenger().post({message: mensaje, type: tipo, showCloseButton: true});
}

//Crear Storage configuracion
/*var promesa = new Promise((resolve, reject) => {
  //$.get('<?php echo base_url("Welcome/configuracionScript"); ?>', function(data) {
    return data ? resolve(data) : reject(new Error('error'));
  });
}).then((resolved) => {
  console.log('resolved configuracion')
  console.log(resolved)
})
.catch((error) => {console.log(error.message)});*/
</script>