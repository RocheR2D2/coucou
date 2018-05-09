<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $labelStyle = 'font-size:17px;color:#5E5E5E;font-family:"FontAwesome";font-weight:bold;margin-top:12px;margin-bottom:9px';

        $builder
            ->add('profil', FileType::class, [
                'attr'=>[
                    'class' => 'form-control',
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'label_attr' => [
                    'style' => $labelStyle,
                ],
                'attr'=>[
                    'class' => 'form-control',
                    'readonly' => "readonly",
                    'value' => 'Nom',

                ],
            ])
            ->add('firstname',TextType::class, [
                'label' => 'Prénom',
                'label_attr' => [
                    'style' => $labelStyle,
                ],
                'attr'=>[
                    'class' => 'form-control',
                    'readonly' => "readonly",
                    'value' => 'Prenom'
                ],
            ])
            ->add('age',TextType::class, [
                'label' => 'L\'âge',
                'label_attr' => [
                    'style' => $labelStyle,
                ],
                'attr'=>[
                    'class' => 'form-control',
                    'readonly' => "readonly",
                    'value' => '18'
                ],
            ])
            ->add('email',EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'style' => $labelStyle,
                ],
                'attr'=>[
                    'class' => 'form-control',
                ],
            ])
            ->add('post',TextType::class, [
                'label' => 'Poste',
                'label_attr' => [
                    'style' => $labelStyle,
                ],
                'attr'=>[
                    'class' => 'form-control',
                ],
            ])
            ->add('type',ChoiceType::class, [
                'choices'  => [
                    'Interne' => 0,
                    'Externe-Indépendant' => 1,
                    'Externe-Employée' => 2,
                ],
                'label' => 'Type',
                'label_attr' => [
                    'style' => $labelStyle,
                ],
                'attr'=>[
                    'class' => 'form-control',
                ],
            ])
            ->add('team',ChoiceType::class, [
                'choices'  => [
                    'SR00C' => '0',
                    'SR21B' => '1',
                    'SR21C' => '2',
                    'SR22C' => '3',
                    'SR23B' => '4',
                    'SR23C' => '5',
                    'SR23D' => '6',
                    'SR23E' => '7',
                ],
                'label' => 'Équipe',
                'label_attr' => [
                    'style' => $labelStyle,
                ],
                'attr'=>[
                    'class' => 'form-control',
                ],
            ])
            ->add('status',ChoiceType::class, [
                'choices'  => [
                    'Activé' => 0,
                    'Déactivé' => 1,

                ],
                'label' => 'Status',
                'label_attr' => [
                    'style' => $labelStyle,
                ],
                'attr'=>[
                    'class' => 'form-control',
                ],
            ])
            ->add('Enregistrer',SubmitType::class, [
                'attr'=>[
                    'label' => '',
                    'class' => 'btn btn-info btn-md waves-effect waves-light',
                    'style' => 'margin-top:25px;',
                ],
            ]);
       }
       /*
       public function configureOptions(OptionsResolver $resolver)
       {
           $resolver->setDefaults([
               'data_class' => Post::class,
           ]);
       }
       */
}
