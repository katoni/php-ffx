A pure PHP implementation of Format-preserving, Feistel-based encryption (FFX).

Ported from [emulbreh/pyffx](https://github.com/emulbreh/pyffx).

# Usage
```php
$key = 'hello';
$alphabet = 'abcdefghijklmnopqrstuvwxyz';

$ffx = new \FFX\Codecs\Text($key, $alphabet, 10);
$ffx->encrypt('encryption'); // string: jrsunxgmbq

$ffx = new \FFX\Codecs\Integer($key, 4);
$ffx->encrypt('1234'); // int: 1867
```
