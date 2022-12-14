<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Sejour;
use App\Entity\Service;
use App\Entity\Chambre;
use App\Entity\Lit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SejoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('datedebut',DateType::class,array('label'=>'Date du debut: '))
        ->add('datefin',DateType::class,array('label'=>'Date de fin : '))
        ->add('description',TextType::class, array('label'=>'Description du sejour: '))
        ->add('patient',EntityType::class,array('class'=>Patient::class,'choice_label'=>'nom'))
        ->add('service',EntityType::class,array('class'=>Service::class,'choice_label'=>'libelle'))
        ->add('lit',EntityType::class,array('class'=>Lit::class,'choice_label'=>'id'))
        ->add('description',TextType::class, array('label'=>'Description du sejour: '))
        ->add('validation',CheckboxType::class, array('label'=>'Validation de l\'arrivée: '))
        ->add('save',SubmitType::class,array('label' =>'Enregistrer le Sejour'))
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sejour::class,
        ]);
    }
}