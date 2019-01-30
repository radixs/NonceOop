<?php
declare(strict_types=1);

namespace radix\NonceOop;

class NonceFacade
{
    /** @var string $action */
    private $action;

    /** @var NonceServiceInterface $nonceService */
    private $nonceService;

    /**
     * Create facade instance and inject nonce service.
     *
     * Will use default wordpress nonce service if parameter is empty.
     *
     * @param NonceServiceInterface|null $nonceService Optional.
     */
    public function __construct(string $action, NonceServiceInterface $nonceService = null)
    {
        if (is_null($nonceService)) {
            $nonceService = new SimpleNonce();
        }
        $this->nonceService = $nonceService;
        $this->action = $action;
    }

    /**
     * Create a simple nonce.
     *
     * @return string
     */
    public function create() : string
    {
        return $this->nonceService->getNonce($this->action);
    }

    /**
     * Create input field with nonce.
     *
     * @param string $name
     * @param bool $referer
     * @param bool $echo
     *
     * @return string
     */
    public function createField(
        string $name = "_wpnonce",
        bool $referer = true,
        bool $echo = true
    ) : string {

        return $this->nonceService->getNonceField($this->action, $name, $referer, $echo);
    }

    /**
     * Create an url with added nonce.
     *
     * @param string $actionurl
     * @param string $name
     *
     * @return string
     */
    public function createUrl(string $actionurl, string $name = '_wpnonce') : string
    {
        return $this->nonceService->getNonceUrl($actionurl, $this->action, $name);
    }

    /**
     * Verify nonce.
     *
     * @param string $toCheck
     *
     * @return bool
     */
    public function check(string $toCheck) : bool
    {
        return (bool)$this->nonceService->verifyNonce($this->action, $toCheck);
    }
}
