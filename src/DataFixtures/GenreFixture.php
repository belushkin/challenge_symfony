<?php
/**
 * IGNORE FIXTURE FILES
 */
namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GenreFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $genres = [
            'Action',
            'Drama',
            'Adventure',
            'Comedy',
            'Animation',
            'Sci-Fi',
            'Crime',
            'Fantasy',
            'Thriller',
            'Family',
            'Romance',
            'Short',
            'Mystery',
            'Sport',
            'Horror',
            'War',
            'History',
            'Western',
            'Game-Show',
            'Documentary',
            'Music',
            'Biography',
            'Musical',
            'News',
        ];

        foreach ($genres as $genreName) {

            $genre = new Genre();
            $genre->setName($genreName);

            $this->addReference('GENRE_' . strtoupper(str_replace('-', '_', $genreName)), $genre);
            $manager->persist($genre);
        }

        $manager->flush();
    }
}
