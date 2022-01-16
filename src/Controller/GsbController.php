<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FichesType;
use App\Entity\Fiches;
use App\Repository\FichesRepository;

class GsbController extends AbstractController
{
    /**
     * @Route("/gsb", name="gsb")
     */
    public function index(): Response
    {
        return $this->render('gsb/accueil.html.twig', [
            'controller_name' => 'GsbController',
        ]);
    }

    //Mes fiches de frais
    /**
     * @Route("/mesfichesfrais", name="mesfiches")
     */
    public function mesfiches(FichesRepository $ficheRequestRepository): Response
    {

        return $this->render('gsb/MesFiches.html.twig', [
            'fiches' => $ficheRequestRepository->findAll(),
          ]);
    }

    //Saisie fiches de frais
    /**
     * @Route("/saisiefichesfrais", name="saisiefiches")
     */
    public function saisiefiches(Request $request, EntityManagerInterface $em)
    {

        $fichefrais = new Fiches();
        $fichefrais->setUsers($this->getUser());
    //     $fichehorsforfait = new FicheFraisHorsForfait;
        $form = $this->createForm(FichesType::class, $fichefrais);
    //     $form2 = $this->createForm(FicheFraisHorsForfaitType::class, $fichehorsforfait);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->persist($fichefrais);
            $em->flush();
        }

    //     // if($request->isMethod('POST') && $form2->handleRequest($request)->isValid()){
    //     //    $em->persist($fichehorsforfait);
    //     //     $em->flush();
    //     // }

         return $this->render('gsb/Saisie.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/comptable/validation", name="app_validation")
     */
    public function validation(): Response
    {
        return $this->render('gsb/validation.html.twig', [
            'controller_name' => 'GsbController',
        ]);
    }
}
