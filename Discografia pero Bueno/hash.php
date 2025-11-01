<?php
$pass = 'Patap';
$salt = '$2y$12$'; // blowfish with complexity 12
$salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9), array('/', '.'));
for($i=0; $i < 22; $i++) $salt .= $salt_chars[array_rand($salt_chars)];
// use of crypt function
$hash = crypt($pass, $salt);
echo $hash;
?>