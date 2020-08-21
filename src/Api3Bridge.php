<?php

namespace Postabezhranic\Apisdk;


class Api3Bridge
{
	const HOST = 'https://api.postabezhranic.cz/';

	public function request($endpoint, $data){
		$result = Request::request(self::HOST . $endpoint, json_encode($data));

		return json_decode($result);
	}
}