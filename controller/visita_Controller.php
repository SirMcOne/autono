<?php

class visita_Controller extends Controller
{
        public $footer = "© 2023";

        public function error()
        {
                $this->visita();
        }
        public function visita()
        {
            $sesion = new sesion();
            $log = $sesion->get("usuario");
            $data['ttl'] = 'Autonomo - Administrador';
            $data['lang'] = 'es';
            $data['src'] = '../../';
            $data['foot'] = $this->footer;
            $this->registry->template->show('visita', $data);
        }
}
