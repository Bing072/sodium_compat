<?php

/**
 * Class ParagonIE_Sodium_Crypto
 */
abstract class ParagonIE_Sodium_Crypto
{
    const box_curve25519xsalsa20poly1305_SEEDBYTES = 32;
    const box_curve25519xsalsa20poly1305_PUBLICKEYBYTES = 32;
    const box_curve25519xsalsa20poly1305_SECRETKEYBYTES = 32;
    const box_curve25519xsalsa20poly1305_BEFORENMBYTES = 32;
    const box_curve25519xsalsa20poly1305_NONCEBYTES = 24;
    const box_curve25519xsalsa20poly1305_MACBYTES = 16;
    const box_curve25519xsalsa20poly1305_BOXZEROBYTES = 16;
    const box_curve25519xsalsa20poly1305_ZEROBYTES = 32;

    const onetimeauth_poly1305_BYTES = 16;
    const onetimeauth_poly1305_KEYBYTES = 32;

    const secretbox_xsalsa20poly1305_KEYBYTES = 32;
    const secretbox_xsalsa20poly1305_NONCEBYTES = 24;
    const secretbox_xsalsa20poly1305_MACBYTES = 16;
    const secretbox_xsalsa20poly1305_BOXZEROBYTES = 16;
    const secretbox_xsalsa20poly1305_ZEROBYTES = 32;

    const stream_salsa20_KEYBYTES = 32;

    /**
     * @param string $message
     * @param string $key
     * @return string
     */
    public static function auth($message, $key)
    {

    }

    /**
     * @param string $mac
     * @param string $message
     * @param string $key
     * @return bool
     */
    public static function auth_verify($mac, $message, $key)
    {
        return hash_equals(
            $mac,
            self::auth($message, $key)
        );
    }

    /**
     * @param string $plaintext
     * @param string $nonce
     * @para, string $keypair
     * @return string
     */
    public static function box($plaintext, $nonce, $keypair)
    {
        $k = self::scalarmult(
            self::box_secretkey($keypair),
            self::box_publickey($keypair)
        );
        $c = self::secretbox($plaintext, $nonce, $k);
        ParagonIE_Sodium_Compat::memzero($k);
        return $c;
    }

    /**
     * @return string
     */
    public static function box_keypair()
    {
        $sk = random_bytes(32);
        $pk = self::scalarmult_base($sk);
        return $sk . $pk;
    }

    public static function box_keypair_from_secretkey_and_publickey($sk, $pk)
    {
        return ParagonIE_Sodium_Core_Util::substr($sk, 0, 32) .
            ParagonIE_Sodium_Core_Util::substr($pk, 0, 32);
    }

    /**
     * @param string $keypair
     * @return string
     */
    public static function box_secretkey($keypair)
    {
        if (ParagonIE_Sodium_Core_Util::strlen($keypair) !== 64) {
            throw new RangeException('Must be a keypair.');
        }
        return ParagonIE_Sodium_Core_Util::substr($keypair, 0, 32);
    }

    /**
     * @param string $keypair
     * @return string
     */
    public static function box_publickey($keypair)
    {
        if (ParagonIE_Sodium_Core_Util::strlen($keypair) !== 64) {
            throw new RangeException('Must be a keypair.');
        }
        return ParagonIE_Sodium_Core_Util::substr($keypair, 32, 32);
    }

    /**
     * @param $sk
     * @return string
     * @throws RangeException
     */
    public static function box_publickey_from_secretkey($sk)
    {
        if (ParagonIE_Sodium_Core_Util::strlen($sk) !== 32) {
            throw new RangeException('Must be 32 bytes long.');
        }
        return self::scalarmult_base($sk);
    }

    /**
     * @param string $ciphertext
     * @param string $nonce
     * @param string $nonce
     * @para, string $keypair
     * @return string
     */
    public static function box_open($ciphertext, $nonce, $keypair)
    {
        $k = self::scalarmult(
            self::box_secretkey($keypair),
            self::box_publickey($keypair)
        );
        $p = self::secretbox_open($ciphertext, $nonce, $k);
        ParagonIE_Sodium_Compat::memzero($k);
        return $p;
    }

    /**
     * @param string $n
     * @param string $p
     * @return string
     */
    public static function scalarmult($n, $p)
    {
        return ParagonIE_Sodium_Core_X25519::crypto_scalarmult_curve25519_ref10($n, $p);
    }

    /**
     * @param string $n
     * @return string
     */
    public static function scalarmult_base($n)
    {
        return ParagonIE_Sodium_Core_X25519::crypto_scalarmult_curve25519_ref10_base($n);
    }

