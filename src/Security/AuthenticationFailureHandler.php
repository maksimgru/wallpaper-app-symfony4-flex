<?php

namespace App\Security;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\HttpUtils;

/**
 * This is Description of AuthenticationFailureHandler class
 *
 */
class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler
{
    /**
     * @var int $id
     */
    private $flashBag;

    /**
     * Create new AuthenticationFailureHandler instance.
     *
     * @param HttpKernelInterface $httpKernel
     * @param HttpUtils $httpUtils
     * @param ARRAY $options
     * @param LoggerInterface $logger
     * @param FlashBagInterface $flashBag
     *
     */
    public function __construct(
        HttpKernelInterface $httpKernel,
        HttpUtils $httpUtils,
        array $options = array(),
        LoggerInterface $logger,
        FlashBagInterface $flashBag
    )
    {
        parent::__construct($httpKernel, $httpUtils, $options, $logger);

        $this->flashBag = $flashBag;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure (Request $request, AuthenticationException $exception)
    {
        $this->flashBag->add('warning', '!!!Access Denied!!! <br/> Invalid `Username` or `Password`');

        return parent::onAuthenticationFailure($request, $exception);
    }

}