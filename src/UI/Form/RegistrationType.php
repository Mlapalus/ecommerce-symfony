<?php

namespace App\UI\Form;

use App\UI\DTO\RegistrationDTO;
use App\UI\Validator\NonUniqueEmailValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add("email", EmailType::class, [
        "label" => "Email: ",
        "constraints" => [
          new NotBlank(),
          new Email()
        ],
        "help" => "Saisissez une adresse mail valide"
      ])
      ->add("pseudo", TextType::class, [
        "label" => "Votre Pseudo: ",
        "constraints" => [
          new NotBlank()
        ]
      ])
      ->add("plainPassword", RepeatedType::class, [
        "type" => PasswordType::class,
        "first_options" => [
          "label" => "Mot de Passe : ",
          "help" => "Minimum 8 caractères"
        ],
        "second_options" => [
          "label" => "Confirmez votre mot de passe : ",
          "help" => "Saisissez de nouveau votre mot de passe"
        ],
        "invalid_message" => "Mots de passe non identiques",
        "constraints" => [
          new NotBlank(),
          new Length(["min" => 8])
        ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefault("data_class", RegistrationDTO::class);
  }
}