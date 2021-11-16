<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuthorFixtures extends Fixture
{

    public const ADMIN_AUTHOR_REFERENCE = 'admin-author';

    public function load(ObjectManager $manager)
    {
        $author = new Author();
        $author->setName('Fistname');
        $author->setSurname('Surname');
        $author->setDescription('Description');

        // other fixtures can get this object using the UserFixtures::ADMIN_AUTHOR_REFERENCE constant
        $this->addReference(self::ADMIN_AUTHOR_REFERENCE, $author);

        $manager->persist($author);

        $manager->flush();
    }
}
