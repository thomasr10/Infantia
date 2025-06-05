<?php

namespace App\Form;

use App\Entity\Child;
use App\Entity\ChildPresence;
use App\Entity\Date;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildPresenceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entrance_hour')
            ->add('exit_hour')
            ->add('is_present')
            ->add('date', EntityType::class, [
                'class' => Date::class,
                'choice_label' => 'id',
            ])
            ->add('child', EntityType::class, [
                'class' => Child::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChildPresence::class,
        ]);
    }
}
