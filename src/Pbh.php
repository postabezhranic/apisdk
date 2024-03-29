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

	/** @var array  - array of products for fulfillment */
	private $productsForUpdate = array();
	
	/** @var bool */
	private $useInTransaction = FALSE;
	
	/** @var Request */
	private $request;
	
	const URL_SEND_PACKAGES = 'https://www.postabezhranic.cz/api/send-packages';
	const URL_GET_PACKAGE_INFO = 'https://www.postabezhranic.cz/api/get-package-info?id={id}';
	const URL_ADD_PRODUCTS = 'https://www.postabezhranic.cz/api/add-products';
	const URL_UPDATE_PRODUCTS = 'https://www.postabezhranic.cz/api/update-products';
	const URL_GET_RETURN_SHIPPING_LABEL = 'https://www.postabezhranic.cz/api/get-return-shipping-label';

	/**
	 * 
	 * @param int $userId - ID uživatele
	 * @param string $apiKey - apikey (Pokud nemáte API klíč, můžete si ho vygenerovat v klientském účtu v sekci Nastavení.)
	 */
	public function __construct($userId, $apiKey) {
		$this->request = new Request($userId, $apiKey);
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
			throw new PbhException('"$productData" must be array.');
		}
		
		if(!isset($productData['productcode'])){
			throw new PbhException('Item does not contains "productcode"');
		}
		
		if(!isset($productData['name'])){
			throw new PbhException('Item does not contains "name"');
		}
		
		$this->products[$productData['productcode']] = new Product($productData);
	}


	/**
	 * Přidání produktu pro fulfillment
	 * @param array $productData
	 * @throws PbhException
	 */
	public function updateProduct($productData){
		if(!is_array($productData)){
			throw new PbhException('"$productData" must be array.');
		}

		if(!isset($productData['productcode'])){
			throw new PbhException('Item does not contains "productcode"');
		}

		if(!isset($productData['name'])){
			throw new PbhException('Item does not contains "name"');
		}

		$this->productsForUpdate[$productData['productcode']] = new Product($productData);
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


	/**
	 * Odeslání všech přidaných produktů do fulfillmentu
	 *
	 * @return array
	 */
	public function sendProductsForUpdate(){
		$xmlBuilder = new XmlBuilder(XmlBuilder::TYPE_PRODUCT);

		try{
			$result = $this->request->sendRequest(self::URL_UPDATE_PRODUCTS, $xmlBuilder->build($this->productsForUpdate, $this->useInTransaction));
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

    /**
     * Získání zpětného štítku
     * @param array $labelData
     * @throws PbhException
     */
    public function getReturnShippingLabel($labelData){
        if(!is_array($labelData)){
            throw new PbhException('"$labelData" must be an array.');
        }

        $xmlBuilder = new XmlBuilder(XmlBuilder::TYPE_LABEL);

        try{
            $result = $this->request->sendRequest(self::URL_GET_RETURN_SHIPPING_LABEL, $xmlBuilder->buildSimple(XmlBuilder::TYPE_LABEL, $labelData));
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
