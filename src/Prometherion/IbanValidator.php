<?php
namespace Prometherion;

use Exception;

class IbanValidator
{
    protected $country;
    protected $routing;
    protected $number;
    protected $complete;

    protected function __construct(array $data)
    {
        $this->country = $data['country'];
        $this->routing = $data['routing'];
        $this->number = $data['number'];
        $this->complete = $data['complete'];
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
           throw new Exception('Data cannot be modified: parse a new one via static public method "parse"');
        }
    }

    static public function parse($unparsed)
    {
        $iban = strtolower(str_replace(' ', '', $unparsed));
        $countries = [
            'al' => 28,
            'ad' => 24,
            'at' => 20,
            'az' => 28,
            'bh' => 22,
            'be' => 16,
            'ba' => 20,
            'br' => 29,
            'bg' => 22,
            'cr' => 21,
            'hr' => 21,
            'cy' => 28,
            'cz' => 24,
            'dk' => 18,
            'do' => 28,
            'ee' => 20,
            'fo' => 18,
            'fi' => 18,
            'fr' => 27,
            'ge' => 22,
            'de' => 22,
            'gi' => 23,
            'gr' => 27,
            'gl' => 18,
            'gt' => 28,
            'hu' => 28,
            'is' => 26,
            'ie' => 22,
            'il' => 23,
            'it' => 27,
            'jo' => 30,
            'kz' => 20,
            'kw' => 30,
            'lv' => 21,
            'lb' => 28,
            'li' => 21,
            'lt' => 20,
            'lu' => 20,
            'mk' => 19,
            'mt' => 31,
            'mr' => 27,
            'mu' => 30,
            'mc' => 27,
            'md' => 24,
            'me' => 22,
            'nl' => 18,
            'no' => 15,
            'pk' => 24,
            'ps' => 29,
            'pl' => 28,
            'pt' => 25,
            'qa' => 29,
            'ro' => 24,
            'sm' => 27,
            'sa' => 24,
            'rs' => 22,
            'sk' => 24,
            'si' => 19,
            'es' => 24,
            'se' => 24,
            'ch' => 21,
            'tn' => 24,
            'tr' => 26,
            'ae' => 23,
            'gb' => 22,
            'vg' => 24
        ];
        $chars = [
            'a' => 10,
            'b' => 11,
            'c' => 12,
            'd' => 13,
            'e' => 14,
            'f' => 15,
            'g' => 16,
            'h' => 17,
            'i' => 18,
            'j' => 19,
            'k' => 20,
            'l' => 21,
            'm' => 22,
            'n' => 23,
            'o' => 24,
            'p' => 25,
            'q' => 26,
            'r' => 27,
            's' => 28,
            't' => 29,
            'u' => 30,
            'v' => 31,
            'w' => 32,
            'x' => 33,
            'y' => 34,
            'z' => 35
        ];
        if (!array_key_exists(substr($iban, 0, 2), $countries)) {
            throw new Exception('Country code ' .strtoupper(substr($iban, 0, 2)) . ' seems not valid');
        }
        if(strlen($iban) == $countries[substr($iban, 0, 2)]) {
            $movedchar = substr($iban, 4).substr($iban, 0, 4);
            $movedchar_array = str_split($movedchar);
            $newstring = '';
            foreach($movedchar_array as $key => $value){
                if(!is_numeric($movedchar_array[$key])){
                    $movedchar_array[$key] = $chars[$movedchar_array[$key]];
                }
                $newstring .= $movedchar_array[$key];
            }
            if (bcmod($newstring, '97') == 1) {
                return new static([
                    'country' => strtoupper( substr($iban, 0, 2) ),
                    'routing' => substr($iban, 2, 13),
                    'number' => substr($iban, 15),
                    'complete' => strtoupper($iban)
                ]);
            } else {
                throw new Exception('IBAN '.$unparsed.' seems not valid!');
            }
        } else {
            throw new Exception('IBAN '.$unparsed.' seems not valid!');
        }
    }
}

