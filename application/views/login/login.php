<div class="single-widget-container">
  <section class="widget login-widget">
    <header class="text-align-center">
      <h4>Inicio de Sesion</h4>
    </header>
    <div class="body">
      <form class="no-margin" id="form-login" method="post">
        <fieldset>
          <div class="form-group">
            <label for="user" >Usuario</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input id="char_user" type="text" name="char_user" class="form-control input-lg input-transparent" placeholder="Usuario">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="form-group">
            <label for="char_password">Password</label>
            <div class="input-group input-group-lg">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input id="char_password" name="char_password" type="password" class="form-control input-lg input-transparent" placeholder="Password">
              <div class="help-block"></div>
            </div>
          </div>
        </fieldset>
        <div class="form-actions">
          <button type="button" class="btn btn-block btn-lg btn-danger" id="logear">
            <span class="small-circle"><i class="fa fa-caret-right"></i></span><small>Ingresar</small>
          </button>
          <!--a class="forgot" data-toggle="modal" data-target="#modalReset">¿Olvidaste tu Usuario o Password?</a-->
          <a href="javascript:void(0);" class="forgot">¿Olvidaste tu Usuario o Password?</a>
        </div>
    </div>
    <div id="relog" style="display: none;" class="body">
      Este formulario estara disponible en <p id="tiempo"></p>
    </div>
  </section>
</div>


<!--Componente para manejo de errores-->
<div class="content container">
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="alert alert-danger" style="display: none;" id="errorLogin"></div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="modalReset" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel2">Recuperar Datos</h4>
      </div>
      <div class="modal-body">
        <form id="formReset">
          <div class="form-group">
            <label for="char_email" class="control-label">Correo</label>
            <input type="text" class="form-control" id="char_email" name="char_email">
            <div class="help-block"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="enviar">Enviar</button>
      </div>
      </div>
  </div>
</div>
<!--Carga de las funciones para la pagina-->
<script>
var ajaxUrl = '<?php echo base_url("Welcome/login"); ?>';
//'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',

$('#logear').click(function(event) {
  /*$('#form-login input').each(function(index, el) {
    if($(el).val() == '') {
      $(el).parent().find('.help-block').html('<font color="red">Este campo no puede estar vacio</font>');
      bandera = false;
    }
  });*/

  $.post(ajaxUrl, {char_user: $('#char_user').val(), char_password: $('#char_password').val()}, function(data) {
    console.log(data)
    if(data.data) {
      location.reload();
    }
  });

});
</script>