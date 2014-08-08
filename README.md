# Twig Text Extension

TwigTextExtension contains the following filters:

* `br2p`: Replaces double linebreaks formatting into paragraphs.
* `hash`: Exposes the [hash](http://www.php.net/manual/en/function.hash.php) function included in PHP.
* `p2br`: Replaces paragraph formatting with double linebreaks.
* `paragraphs_slice`: Extracts paragraphs from a string. Similar to [array_slice](http://www.php.net/manual/en/function.array-slice.php).

License: **MIT**

## Requirements

* PHP >= 5.3
* Twig >= 1.12

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

### br2p

```
// Example
{{ 'This is a text.<br /><br>This should be another paragraph.' | br2p }}

// Output
"<p>This is a text.</p><p>This should be another paragraph.</p>"
```

### hash(algorithm, rawOutput)

* `algorithm`: Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..)
* `rawOutput`: When set to `true`, outputs raw binary data. `False` outputs lowercase hexits.
  * Optional.
  * Default is **false**.

```
// Example
{{ 'hash-something' | hash('md5') }}

// Output
"6885610d9373d81639f73b6844aad6b3"
```

Check [`hash_algos()`](http://www.php.net/manual/en/function.hash-algos.php) to find a list of available algorithms.

### p2br

```
// Example
{{ '<p>This is a text.</p><p>This should be another paragraph.</p>' | p2br }}

// Output
"This is a text.<br /><br />This should be another paragraph."
```

### paragraphs_slice(offset, length)

* `offset`: Number of paragraphs to offset.
  * Optional.
  * Default is **0**.
* `length`: Number of paragraphs to return.
  * Optional.
  * Default is **null**.

This filter works like [array_slice](http://www.php.net/manual/en/function.array-slice.php).

#### Examples

Without parameters, it will return an array containing all the paragraphs:

```
// Example
{{ '<p>First paragraph.</p><p>Second paragraph.</p><p>Third paragraph</p>' | paragraphs_slice }}

// Output
["<p>First paragraph.</p>", "<p>Second paragraph.</p>", "<p>Third paragraph</p>"]
```

Return an array containing the first two paragraphs:

```
// Example
{{ '<p>First paragraph.</p><p>Second paragraph.</p><p>Third paragraph</p>' | paragraphs_slice(0, 2) }}

// Output
["<p>First paragraph.</p>", "<p>Second paragraph.</p>"]
```

Return an array containing only the second paragraph:

```
// Example
{{ '<p>First paragraph.</p><p>Second paragraph.</p><p>Third paragraph</p>' | paragraphs_slice(1, 1) }}

// Output
["<p>Second paragraph.</p>"]
```

Return an array containing the last paragraph:

```
// Example
{{ '<p>First paragraph.</p><p>Second paragraph.</p><p>Third paragraph</p>' | paragraphs_slice(0, -1) }}

// Output
["<p>Third paragraph</p>"]
```

Twig allows to chain filters, so you can join the resulting array using [join](http://twig.sensiolabs.org/doc/filters/join.html)...

```
// Example
{{ '<p>First paragraph.</p><p>Second paragraph.</p><p>Third paragraph</p>' | paragraphs_slice(0, 2) | join }}

// Output
"<p>First paragraph.</p><p>Second paragraph.</p>"
```

...and to make Twig process HTML, chain the [raw](http://twig.sensiolabs.org/doc/filters/raw.html) filter:

```
{{ '<p>First paragraph.</p><p>Second paragraph.</p><p>Third paragraph</p>' | paragraphs_slice(0, 2) | join | raw }}
```

That way it is possible to truncate a text at a paragraph level.
