<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('authors', ChoiceType::class, [
                'choice_loader' => new CallbackChoiceLoader(function() {
                    return StaticClass::getConstants();
                }),
            ])
            ->add('visible', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false,
            ]);
    }

}
