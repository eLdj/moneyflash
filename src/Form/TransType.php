<?php

namespace App\Form;

use App\Entity\Compte;
use App\Entity\Expediteur;
use App\Entity\Transaction;
use App\Entity\Beneficiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TransType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $class = 'class';
        $builder
            ->add('codeGenere')
            ->add('montantTransfert')
            ->add('fraisTransaction')
            ->add('totalEnvoi')
            ->add('commissionEtat')
            ->add('commissionSysteme')
            ->add('commissionRetrait')
            ->add('commissionEnvoie')
            ->add('statut')
            ->add('expediteur',EntityType::class,[
                $class => Expediteur::class,
                ])
            ->add('beneficiaire',EntityType::class,[
                $class => Beneficiaire::class,
                ])
            ->add('compte',EntityType::class,[
                $class => Compte::class,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
