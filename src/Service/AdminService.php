<?php

namespace App\Service;

use App\Service\Webhook;
use App\Entity\Questions;
use App\Entity\Applications;
use App\Entity\ApplicationsAccepted;
use App\Entity\ApplicationsRejected;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\ApplicationsRepository;
use App\Repository\ApplicationsAcceptedRepository;
use App\Repository\ApplicationsRejectedRepository;
use Knp\Component\Pager\PaginatorInterface;

class AdminService{

    private $entityManager;
    private $queRepository;
    private $appRepository;
    private $appsPaginator;
    private $webHook;
    
    

    public function __construct(EntityManagerInterface $entityManager, QuestionsRepository $queRepository,ApplicationsRepository $appRepository,PaginatorInterface $appsPaginator, Webhook $webHook)
    {
        $this->entityManager = $entityManager;
        $this->queRepository = $queRepository;
        $this->appRepository = $appRepository;
        $this->appsPaginator = $appsPaginator;
        $this->webHook = $webHook;

    }

    public function Edit()
    {
        $this->entityManager->flush();
    }

    public function pagginatrion($page){

        $users = $this->appRepository->findAll();
        $pagination = $this->appsPaginator->paginate($users, $page, 35);

        return $pagination;
    }

    public function pagginatrionFaster($page){

        $users = $this->appRepository->findBy(array('faster' => true),array('id' => 'ASC'));
        
        $pagination = $this->appsPaginator->paginate($users, $page, 35);

        return $pagination;
    }
    
    public function getFasterCount(){

        $faster = $this->appRepository->findBy(array('faster' => true),array('id' => 'ASC'));

        return $faster;
    }

    public function Accepted($app, $userInfo){
        $pieces = explode("(", $app->getDiscordId());
        $pieces2 = explode(")", $pieces[1]);

        $accept = new ApplicationsAccepted;
        
        $accept->setDiscordId($app->getDiscordId());
        $accept->setSteamHex($app->getSteamHex());
        $accept->setBirthDate($app->getBirthDate());
        $accept->setQue1($app->getQue1());
        $accept->setAnsw1($app->getAnsw1());
        $accept->setQue2($app->getQue2());
        $accept->setAnsw2($app->getAnsw2());
        $accept->setQue3($app->getQue3());
        $accept->setAnsw3($app->getAnsw3());
        $accept->setQue4($app->getQue4());
        $accept->setAnsw4($app->getAnsw4());
        $accept->setQue5($app->getQue5());
        $accept->setAnsw5($app->getAnsw5());
        $accept->setQue6($app->getQue6());
        $accept->setAnsw6($app->getAnsw6());
        $accept->setStatus('accepted');
        $accept->setReason($app->getReason());
        $accept->setFaster($app->getFaster());
        $accept->setReason($app->getReason());

        $this->entityManager->persist($accept);

        $this->entityManager->remove($app);
        $this->entityManager->flush();

        $this->webHook->Accepted($userInfo,$pieces2[0],$app->getSteamHex());
    }

    public function Rejected($app, $userInfo){
        $pieces = explode("(", $app->getDiscordId());
        $pieces2 = explode(")", $pieces[1]);

        $accept = new ApplicationsRejected;

        $accept->setDiscordId($app->getDiscordId());
        $accept->setSteamHex($app->getSteamHex());
        $accept->setBirthDate($app->getBirthDate());
        $accept->setQue1($app->getQue1());
        $accept->setAnsw1($app->getAnsw1());
        $accept->setQue2($app->getQue2());
        $accept->setAnsw2($app->getAnsw2());
        $accept->setQue3($app->getQue3());
        $accept->setAnsw3($app->getAnsw3());
        $accept->setQue4($app->getQue4());
        $accept->setAnsw4($app->getAnsw4());
        $accept->setQue5($app->getQue5());
        $accept->setAnsw5($app->getAnsw5());
        $accept->setQue6($app->getQue6());
        $accept->setAnsw6($app->getAnsw6());
        $accept->setStatus('accepted');
        $accept->setReason($app->getReason());
        $accept->setFaster($app->getFaster());
        $accept->setReason($app->getReason());

        $this->entityManager->persist($accept);

        $this->entityManager->remove($app);
        $this->entityManager->flush();


        $this->webHook->Rejected($userInfo,$pieces2[0],$app->getReason());
        
    }
}