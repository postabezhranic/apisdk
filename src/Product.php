<?php

namespace Postabezhranic\Apisdk;

/**
 * @author Jan Matoušek
 * @version 1.0
 */
class Product
{	
	/** @var string @required */
	private $name;
	
	/** @var string @required */
	private $productcode;
	
	/** @var string|bool link to product photo*/
	private $photo;
	
	public function __construct($data){
		$this->name = $data['name'];
		$this->productcode = $data['productcode'];
		$this->photo = isset($data['photo']) ? $data['photo'] : FALSE;
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
