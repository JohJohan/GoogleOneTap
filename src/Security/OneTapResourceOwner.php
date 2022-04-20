<?php

declare(strict_types=1);

namespace App\Security;

use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\OAuth\StateInterface;
use LogicException;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Basic class to use OAuth from HWI\Bundle.
 *
 * Class OneTapResourceOwner.
 */
final class OneTapResourceOwner implements ResourceOwnerInterface
{
    /**
     * @var StateInterface
     */
    private $state;

    /**
     * {@inheritDoc}
     */
    public function getUserInformation(array $accessToken, array $extraParameters = [])
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthorizationUrl($redirectUri, array $extraParameters = [])
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * {@inheritDoc}
     */
    public function getAccessToken(HttpRequest $request, $redirectUri, array $extraParameters = [])
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * {@inheritDoc}
     */
    public function isCsrfTokenValid($csrfToken)
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'google_one_tab';
    }

    /**
     * {@inheritDoc}
     */
    public function getOption($name)
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * {@inheritDoc}
     */
    public function handles(HttpRequest $request)
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * {@inheritDoc}
     */
    public function addPaths(array $paths)
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshAccessToken($refreshToken, array $extraParameters = [])
    {
        throw new LogicException(sprintf('Function: `%s` of class `%s` is not implemented.', __FUNCTION__, __CLASS__));
    }

    /**
     * @return StateInterface
     */
    public function getState(): StateInterface
    {
        return $this->state;
    }

    /**
     * @param StateInterface|null $state
     */
    public function storeState(StateInterface $state = null): void
    {
        $this->state = $state;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addStateParameter(string $key, string $value): void
    {
        $this->state->add($key, $value);
    }
}
