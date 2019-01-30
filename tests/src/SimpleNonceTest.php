<?php
declare(strict_types=1);

namespace radix\NonceOop\Tests;

use radix\NonceOop\SimpleNonce;
use radix\NonceOop\NonceServiceInterface;
use PHPUnit\Framework\TestCase;

class SimpleNonceTest extends TestCase
{
    const PATTERN_SIMPLE = '/^[0-9a-zA-Z]{10}$/';
    const PATTERN_FIELD_ACTION =
        '/^<input type="hidden" id="_wpnonce" name="_wpnonce" value="[0-9a-zA-Z]{10}" \/>'.
        '<input type="hidden" name="_wp_http_referer" value="" \/>$/';
    const PATTERN_FIELD_NAME =
        '/^<input type="hidden" id="testName" name="testName" value="[0-9a-zA-Z]{10}" \/>'.
        '<input type="hidden" name="_wp_http_referer" value="" \/>$/';
    const PATTERN_FIELD_NO_REF = '/^<input type="hidden" id="" name="" value="[0-9a-zA-Z]{10}" \/>$/';
    const PATTERN_FIELD_NO_ECHO = '/^<input type="hidden" id="" name="" value="[0-9a-zA-Z]{10}" \/>'.
        '<input type="hidden" name="_wp_http_referer" value="" \/>$/';
    const PATTERN_URL = '/^http:\/\/test\.com\?_wpnonce=[0-9a-zA-Z]{10}$/';
    const PATTERN_URL_NAME = '/^http:\/\/test\.com\?testName=[0-9a-zA-Z]{10}$/';

    /** @var NonceServiceInterface $nonceService */
    private $nonceService;

    /**
     * Test nonce generation.
     */
    public function testNonceGeneration()
    {
        //simple
        $this->assertRegExp(self::PATTERN_SIMPLE, $this->nonceService->getNonce());
        $this->assertRegExp(self::PATTERN_SIMPLE, $this->nonceService->getNonce('testAction'));
        $this->assertNotEquals(
            $this->nonceService->getNonce(),
            $this->nonceService->getNonce('testAction')
        );

        //field, includes echo output
        ob_start();
        $this->assertRegExp(self::PATTERN_FIELD_ACTION, $this->nonceService->getNonceField());
        $this->assertRegExp(self::PATTERN_FIELD_ACTION, ob_get_contents());
        ob_end_clean();
        ob_start();
        $this->assertRegExp(self::PATTERN_FIELD_ACTION, $this->nonceService->getNonceField('testAction'));
        $this->assertRegExp(self::PATTERN_FIELD_ACTION, ob_get_contents());
        ob_end_clean();
        ob_start();
        $this->assertRegExp(self::PATTERN_FIELD_NAME, $this->nonceService->getNonceField('', 'testName'));
        $this->assertRegExp(self::PATTERN_FIELD_NAME, ob_get_contents());
        ob_end_clean();
        ob_start();
        $this->assertRegExp(self::PATTERN_FIELD_NO_REF, $this->nonceService->getNonceField('', '', false));
        $this->assertRegExp(self::PATTERN_FIELD_NO_REF, ob_get_contents());
        ob_end_clean();
        ob_start();
        $this->assertRegExp(self::PATTERN_FIELD_NO_ECHO, $this->nonceService->getNonceField(
            '',
            '',
            true,
            false
        ));
        $this->assertEmpty(ob_get_contents());
        ob_end_clean();

        //url
        $this->assertRegExp(self::PATTERN_URL, $this->nonceService->getNonceUrl('http://test.com'));
        $this->assertRegExp(self::PATTERN_URL, $this->nonceService->getNonceUrl(
            'http://test.com',
            'testAction'
        ));
        $this->assertRegExp(self::PATTERN_URL_NAME, $this->nonceService->getNonceUrl(
            'http://test.com',
            '',
            'testName'
        ));
    }

    /**
     * Test nonces verification.
     */
    public function testNonceVerification()
    {
        $noActionNonce = $this->nonceService->getNonce('');
        $actionNonce = $this->nonceService->getNonce('testAction');

        $this->assertNotFalse($this->nonceService->verifyNonce('', $noActionNonce));
        $this->assertNotFalse($this->nonceService->verifyNonce('testAction', $actionNonce));

        $this->assertFalse($this->nonceService->verifyNonce('', $actionNonce));
        $this->assertFalse($this->nonceService->verifyNonce('testAction', $noActionNonce));
    }

    /**
     * Set up WP libraries.
     */
    public function setUp()
    {
        define('ABSPATH', dirname(__FILE__).'/../../../../../');
        require_once(ABSPATH.'wp-load.php');
        $this->nonceService = new SimpleNonce();
    }
}
