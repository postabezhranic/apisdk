#Apisdk

[![Latest stable](https://img.shields.io/packagist/v/postabezhranic/apisdk.svg)](https://packagist.org/packages/postabezhranic/apisdk)

API SDK for postabezhranic


Instalace
------------

Nejsnazší instalace je pomocí composeru  [Composer](http://getcomposer.org/):

```sh
$ composer require postabezhranic/Apisdk
```

Pokud nepoužíváte composer, stáhněte si data do svého projektu a použijte:
```php
require $path . '/Apisdk/src/Request.php';
require $path . '/Apisdk/src/Pbh.php';
require $path . '/Apisdk/src/Item.php';
require $path . '/Apisdk/src/XmlBuilder.php';
```

Kde ***$path*** je cesta ke knihovně.

Použití
------------
Použití je jednoduché. Nejprve je potřeba inicializovat třídu \postabezhranic\Apisdk\Pbh a předat ji ***userId*** a ***apikey***
```php
$pbh = new \postabezhranic\api\Pbh('userId', 'apikey');
```

Potom můžeme přidávat zásilky pomocí addItem. 
Jaké klíče použít zjistíte ve třídě Item nebo pomocí naší interní dokumentace.
Interní dokumentaci obdržíte na žádost emailem po vytvoření klientského účtu. V dokumentaci se také dozvíte jaké přepravce volit, atd.

```php

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
	    '@attributy' => [
	        'key' => 'val', //vygeneruje <sluzba key="val">
	    ]
	    'nazev' => 'PP',
	    'hodnota' => '1',
	]
    ]
]);

//starší zápis
$pbh->addItem(array(
    'kod' => '2-545',
    'psc' => '110 00',
    'ulice' => '17. listopadu',
    'mesto' => 'Praha 5', 
    'stat' => 'RO',
    'prepravce' => 23,
    'jmeno' => 'Adresát'
));
```

Zásilek je možné přidat až 2000

Jakmile jsou zásilky přidané, je nutné je poslat na náš server:

```php
$result = $pbh->sendItems();
```

V ***$result*** obdržíme odpověď ve formě pole. V případě, že nastane chyba, tak v odpovědi obdržíte bližší informace o chybě. Více informací se dozvíte v naší interní dokumetaci.

Získání informací o zásilce
------------
Stačí zavolat metodu getPackageInfo a předat jí kód žásilky

```php
$result = $pbh->getPackageInfo('2-545'); //kod viz example-send-packages
var_dump($result); //výsledek dotazu, pokud je vše dobře, vrátí se state ok
```

Použití u fulfillmentu
------------

Přidání produktů a odeslání produktů na postabezhranic.cz

```php
$pbh = new Pbh('userId', 'apikey'); //zde zadáme ID uživatele a api klíč


$pbh->useTransactionMode(); 

$pbh->addProduct([
    'productcode' => '1-545',
    'name' => 'test',
    'photo' => 'https://www.postabezhranic.cz/styl/images/logo-posta-bez-hranic.png',
]);

$pbh->addProduct([
    'productcode' => '1-5454',
    'productcodeOther' => 'some-code',
    'name' => 'test2',
    'photo' => 'https://www.postabezhranic.cz/styl/images/logo-posta-bez-hranic.png',
]);


$result = $pbh->sendProducts(); 
var_dump($result);
```

Odeslání zásilek s produkty potom vypadá podobně jako klasické odeslání balíku, jen se přidají produkty, které se mají odeslat.


```php
$pbh->addItem([
    'kod' => '2-545',
    'psc' => '110 00',
    'ulice' => '17. listopadu',
    'mesto' => 'Praha 5', 
    'stat' => 'RO',
    'prepravce' => 23,
    'jmeno' => 'Adresát',
    'produkty' => [
	[
	    'id' => '123456789',
	    'mnozstvi' => '1',
	],[
	    'id' => '12345678',
	    'mnozstvi' => '1',
	]
    ]
]);
```
