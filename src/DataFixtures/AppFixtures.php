<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $post1 = new Post();
        $post1->setTitle('Welcome to Our Blog');
        $post1->setContent('This is the first post on our blog. We hope you enjoy reading our content!');

        $post2 = new Post();
        $post2->setTitle('Symfony Basics Showcase');
        $post2->setContent('In this post, we showcase various Symfony features including Entities, Controllers, DTOs, and more.');

        $post3 = new Post();
        $post3->setTitle('Getting Started with Doctrine');
        $post3->setContent('Doctrine is a powerful ORM for PHP. Learn how to use entities and repositories in your Symfony applications.');

        $manager->persist($post1);
        $manager->persist($post2);
        $manager->persist($post3);

        $manager->flush();
    }
}
