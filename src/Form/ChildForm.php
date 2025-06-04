<?php

namespace App\Form;

use App\Entity\Allergy;
use App\Entity\Child;
use App\Entity\Representative;
use App\Entity\TrustedPerson;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('birth_date')
            ->add('entrance_date')
            ->add('household_income')
            ->add('allergy', EntityType::class, [
                'class' => Allergy::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('representative', EntityType::class, [
                'class' => Representative::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('trusted_person', EntityType::class, [
                'class' => TrustedPerson::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}
