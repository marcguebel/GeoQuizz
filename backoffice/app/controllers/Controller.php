<?php
namespace Backoffice\Controllers;

class Controller{
	protected $container;
	protected $baseUrl;
	public function __construct($container){
		$this->container = $container;
		$this->baseUrl = "https://backend-lmaillard.pagekite.me";
	}

	public function __get($property){
		if($this->container->{$property}){
			return $this->container->{$property};
		}
	}
}