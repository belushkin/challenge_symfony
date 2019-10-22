<?php

namespace App\Form\User;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                ChoiceType::class,
                [
                    'required' => true,
                    'choices'  => $this->getTitleChoices(),
                ]
            )
            ->add('name', TextType::class, ['required' => true])
            ->add('email', TextType::class, ['required' => true])
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'invalid_message' => 'validation.passwords.must.match',
                    'options'         => ['attr' => ['class' => 'password-field']],
                    'required'        => true,
                    'first_options'   => ['label' => 'Password'],
                    'second_options'  => ['label' => 'Password Repeat'],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class
            ]
        );
    }

    private function getTitleChoices()
    {
        return [
            'mr' => User::TITLE_MR,
            'ms' => User::TITLE_MS
        ];
    }
}
