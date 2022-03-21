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
use Doctrine\Persistence\ManagerRegistry;

class GsbController extends AbstractController
{

    private $ManagerRegistry;

    public function __construct(ManagerRegistry $ManagerRegistry)
    {
        $this->ManagerRegistry = $ManagerRegistry;
    }
    
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
    public function saisiefiches(Request $request): Response
    {
        $em = $this->ManagerRegistry->getManager();
        $fichefrais = new Fiches();
        $fichefrais->setUsers($this->getUser());

        $form = $this->createForm(FichesType::class, $fichefrais);
        $form->handleRequest($request);
        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()){
            $periode = new \DateTime();
            $fichefrais->setPeriode($periode->format('m/Y'));
            $em->persist($fichefrais);
            $em->flush();
        }

         return $this->render('gsb/Saisie.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    //modifier fiches de frais
    /**
     * @Route("/modiffichesfrais/{id}", name="modiffiches")
     */
    public function modifsaisiefiches(Request $request, Fiches $fichefrais): Response
    {
        $em = $this->ManagerRegistry->getManager();


        $form = $this->createForm(FichesType::class, $fichefrais);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fichefrais);
            $em->flush();
        }

         return $this->render('gsb/modifFiche.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    //modifier fiches hors forfait 
    /**
     * @Route("/modiffichehorsforfait/{id}", name="modifficheshorsforfait")
     */
    public function modifficheshorsforfait(Request $request, FicheHorsForfait $fichehorsforfait): Response
    {
        $em = $this->ManagerRegistry->getManager();


        $form = $this->createForm(FicheHorsForfaitType::class, $fichehorsforfait);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fichehorsforfait);
            $em->flush();
        }

