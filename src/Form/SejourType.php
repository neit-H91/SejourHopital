<?php

namespace App\Form;

use App\Entity\Lit;
use App\Entity\Sejour;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SejourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('commentaire')
            ->add('estArrive')
            ->add('estParti')
            ->add('leLit', EntityType::class, [
                'class' => Lit::class,
'choice_label' => 'libelle',
            ])
            ->add('lePatient', EntityType::class, [
                'class' => User::class,
'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sejour::class,
            'csrf_protection' => false,
        ]);
    }
}
