<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CategoryMovie;

class CategoryMovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(\App\Entity\Category::class)->findAll();
        $movies = $manager->getRepository(\App\Entity\Movie::class)->findAll();

        if (empty($movies)) {
            return;
        }
        foreach ($categories as $category) {
            $numMovies = rand(2, 5); 

        
            $randomMovies = array_rand($movies, min($numMovies, count($movies)));
            if (!is_array($randomMovies)) {
                $randomMovies = [$randomMovies];
            }

            foreach ($randomMovies as $index) {
                $movie = $movies[$index];
                
                $categoryMovie = new CategoryMovie();
                $categoryMovie->setCategory($category);
                $categoryMovie->setMovie($movie);

                $manager->persist($categoryMovie);
            }
        }

        $manager->flush();
    }
}
