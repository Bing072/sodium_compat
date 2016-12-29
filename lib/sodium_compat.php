<?php
namespace Sodium;

/* If the PHP extension is installed, don't do anything
 */
if (!extension_loaded('libsodium')) {
    if (!is_callable('\\Sodium\\bin2hex')) {
        /**
         * @param $string
         * @return string
         */
        function bin2hex($string)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'bin2hex'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\compare')) {
        /**
         * @param string $a
         * @param string $b
         * @return int
         */
        function compare($a, $b)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'compare'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\memcmp')) {
        /**
         * @param string $a
         * @param string $b
         * @return int
         */
        function memcmp($a, $b)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'memcmp'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_box')) {
        /**
         * @param string $message
         * @param string $nonce
         * @param string $kp
         * @return string
         */
        function crypto_box($message, $nonce, $kp)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_box'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_box_keypair')) {
        /**
         * @return string
         */
        function crypto_box_keypair()
        {
            return call_user_func(
                array('ParagonIE_Sodium_Compat', 'crypto_box_keypair')
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_box_publickey')) {
        /**
         * @param string $keypair
         * @return string
         */
        function crypto_box_publickey($keypair)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_box_publickey'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_box_publickey_from_secretkey')) {
        /**
         * @param string $sk
         * @return string
         */
        function crypto_box_publickey_from_secretkey($sk)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_box_publickey_from_secretkey'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_box_secretkey')) {
        /**
         * @param string $keypair
         * @return string
         */
        function crypto_box_secretkey($keypair)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_box_secretkey'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_box_open')) {
        /**
         * @param string $message
         * @param string $nonce
         * @param string $kp
         * @return string
         */
        function crypto_box_open($message, $nonce, $kp)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_box_open'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_sign_detached')) {
        /**
         * @param string $message
         * @param string $sk
         * @return string
         */
        function crypto_sign_detached($message, $sk)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_sign_detached'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_sign')) {
        /**
         * @param string $message
         * @param string $sk
         * @return string
         */
        function crypto_sign($message, $sk)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_sign'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_sign_keypair')) {
        /**
         * @return string
         */
        function crypto_sign_keypair()
        {
            return call_user_func(
                array('ParagonIE_Sodium_Compat', 'crypto_sign_keypair')
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_sign_open')) {
        /**
         * @param string $signedMessage
         * @param string $pk
         * @return string
         */
        function crypto_sign_open($signedMessage, $pk)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_sign_open'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_sign_publickey')) {
        /**
         * @param string $keypair
         * @return string
         */
        function crypto_sign_publickey($keypair)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_sign_publickey'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_sign_publickey_from_secretkey')) {
        /**
         * @param string $sk
         * @return string
         */
        function crypto_sign_publickey_from_secretkey($sk)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_sign_publickey_from_secretkey'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_sign_secretkey')) {
        /**
         * @param string $keypair
         * @return string
         */
        function crypto_sign_secretkey($keypair)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_sign_secretkey'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_sign_verify_detached')) {
        /**
         * @param string $signature
         * @param string $message
         * @param string $pk
         * @return bool
         */
        function crypto_sign_verify_detached($signature, $message, $pk)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_sign_verify_detached'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_stream')) {
        /**
         * @param int $len
         * @param string $nonce
         * @param string $key
         * @return string
         */
        function crypto_stream($len, $nonce, $key)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_stream'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\crypto_stream_xor')) {
        /**
         * @param $message
         * @param $nonce
         * @param $key
         * @return mixed
         */
        function crypto_stream_xor($message, $nonce, $key)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'crypto_stream_xor'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\hex2bin')) {
        /**
         * @param $string
         * @return string
         */
        function hex2bin($string)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'hex2bin'),
                func_get_args()
            );
        }
    }
    if (!is_callable('\\Sodium\\randombytes_buf')) {
        /**
         * @param int $amount
         * @return string
         */
        function randombytes_buf($amount)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'randombytes_buf'),
                func_get_args()
            );
        }
    }

    if (!is_callable('\\Sodium\\randombytes_uniform')) {
        /**
         * @param int $upperLimit
         * @return int
         */
        function randombytes_uniform($upperLimit)
        {
            return call_user_func_array(
                array('ParagonIE_Sodium_Compat', 'randombytes_uniform'),
                func_get_args()
            );
        }
    }

    if (!is_callable('\\Sodium\\randombytes_uniform')) {
        /**
         * @return int
         */
        function randombytes_random16()
        {
            return call_user_func(
                array('ParagonIE_Sodium_Compat', 'randombytes_random16')
            );
        }
    }
}