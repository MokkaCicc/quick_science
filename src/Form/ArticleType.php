<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Magazine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('page')
            ->add('magazine', EntityType::class, [
                'class'=>Magazine::class,
                'choice_label'=>function($magazine) {
                    return sprintf("n°%d: %s", $magazine->getNumber(), $magazine->getTitle());
                },
                'expanded' => false,
                'multiple' => false
            ])
            ->add('author', EntityType::class, [
                'class'=>Author::class,
                'choice_label'=>function($author) {
                    return sprintf("%s %s", $author->getFirstName(), $author->getLastName());
                },
                'expanded' => false,
                'multiple' => false
            ])
            ->add('categories', EntityType::class, [
                'class'=>Category::class,
                'choice_label'=>'name',
                'expanded' => false,
                'multiple' =>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
