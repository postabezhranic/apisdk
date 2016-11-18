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
	
	public function __construct(){
		$this->xml = $xml = new DOMDocument('1.0', 'UTF-8');
		$xml->formatOutput = true;
		$this->xmlContainer = $container = $xml->appendChild($xml->createElement("zasilky"));
	}
	
	/**
	 * 
	 * @param array $items
	 * @return string - xml
	 */
	public function build($items){
		if($this->buildedXml){
			return $this->buildedXml;
		}
		
		foreach($items as $item){
			$xmlItem = $this->xmlContainer->appendChild($this->xml->createElement("zasilka"));
			
			foreach($item->getArray() as $key => $data){
				if(!$data || !$key){
					continue;
				}
				$xmlItem->appendChild($this->xml->createElement($key, $data));
			}
		}
		
		$this->buildedXml = $this->xml->saveXML();
		return $this->buildedXml;
	}
	
}
