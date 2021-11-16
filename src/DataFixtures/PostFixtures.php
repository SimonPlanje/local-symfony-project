<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $post = new Post();

        $post->setTitle('Post title');
        $post->setDescription('Post description');
        $post->setAuthor($this->getReference(AuthorFixtures::ADMIN_AUTHOR_REFERENCE));

        $manager->persist($post);

        $manager->flush();
    }
}
