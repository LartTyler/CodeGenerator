# Installation
```bash
$ composer require dbstudios/code-generator
```

# Usage
All components support a `setTargetPHPVersion()` method, which can be used to specify the
[PHP Version ID](http://php.net/manual/en/reserved.constants.php#reserved.constants.core) that the generated code will
run on.

```php
<?php
    use DaybreakStudios\CodeGenerator\Member\Property\PropertyGenerator;

    $property = new PropertyGenerator('myProp');
    $property->setVersion(50627);
```

In the above example, the generated property will be compatible with PHP 5.6.27 (and higher, wherever possible).