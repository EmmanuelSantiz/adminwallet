<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci = new CI_Controller();
$ci =& get_instance();
$ci->load->helper('url');
?>

<!DOCTYPE html>
<html>
<head>
    <title>404 Pagina No Encontrada</title>
    <link href="<?php echo base_url("assets/css/application.css") ?>" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
</head>
<body>
    <div class="error-page container">
        <main id="content" class="error-container" role="main">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-10 col-lg-offset-4 col-sm-offset-3 col-xs-offset-1">
                    <div class="error-container">
                        <h1 class="error-code">404</h1>
                        <p class="error-info">
                            Esta Pagina no fue encontrada
                        </p>
                        <a href="javascript:window.history.back();" class="btn btn-transparent">
                            Regresar <i class="fa fa-history text-warning ml-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <footer class="page-footer">
            <?php echo date('Y');?> &copy; Valeant Engineering Technologies
        </footer>
    </div>
</body>
</html>