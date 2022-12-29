<?php

use postabezhranic\Apisdk\Pbh; //zadání namespace Pbh

//pokud nepoužíváte composer je potřeba takto nalinkovat závislosti
require __DIR__ . '/../src/Pbh.php';
require __DIR__ . '/../src/Request.php';

//příklad zásilky AT - POST
$pbh = new Pbh('userId', 'apikey'); //zde zadáme ID uživatele a api klíč
$result = $pbh->getReturnShippingLabel([
	'company' => 'Firma s.r.o.',
	'name' => 'Charlie Brown',
	'street' => 'Kellergasse 23',
	'zip' => '4040',
	'city' => 'Linz',
	'phone' => '123456789',
	'email' => 'test@domena.cz',
	'courierNumber' => 11,
]);

var_dump($result);


//příklad zásilky FR - Colissimo
$pbh = new Pbh('userId', 'apikey'); //zde zadáme ID uživatele a api klíč
$result = $pbh->getReturnShippingLabel([
	'parcel_id' => '2-202004221',
]);

var_dump($result);