    /**
     * @param string $plaintext
     * @param string $nonce
     * @param string $key
     * @return string
     */
    public static function secretbox($plaintext, $nonce, $key)
    {
        $subkey = ParagonIE_Sodium_Core_HSalsa20::hsalsa20($nonce, $key);

        $block0 = str_repeat("\x00", 32);
        $mlen = ParagonIE_Sodium_Core_Util::strlen($plaintext);
        $mlen0 = $mlen;
        if ($mlen0 > 64 - self::secretbox_xsalsa20poly1305_ZEROBYTES) {
            $mlen0 = 64 - self::secretbox_xsalsa20poly1305_ZEROBYTES;
        }
        for ($i = 0; $i < $mlen0; ++$i) {
            $block0[$i + self::secretbox_xsalsa20poly1305_ZEROBYTES] = $plaintext[$i];
        }
        $block0 = ParagonIE_Sodium_Core_Salsa20::salsa20_xor(
            $block0,
            ParagonIE_Sodium_Core_Util::substr($nonce, 16, 8),
            $subkey
        );
        $state = new ParagonIE_Sodium_Core_Poly1305_State(
            ParagonIE_Sodium_Core_Util::substr(
                $block0,
                0,
                self::onetimeauth_poly1305_KEYBYTES
            )
        );

        $c = ParagonIE_Sodium_Core_Util::substr(
            $block0,
            self::secretbox_xsalsa20poly1305_ZEROBYTES
        );
        if ($mlen > $mlen0) {
            $c .= ParagonIE_Sodium_Core_Salsa20::salsa20_xor_ic(
                ParagonIE_Sodium_Core_Util::substr(
                    $plaintext,
                    self::secretbox_xsalsa20poly1305_ZEROBYTES
                ),
                $nonce,
                1,
                $subkey
            );
        }
        ParagonIE_Sodium_Compat::memzero($block0);
        ParagonIE_Sodium_Compat::memzero($subkey);

        $state->update($c);
        $c = $state->finish() . $c;
        unset($state);

        return $c;
    }

    /**
     * @param string $ciphertext
     * @param string $nonce
     * @param string $key
     * @return string
     * @throws Exception
     */
    public static function secretbox_open($ciphertext, $nonce, $key)
    {
        $mac = ParagonIE_Sodium_Core_Util::substr(
            $ciphertext,
            0,
            self::box_curve25519xsalsa20poly1305_MACBYTES
        );
        $c = ParagonIE_Sodium_Core_Util::substr(
            $ciphertext,
            self::box_curve25519xsalsa20poly1305_MACBYTES
        );
        $clen = ParagonIE_Sodium_Core_Util::strlen($c);

        $subkey = ParagonIE_Sodium_Core_HSalsa20::hsalsa20($nonce, $key);
        $block0 = ParagonIE_Sodium_Core_Salsa20::salsa20(
            64,
            ParagonIE_Sodium_Core_Util::substr($nonce, 16, 8),
            $subkey
        );
        if (!ParagonIE_Sodium_Core_Poly1305::onetimeauth_verify($mac, $c, $block0)) {
            ParagonIE_Sodium_Compat::memzero($subkey);
            throw new Exception('Invalid MAC');
        }

        $m = ParagonIE_Sodium_Core_Util::xorStrings(
            ParagonIE_Sodium_Core_Util::substr($block0, self::secretbox_xsalsa20poly1305_ZEROBYTES),
            ParagonIE_Sodium_Core_Util::substr($c, 0, self::secretbox_xsalsa20poly1305_ZEROBYTES)
        );
        if ($clen > self::secretbox_xsalsa20poly1305_ZEROBYTES) {
            $m .= ParagonIE_Sodium_Core_Salsa20::salsa20_xor_ic(
                ParagonIE_Sodium_Core_Util::substr(
                    $c,
                    self::secretbox_xsalsa20poly1305_ZEROBYTES
                ),
                $nonce,
                1,
                $subkey
            );
        }
        return $m;
    }

    /**
     * @param string $message
     * @param string $sk
     * @return string
     */
    public static function sign_detached($message, $sk)
    {
        return ParagonIE_Sodium_Core_Ed25519::sign_detached($message, $sk);
    }

    /**
     * @param string $message
     * @param string $sk
     * @return string
     */
    public static function sign($message, $sk)
    {
        return ParagonIE_Sodium_Core_Ed25519::sign($message, $sk);
    }

    /**
     * @param string $signedMessage
     * @param string $pk
     * @return string
     */
    public static function sign_open($signedMessage, $pk)
    {
        return ParagonIE_Sodium_Core_Ed25519::sign_open($signedMessage, $pk);
    }

    /**
     * @param string $signature
     * @param string $message
     * @param string $pk
     * @return bool
     */
    public static function sign_verify_detached($signature, $message, $pk)
    {
        return ParagonIE_Sodium_Core_Ed25519::verify_detached($signature, $message, $pk);
    }
}