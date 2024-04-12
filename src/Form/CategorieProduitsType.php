<?php

namespace App\Form;

use App\Entity\CategorieProduits;
use App\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeDeProduit')
            ->add('Utilisation')
            ->add('nomProduit')
            ->add('produits', EntityType::class, [
                'class' => Produits::class,
                'choice_label' => 'id',
                'multiple' => true,
                'expanded'=>true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieProduits::class,
        ]);
    }
}
