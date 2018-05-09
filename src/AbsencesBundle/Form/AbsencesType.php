<?php

namespace AbsencesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbsencesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Choisir votre raison' => 0,
                    'Congés Payés/RTT' => 1,
                    'Maladie' => 2,
                    'Déplacement' => 3,
                    'Absence Prestation' => 4,
                    'Télé travail' => 5,
                    'Astreinte' => 6,
                    'Congés Prévisionnels' => 7,
                    '4/5' => 8,
                    'Formation' => 9,
                    'Ecole/Contrat Pro' => 10,
                    'Evènement Famillial' => 11,
                    'Heures Supp' => 11
                ],
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('startTime', TextType::class)
            ->add('endTime', TextType::class)
            ->add('save', SubmitType::class);
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AbsencesBundle\Entity\Absence'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }


}
