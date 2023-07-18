<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Table;
use App\Entity\Booking;
use App\Entity\Guest;
use Doctrine\ORM\EntityManagerInterface;

class ImportController extends AbstractController
{


    #[Route('/import', name: 'app_import')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tableRepo = $entityManager->getRepository(Table::class);
        $tableDtata = $tableRepo->findBy(['maxGuests' => 5,'number'=>5]);
        dd($tableDtata);
        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
        ]);
    }
}
