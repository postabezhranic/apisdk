<?php

use postabezhranic\Apisdk\Pbh; //zadání namespace Pbh

//pokud nepoužíváte composer je potřeba takto nalinkovat závislosti
require __DIR__ . '/../src/Request.php';
require __DIR__ . '/../src/Pbh.php';
require __DIR__ . '/../src/Product.php';
require __DIR__ . '/../src/XmlBuilder.php';

$pbh = new Pbh('username', 'apikey'); //zde zadáme uživatelské jméno a api klíč

//pokud chceme, aby se při chybě nenahrály žádné zásilky, můžeme použít metodu
$pbh->useTransactionMode(); 

// příklad přidání produktu
$pbh->addProduct([
    'kod_produktu' => '1-545',
    'nazev' => 'test',
    'foto' => 'https://www.postabezhranic.cz/styl/images/logo-posta-bez-hranic.png',
]);

$pbh->addProduct([
    'kod_produktu' => '1-5454',
    'nazev' => 'test2',
    'foto' => 'https://www.postabezhranic.cz/styl/images/logo-posta-bez-hranic.png',
]);


$result = $pbh->sendProducts(); //odešleme produkty na postabezhranic.cz
var_dump($result);