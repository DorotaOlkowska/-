<?php

namespace App\Service\BusinessCardUrlCrypt;

use App\Service\BusinessCardUrlCrypt\Urlcrypt\Urlcrypt;
use App\Service\ServiceInterface;

class BusinessCardUrlCryptService implements ServiceInterface
{
    const ENCRYPT_METHOD = 'aes-256-cbc';

    private $firstKey;
    private $secondKey;

    public function __construct($firstKey, $secondKey)
    {
        $this->firstKey = $firstKey;
        $this->secondKey = $secondKey;
    }

    public function decrypt($input)
    {
        $c = base64_decode($input);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $this->firstKey, $options = OPENSSL_RAW_DATA,$iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $this->firstKey, $as_binary = true);

        if ($this->hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }

        return false;
    }

    public function encrypt($string)
    {
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($string, $cipher, $this->firstKey, $options = OPENSSL_RAW_DATA, $iv);

        $hmac = hash_hmac('sha256', $ciphertext_raw, $this->firstKey, $as_binary = true);
        return base64_encode($iv . $hmac . $ciphertext_raw);
    }

    public function hash_equals($knownString, $userString)
    {
        if (function_exists('mb_strlen')) {
            $kLen = mb_strlen($knownString, '8bit');
            $uLen = mb_strlen($userString, '8bit');
        } else {
            $kLen = strlen($knownString);
            $uLen = strlen($userString);
        }
        if ($kLen !== $uLen) {
            return false;
        }
        $result = 0;
        for ($i = 0; $i < $kLen; $i++) {
            $result |= (ord($knownString[$i]) ^ ord($userString[$i]));
        }

        return 0 === $result;
    }
}