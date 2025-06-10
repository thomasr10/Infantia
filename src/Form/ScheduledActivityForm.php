<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Date;
use App\Entity\ScheduledActivity;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ScheduledActivityForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('starting_hour')
            ->add('ending_hour')
            ->add('date', EntityType::class, [
                'class' => Date::class,
                'choice_label' => function ($date) {
                    return $date->getDate()->format('d/m/Y');
                },
                'query_builder' => function (EntityRepository $dateRepository) {
                    return $dateRepository->createQueryBuilder('d')
                        ->andWhere('d.date >= :todayDate')
                        ->andWhere('d.is_holiday = 0')
                        ->setParameter('todayDate', new \DateTimeImmutable('today'))
                        ->orderBy('d.date', 'ASC')
                        ->setMaxResults(7);
                },
                'placeholder' => 'Choisir une date'
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une équipe'
            ])
            ->add('activity', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une activité'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScheduledActivity::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'user_item'
        ]);
    }
}
