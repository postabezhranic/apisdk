<?php

namespace Postabezhranic\Apisdk;

/**
 * @author Jan Matoušek
 * @version 1.0
 */
class Pbh {
	/** @var array */
	private $items = array();
	
	/** @var Request */
	private $request;
	
	const URL_SEND_PACKAGES = 'https://www.postabezhranic.cz/api/send-packages';
	//const URL_SEND_PACKAGES = 'localhost/pbh/Apisdk/send-packages'; //testovací
	
	public function __construct($login, $ApisdkKey) {
		$this->request = new Request($login, $ApisdkKey);
	}

	
	/**
	 * Přidání balíku do seznamu
	 * @param array $itemData
	 * @throws PbhException
	 */
	public function addItem($itemData){
		if(!is_array($itemData)){
			throw new PbhException('Položka musí být ve formátu pole.');
		}
		
		if(!isset($itemData['kod'])){
			throw new PbhException('Položka neobsahuje povinný parametr "kod"');
		}
		
		$this->items[$itemData['kod']] = new Item($itemData);
	}
	
	
	/**
	 * Odeslání všech přidaných balíků
	 * 
	 * @return array
	 */
	public function sendItems(){
		$xmlBuilder = new XmlBuilder;
		
		try{
			$result = $this->request->sendRequest(self::URL_SEND_PACKAGES, $xmlBuilder->build($this->items));
		} catch (RequestException $e){
			$result = array();
			$result['state'] = 'error';
			$result['state_info'] = $e->getMessage();
		}
		
		return $result;
	}
	
	
}

class PbhException extends \Exception{}
