<?php

namespace radix\NonceOop;

interface NonceServiceInterface
{
    /**
     * Basic nonce creation
     *
     * @param string $action Action name.
     *
     * @return string
     */
    public function getNonce(string $action) : string;


    /**
     * Create an input field with nonce.
     *
     * @param string $action
     * @param string $name
     * @param bool   $referer
     * @param bool   $echo
     *
     * @return string
     */
    public function getNonceField(
        string $action = '-1',
        string $name = "_wpnonce",
        bool $referer = true,
        bool $echo = true
    ) : string;


    /**
     * Create an url containing a nonce.
     *
     * @param string $actionurl
     * @param string $action
     * @param string $name
     *
     * @return string
     */
    public function getNonceUrl(
        string $actionurl,
        string $action = '-1',
        string $name = '_wpnonce'
    ) : string;


    /**
     * Verify nonce.
     *
     * @param string $action
     * @param string $toVerify
     *
     * @return bool|int False if the nonce is invalid, 1 if the nonce is valid and generated between
     *                   0-12 hours ago, 2 if the nonce is valid and generated between 12-24 hours ago.
     */
    public function verifyNonce(string $action, string $toVerify);
}
