DopamineMdashBundle
===================

Evgeny Muravjev Typograph bundle for Symfony2

Installation
------------

Add the following line to your composer.json file.

```js
//composer.json
{
    //...

    "require": {
        //...
        "Dopamine/MdashBundle" : "dev-master"
    }

    //...
}
```

And install the new bundle

```bash
php composer.phar update Dopamine/MdashBundle
```

Or

```bash
php composer.phar require Dopamine/MdashBundle:dev-master
```


If you haven't allready done so, get Composer ([make sure it's up-to-date](http://getcomposer.org/doc/03-cli.md#self-update)).

```bash
curl -s http://getcomposer.org/installer | php
```

The final step is to add the bundle to your AppKernel.php.

```php
<?php

    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Dopamine\MdashBundle\DopamineMdashBundle(),
    );
```

