<?php

namespace App\Controller;

use App\Service\Discord;
use App\Entity\Questions;
use App\Entity\Applications;
use App\Service\AdminService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminController extends AbstractController
{

    private $discord;
    private $adminService;

    public function __construct(Discord $discord, AdminService $adminService)
    {
        $this->discord = $discord;
        $this->adminService = $adminService;
    }

    /**
     * @Route("/admin/{page}", name="admin")
     */
    public function index(Request $request, int $page = 1): Response
    {
 
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $cookie = $request->cookies->get('iniZAuth');
        // dd($cookie);
        if ($cookie) {
            
            $userInfo = $this->discord->getUser($cookie);
            $pagination = $this->adminService->pagginatrion($page);
            $count =$this->adminService->getFasterCount();
            // dd(count($count));
        }else{
            $userInfo = null;
            return $this->render('index/index.html.twig', [
                'me' => $userInfo,
            ]);
        }
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'me' => $userInfo,
            'pagination' => $pagination,
            'count' => count($count),
        ]);
    }

    /**
     * @Route("/admin/show/{page}/{id}", name="show_apps")
     */
    public function show(Request $request, int $page = 1, int $id): Response
    {
        // dd();
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $cookie = $request->cookies->get('iniZAuth');
        // dd($cookie);
        if ($cookie) {
            
            $userInfo = $this->discord->getUser($cookie);
            
            $count =$this->adminService->getFasterCount();
            $application = $this->getDoctrine()
            ->getRepository(Applications::class)
            ->find($id);

            $form = $this->createFormBuilder($application, array('attr' => array('class' => 'input-container')))
            ->setAttribute('class', 'input-container')
            ->add('discordId', TextType::class, ['label' => 'Discord ID','disabled' => true])
            ->add('steamHex', TextType::class, ['label' => 'Steam hex'])
            ->add('birth_date', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd', 'label' => 'Data urodzenia','disabled' => true])
            ->add('answ1', TextareaType::class, ['label' => $application->getQue1(),'disabled' => true])
            ->add('answ2', TextareaType::class, ['label' => $application->getQue2(),'disabled' => true])
            ->add('answ3', TextareaType::class, ['label' => $application->getQue3(),'disabled' => true])
            ->add('answ4', TextareaType::class, ['label' => $application->getQue4(),'disabled' => true])
            ->add('answ5', TextareaType::class, ['label' => $application->getQue5(),'disabled' => true])
            ->add('answ6', TextareaType::class, ['label' => $application->getQue6(),'disabled' => true])
            ->add('reason', TextareaType::class, [])
            ->add('add', SubmitType::class, ['label' => 'Add'])
            ->add('reject', SubmitType::class, ['label' => 'Reject', 'attr' => array( 'class' => 'btn_half')])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->adminService->Edit($application);
            }
        }else{
            $userInfo = null;
            return $this->render('index/index.html.twig', [
                'me' => $userInfo,
            ]);
        }
        return $this->render('admin/show.html.twig', [
            'controller_name' => 'AdminController',
            'me' => $userInfo,
            'form' => $form->createView(),
            'count' => count($count),
            // 'pagination' => $pagination,
        ]);
    }
    /**
     * @Route("/change_questions", name="change_questions")
     */
    public function changeQuestions(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $cookie = $request->cookies->get('iniZAuth');
        // dd($cookie);
        if ($cookie) {
            $userInfo = $this->discord->getUser($cookie);
            $questions = $this->getDoctrine()
            ->getRepository(Questions::class)
            ->find(1);

            $form = $this->createFormBuilder($questions, array('attr' => array('class' => 'input-container')))
            ->setAttribute('class', 'input-container')
            ->add('discordId', TextType::class, ['disabled' => true])
            ->add('steam_hex', TextType::class, ['disabled' => true])
            ->add('birth_date', TextType::class, ['disabled' => true])
            ->add('que1', TextType::class, [])
            ->add('que2', TextType::class, [])
            ->add('que3', TextType::class, [])
            ->add('que4', TextType::class, [])
            ->add('que5', TextType::class, [])
            ->add('que6', TextType::class, [])
            
            ->add('save', SubmitType::class, ['label' => 'Send'])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->adminService->Edit($questions);
            }
        }else{
            $userInfo = null;
            return $this->render('index/index.html.twig', [
                'me' => $userInfo,
            ]);
        }
        return $this->render('admin/questions.html.twig', [
            'controller_name' => 'AdminController',
            'me' => $userInfo,
            'form' => $form->createView(),
        ]);
    }
}
