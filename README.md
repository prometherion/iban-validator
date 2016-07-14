# IBAN Validator

Just a simple class to check IBAN hash and get simple informations like country ISO code, routing number and account number.

# Installation
Install via composer:
```sh
composer require prometherion/iban-validator
```

# Usage Example
```sh
<?php
use Prometherion\IbanValidator;

$valid_iban = IbanValidator::parse('IT40 S054 2811 1010 0000 0123 456');
$valid_iban->number; // 000000123456
$valid_iban->country; // IT
$valid_iban->routing; // 40s0542811101
$valid_iban->complete; // IT40S0542811101000000123456

$invalid_iban = IbanValidator::parse('PZ14 A014 7852 0369 0000 9874 654');
// Exception with message 'Country code PZ seems not valid'


$invalid_iban = IbanValidator::parse('IT40 S054 2811 1010 0000 0123 451');
// Exception with message 'IBAN IT40 S054 2811 1010 0000 0123 451 seems not valid!'

```
