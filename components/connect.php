<?php
$db_name = 'mysql:host=localhost;port=3307;dbname=candle_db'; 
$username = 'root'; 
$password = ''; 

try {
    $conn = new PDO($db_name, $username, $password);
    // echo "Connected successfully"; // optionnel
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!function_exists('unique_id')) {
    function unique_id() {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($chars);
        $randomString = '';
        for ($i = 0; $i < 20; $i++){
            $randomString .= $chars[mt_rand(0, $charLength - 1)];
        }
        return $randomString;
    }
}
?>

