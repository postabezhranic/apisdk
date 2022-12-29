<?php

use postabezhranic\Apisdk\Pbh; //zadání namespace Pbh

//pokud nepoužíváte composer je potřeba takto nalinkovat závislosti
require __DIR__ . '/../src/Request.php';
require __DIR__ . '/../src/Pbh.php';

$pbh = new Pbh('userId', 'apikey'); //zde zadáme ID uživatele a api klíč

$result = $pbh->getPackageInfo('2-545'); //kod viz example-send-packages
var_dump($result); //výsledek dotazu, pokud je vše dobře, vrátí se state ok