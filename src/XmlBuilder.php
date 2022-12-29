<?php

namespace Postabezhranic\Apisdk;

use DOMDocument;

/**
 * @author Jan Matoušek
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

	const ATTRIBUTES = '@attributy';

	public function __construct($type = self::TYPE_ITEM){
		$this->xml = $xml = new DOMDocument('1.0', 'UTF-8');
		$xml->formatOutput = true;
		
		if($type == self::TYPE_PRODUCT){
			$this->mainWrapper = 'products';
			$this->wrapper = 'product';
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


	/**
	 * @param $data
	 * @param $element
	 */
	private function buildProdukty($data, &$element){
		foreach($data as $product){
			$productElement = $element->appendChild($this->xml->createElement('produkt'));
			foreach($product as $key => $val){
				$productVal = $productElement->appendChild($this->xml->createElement($key));
				$productVal->appendChild($this->xml->createCDATASection($val));
			}
		}
	}


	/**
	 * @param $data
	 * @param $element
	 */
	private function buildSluzby($data, &$element){
		foreach($data as $item){
			$productElement = $element->appendChild($this->xml->createElement('sluzba'));
			foreach($item as $key => $val){
				if(strtolower($key) == self::ATTRIBUTES){
					$this->buildAttributes($productElement, $val);
				}else{
					$productVal = $productElement->appendChild($this->xml->createElement($key));
					$productVal->appendChild($this->xml->createCDATASection($val));
				}
			}
		}
	}

    /**
     * @param $data
     * @param $element
     */
    private function buildVicekusove_zasilky($data, &$element){
        foreach($data as $item){
            $productElement = $element->appendChild($this->xml->createElement('zasilka'));
            foreach($item as $key => $val){
                if(strtolower($key) == self::ATTRIBUTES){
                    $this->buildAttributes($productElement, $val);
                }else{
                    $productVal = $productElement->appendChild($this->xml->createElement($key));
                    $productVal->appendChild($this->xml->createCDATASection($val));
                }
            }
        }
    }


	/**
	 * @param $productElement
	 * @param $arraykey
	 * @param $attributes
	 */
	private function buildAttributes($productElement, $attributes){
		foreach($attributes as $key => $value){
			$attribute = $this->xml->createAttribute($key);
			$attribute->value = $value;
			$productElement->appendChild($attribute);
		}
	}

}
