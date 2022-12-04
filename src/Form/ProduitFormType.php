<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class ProduitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre du produit'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description du produit'
                ]
            ])
            ->add('color', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Couleur du produit'
                ],
            ])
            ->add('size', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'S' => 'small',
                    'M' => 'medium',
                    'L' => 'large'
                ],
//                'choice_label' => 'Taille'
            ])
            ->add('collection', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Collection homme ou femme'
                ],
            ])
            ->add('price', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix €'
                ],
            ])
            ->add('stock', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Quantité en stock'
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => "Photo du produit",
                'data_class' => null,
                'constraints' => [
                    new Image([
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Les formats autorisés sont .jpg ou .png',
                        'maxSize' => '3M',
                        'maxSizeMessage' => 'Le poids maximal du fichier est : {{ limit }} {{ suffix }} ({{ name }}: {{ size }} {{ suffix }})',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' =>  $options['photo'] ? 'Modier': 'Ajouter',
                'validate' => false,
                'attr' => [
                    'class' => 'd-block mx-auto col-3 btn btn-success'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'allow_file_upload' => true,
            # Variable 'photo' déclarée par défaut à NULL, cela nous servira pour la modification.
            'photo' => null,
        ]);
    }
}