<?php
namespace Firebase\JWT;

class JWT
{
    public static function encode($payload, $key, $alg = 'HS256')
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => $alg]);
        $payload = json_encode($payload);
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    
    public static function decode($jwt, $key, $allowed_algs = ['HS256'])
    {
        $tks = explode('.', $jwt);
        if (count($tks) != 3) {
            throw new \Exception('Wrong number of segments');
        }
        
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $tks[1])));
        return $payload;
    }
}

class ExpiredException extends \Exception {}
class BeforeValidException extends \Exception {}
class SignatureInvalidException extends \Exception {}
?>
