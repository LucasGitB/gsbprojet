<?php

namespace App\Form;

use App\Entity\Fiches;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class FichesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('periode')
            ->add('repas_midi')
            ->add('nuits')
            ->add('etape')
            ->add('km')
            // ->add ('etat', EntityType::class, array(
            //     'class' => 'App\Entity\Etat', 
            //     'query_builder' => function (EntityRepository $er){
            //         return $er ->createQueryBuilder('q');
            //     }, 
            //     'placeholder' => 'Choississez le status',
            //     'expanded' => false,
            //     'multiple' => false
            // ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fiches::class,
        ]);
    }
}
