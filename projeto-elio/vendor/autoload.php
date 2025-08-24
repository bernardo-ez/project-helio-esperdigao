<?php
// Autoloader manual para o projeto
spl_autoload_register(function ($class) {
    // Mapeamento de classes para arquivos
    $classMap = [
        'Firebase\JWT\JWT' => __DIR__ . '/firebase/php-jwt/src/JWT.php',
        'Firebase\JWT\Key' => __DIR__ . '/firebase/php-jwt/src/Key.php',
        'Firebase\JWT\BeforeValidException' => __DIR__ . '/firebase/php-jwt/src/BeforeValidException.php',
        'Firebase\JWT\ExpiredException' => __DIR__ . '/firebase/php-jwt/src/ExpiredException.php',
        'Firebase\JWT\SignatureInvalidException' => __DIR__ . '/firebase/php-jwt/src/SignatureInvalidException.php'
    ];
    
    if (isset($classMap[$class])) {
        require_once $classMap[$class];
        return;
    }
    
    // Fallback para outras classes
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
?>
