<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Patient;
use App\Entity\Sejour;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PatientController extends AbstractController
{
    #[Route('/patients', name: 'app_patient')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Accès au Repository de la classe Adherent
        $repository=$doctrine->getRepository(Patient::class);
        // Récupération de tous les adhérents
        $lesPatients=$repository->findAll();
        // Appel de la vue
        return $this->render('patient/index.html.twig', [
            'patients' => $lesPatients,
        ]);
    }

    #[Route('/affichageUnPatient/{id}', name: 'app_patient_id')]
        public function AfficherLePatient(ManagerRegistry $doctrine,$id): Response
        {
           $repository=$doctrine->getRepository(Patient::class);
           
           $unPatient=$repository->find($id);
           return $this->render('patient/patientAvecId.html.twig', [
            'patient' => $unPatient,
            ]);
        }

    #[Route('/ajoutPatient', name: 'app_ajout_patient')]
    public function inscription(ManagerRegistry $doctrine,Request $request): Response
    {
    $em=$doctrine->getManager();
    $patient=new Patient();
    $form = $this->createFormBuilder($patient)
    ->add('nom', TextType::class, array('label'=>'Nom du patient : '))
    ->add('prenom', TextType::class, array('label'=>'Prenom du patient : '))
    ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
    ->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $patient = $form->getData();
        $em->persist($patient);
        $em->flush();
        // redirection vers la liste des adhérents
        return $this->redirectToRoute('app_patient');
    }
    else{
        return $this->render('patient/ajoutPatient.html.twig', array(
            'form' => $form->createView(),));
            }
    }

    #[Route('/modifPatient/{id}', name: 'app_modif_patient')]
    public function ModifierUnPatient(ManagerRegistry $doctrine,Request $request, $id): Response
    {
    $repository=$doctrine->getRepository(Patient::class);
    $em=$doctrine->getManager();
    $patient=$repository->find($id);
    $form = $this->createFormBuilder($patient)
    ->add('nom', TextType::class, array('label'=>'Nom du patient : '))
    ->add('prenom', TextType::class, array('label'=>'Prenom du patient : '))
    ->add('save', SubmitType::class, array('label' => 'Modifier le patient'))
    ->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $patient = $form->getData();
        $em->persist($patient);
        $em->flush();
        // redirection vers la liste des traitements
        return $this->redirectToRoute('app_patient');
    }
    else{
        return $this->render('patient/modifUnTraitement.html.twig', array(
    'form' => $form->createView(),));
    }
    }

    #[Route('/sejours_actuels_patient', name: 'app_sejours_actuels_patient')]
    public function AfficherSejour_actuels_patient(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Sejour::class);
        $lesSejours=$repository->findBy(array('datedebut' => $this->date = new \DateTime()));
        //Appel de la vue

        return $this->render('patient/patientAvecSejourActuel.html.twig', [
            'sejours' => $lesSejours,
        ]);
    }

    #[Route('/afficher_sejour_info/{id}', name: 'sejour_info')]
    public function AfficherInfoSejour(ManagerRegistry $doctrine, int $id): Response
    {
        $repository2=$doctrine->getRepository(Sejour::class);
        $lesSejours=$repository2->find($id);
        //Appel de la vue

        return $this->render('patient/sejourinfo.html.twig', [
            'sejour' => $lesSejours,
        ]);
    }
}