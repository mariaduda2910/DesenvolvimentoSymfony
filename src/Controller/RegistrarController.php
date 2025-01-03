<?php

namespace App\Controller;

use App\Form\RegistrarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Customer;
use App\Entity\Admin;

class RegistrarController extends AbstractController
{
    #[Route('/Registrar', name: 'app_registro')]
    public function CriarUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $customer = new Customer();
        $admin = new Admin();

        // Criar o formulário e processá-lo
        $form = $this->createForm(RegistrarType::class, $user);
        $form->handleRequest($request);

        // Verificar se o formulário foi enviado e válido
        if ($form->isSubmitted() && $form->isValid()) {

            // Capturar o valor de isAdmin
            $isAdmin = $form->get('isAdmin')->getData(); 

            // Codificar a senha
            $hashedPassword = $passwordEncoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Definir se o usuário é admin
            $user->setIsAdmin($isAdmin);

            // Persistir o usuário no banco de dados
            $em->persist($user);
            $em->flush();

            // Atribuir o usuário a um Customer ou Admin
            if ($isAdmin) {
                // Se for Admin, criar e persistir o Admin
                $admin->setUser($user);
                $em->persist($admin);
            } else {
                // Se não for Admin, criar e persistir o Customer
                $customer->setUser($user);
                $customer->setChecked(false); // Status de verificação do cliente
                $em->persist($customer);
            }

            // Persistir a entidade correspondente
            $em->flush();

            // Mensagem de sucesso
            $this->addFlash('success', 'Aguardando autorização do Administrador');

            // Redirecionar para a página de login
            return $this->redirectToRoute('app_login');
        }

        // Renderizar a página com o formulário
        return $this->render('registro/registro.html.twig', [
            'Titulo' => 'Registrar',
            'form' => $form->createView(),
        ]);
    }
}
