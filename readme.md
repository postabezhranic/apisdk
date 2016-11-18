#Apisdk

API SDK for postabezhranic


Instalace
------------

Nejsnažší instalace je pomocí composeru  [Composer](http://getcomposer.org/):

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

Kde ***$path*** je samozřejmě cesta ke knihovně.

Použití
------------
Použití je jednoduché. Nejprve je potřeba inicializovat třídu \postabezhranic\Apisdk\Pbh a předat ji ***username*** a ***apikey***
```php
$pbh = new \postabezhranic\api\Pbh('username', 'apikey');
```

Potom můžeme přidávat balíky jednoduše pomocí addItem. 
Jaké klíče použít zjistíte ve třídě Item, nebo pomocí naší interní dokumentace.
Interní dokumentaci dostanete emailem po aktivaci vašeho účtu. V dokumnetaci se také dozvíte jaké přepravce volit atd...

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

balíků je možné přidat až 2000

Pokud máme balíky přidané, je ještě potřeba je poslat k nám na server, to se udělá pomocí .

```php
$result = $pbh->sendItems();
```

V ***$result*** obdržíme odpověď ve formě pole. Pokud nastane chyba, tak bude zde i informace o chybě. Více se dozvíte zase v interní dokumetaci.