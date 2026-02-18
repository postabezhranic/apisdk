<?php

use postabezhranic\Apisdk\Pbh; //zadání namespace Pbh

//pokud nepoužíváte composer je potřeba takto nalinkovat závislosti
require __DIR__ . '/../src/Pbh.php';
require __DIR__ . '/../src/Request.php';

//příklad zásilky AT - POST
$pbh = new Pbh('userId', 'apikey'); //zde zadáme ID uživatele a api klíč
$result = $pbh->getReturnShippingLabel([
    'senderCompany' => 'Firma s.r.o.',
    'senderName' => 'Charlie Brown',
    'senderStreet' => 'Kellergasse 23',
    'senderZip' => '4040',
    'senderCity' => 'Linz',
    'senderPhone' => '123456789',
    'senderEmail' => 'test@domena.cz',
    'courierNumber' => 11,
    'additionalData' => [
        'width' => 100,
        'height' => 10,
        'length' => 10,
    ],
]);

var_dump($result);


//příklad zásilky FR - Colissimo
$pbh = new Pbh('userId', 'apikey'); //zde zadáme ID uživatele a api klíč
$result = $pbh->getReturnShippingLabel([
	'parcel_id' => '2-202004221',
]);

var_dump($result);