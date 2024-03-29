<?php

use postabezhranic\Apisdk\Pbh; //zadání namespace Pbh

//pokud nepoužíváte composer je potřeba takto nalinkovat závislosti
require __DIR__ . '/../src/Request.php';
require __DIR__ . '/../src/Pbh.php';
require __DIR__ . '/../src/Product.php';
require __DIR__ . '/../src/XmlBuilder.php';

$pbh = new Pbh('userId', 'apikey'); //zde zadáme ID uživatele a api klíč

//pokud chceme, aby se při chybě nenahrály žádné zásilky, můžeme použít metodu
$pbh->useTransactionMode();

// příklad přidání produktu
$pbh->addProduct([
	'productcode' => '1-545',
	'name' => 'test',
	'photo' => 'https://www.postabezhranic.cz/styl/images/logo-posta-bez-hranic.png',
]);

$pbh->addProduct([
	'productcode' => '1-5454',
	'name' => 'test2',
	'photo' => 'https://www.postabezhranic.cz/styl/images/logo-posta-bez-hranic.png',
]);



$result = $pbh->sendProducts(); //odešleme produkty na postabezhranic.cz
var_dump($result);