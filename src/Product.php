<?php

namespace Postabezhranic\Apisdk;

/**
 * @author Jan Matoušek
 * @version 1.0
 */
class Product
{	
	/** @var string @required*/
	private $nazev;
	
	/** @var string @required nazev*/
	private $kod_produktu;
	
	/** @var string|bool odkaz na fotografii produktu*/
	private $foto;
	
	public function __construct($data){
		$this->nazev = $data['nazev'];
		$this->kod_produktu = $data['kod_produktu'];
		$this->foto = isset($data['foto']) ? $data['foto'] : FALSE;
	}
	
	/**
	 * @return array()
	 */
	public function getArray()
	{
		$array = array();
		$obj = new \ReflectionObject($this); 
		$namespace = $obj->getName(); 

		foreach((array) $this as $key => $data){
			$array[trim(strtolower(str_replace($namespace, '', $key)))] = $data;
		}
		
		return $array;
	}



}
