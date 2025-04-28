<?php 

class BD{

		private $host;
		private $base;
		private $usu;
		private $clave;

		function __construct(){

			$this->host = 'localhost';
			$this->base = 'casalai';
			$this->usu = 'root';
			$this->clave = '';

		}

		function conexion(){

			$conex = new PDO('mysql:host='.$this->host.';dbname='.$this->base.';charset=utf8',$this->usu,$this->clave);

			return $conex;

		}
	}


	 ?>