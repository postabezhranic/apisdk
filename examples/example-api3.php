<?php

use postabezhranic\Apisdk\Pbh; //zadání namespace Pbh

//pokud nepoužíváte composer je potřeba takto nalinkovat závislosti
require __DIR__ . '/../src/Api3Bridge.php';
require __DIR__ . '/../src/Request.php';

$pbh = new \Postabezhranic\Apisdk\Api3Bridge('username', 'apikey'); //zde zadáme uživatelské jméno a api klíč
$result = $pbh->request('delete-fulfillment-order',  [
	'apiKey' => '1111',
	'userId' => 1,
	'data' => [
		'orderNumber' => '1-123456789'
	],
]);

var_dump($result);