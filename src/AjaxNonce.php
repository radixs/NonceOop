<?php

namespace radix\NonceOop;

class AjaxNonce extends WordpressSimpleNonce
{
    /**
     * Verify that correct nonce was used with time limit. Checks against argument in the ajax request.
     *
     * @param string|int $action         Action name.
     * @param string     $queryArgument  Query argument that holds nonce as value.
     *
     * @return false|int
     */
    public function verifyNonce(string $action, string $queryArgument)
    {
        return check_ajax_referer($nonce, $action);
    }
}
