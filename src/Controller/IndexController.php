<?php

namespace App\Controller;

use App\Entity\Questions;

use App\Entity\Applications;
use App\Form\ApplicationsType;

use App\Service\Discord;
use App\Service\ApplicationsService;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\HttpFoundation\Cookie;

class IndexController extends AbstractController
{
    private const DISCORD_ENDPOINT = 'https://discord.com/api/oauth2/authorize';
    private const ATLANTIS_ENDPOINT = 'https://atlantisrp.gg';
    private const ATLANTIS_DISCORD_ENDPOINT = 'https://discord.atlantisrp.gg';

    private $discord;
    private $applicationsService;

    public function __construct(Discord $discord, ApplicationsService $applicationsService)
    {
        $this->discord = $discord;
        $this->applicationsService = $applicationsService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $cookie = $request->cookies->get('iniZAuth');
        if ($cookie) {
            $userInfo = $this->discord->getUser($cookie);
            $questions = $this->getDoctrine()
            ->getRepository(Questions::class)
            ->find(1);
            $applications = new Applications();
            $applications->setDiscordId($userInfo['username'].' ('.$userInfo['id'].')');
            
            $form = $this->createFormBuilder($applications, array('attr' => array('class' => 'input-container')))
            ->setAttribute('class', 'input-container')
            ->add('discordId', TextType::class, ['label' => $questions->getDiscordId(),'disabled' => true])
            ->add('steamHex', TextType::class, ['label' => $questions->getSteamHex()])
            ->add('birth_date', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd', 'label' => $questions->getBirthDate()])
            ->add('answ1', TextareaType::class, ['label' => $questions->getQue1()])
            ->add('answ2', TextareaType::class, ['label' => $questions->getQue2()])
            ->add('answ3', TextareaType::class, ['label' => $questions->getQue3()])
            ->add('answ4', TextareaType::class, ['label' => $questions->getQue4()])
            ->add('answ5', TextareaType::class, ['label' => $questions->getQue5()])
            ->add('answ6', TextareaType::class, ['label' => $questions->getQue6()])
            ->add('save', SubmitType::class, ['label' => 'Wyślij'])
            ->add('add', SubmitType::class, ['label' => 'Zapisz jako wersję roboczą', 'attr' => array('class' => 'btn_half')])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $isBL = $this->applicationsService->getBL($userInfo['id']);
                if ($isBL) {
                    return $this->redirectToRoute('user_app_logout');
                    // return $this->redire
                }else {
                    if ($form->getClickedButton() && 'save' === $form->getClickedButton()->getName()) {
                        $applications->setStatus("wait");
                        $applications->setFaster(false);
                        $applications->setCreateTime(new \DateTime());
                        $applications->setFasterBuyTime(new \DateTime());
                        $this->applicationsService->Insert($applications, $questions);
                    } elseif ($form->getClickedButton() && 'add' === $form->getClickedButton()->getName()) {
                        $applications->setStatus("wait");
                        $this->applicationsService->toDo($applications, $questions);
                    }
                
                }
            }

            return $this->render('index/application/index.html.twig', [
                'me' => $userInfo,
                'form' => $form->createView(),
            ]);
        } else {
            $userInfo = null;
            return $this->render('index/index.html.twig', [
                'me' => $userInfo,
            ]);
        }
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
        $redirectUrl = $urlGenerator->generate('app_user_login', [
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
     * @Route("/login", name="app_user_login",
     * methods={"GET"})
     */
    public function appLogin(Request $request, UrlGeneratorInterface $urlGenerator): Response
    {
        $code = $request->query->get('code');
        $user = $this->discord->loadDiscordUser($code);

        $response = new Response();
        $expires = time() + 36000;
        $cookie = Cookie::create('iniZAuth', $user['access_token'], $expires);
        $response->headers->setCookie($cookie);

        $response->headers->set('Content-Type', 'text/html');
        $response->send();
        
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/logout", name="user_app_logout",
     * methods={"GET"})
     */
    public function appLogout(Request $request, UrlGeneratorInterface $urlGenerator): Response
    {
        $response = new Response();
        $response->headers->clearCookie('iniZAuth');

        $response->headers->set('Content-Type', 'text/html');
        $response->send();
        
        return $this->redirectToRoute('index');
    }


    /**
     * @Route("/applications", name="myApplications",
     * methods={"GET"})
     */
    public function appShow(Request $request): Response
    {
        $cookie = $request->cookies->get('iniZAuth');
        if ($cookie) {
            $userInfo = $this->discord->getUser($cookie);
            $discord =$userInfo['username'].' ('.$userInfo['id'].')'; 
            $apps = $this->applicationsService->getMyApps($discord);
                
            // dd($apps);
            return $this->render('index/application/list.html.twig', [
            'userinfo' => $apps,
            'me' => $userInfo,
        ]);
        } else {
            $userInfo = null;
            return $this->render('index/index.html.twig', [
            'me' => $userInfo,
        ]);
        }
    }

    /**
     * @Route("/atlantis", name="atlantis",
     * methods={"GET"})
     */
    public function atlantis(): Response
    {
        return new RedirectResponse(self::ATLANTIS_ENDPOINT);
    }
    /**
     * @Route("/discord", name="discord",
     * methods={"GET"})
     */
    public function atlantisdiscord(): Response
    {
        return new RedirectResponse(self::ATLANTIS_DISCORD_ENDPOINT);
    }
}
