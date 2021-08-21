<?php

namespace App\Service;

use App\Entity\Questions;
use App\Entity\Applications;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\ApplicationsRepository;
use Knp\Component\Pager\PaginatorInterface;

class AdminService{

    private $entityManager;
    private $queRepository;
    private $appRepository;
    private $appsPaginator;
    
    

    public function __construct(EntityManagerInterface $entityManager, QuestionsRepository $queRepository,ApplicationsRepository $appRepository,PaginatorInterface $appsPaginator)
    {
        $this->entityManager = $entityManager;
        $this->queRepository = $queRepository;
        $this->appRepository = $appRepository;
        $this->appsPaginator = $appsPaginator;

    }

    public function Edit()
    {
        $this->entityManager->flush();
    }

    public function pagginatrion($page){

        $users = $this->appRepository->findAll();
        $pagination = $this->appsPaginator->paginate($users, $page, /*page number*/35/*limit per page*/);

        return $pagination;
    }
    
    public function getFasterCount(){

        // $users = $this->appRepository->findAll();
        $faster = $this->appRepository->findBy(array('faster' => true),array('id' => 'ASC'));
        // $pagination = $this->appsPaginator->paginate($users, $page, /*page number*/10/*limit per page*/);

        return $faster;
    }
}