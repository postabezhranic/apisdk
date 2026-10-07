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
	
	/** Verze knihovny, při vydání nové verze je potřeba ji zvednout */
	const VERSION = '1.7.5';
	
	private const USER_AGENT = 'postabezhranic-apisdk/' . self::VERSION . ' (PHP ' . PHP_VERSION . ')';

	private const SERVER_ERROR_MESSAGE = 'Nastala neočekávaná chyba na straně serveru. Opakujte požadavek později. Pokud chyba přetrvává, kontaktujte nás.';
	
	
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
		curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
		curl_setopt($ch, CURLOPT_USERPWD, "$this->login:$this->apisdkKey");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		$response = curl_exec($ch); 
		$error = curl_error($ch);
		
		if($error){
			throw new RequestException($error);
		}

		return $this->decodeXml($response);
	}

	/**
	 * Hlavičky se předávají jako řetězce ve tvaru 'Název: hodnota'.
	 *
	 * @param string $url
	 * @param string $data xml
	 */
	public static function request($url, $data = '', $headers = []){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		$response = curl_exec($ch);
		$error = curl_error($ch);

		if($error){
			throw new RequestException($error);
		}

		return $response;
	}
	
	
	private function decodeXml($response)
    {
        // Chyby libxml jsou sdílené s aplikací klienta: jeho staré chyby se nesmí započítat do naší odpovědi
        // a jeho nastavení se po parsování vrací.
        $previousUseErrors = libxml_use_internal_errors(true);
        libxml_clear_errors();

        $xml = simplexml_load_string($response);
        $result = json_decode(json_encode((array)$xml), 1);

        // Prázdná odpověď chybu libxml nezanechá, pozná se jen podle false ze simplexml_load_string().
        $isValid = $xml !== false && !libxml_get_errors();

        libxml_clear_errors();
        libxml_use_internal_errors($previousUseErrors);

        if (!$isValid) {
            $result = array();
            $result['state'] = 'error';
            $result['state_info'] = self::SERVER_ERROR_MESSAGE;
        }

        return $result;
	}
}

class RequestException extends \Exception{}
