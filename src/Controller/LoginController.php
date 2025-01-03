<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Customer;

class LoginController extends AbstractController
{
    #[Route('/Login', name: 'app_login')]
    #[Route('/login', name: 'app_login_lowercase')]
    public function LoginUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordEncoder): Response
    {
        // Criação do formulário de login
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            // Busca o usuário pelo email
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user && $passwordEncoder->isPasswordValid($user, $password)) {
                
                if ($user->getIsAdmin()) {
                    return $this->redirectToRoute('app_Admin');
                }

                $customer = $em->getRepository(Customer::class)->findOneBy(['user' => $user->getId()]);

                if ($customer && $customer->getIsChecked()) { 
                    return $this->redirectToRoute('app_Customer');
                }

                $this->addFlash(
                    'error',
                    'Tente se registrar ou entre em contato com algum de nossos colaboradores.'
                );
            } else {
                $this->addFlash('error', 'Email ou senha inválidos.');
            }
        }

        return $this->render('login/login.html.twig', [
            'Titulo' => 'Login',
            'form' => $form->createView(),
        ]);
    }
}
