<?php
namespace Firebase\JWT;

class Key
{
    public $key;
    public $algorithm;
    
    public function __construct($key, $algorithm = 'HS256')
    {
        $this->key = $key;
        $this->algorithm = $algorithm;
    }
}
?>
