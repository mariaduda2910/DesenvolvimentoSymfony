<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\User;

class RegistrarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('nome', TextType::class, ['label' => 'Nome'])
            ->add('password', PasswordType::class, ['label' => 'Senha'])
            ->add('isAdmin', ChoiceType::class, [
                'label' => 'É Administrador?',
                'choices' => [
                    'Sim' => true,
                    'Não' => false,
                ],
                'expanded' => true,  
                'multiple' => false, 
            ])
            ->add('registrar', SubmitType::class, ['label' => 'Registrar']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class, // A entidade precisa ser mapeada aqui
        ]);
    }
}
