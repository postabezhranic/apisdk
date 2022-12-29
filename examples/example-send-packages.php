<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use postabezhranic\Apisdk\Pbh; //zadání namespace Pbh

//pokud nepoužíváte composer je potřeba takto nalinkovat závislosti
require __DIR__ . '/../src/Request.php';
require __DIR__ . '/../src/Pbh.php';
require __DIR__ . '/../src/Item.php';
require __DIR__ . '/../src/XmlBuilder.php';

$pbh = new Pbh('userId', 'apikey'); //zde zadáme ID uživatele a api klíč

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
        ],
    ],
]);

// příklad správného balíku s tiskem štítku cílového přepravce
$pbh->addItem([
    'kod' => '2-546',
    'psc' => '110 00',
    'ulice' => '17. listopadu',
    'mesto' => 'Praha 5',
    'stat' => 'HU',
    'prepravce' => 60,
    'jmeno' => 'Adresát',
    'vytisknout_stitek_prepravce' => 1,
]);

// příklad správného balíku s vícekusovou zásilkou
$pbh->addItem([
    'kod' => '2-545',
    'psc' => '110 00',
    'ulice' => '17. listopadu',
    'mesto' => 'Praha 5',
    'stat' => 'HU',
    'prepravce' => 60,
    'jmeno' => 'Adresát',
    'hmotnost' => 100,
    'vicekusova_zasilka' => true,
    'vicekusove_zasilky' => [
        [
            'cislo_zasilky' => '2-545v1',
            'hmotnost' => 100,
        ],
        [
            'cislo_zasilky' => '2-545vk2',
            'hmotnost' => 100,
        ],
    ],
]);

// příklad špatného balíku - nebyly vyplněny všechny údaje
$pbh->addItem([
    'kod' => '2-541',
]);

$result = $pbh->sendItems(); //odešleme balíky na postabezhranic.cz