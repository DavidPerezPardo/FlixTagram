<?php
/**
 * Controlador para TWIG - motor de plantillas.
 * 
 */

/**/


/**
 * Importamos AUTOLOAD.PHP para que, automáticamente se importen.
 * todas las librerías PHP que me permiten trabajar con TWIG.
 * 
 */
require_once "vendor/autoload.php";
//require_once "libs/routing";

class BaseController{

	protected $twig;

	public function __construct(){

		// Instanciamos el cargador y le proporcionamos el directorio raíz
		// a partir del cual se encuentran las vistas.

		$loader = new \Twig\Loader\FilesystemLoader("./vistas");
		// Instanciamos TWIG.
		$this->twig   = new \Twig\Environment($loader);

	}

}
  
	/*
		//Para poder utilizar funciones en las vistas de twig.
		$foo = new Twig\TwigFunction('route',function($rout, $pars){

			return Routing::route($rout , $pars);

		});
		$this->twig->addFunction($foo);
	*/