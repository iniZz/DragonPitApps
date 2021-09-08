<?php

namespace App\Service;

use App\Entity\Applications;
use App\Entity\Questions;
use App\Repository\ApplicationsRepository;
use App\Repository\BlackListRepository;

use Doctrine\ORM\EntityManagerInterface;

class ApplicationsService
{
    

    private $entityManager;
    private $appsRepository;
    private $blackList;

    public function __construct(EntityManagerInterface $entityManager, ApplicationsRepository $appsRepository , BlackListRepository $blackList)
    {
        $this->entityManager = $entityManager;
        $this->appsRepository = $appsRepository;
        $this->blackList = $blackList;

    }


    public function buildYearChoices() {
        $distance = 5;
        $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") - $distance));
        $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") + $distance));
        return array_combine(range($yearsBefore, $yearsAfter), range($yearsBefore, $yearsAfter));
    }
    
    

    public function Insert($applications,$questions){
        // dd();
        $applications->setQue1($questions->getQue1());
        $applications->setQue2($questions->getQue2());
        $applications->setQue3($questions->getQue3());
        $applications->setQue4($questions->getQue4());
        $applications->setQue5($questions->getQue5());
        $applications->setQue6($questions->getQue6());
            
        $this->entityManager->persist($applications);
        $this->entityManager->flush();
        
    }

    public function toDo($applications,$questions){
        // dd();
        $applications->setQue1($questions->getQue1());
        $applications->setQue2($questions->getQue2());
        $applications->setQue3($questions->getQue3());
        $applications->setQue4($questions->getQue4());
        $applications->setQue5($questions->getQue5());
        $applications->setQue6($questions->getQue6());
            
        $this->entityManager->persist($applications);
        $this->entityManager->flush();
        
    }

    private function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $characters = '01eXzE';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        
    }

    public function getMyApps($discord)
    {
        // dd($discord);
        $user = $this->appsRepository->findBy(array('discordId' => $discord),array('id' => 'ASC'));
        // dd($user);
        return $user;
    }

    public function getBL($discordID)
    {
        $user = $this->blackList->findOneBy(array('discordId' => $discordID),array('id' => 'ASC'));
        // dd($user);
        return $user;
    }

    public function CheckStatus($discord)
    {
        $user = $this->appsRepository->findOneBy(array('discordId' => $discord));
        
        return $user;
    }
}