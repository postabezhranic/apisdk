<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use postabezhranic\Apisdk\Pbh; //zadání namespace Pbh

//pokud nepoužíváte composer je potřeba takto nalinkovat závislosti
require __DIR__ . '/../src/Request.php';
require __DIR__ . '/../src/Pbh.php';
require __DIR__ . '/../src/Item.php';
require __DIR__ . '/../src/XmlBuilder.php';

$pbh = new Pbh('username', 'apikey'); //zde zadáme uživatelské jméno a api klíč

//pokud chceme, aby se při chybě nenahrály žádné zásilky, můžeme použít metodu
$pbh->useTransactionMode(); 

// příklad správného balíku
$pbh->addItem([
    'kod' => '2-546',
    'psc' => '110 00',
    'ulice' => '17. listopadu',
    'mesto' => 'Praha 5', 
    'stat' => 'HU',
    'prepravce' => 60,
    'jmeno' => 'Adresát',
]);

// příklad správného balíku se službami
$pbh->addItem([
    'kod' => '2-545',
    'psc' => '110 00',
    'ulice' => '17. listopadu',
    'mesto' => 'Praha 5', 
    'stat' => 'HU',
    'prepravce' => 60,
    'jmeno' => 'Adresát',
    'sluzby' => [
	'sluzba' => [
	    'nazev' => 'PP',
	    'hodnota' => '1',
	]
    ]
]);

// příklad špatného balíku - nebyly vyplněny všechny údaje
$pbh->addItem([
    'kod' => '2-541'
]);

$result = $pbh->sendItems(); //odešleme balíky na postabezhranic.cz