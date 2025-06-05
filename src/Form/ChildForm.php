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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\DayPresenceType;

class ChildForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('birth_date')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Garçon' => 'G',
                    'Fille' => 'F'
                ],
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'label' => 'Genre'
                              
            ])
            ->add('entrance_date')
            ->add('household_income')
            ->add('allergy', EntityType::class, [
                'class' => Allergy::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'user_item'
        ]);
    }
}
