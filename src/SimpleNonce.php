<?php
declare(strict_types=1);

namespace radix\NonceOop;

class SimpleNonce implements NonceServiceInterface
{
    /**
     * Create nonce.
     *
     * @param string $action
     *
     * @return string The token.
     */
    public function getNonce(string $action = '-1') : string
    {
        return wp_create_nonce($action);
    }

    /**
     * Retrieve or display nonce hidden field for forms.
     *
     * @param string $action  Optional. Action name. Default -1.
     * @param string $name    Optional. Nonce name. Default '_wpnonce'.
     * @param bool   $referer Optional. Whether to set the referer field for validation. Default true.
     * @param bool   $echo    Optional. Whether to display or return hidden form field. Default true.
     *
     * @return string Nonce field HTML markup.
     */
    public function getNonceField(
        string $action = '-1',
        string $name = "_wpnonce",
        bool $referer = true,
        bool $echo = true
    ) : string {

        return wp_nonce_field($action, $name, $referer, $echo);
    }

    /**
     * Retrieve URL with nonce added to URL query.
     *
     * @param string     $actionurl URL to add nonce action.
     * @param int|string $action    Optional. Nonce action name. Default -1.
     * @param string     $name      Optional. Nonce name. Default '_wpnonce'.
     *
     * @return string Escaped URL with nonce action added.
     */
    public function getNonceUrl(
        string $actionurl,
        string $action = '-1',
        string $name = '_wpnonce'
    ) : string {

        return wp_nonce_url($actionurl, $action, $name);
    }

    /**
     * Verify that correct nonce was used with time limit.
     *
     * @param string|int $action Should give context to what is taking place
     *                           and be the same when nonce was created.
     * @param string     $nonce  Nonce that was used in the form to verify
     *
     * @return bool|int
     */
    public function verifyNonce(string $action = '-1', string $nonce)
    {
        return wp_verify_nonce($nonce, $action);
    }
}
