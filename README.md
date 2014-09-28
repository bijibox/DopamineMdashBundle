DopamineMdashBundle
===================

Integrates [Evgeny Muravjev Typograph](http://mdash.ru) into your Symfony2 project.


Code Example
------------

The bundle defines Twig filter, which you can use with default `mdash`'s options like so:

```twig
{{ some_text|mdash }}
```

or you can apply your own set of options:

```twig
{{ some_text|mdash('my_options') }}
```

Installation
------------

Install the bundle with the help of [Composer](https://getcomposer.org):

```bash
$ php composer.phar require Dopamine/MdashBundle:dev-master
```

And enable it in your `AppKernel.php`:

```php
<?php

    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Dopamine\MdashBundle\DopamineMdashBundle(),
    );
```

Configuration
-------------

You can use every option supported by `mdash`. The reference is always available via `config:dump-reference` console command:

```bash
$ ./app/console config:dump-reference dompamine_mdash
```

Edit `config.yml` to define as many sets of options as you need:

```yaml
# app/config.yml
dopamine_mdash:
    configs:
        - my_config1:
            Text__paragraphs: false
            OptAlign__oa_oquote: false
            ...
        - my_config2:
            Text__paragraphs: true
            OptAlign__oa_oquote: true
            ...
```

License
-------
Issued under MIT license.
