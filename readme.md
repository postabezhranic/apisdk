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
Použití je jednoduché. Nejprve je potřeba inicializovat třídu \postabezhranic\Apisdk\Pbh a předat ji ***username*** a ***apikey***
```php
$pbh = new \postabezhranic\api\Pbh('username', 'apikey');
```

Potom můžeme přidávat zásilky pomocí addItem. 
Jaké klíče použít zjistíte ve třídě Item nebo pomocí naší interní dokumentace.
Interní dokumentaci obdržíte na žádost emailem po vytvoření klientského účtu. V dokumentaci se také dozvíte jaké přepravce volit, atd.

```php
$pbh->addItem([
    'kod' => '2-545',
    'psc' => '110 00',
    'ulice' => '17. listopadu',
    'mesto' => 'Praha 5', 
    'stat' => 'RO',
    'prepravce' => 23,
    'jmeno' => 'Adresát'
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

přidání produktů a odeslání produktů na postabezhranic.cz
$pbh = new Pbh('username', 'apikey'); //zde zadáme uživatelské jméno a api klíč


$pbh->useTransactionMode(); 

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


$result = $pbh->sendProducts(); 
var_dump($result);


Odeslání zásilek s produkty potom vypadá, podobně, jako klasické odeslání balíku, jen se přidají produkty, které se mají odeslat.


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
	    'id' => '2-5454',
	    'mnozstvi' => '1',
	],[
	    'id' => '2-54',
	    'mnozstvi' => '1',
	]
    ]
]);