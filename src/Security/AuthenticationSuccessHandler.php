<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;

/**
 * This is Description of AuthenticationSuccessHandler class
 *
 */
class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    /**
     * @var int $id
     */
    private $flashBag;
    /**
     * @var int $id
     */
    private $tokenStorage;

    /**
     * Create new AuthenticationSuccessHandler instance.
     *
     * @param HttpUtils $httpUtils
     * @param ARRAY $options
     * @param TokenStorage $tokenStorage
     * @param FlashBagInterface $flashBag
     *
     */
    public function __construct(
        HttpUtils $httpUtils,
        array $options = [],
        TokenStorage $tokenStorage,
        FlashBagInterface $flashBag
    )
    {
        parent::__construct($httpUtils, $options);

        $this->flashBag = $flashBag;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess (Request $request, TokenInterface $token)
    {
        $currentUsername = $this->tokenStorage->getToken()->getUser()->getUsername();
        $this->flashBag->add('success', "Welcome!!! <br/> `$currentUsername`");

        return parent::onAuthenticationSuccess($request, $token);
    }

}