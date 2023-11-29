<?php

Class Template {

/*
 * @the registry
 * @access private
 */
private $registry;

/*
 * @Variables array
 * @access private
 */
private $vars = array();

/**
 *
 * @constructor
 *
 * @access public
 *
 * @return void
 *
 */
function __construct($registry) {
	$this->registry = $registry;

}


 /**
 *
 * @set undefined vars
 *
 * @param string $index
 *
 * @param mixed $value
 *
 * @return void
 *
 */
 public function __set($index, $value)
 {
        $this->vars[$index] = $value;
 }


function show($name,$vari = array(),$ext="htm") {
	$path = __SITE_PATH . '/views' . '/' . $name . '.'.$ext;

	if (file_exists($path) == false)
	{
		throw new Exception('Template not found in '. $path);
		return false;
	}
	
	//Si hay variables para asignar, las pasamos una a una.
	if(is_array($vari))
	{
				foreach ($vari as $keyi => $valui) 
				{
				$$keyi = $valui;
				}
			}else{
				$vari = (object) $vari;} #En esta línea está la solución
	//Finalmente, incluimos la plantilla.

	// Load variables
	foreach ($this->vars as $key => $value)
	{
		$$key = $value;
	}

	include ($path);               
}


}

?>
