<?php

class router
{
	/*
 * @the registry
 */
	private $registry;

	/*
 * @the controller path
 */
	private $path;

	public $file;

	public $controller;

	public $module;

	public $numdir;

	public $action;

	function __construct($registry)
	{
		$this->registry = $registry;
	}

	/**
	 *
	 * @set controller directory path
	 *
	 * @param string $path
	 *
	 * @return void
	 *
	 */
	function setPath($path)
	{

		/*** check if path i sa directory ***/
		if (is_dir($path) == false) {
			throw new Exception('Invalid controller path: `' . $path . '`');
		}
		/*** set the path ***/
		$this->path = $path;
	}


	/**
	 *
	 * @load the controller
	 *
	 * @access public
	 *
	 * @return void
	 *
	 */

	public function loader()
	{
		/*** check the route ***/
		$this->getController();

		/*** if the file is not there diaf ***/
		if (is_readable($this->file) == false) {
			$this->file = $this->path . '/error_Controller.php';
			$this->controller = 'error';
		}

		/*** include the controller ***/
		include $this->file;

		/*** a new controller class instance ***/
		$class = $this->controller . '_Controller';
		$controller = new $class($this->registry);

		/*** check if the action is callable ***/
		if (is_callable(array($controller, $this->action)) == false) {
			$this->file = $this->path . '/error_Controller.php';
			$this->controller = 'error';
			$action = 'error';
			
		} else {
			$action = $this->action;
		}

		/*** run the action ***/
		$controller->$action();
	}


	/**
	 *
	 * @get the controller
	 *
	 * @access private
	 *
	 * @return void
	 *
	 */

	private function getController()
	{

		/*** get the route from the url ***/
		$route = (empty($_GET['rt'])) ? '' : $_GET['rt'];

		if (empty($route)) {
			$route = 'index';
		} else {
			/*** get the parts of the route ***/
			$parts = explode('/', $route);

			$num = count($parts) - 1;

			if (empty($parts[$num])) {
				$num = $num - 1;
			}
			$this->controller = "index";
			$this->module = "index";

			//var_dump($parts);	
			if ($num > 0){
				$this->controller = $parts[1];
				$this->module = $parts[0];
			}
			$this->numdir = $num;
			if (isset($parts[$num])) {
				$this->action = $parts[$num];
			}
			if (isset($_GET['v'])) {
				$this->action = $_GET['v'];
			}
			if (isset($_POST['accion'])) {
				$this->action = $_POST['accion'];
			}
		}

		//comentario		
		if (empty($this->controller)) {
			$this->controller = 'index';
		}

		/*** Get action ***/
		if (empty($this->action)) {
			$this->action = 'index';
		}



		/*** set the file path ***/
		$this->file = $this->path . '/' . $this->controller . '_Controller.php';
	}
}
