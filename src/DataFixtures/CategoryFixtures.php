<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $categoriesData = [
            ['nom' => 'Action'],
            ['nom' => 'Comédie'],
            ['nom' => 'Drame'],
            ['nom' => 'Aventure'],
            ['nom' => 'Guerre'],
            ['nom' => 'Histoire'],
            ['nom' => 'Musical'],
            ['nom' => 'Policier'],
            ['nom' => 'Espionnage'],
            ['nom' => 'Science-Fiction'],
            ['nom' => 'Fantastique'],
            ['nom' => 'Horreur'],
            ['nom' => 'Romance'],
            ['nom' => 'Western'],
            ['nom' => 'Documentaire'],
        ];
        

        foreach ($categoriesData as $data) {
            $category = new Category();
            $category->setNom($data['nom']);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
