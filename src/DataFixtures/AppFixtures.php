<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Actor;
use App\Entity\Movie;
use App\Entity\Category;
use Faker;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            CategoryMovieFixtures::class,
        ];
    }



public function load(ObjectManager $manager): void
{
    $faker = \Faker\Factory::create();
    $faker->addProvider(new \Xylis\FakerCinema\Provider\Person($faker));
    $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

    $actors = $faker->actors($gender = null, $count = 100, $duplicates = false);
    $movies = $faker->movies(100);

    foreach ($actors as $item) {
        $fullname = $item;
        $fullnameExploded = explode(' ', $fullname);
        $firstname = $fullnameExploded[0];
        $lastname = $fullnameExploded[1];

        $actor = new Actor();
        $actor->setNom($lastname);
        $actor->setPrenom($firstname);
        $actor->setNationality('FR');
        $actor->setDateDeNaissance(new \DateTimeImmutable());

        $manager->persist($actor);
    }

    foreach ($movies as $item) {
        $title = $item;
        $releaseDate = $faker->dateTimeBetween('-1 year', 'now');
    
        $movie = new Movie();
        $movie->setTitre($title);
        $movie->setDescription($faker->text);
        $movie->setDirector($faker->director);
        $movie->setNote(mt_rand(0, 100));
        $movie->setDuration(mt_rand(60, 180));
        $movie->setDateSortie($releaseDate);
        $movie->setEntries(mt_rand(100, 10000));
    
        $numActors = rand(1, 5);
        $randomActorNames = array_rand($actors, $numActors);
    
        if (!is_array($randomActorNames)) {
            $randomActorNames = [$randomActorNames];
        }
    
        foreach ($randomActorNames as $index) {
            $actorName = $actors[$index];
            $actor = $manager->getRepository(Actor::class)->findOneBy(['Nom' => $actorName]);
            if ($actor) {
                $movieActor = new MovieActor();
                $movieActor->setMovie($movie);
                $movieActor->setActor($actor);
        
                $manager->persist($movieActor);
            }
        }
    
        $manager->persist($movie);
    }

    /* foreach ($categories as $category) {
        $numMovies = rand(2, 5);

        $randomMovies = array_rand($movies, min($numMovies, count($movies)));
        if (!is_array($randomMovies)) {
            $randomMovies = [$randomMovies];
        }

        foreach ($randomMovies as $index) {
            $movie = $movies[$index];

            $category->addMovie($movie);
            $movie->addCategory($category);

            $manager->persist($movie);
        }
    } */

        $manager->flush();
    }
}




