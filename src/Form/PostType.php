<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Post;
use App\Entity\Tag;
use PhpParser\Parser\Multiple;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('author', EntityType::class, [

                // Look for choices from entity
                'class' => Author::class,

                // Automatisch worden de volledige namen weergegeven door de toString functie in de entity Author.php

                // Use the username as the visible option string
                // 'choice_label' => 'name',

                // Reder a dropdown
                // 'multiple' => 'false',
                // 'expanded' => 'false',
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                
                // Set option to select multiple options
                'multiple' => 'true',
                'expanded' => 'true',
            ])
            ->add('visible', CheckboxType::class, [
                'label'    => 'Laat deze post zien:',
                'required' => false,
            ])
            ->add('date', DateType::class)
            ;
    }

}
