<?php
declare(strict_types=1);

namespace radix\NonceOop\Tests;

use radix\NonceOop\RequestNonce;
use radix\NonceOop\NonceServiceInterface;
use PHPUnit\Framework\TestCase;

class RequestNonceTest extends TestCase
{
    /** @var NonceServiceInterface $nonceService */
    private $nonceService;

    /**
     * Test nonces verification.
     */
    public function testNonceVerification()
    {
        $_REQUEST['testArg'] = $this->nonceService->getNonce('testAction');
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
        $this->nonceService = new RequestNonce();
    }
}
