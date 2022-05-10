<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('categoryId')
            ->add('categoryId',EntityType::class,[
                'label' => "Catégorie de l'événement *",
                'class' => Category::class,
                'group_by' => 'id',
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'libelle',
                'help' => 'Choisissez ensuite la catégorie auquel appartient votre produit.',
                'attr' => ['class' => 'filter-input'],
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
