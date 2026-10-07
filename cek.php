<?php
echo 'cURL: ' . (function_exists('curl_init') ? 'AKTIF ✅' : 'MATI ❌') . '<br>';
echo 'allow_url_fopen: ' . (ini_get('allow_url_fopen') ? 'AKTIF ✅' : 'MATI ❌') . '<br>';
echo 'PHP Version: ' . phpversion() . '<br>';
echo 'OpenSSL: ' . (extension_loaded('openssl') ? 'AKTIF ✅' : 'MATI ❌') . '<br>';
?>
