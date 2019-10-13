<?php

namespace App\Form;

use App\Entity\Fichier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nomdest', TextType::class, [
          'label'           => '',
          'attr'            => ['placeholder' => 'Votre Nom'],
          'required'        => true,
        ])
        ->add('dest' , TextType::class, [
              'label'           => '',
              'attr'            => ['placeholder' => ' email du destinataire'],
              'required'        => true,
            ])
        ->add('expd', TextType::class,[
              'label'           => '',
              'attr'            => ['placeholder' => 'Votre mail'],
              'required'        => true,
            ])
        ->add('nomfile', FileType::class, [
              'label' =>'',
              // 'attr'  => ['placeholder' => 'Fichier à envoyer'],
              'required'        => false,
              // 'mapped' => false,
              // 'constraints' => [
              //   new FileType([
              //     'maxSize' => '1024k',
              //     'mimeTypes' => [
              //       '',
              //       '',
              //     ],
              //     'mimeTypesMessage' => 'Please upload a valid PDF document',
              //   ])
              //   ],
              ])

        ->add('Envoyer', SubmitType::class, [
                      'label' => 'Envoyer le(s) fichier(s)',
                  ])
        ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fichier::class,
        ]);
    }
}
