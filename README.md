# Twig Text Extension

TwigTextExtension contains the following filters:

* `hash`: Exposes the [hash](http://www.php.net/manual/en/function.hash.php) function included in PHP.

License: **MIT**

## Requirements

* PHP >= 5.3
* Twig >= 1.10

## Installation

Update your `composer.json`:

```json
"require": {
    "falc/twig-text-extension": "dev-master"
}
```

### Symfony

To use it in a Symfony project you have to [register the extension as a service](http://symfony.com/doc/current/cookbook/templating/twig_extension.html#register-an-extension-as-a-service).

```yaml
services:
    twig.extension.text:
        class: Falc\Twig\Extension\TextExtension
        tags:
            - { name: twig.extension }
```

If there is already an extension registered as `twig.extension.text` you can give the new one a different name:

```yaml
services:
    twig.extension.text:
        class: Other\Twig\Extension\TextExtension
        tags:
            - { name: twig.extension }
    twig.extension.falc_text:
        class: Falc\Twig\Extension\TextExtension
        tags:
            - { name: twig.extension }
```

### Other

To use it in other projects:

```php
$twig = new Twig_Environment($loader, $options);
$twig->addExtension(new Falc\Twig\Extension\TextExtension());
```

## Usage

### Hash

```
{{ 'hash-something' | hash('md5') }}
```

Check [`hash_algos()`](http://www.php.net/manual/en/function.hash-algos.php) to find a list of available algorithms.
