<?php

namespace Postabezhranic\Apisdk;

/**
 * @author Jan Matoušek
 * @version 1.0
 */
class Pbh {
	/** @var array  - array of items*/
	private $items = array();
	
	/** @var array  - array of products for fulfillment */
	private $products = array();
	
	/** @var bool */
	private $useInTransaction = FALSE;
	
	/** @var Request */
	private $request;
	
	const URL_SEND_PACKAGES = 'https://www.postabezhranic.cz/api/send-packages';
	const URL_GET_PACKAGE_INFO = 'https://www.postabezhranic.cz/api/get-package-info?id={id}';
	const URL_ADD_PRODUCTS = 'https://www.postabezhranic.cz/api/add-products';
	
	/**
	 * 
	 * @param int $login - id uživatele
	 * @param string $apiKey - apikey (Pokud nemáte API klíč, můžete si ho vygenerovat v klientském účtu v sekci Nastavení.)
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
	 * Přidání produktu pro fulfillment
	 * @param array $productData
	 * @throws PbhException
	 */
	public function addProduct($productData){
		if(!is_array($productData)){
			throw new PbhException('Položka musí být ve formátu pole.');
		}
		
		if(!isset($productData['kod_produktu'])){
			throw new PbhException('Položka neobsahuje povinný parametr "kod_produktu"');
		}
		
		if(!isset($productData['nazev'])){
			throw new PbhException('Položka neobsahuje povinný parametr "nazev"');
		}
		
		$this->products[$productData['kod_produktu']] = new Product($productData);
	}
	
	
	/**
	 * Odeslání všech přidaných balíků
	 * 
	 * @return array
	 */
	public function sendItems(){
		$xmlBuilder = new XmlBuilder;
		
		try{
			$result = $this->request->sendRequest(self::URL_SEND_PACKAGES, $xmlBuilder->build($this->items, $this->useInTransaction));
		} catch (RequestException $e){
			$result = array();
			$result['state'] = 'error';
			$result['state_info'] = $e->getMessage();
		}
		
		return $result;
	}
	
	
	/**
	 * Odeslání všech přidaných produktů do fulfillmentu
	 * 
	 * @return array
	 */
	public function sendProducts(){
		$xmlBuilder = new XmlBuilder(XmlBuilder::TYPE_PRODUCT);
		
		try{
			$result = $this->request->sendRequest(self::URL_ADD_PRODUCTS, $xmlBuilder->build($this->products, $this->useInTransaction));
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
	
	
	public function useTransactionMode(){
		$this->useInTransaction = TRUE;
	}
}

class PbhException extends \Exception{}
