<?php

namespace Postabezhranic\Apisdk;


class Api3Bridge
{
	const HOST = 'https://api.postabezhranic.cz/';

	/** @var string|null */
	private $apiKey;


	/**
	 * API klíč se posílá v hlavičce Authorization, takže ho není potřeba dávat do dat požadavku.
	 */
	public function __construct($apiKey = null){
		$this->apiKey = $apiKey;
	}


	public function request($endpoint, $data){
		$apiKey = $this->apiKey;

		// Klíč se posílá vždy v hlavičce, ne v těle požadavku. Klíč uvedený v datech má přednost před klíčem z konstruktoru.
		if (is_array($data) && isset($data['apiKey'])) {
			$apiKey = $data['apiKey'];
			unset($data['apiKey']);
		} elseif ($data instanceof \stdClass && isset($data->apiKey)) {
			$apiKey = $data->apiKey;
			// Objekt patří volajícímu, klíč se mu z něj nesmí smazat.
			$data = clone $data;
			unset($data->apiKey);
		}

		$headers = [];

		if ($apiKey) {
			$headers[] = 'Authorization: Bearer ' . $apiKey;
		}

		$result = Request::request(self::HOST . $endpoint, json_encode($data), $headers);

		return json_decode($result);
	}
}
