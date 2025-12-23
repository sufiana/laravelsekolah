<?php
$password = 'developer123';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Hash for '$password': $hash\n";
?>