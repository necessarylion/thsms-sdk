## THSMS SDK

## THSMS.com SMS Service Provider SDK

`composer require necessarylion/thsms-sdk`


## Usage

```

<?php

use Necessarylion\THSMS;

require __DIR__ . '/vendor/autoload.php';

$sms = new THSMS([
  'username' => '',
  'password' => '',
  'sender'   => 'OTP',
]);

$result  = $sms->sent('0123456789', 'Swadee!');

print_r($result);


```

## Result

```

SimpleXMLElement Object
(
  [0] => 2312-b81662d5-00000000-7b6b-07bee257
)

```