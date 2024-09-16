<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\TwigFunction;

class AuthenticationExtension extends AbstractExtension
{
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_last_username', [$this, 'getLastUsername']),
            new TwigFunction('get_authentication_error', [$this, 'getAuthenticationError']),
        ];
    }

    public function getLastUsername(): ?string
    {
        return $this->authenticationUtils->getLastUsername();
    }

    public function getAuthenticationError(): ?\Throwable
    {
        return $this->authenticationUtils->getLastAuthenticationError();
    }
}
