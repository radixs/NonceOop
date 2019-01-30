<?php
declare(strict_types=1);

namespace radix\NonceOop\Tests;

use radix\NonceOop\AjaxNonce;
use radix\NonceOop\NonceServiceInterface;
use PHPUnit\Framework\TestCase;

class AjaxNonceTest extends TestCase
{
    /** @var NonceServiceInterface $nonceService */
    private $nonceService;

    /**
     * Test nonces verification.
     */
    public function testNonceVerification()
    {
        $nonce = $this->nonceService->getNonce('testAction');

        //no request argument
        $this->assertFalse($this->nonceService->verifyNonce('testAction', 'testArg'));

        //with request argument
        $_REQUEST['testArg'] = $nonce;
        $this->assertNotFalse($this->nonceService->verifyNonce('testAction', 'testArg'));
        unset($_REQUEST['testArg']);
    }

    /**
     * Set up WP libraries.
     */
    public function setUp()
    {
        define('ABSPATH', dirname(__FILE__).'/../../../../../');
        require_once(ABSPATH.'wp-load.php');
        $this->nonceService = new AjaxNonce();
    }
}
