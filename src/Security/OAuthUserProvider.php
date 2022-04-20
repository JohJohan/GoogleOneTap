<?php

declare(strict_types=1);

namespace App\Security;

use Doctrine\ORM\UnexpectedResultException;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

/**
 * Class OAuthUserProvider.
 */
final class OAuthUserProvider implements OAuthAwareUserProviderInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * OAuthUserProvider constructor.
     *
     * @param LoggerInterface $logger
     * @param RequestStack    $requestStack
     */
    public function __construct(
        LoggerInterface $logger,
        RequestStack $requestStack,
    ) {
        $this->logger                = $logger;
        $this->requestStack          = $requestStack;
    }

    /**
     * @param UserResponseInterface $response
     *
     * @throws UserNotFoundException
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        dump($response);
        die();
        // email is required for mapping an account with social media
        if (null === $response->getEmail()) {
            $this->logger->info(sprintf('Someone tried to login/register with %s but no e-mail is fetched from the API', $response->getResourceOwner()->getName()));
            throw new UserNotFoundException();
        }

        $email = mb_strtolower($response->getEmail());

        try {
            // find one by email...
        } catch (UnexpectedResultException $exception) {
            $oauthUser = new OAuthUser();
            $oauthUser->setId($response->getUsername());
            $oauthUser->setResourceOwner($response->getResourceOwner()->getName());
            $oauthUser->setFirstName($response->getFirstName());
            $oauthUser->setLastName($response->getLastName());
            $oauthUser->setEmail($email);
            $oauthUser->setProfilePicture($response->getProfilePicture());

            throw new UserNotFoundException();
        }
    }
}
