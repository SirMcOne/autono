<?php
class index_Controller extends Controller
{
	public $footer = "© 2023";

	public function error()
	{
        $this->registry->template->show('error404');
	}

	public function index()
	{
		$data['ttl'] = 'Autonomo';
		$data['lang'] = 'es';
		$data['foot'] = $this->footer;
		$this->registry->template->show('index', $data);
	}
	public function acceso()
	{
		$sesion = new sesion();
		$log = $sesion->get("usuario");
		$data['ttl'] = 'Autonomo - Acceso';
		$data['lang'] = 'es';
		$data['src'] = '../';
		if (isset($_POST['acceder'])) {
			$user = $_POST['usuario'];
			$pass = $_POST['clave'];
			$sql = "SELECT id_usuario FROM `usuario` WHERE nicUsu='$user' AND claUsu='$pass' AND bloqueo=0;";
			$resul = $this->registry->db->query($sql);
			$rows = $resul->fetch();
			if (empty($rows['id_usuario'])) {
				$this->registry->template->erroring = "Error de ingreso";
				$this->registry->template->show('acceso', $data);
			} else {
				$sesion->set('usuario', $rows['id_usuario']);
				header('Location: ../admin/');
			}
		} else {
			if (empty($log)) {
				$this->registry->template->show('acceso', $data);
			} else {
				header('Location: ../admin/');
			}
		}
	}
	public function salir()
	{
		$sesion = new sesion();
		$sesion->termina_sesion();
		$this->acceso();
	}
	public function admin()
	{
		$sesion = new sesion();
		$log = $sesion->get("usuario");
		if(empty($log)){
			$this->acceso();
		}else{
			$data['ttl'] = 'Autonomo - Administrador';
			$data['lang'] = 'es';
			$data['src'] = '../';
			$data['foot'] = $this->footer;
			$this->registry->template->show('admin', $data);
		}
	}

}
