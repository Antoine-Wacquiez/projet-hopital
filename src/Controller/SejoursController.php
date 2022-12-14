<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sejour;
use Doctrine\DBAL\Types\TextType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use App\Form\SejoursType;

class SejoursController extends AbstractController
{
    #[Route('/sejours', name: 'app_sejours')]
    public function indexSejour(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Sejour::class);
        $lesSejours=$repository->findAll();
        //Appel de la vue

        return $this->render('sejours/index.html.twig', [
            'Sejours' => $lesSejours,]);
    }
    #[Route('/sejours_ajout', name: 'ajouts_sejours')]
    public function ajout_sejours(ManagerRegistry $doctrine ,Request $request):Response{
    $em=$doctrine->getManager();
        $Sejours=new Sejour();
        $form =$this->createForm(SejoursType::class,$Sejours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $Sejours=$form->getData();
            $em->persist($Sejours);
            $em->flush();
            return $this->redirectToRoute('app_sejours');
        }
        return $this->render ('sejours/ajout_sejours.html.twig',array(
            'form'=> $form->createView(),
        ));
}

#[Route('/ajout_sejours_patient', name: 'ajouts_sejours_patient')]
public function ajout_sejours_patient(ManagerRegistry $doctrine ,Request $request):Response{
$em=$doctrine->getManager();
    $Sejours=new Sejour();
    $form =$this->createForm(SejoursType::class,$Sejours);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        $Sejours=$form->getData();
        $em->persist($Sejours);
        $em->flush();
        return $this->redirectToRoute('app_patient');
    }
    return $this->render ('sejours/ajout_sejours.html.twig',array(
        'form'=> $form->createView(),
    ));
}

#[Route('/sejour_modif/{id}' , name: 'formulaire_modif_sejour')]
public function formulaire_modif(ManagerRegistry $doctrine , $id,Request $request):Response {
    $em=$doctrine->getManager();
    $repository=$doctrine->getRepository(Sejour::class);
    $Sejours=$repository->find($id);
    $form =$this->createForm(SejoursType::class,$Sejours);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        $Sejours=$form->getData();
        $em->persist($Sejours);
        $em->flush();
        return $this->redirectToRoute('app_sejours');
    }
    return $this->render ('sejours/ajout_sejours.html.twig',array(
        'form'=> $form->createView(),
    ));
}
#[Route('/sejoursaffichage/{id}', name: 'app_sejourId')]
public function AfficherLeSejour(ManagerRegistry $doctrine,$id): Response
{
   $repository=$doctrine->getRepository(Sejour::class);
   
   $unSejour=$repository->find($id);
   return $this->render('sejours/SejourAvecId.html.twig', [
    'Sejour' => $unSejour,
    ]);
}

#[Route('/sejours_actuels', name: 'app_sejours_actuels')]
    public function AfficherSejour_actuels(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Sejour::class);
        $lesSejourspardate=$repository->findBy(array('datefin' => $this->date = new \DateTime()));
        $lesSejours=$repository->findAll();
        $dateduJour=$this->date=new \DateTime();
        //Appel de la vue

        return $this->render('sejours/affichage_date_actuelle.html.twig', [
            'controller_name' => 'SejoursController',
            'Sejoursdate' => $lesSejourspardate,
            'sejours' => $lesSejours,
            'datedujour' =>$dateduJour]);
    }


#[Route('/sejours_actuels/{id}', name: 'app_sejours_actuels_par_id')]
    public function AfficherSejour_actuels_par_id(ManagerRegistry $doctrine,$id): Response
    {
        $repository=$doctrine->getRepository(Sejour::class);
        $lesSejourspardate=$repository->findBy(array('datefin' => $this->date = new \DateTime()));
        $UnSejour=$repository->find($id);
        $dateduJour=$this->date=new \DateTime();
        //Appel de la vue

        return $this->render('sejours/Sejour_actuelAvecId.html.twig', [
            'controller_name' => 'SejoursController',
            'Sejoursdate' => $lesSejourspardate,
            'Sejour' => $UnSejour,
            'datedujour' =>$dateduJour]);
    


    }

#[Route('/sejour_modif_patient/{id}' , name: 'formulaire_modif_sejour_patient')]
public function formulaire_modif_patient(ManagerRegistry $doctrine , $id,Request $request):Response {
    $em=$doctrine->getManager();
    $repository=$doctrine->getRepository(Sejour::class);
    $Sejours=$repository->find($id);
    $form =$this->createForm(SejoursType::class,$Sejours);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        $Sejours=$form->getData();
        $em->persist($Sejours);
        $em->flush();
        return $this->redirectToRoute('formulaire_modif_sejour_patient');
    }
    return $this->render ('sejours/ajout_sejours.html.twig',array(
        'form'=> $form->createView(),
    ));
}
}