# NonceOop
This is an oop wrapper for wordpress nonces functionality.

# Installation
If you have not done that already add composer autoloader to your wordpress main index.php:
```
require_once('vendor/autoload.php');
```

Add to your `composer.json` in `require` this: `"radix/nonce-oop": "1.0` and run `composer update`.

# Usage
### Initialize the facade.
At the beginning of the file you want to use nonces in put:
```
use radix\NonceOop\NonceFacade;
```
then you can instantiate a common facade via:
```
$facade = new NonceFacade('testAction');
```
Without a second argument it will use the default `SimpleNonce` variant. If you want you can also use `RequestNonce` and `AjaxNonce`, just add them to the `use` declaration and inject their insances into the facade like that:

```
use radix\NonceOop\{NonceFacade, RequestNonce};

// ...

$facade = new NonceFacade('testAction', new RequestNonce());
```
### Use the interface.
After that is done you have four methods that you can use:

```
$simpleNonce  = $facade->create();
$fieldNonce   = $facade->createField();
$urlNonce     = $facade->createUrl('http://example.com');
$isNonceValid = $facade->check($simpleNonce);
```

The methods wrap original WordPress nonce functions.
* create method creates a simple 10-character string,
* createField method gives you HTML string containing hidden input field with a nonce in it. Refer to the method interface to see what options you can use.
* createUrl method gives you an URL with a nonce appended to URL's query. Refer to the method interface to see what options you can use.
* check method validates the nonce. When used with `SimpleNonce` it only checks the string, other classes check the $_REQUEST superglobal.

# Extending
You can add your own class that implements `NonceServiceInterface` and inject it into the facade on initialization.

# Tests
In order to run tests type:

```
vendor/bin/phpunit --bootstrap vendor/autoload.php vendor/radix/nonce-oop/tests/src
```

Please note that you need to have PHPUnit installed.


/https://phpunit.de/man
