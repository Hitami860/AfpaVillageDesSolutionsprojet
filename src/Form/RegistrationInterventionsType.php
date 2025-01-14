<?php

namespace App\Form;

use App\Entity\Interventions;
use App\Entity\RegistrationInterventions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationInterventionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('phone')
            ->add('interventions', EntityType::class, [
                'class' => Interventions::class,
                'choice_label' => function (Interventions $intervention) {
                    $startDate = $intervention->getDate()->format('d-m-Y H:i');
                    $endDate = $intervention->getEnddate() ? $intervention->getEnddate()->format('H:i') : ' ';
                    return $intervention->getTitle() . ' (' . $startDate . ' - ' . $endDate . ')';
                },
            ])
        ;
    }
    


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationInterventions::class,
        ]);
    }
}
