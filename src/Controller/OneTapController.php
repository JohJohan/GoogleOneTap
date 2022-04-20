<?php

declare(strict_types=1);

namespace App\Controller;

use App\Security\OAuthUserProvider;
use App\Security\OneTapResourceOwner;
use Google_Client;
use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Class OneTapController.
 *
 * More information @see https://developers.google.com/identity/one-tap/web
 */
final class OneTapController extends AbstractController
{
    /**
     * @var OAuthUserProvider
     */
    private $oAuthUserProvider;

    /**
     * @var Google_Client
     */
    private $client;

    /**
     * OneTapController constructor.
     *
     * @param OAuthUserProvider     $oAuthUserProvider
     * @param Google_Client         $client
     */
    public function __construct(
        OAuthUserProvider $oAuthUserProvider,
        Google_Client $client,
    ) {
        $this->oAuthUserProvider = $oAuthUserProvider;
        $this->client            = $client;
    }

    /**
     * @param Request $request
     *
     * @Route("/public/api/one-tab-callback", name="api.one-tab.callback")
     *
     * @return Response
     */
    public function callback(Request $request): Response
    {
        $successUrl = $request->request->get('successUrl');
        if (null === $successUrl) {
            throw new BadRequestHttpException('No attr `data-success-url` added to Google One Tab config');
        }
        $fallbackUrl = $request->request->get('fallbackUrl');
        if (null === $fallbackUrl) {
            throw new BadRequestHttpException('No attr `data-fallback-url` added to Google One Tab config');
        }

        $requestToken = $request->request->get('g_csrf_token');
        $credential   = $request->request->get('credential');
        try {
            if (null === $requestToken || null === $credential) {
                throw new LogicException(sprintf('No request token: `%s` or credential set: `%s`', $requestToken, $credential));
            }

            if ($request->cookies->get('g_csrf_token') !== $requestToken) {
                throw new LogicException(sprintf('CSRF tokens do not match cookie: `%s` and request token: `%s`', $request->cookies->get('g_csrf_token'), $requestToken));
            }

            $payload = $this->client->verifyIdToken((string) $credential);
            if (false === $payload) {
                throw new LogicException(sprintf('Got invalid ID token from Google One Tab request with credential: `%s`', $credential));
            }
        } catch (LogicException) {
            $this->addFlash(
                'error',
                'errorOauth',
            );

            return $this->redirect((string) $fallbackUrl);
        }

        // Setup oatuh response so we can use loadUserByOAuthUserResponse.
        $pathUserResponse = new PathUserResponse();
        $pathUserResponse->setPaths([
            'identifier'     => 'sub',
            'nickname'       => 'given_name',
            'firstname'      => 'given_name',
            'lastname'       => 'family_name',
            'realname'       => 'given_name',
            'email'          => 'email',
            'profilepicture' => 'picture',
        ]);
        $pathUserResponse->setData($payload);
        $pathUserResponse->setResourceOwner(new OneTapResourceOwner());
        try {
            $this->oAuthUserProvider->loadUserByOAuthUserResponse($pathUserResponse);
        } catch (UsernameNotFoundException) {
            return $this->redirect((string) $fallbackUrl);
        }

        return $this->redirectToRoute('home');
    }
}
