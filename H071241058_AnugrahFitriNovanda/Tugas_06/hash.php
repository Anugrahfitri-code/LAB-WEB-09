<?php
$password_plain = 'iraaCoding'; 
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
echo "Hash untuk 'iraaCoding' yang harus Anda salin: " . $password_hash;
?>