<?php

namespace App\Controller;

use App\Service\Discord;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Cookie;

class IndexController extends AbstractController
{
    private const DISCORD_ENDPOINT = 'https://discord.com/api/oauth2/authorize';

    private $discord;

    public function __construct(Discord $discord)
    {
        $this->discord = $discord;
    }

    /**
     * @Route("/", name="index",
     * methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $cookie = $request->cookies->get('iniZAuth');
        // dd($cookie);
        if ($cookie) {
            $userInfo = $this->discord->getUser($cookie);
        } else {
            $userInfo = null;
        }
        // dd($cookie);
        return $this->render('index/index.html.twig', [
            'userInfo' => $userInfo,
        ]);
    }

    /**
     * @Route("/oauth/discord", name="app_oauth_discord",
     * methods={"GET"})
     *
     */
    public function oAuth(
        CsrfTokenManagerInterface $csrfTokenManager,
        UrlGeneratorInterface $urlGenerator
    ): RedirectResponse {
        $redirectUrl = $urlGenerator->generate('app_login', [
            'discord-oauth-provider' => true
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $querryParams = http_build_query([
            'client_id' => $this->getParameter('app.discord_client_id'),
            'prompt' => 'consent',
            'redirect_url' => $redirectUrl,
            'response_type' => 'code',
            'scope' => 'identify email guilds',
            'state' => $csrfTokenManager->getToken('oauth-discord-SF')->getValue()
        ]);

        return new RedirectResponse(self::DISCORD_ENDPOINT.'?'.$querryParams);
    }

    /**
     * @Route("/login", name="app_login",
     * methods={"GET"})
     */
    public function appLogin(Request $request, UrlGeneratorInterface $urlGenerator): Response
    {
        $code = $request->query->get('code');
        // $state = $request->query->get('state');
        $user = $this->discord->loadDiscordUser($code);

        // $this->getResponse()->setCookie('user', $user['access_token'], $user['expire']);
    //     $response = new RedirectResponse($urlGenerator->generate('index'));
    //     // dd($user['access_token']);
    //     $cookie = Cookie::create('iniZAuth')
    // ->withValue($user['access_token'])
    // ->withExpires(time() + (0 * 3 * 5 * 35))
    // ->withDomain('https://127.0.0.1')
    // ->withSecure(true);
    //     $response->headers->setCookie($cookie);
    $response = new Response();
        $expires = time() + 36000;
        $cookie = Cookie::create('iniZAuth', $user['access_token'],  $expires);
        //$cookie = $response->headers->setCookie(Cookie::create('foo', 'bar'));
        $response->headers->setCookie($cookie);

        // $content = "<html><body><h1>Learning symfony cookie creation techniques?</h1></body></html>";
        // $response->setContent($content);
        $response->headers->set('Content-Type', 'text/html');
        // return $response;
        $response->send();
        
        return $this->redirectToRoute('index');
    }
}
