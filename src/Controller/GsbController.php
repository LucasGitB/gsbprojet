<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FichesType;
use App\Entity\Fiches;
use App\Entity\FicheHorsForfait;
use App\Form\FicheHorsForfaitType;
use App\Form\UploadType;
use App\Repository\FichesRepository;
use App\Entity\Upload;
use App\Repository\FicheHorsForfaitRepository;

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
    public function mesfiches(FichesRepository $ficheRequestRepository, FicheHorsForfaitRepository $ficheHorsForfaitRepository): Response
    {

        return $this->render('gsb/MesFiches.html.twig', [
            'fiches' => $ficheRequestRepository->findAll(),
            'ficheHorsForfait' => $ficheHorsForfaitRepository->findAll(),
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
        $fichehorsforfait = new FicheHorsForfait();
        $fichehorsforfait->setUsers($this->getUser());



        $form = $this->createForm(FichesType::class, $fichefrais);
        $form2 = $this->createForm(FicheHorsForfaitType::class, $fichehorsforfait);
        $form->handleRequest($request);
        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()){
            $em->persist($fichefrais);
            $em->flush();
        }
        $form2->handleRequest($request);
        if($request->isMethod('POST') && $form2->isSubmitted() && $form2->isValid()){
           $em->persist($fichehorsforfait);
            $em->flush();
        }

         return $this->render('gsb/Saisie.html.twig',[
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }

     //Validation comptable fiches
    /**
     * @Route("/comptable/validation", name="app_validation")
     */
    public function validation(FichesRepository $ficheRequestRepository, FicheHorsForfaitRepository $ficheHorsForfaitRepository): Response
    {
        return $this->render('gsb/validation.html.twig', [
            'fiches' => $ficheRequestRepository->findAll(),
            'ficheHorsForfait' => $ficheHorsForfaitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/upload", name="app_upload")
     */
    public function upload(Request $request, EntityManagerInterface $em)
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $file = $upload->getName();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $upload->setName($fileName);

            //return $this->redirectToRoute('');
        }

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->persist($upload);
            $em->flush();
        }

        return $this->render('gsb/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //Mes fiches de frais delete
    /**
     * @Route("/comptable/validation/delete/{id}", name="delete_fiches")
     */
    public function suppFiche(Fiches $fiche, EntityManagerInterface $em)
    {
        
        $em->remove($fiche);
        $em->flush();

        return $this->redirectToRoute('app_validation');

    }

        //Mes fiches de frais delete
    /**
     * @Route("/comptable/validation/deletehors/{id}", name="delete_ficheshors")
     */
    public function suppFicheHors(FicheHorsForfait $ficheHorsForfait, EntityManagerInterface $em)
    {
        
        $em->remove($ficheHorsForfait);
        $em->flush();

        return $this->redirectToRoute('app_validation');

    }

}
