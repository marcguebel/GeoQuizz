<?php
namespace Backoffice\Controllers;

class Controller{
	protected $container;
	protected $baseUrl = "http://api.backend.local";
	public function __construct($container){
		$this->container = $container;
	}

	public function __get($property){
		if($this->container->{$property}){
			return $this->container->{$property};
		}
	}
}