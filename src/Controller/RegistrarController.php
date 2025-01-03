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

class RegistrarController extends AbstractController
{
    #[Route('/Registrar', name: 'app_registro')]
    public function CriarUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $customer = new Customer();
        $form = $this->createForm(RegistrarType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $isAdmin = false;
            $hasheadPassword = $passwordEncoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hasheadPassword);
            $user->setisAdmin($isAdmin);
            $em->persist($user);
            $em->flush();

            $iduser = $user;
            $customer->setUser($iduser);
            $customer->setChecked(false); // Definir o status de verificação do cliente

            // Persistir o Customer no banco de dados
            $em->persist($customer);
            $em->flush();
            $this->addFlash('success', 'Aguardando autorização do Administrador');
            return $this->redirectToRoute('app_login');
            
        };


        return $this->render('registro/registro.html.twig', [
            'Titulo' => 'Registrar',
            'form' => $form->createView(),
        ]);
    }
}
