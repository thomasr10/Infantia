<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Éducateur' => 'ROLE_EDUCATOR',
                    'Parent' => 'ROLE_PARENT',
                ],
                'expanded' => true,
                'required' => true,
                'multiple' => true,
            ])
            ->add('first_name')
            ->add('last_name')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'H',
                    'Femme' => 'F',
                    'Autre' => 'A',
                ],
                'placeholder' => 'Sélectionnez un genre',
            ])
            ->add('email')
            ->add('phone_number')
            ->add('birth_date');

        // Ajout des champs conditionnels à l'affichage initial
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $user = $event->getData();

            if (!$user) {
                return;
            }

            $roles = $user->getRoles();

            if (in_array('ROLE_PARENT', $roles)) {
                $form->add('adress', TextType::class, [
                    'mapped' => false,
                    'required' => true,
                ]);
                $form->add('postal_code', TextType::class, [
                    'mapped' => false,
                    'required' => true,
                ]);
                $form->add('city', TextType::class, [
                    'mapped' => false,
                    'required' => true,
                ]);
            }
        });

        // Ajout des champs conditionnels à la soumission
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            $roles = $data['roles'] ?? [];

            if (in_array('ROLE_PARENT', $roles)) {
                $form->add('adress', TextType::class, [
                    'mapped' => false,
                    'required' => true,
                ]);
                $form->add('postal_code', TextType::class, [
                    'mapped' => false,
                    'required' => true,
                ]);
                $form->add('city', TextType::class, [
                    'mapped' => false,
                    'required' => true,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'user_item'
        ]);
    }
}
