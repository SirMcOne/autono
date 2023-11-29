<?php

class error_Controller extends Controller
{
        public $footer = "© 2023";

        public function error()
        {
                
                $this->registry->template->ttl = 'Autonomo - Pagina 404';
                $this->registry->template->lang = 'es';
                $this->registry->template->src = '../../';
                $this->registry->template->foot = $this->footer;
                $this->registry->template->show('error404');
        }
}
