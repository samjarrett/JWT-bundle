<?php

namespace SamJ\JWTBundle;


class Manager
{
    const DEFAULT_ALG = 'HS256';

    /**
     * @var string
     */
    private $key;

    /**
     * @param string $key
     * @param string|null $alg
     */
    public function __construct($key, $alg = null)
    {
        $this->key = $key;

        if (empty($alg)) {
            $alg = self::DEFAULT_ALG;
        }
        $this->alg = $alg;
    }

    /**
     * Decodes a JWT string into a PHP object.
     *
     * @param string      $jwt           The JWT
     * @param array|null  $allowed_algs  List of supported verification algorithms
     *
     * @return object      The JWT's payload as a PHP object
     */
    public function decode($jwt, $allowedAlgs = array())
    {
        if (empty($allowedAlgs)) {
            $allowedAlgs = array($this->alg);
        }

        return \JWT::decode($jwt, $this->key, $allowedAlgs);
    }

    /**
     * Converts and signs a PHP object or array into a JWT string.
     *
     * @param object|array $payload PHP object or array
     * @param string|null  $alg     The signing algorithm. Supported
     *                              algorithms are 'HS256', 'HS384' and 'HS512'
     *
     * @return string      A signed JWT
     */
    public function encode($payload, $alg = null)
    {
        if (empty($alg)) {
            $alg = $this->alg;
        }

        return \JWT::encode($payload, $this->key, $alg);
    }
}