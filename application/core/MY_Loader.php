<?php
/**
 * Archivo para pintar el template
 * @param:  $template_name nombre del archivo a incluir 
 * @param:  $vars datos a retornar en la vista
 * @param:  $return si desea que los datos devueltos en lugar de enviados
 * @return: Template vista general
 */
class MY_Loader extends CI_Loader {

    public function template($template_name, $vars = array(), $return = FALSE) {
        if($return):
            $content  = $this->view('layout/template_start', $vars, $return);
            $content .= $this->view('layout/page_head', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('layout/template_end', $vars, $return);

            return $content;
        else:
            $this->view('layout/template_start', $vars);
            $this->view('layout/page_head', $vars);
            $this->view($template_name, $vars);
            $this->view('layout/template_end', $vars);
        endif;
    }
}