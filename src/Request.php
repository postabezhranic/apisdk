<?php

namespace Postabezhranic\Apisdk;


/**
 * @author Jan Matoušek
 * @version 1.0
 */
class Request
{
	/** @var string */
	private $login;
	
	/** @var string */
	private $apisdkKey;
	
	const CERTIFICATE_PATH = '/ca-bundle.crt';
	
	
	public function __construct($login, $apisdkKey){
		$this->login = $login;
		$this->apisdkKey = $apisdkKey;
	}
	
	
	/**
	 * 
	 * @param string $url
	 * @param string $data xml
	 */
	public function sendRequest($url, $data = ''){
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($ch, CURLOPT_USERPWD, "$this->login:$this->apisdkKey");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . self::CERTIFICATE_PATH);
		$response = curl_exec($ch); 
		$error = curl_error($ch);
		
		if($error){
			throw new RequestException($error);
		}

		curl_close($ch);
		var_dump($response);
		return $this->decodeXml($response);
	}
	
	
	private function decodeXml($response){
		return json_decode(json_encode((array) simplexml_load_string($response)), 1);
	}
}

class RequestException extends \Exception{}
