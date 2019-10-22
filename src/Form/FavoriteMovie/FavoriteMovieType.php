<?php

namespace App\Form\FavoriteMovie;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FavoriteMovieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $chekedMovies   = [];
        $selectedMovies = (!empty($options['selectedMovies']))  ? $options['selectedMovies']->toArray()     : [];
        $movies         = (!empty($options['movies']))          ? $options['movies']                        : [];

        foreach ($movies as $movie) {
            if (in_array($movie, $selectedMovies)) {
                $chekedMovies[] = $movie;
            }
        }

        $builder
            ->add('favorite', ChoiceType::class, array(
                'choices' => $options['movies'],
                'choice_label' => false,
                'choice_value' => function(Movie $movie) {
                    return $movie->getId();
                },
                'data' => $chekedMovies,
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'movies' => 1,
                'selectedMovies' => 1
            ]
        );
    }

}