         return $this->render('gsb/modificationFicheHorsForfait.html.twig',[
            'form2' => $form->createView(),
        ]);
    }


    //Saisie fiches hors forfait
    /**
     * @Route("/saisiefichesHorsForfait", name="saisiefichesHorsForfait")
     */
    public function saisieficheshorsforfait(Request $request): Response
    {
        $em = $this->ManagerRegistry->getManager();
        $fichehorsforfait = new FicheHorsForfait();
        $fichehorsforfait->setUsers($this->getUser());


        $form2 = $this->createForm(FicheHorsForfaitType::class, $fichehorsforfait);


        $form2->handleRequest($request);
        if($request->isMethod('POST') && $form2->isSubmitted() && $form2->isValid()){
            $periode = new \DateTime();
            $fichehorsforfait->setPeriode($periode->format('m/Y'));
           $em->persist($fichehorsforfait);
            $em->flush();
        }

         return $this->render('gsb/SaisieHorsForfait.html.twig',[
            'form2' => $form2->createView(),
        ]);
    }

    //details fiches au forfait pour modifier l'etat
    /**
     * @Route("/detailsFiche/{id}", name="detailsFiche")
     */
    public function info(Request $request, Fiches $fichefrais): Response
    {
        $em = $this->ManagerRegistry->getManager();


        $form = $this->createForm(FichesType::class, $fichefrais);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fichefrais);
            $em->flush();
        }

         return $this->render('gsb/detailsFiche.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    //details fiches hors forfait pour modifier l'etat
    /**
     * @Route("/detailsFichehorsforfait/{id}", name="detailsFichehorsforfait")
     */
    public function detailsFicheHorsForfait(Request $request, FicheHorsForfait $fichehorsforfait): Response
    {
        $em = $this->ManagerRegistry->getManager();


        $form = $this->createForm(FicheHorsForfaitType::class, $fichehorsforfait);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fichehorsforfait);
            $em->flush();
        }

         return $this->render('gsb/detailsFicheHorsForfait.html.twig',[
            'form2' => $form->createView(),
        ]);
    }

    //  //Validation comptable fiches
    // /**
    //  * @Route("/comptable/validation", name="app_validation")
    //  */
    // public function validation(Request $request): Response
    // {
    //     $em = $this->ManagerRegistry->getManager();
    //     $ficheRequestRepository = $em->getRepository('app:Fiches')->findAll();
    //     $ficheHorsForfaitRepository = $em->getRepository('app:Fiches')->findAll();

    //     $form = $this->createForm(FichesType::class, $fichefrais);
    //     $form->handleRequest($request);
    //     if($form->isSubmitted() && $form->isValid()){
    //         $em->persist($fichefrais);
    //         $em->flush();
    //     }

    //     return $this->render('gsb/validation.html.twig', [
    //         'fiches' => $ficheRequestRepository,
    //         'ficheHorsForfait' => $ficheHorsForfaitRepository,
    //         'form' => $form->createView()
            

            
    //     ]);
    // }

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


    //  //Validation comptable fiches
    // /**
    //  * @Route("/comptable/validation", name="app_validation")
    //  */
    // public function Testvalidation(Request $request): Response
    // {
    //     $em = $this->ManagerRegistry->getManager();
    //     $ficheRequestRepository = $em->getRepository('app:Fiches')->findAll();
    //     $ficheHorsForfaitRepository = $em->getRepository('app:Fiches')->findAll();

    //     $form = $this->createForm(FichesType::class, $fichefrais);
    //     $form->handleRequest($request);
    //     if($form->isSubmitted() && $form->isValid()){
    //         $em->persist($fichefrais);
    //         $em->flush();
    //     }

    //     return $this->render('gsb/validation.html.twig', [
    //         'fiches' => $ficheRequestRepository,
    //         'ficheHorsForfait' => $ficheHorsForfaitRepository,
    //         'form' => $form->createView()
            

            
    //     ]);
    // }


     //Suivre Paiement comptable fiches
    /**
     * @Route("/comptable/suivrePaiement", name="app_suivrePaiement")
     */
    public function suivrePaiement(FichesRepository $ficheRequestRepository, FicheHorsForfaitRepository $ficheHorsForfaitRepository): Response
    {
        return $this->render('gsb/suivrePaiement.html.twig', [
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
        $fiche->setEtat($fiche::ETATVALIDE);
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


        //Mes fiches de frais delete
    /**
     * @Route("/mesfichesfrais/delete/{id}", name="delete_fichesSalarie")
     */
    public function suppFicheSalarié(Fiches $fiche, EntityManagerInterface $em)
    {
        
        $em->remove($fiche);
        $em->flush();

        return $this->redirectToRoute('mesfiches');

    }

        //Mes fiches de frais delete
    /**
     * @Route("/mesfichesfrais/deletehors/{id}", name="delete_ficheshorsSalarie")
     */
    public function suppFicheHorsSalarié(FicheHorsForfait $ficheHorsForfait, EntityManagerInterface $em)
    {
        
        $em->remove($ficheHorsForfait);
        $em->flush();

        return $this->redirectToRoute('mesfiches');

    }

   
    //modifier fiches de frais
    /**
     * @Route("/comptable/validationFF/{etat}/{fichefrais}", name="app_validationEtat")
     */
    public function Etatfichesforfait(Request $request, Fiches $fichefrais, $etat): Response
    {
        $em = $this->ManagerRegistry->getManager();

        $fichefrais->setEtat($etat);
        $em->persist($fichefrais);
        $em->flush();
    

         return $this->redirectToRoute('app_validation'
        );
    }
    
        //modifier fiches de frais
    /**
     * @Route("/comptable/validationHF/{etat}/{ficheHorsForfait}", name="app_validationEtatHorsForfait")
     */
    public function Etatficheshorsforfait(Request $request, FicheHorsForfait $ficheHorsForfait, $etat): Response
    {
        $em = $this->ManagerRegistry->getManager();

        $ficheHorsForfait->setEtat($etat);
        $em->persist($ficheHorsForfait);
        $em->flush();
    

         return $this->redirectToRoute('app_validation'
        );
    }

}


// Ajouter vu ticket unique en fonction de l'id dans la vu info