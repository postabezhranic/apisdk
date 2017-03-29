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
	//const URL_SEND_PACKAGES = 'localhost/pbh/api/send-packages'; //testovací
	
	const URL_GET_PACKAGE_INFO = 'https://www.postabezhranic.cz/api/get-package-info?id={id}';
	//const URL_GET_PACKAGE_INFO = 'localhost/pbh/api/get-package-info?id={id}'; //testovací
	
	/**
	 * 
	 * @param int $login - id uživatele
	 * @param string $apisdkKey - apikey (Pokud nemáte API klíč, můžete si ho vygenerovat v klientském účtu v sekci Nastavení.)
	 */
	public function __construct($login, $apiKey) {
		$this->request = new Request($login, $apiKey);
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
	
	
	public function getPackageInfo($packageId){
		try{
			$result = $this->request->sendRequest(str_replace('{id}', $packageId, self::URL_GET_PACKAGE_INFO));
		} catch (RequestException $e){
			$result = array();
			$result['state'] = 'error';
			$result['state_info'] = $e->getMessage();
		}
		
		return $result;	
	}
}

class PbhException extends \Exception{}
