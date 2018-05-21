<?php

namespace Postabezhranic\Apisdk;

use DOMDocument;

/**
 * @author Jan Matoušek
 * @version 1.0
 */
class XmlBuilder {
	
	/** @var DOMDocument */
	public $xml, $xmlContainer;
	
	/** @var string|bool*/
	public $buildedXml = FALSE;
	
	private $mainWrapper = 'zasilky';
	private $wrapper = 'zasilka';
	
	const TYPE_ITEM = 'item';
	const TYPE_PRODUCT = 'product';
	
	public function __construct($type = self::TYPE_ITEM){
		$this->xml = $xml = new DOMDocument('1.0', 'UTF-8');
		$xml->formatOutput = true;
		
		if($type == self::TYPE_PRODUCT){
			$this->mainWrapper = 'produkty';
			$this->wrapper = 'produkt';
		}
		
		
		$this->xmlContainer = $container = $xml->appendChild($xml->createElement($this->mainWrapper));
	}
	
	/**
	 * 
	 * @param array $items
	 * @return string - xml
	 */
	public function build($items, $useInTransaction){
		if($this->buildedXml){
			return $this->buildedXml;
		}
		
		if($useInTransaction){
			$this->xmlContainer->appendChild($this->xml->createElement('zpracovat_transakcne', 1));	
		}

		foreach($items as $item){
			$xmlItem = $this->xmlContainer->appendChild($this->xml->createElement($this->wrapper));
			
			foreach($item->getArray() as $key => $data){
				if(!$data || !$key){
					continue;
				}
				
				$element = $xmlItem->appendChild($this->xml->createElement($key));
				
				if(is_array($data)){
					$function = 'build' . ucfirst($key);
					$this->$function($data, $element);
				}else{
					$element->appendChild($this->xml->createCDATASection($data));	
				}
			}
		}
		
		$this->buildedXml = $this->xml->saveXML();

		return $this->buildedXml;
	}
	
	
	private function buildProdukty($data, &$element){
		foreach($data as $product){
			$productElement = $element->appendChild($this->xml->createElement('produkt'));
			foreach($product as $key => $val){
				$productVal = $productElement->appendChild($this->xml->createElement($key));
				$productVal->appendChild($this->xml->createCDATASection($val));
			}
		}
	}
	
			}
