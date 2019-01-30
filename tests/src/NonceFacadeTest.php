<?php
declare(strict_types=1);

namespace radix\NonceOop\Tests;

use radix\NonceOop\NonceFacade;
use radix\NonceOop\NonceServiceInterface;
use radix\NonceOop\SimpleNonce;
use PHPUnit\Framework\TestCase;

class NonceFacadeTest extends TestCase
{
    /** @var NonceFacade $successFacadeWithAction */
    private $successFacadeWithAction;

    /** @var NonceFacade $failedFacadeWithAction */
    private $failedFacadeWithAction;

    /** @var NonceFacade $successFacadeWithNoAction */
    private $successFacadeWithNoAction;

    /** @var NonceFacade $failedFacadeWithNoAction */
    private $failedFacadeWithNoAction;

    /**
     * Nonce creations, check if string is being returned.
     */
    public function testCreateNonces()
    {
        //simple
        $this->assertIsString($this->successFacadeWithAction->create());
        $this->assertIsString($this->failedFacadeWithAction->create());
        $this->assertIsString($this->successFacadeWithNoAction->create());
        $this->assertIsString($this->failedFacadeWithNoAction->create());

        //field, no arguments
        $this->assertIsString($this->successFacadeWithAction->createField());
        $this->assertIsString($this->failedFacadeWithAction->createField());
        $this->assertIsString($this->successFacadeWithNoAction->createField());
        $this->assertIsString($this->failedFacadeWithNoAction->createField());

        //field, name specified
        $this->assertIsString($this->successFacadeWithAction->createField('testName'));
        $this->assertIsString($this->failedFacadeWithAction->createField('testName'));
        $this->assertIsString($this->successFacadeWithNoAction->createField('testName'));
        $this->assertIsString($this->failedFacadeWithNoAction->createField('testName'));

        //field, referer false
        $this->assertIsString($this->successFacadeWithAction->createField('', false));
        $this->assertIsString($this->failedFacadeWithAction->createField('', false));
        $this->assertIsString($this->successFacadeWithNoAction->createField('', false));
        $this->assertIsString($this->failedFacadeWithNoAction->createField('', false));

        //field, echo set to true
        $this->assertIsString($this->successFacadeWithAction->createField('', true, false));
        $this->assertIsString($this->failedFacadeWithAction->createField('', true, false));
        $this->assertIsString($this->successFacadeWithNoAction->createField('', true, false));
        $this->assertIsString($this->failedFacadeWithNoAction->createField('', true, false));

        //url, url specified
        $this->assertIsString($this->successFacadeWithAction->createUrl('https://test.com'));
        $this->assertIsString($this->failedFacadeWithAction->createUrl('https://test.com'));
        $this->assertIsString($this->successFacadeWithNoAction->createUrl('https://test.com'));
        $this->assertIsString($this->failedFacadeWithNoAction->createUrl('https://test.com'));

        //url, name specified
        $this->assertIsString($this->successFacadeWithAction->createUrl('', 'testName'));
        $this->assertIsString($this->failedFacadeWithAction->createUrl('', 'testName'));
        $this->assertIsString($this->successFacadeWithNoAction->createUrl('', 'testName'));
        $this->assertIsString($this->failedFacadeWithNoAction->createUrl('', 'testName'));
    }

    /**
     * Check if proper nonce verification results are being given.
     */
    public function testNoncesChecks()
    {
        $this->assertTrue($this->successFacadeWithAction->check('x'));
        $this->assertTrue($this->successFacadeWithNoAction->check('x'));
        $this->assertFalse($this->failedFacadeWithAction->check('x'));
        $this->assertFalse($this->failedFacadeWithNoAction->check('x'));
    }

    /**
     * Set up mocks.
     */
    public function setUp()
    {
        $this->successFacadeWithAction = $this->getFacadeWithMock('testAction');
        $this->failedFacadeWithAction = $this->getFacadeWithMock('testAction', false);
        $this->successFacadeWithNoAction = $this->getFacadeWithMock('');
        $this->failedFacadeWithNoAction = $this->getFacadeWithMock('', false);
    }

    /**
     * Initialize facade variants for testing.
     *
     * @param string $action
     * @param bool   $verificationResult
     *
     * @return NonceFacade
     */
    private function getFacadeWithMock(string $action, bool $verificationResult = true) : NonceFacade
    {
        $nonceService = $this->createConfiguredMock(
            'radix\NonceOop\SimpleNonce',
            [
                'getNonce' => 'x',
                'getNonceField' => 'x',
                'getNonceUrl' => 'x',
                'verifyNonce' => $verificationResult,
            ]
        );

        return new NonceFacade(
            $action,
            $this->createConfiguredMock(
                'radix\NonceOop\SimpleNonce',
                [
                    'getNonce' => 'x',
                    'getNonceField' => 'x',
                    'getNonceUrl' => 'x',
                    'verifyNonce' => $verificationResult,
                ]
            )
        );
    }
}
