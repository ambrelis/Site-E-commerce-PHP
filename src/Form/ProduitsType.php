<?php

namespace App\Form;

use App\Entity\CategorieProduits;
use App\Entity\MotsCles;
use App\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type')
            ->add('prix')
            ->add('description')
            //->add('photo')
            ->add('categories_produits', EntityType::class, [
                'class' => CategorieProduits::class,
                'choice_label' => 'nomProduit',
                'multiple' => true,
            ])
            ->add('motsCles', EntityType::class, [
                'class' => MotsCles::class,
                'choice_label' => 'mot',
                'multiple' => true,
            ])
            ->add('fichier-image', FileType::class, [
                'label' => 'Photo du produit',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '200k',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Sélectionnez un fichier JPEG ou PNG de poids inférieur à 200Ko',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
