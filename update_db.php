<?php
$host = '127.0.0.1';
$port = '5432';
$dbname = 'sekolah_bersih';
$user = 'postgres';
$password = '12345';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $newHash = '$2y$10$IaBfjy991Yv/V6iRcyBZh.k24058mlvFRU67DrAF7ctch9JztZjyi';
    $email = 'raffialfarizky@gmail.com';

    $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
    $stmt->execute([$newHash, $email]);

    echo "Password updated successfully for $email\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>