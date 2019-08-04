<?php

namespace App\Form;

use App\Entity\Depot;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Compte;

class DepotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montantDepot')
            ->add('dateDepot')
            ->add('caissier', EntityType::class,[
                'class'=> Utilisateur::class,
                'label' => false])
            ->add('compte', EntityType::class,[
                'class'=> Compte::class,
                'label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Depot::class,
            'crsf_protection'=>false
        ]);
    }
}
