<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminController extends AbstractController
{
    // Rota para página administrativa
    #[Route('/Administrador', name: 'app_admin_upper')]
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    // Rota para listar clientes não verificados
    #[Route('/Administrador/Autorizar', name: 'app_Admin')]
    public function ListarCustomers(UserRepository $userRepository): Response
    {
        // Buscar usuários que atendem aos critérios
        $users = $userRepository->findNonAdminUnverifiedCustomers();

        // Passar os dados dos usuários para o template
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users // Passando os dados de usuários para o template
        ]);
    }

    #[Route('/Administrador/AceitarClientes', name: 'AceitarCliente', methods: ['POST'])]
    public function AceitarClientes(Request $request, UserRepository $userRepository, EntityManagerInterface $em): RedirectResponse
    {
        // Recebe os IDs dos usuários marcados nas checkboxes
        $userIds = $request->request->get('users'); // Isso deve ser um array de IDs

        // Verifique se $userIds é um array (ou iterable)
        if (is_array($userIds)) {
            foreach ($userIds as $userId) {
                // Buscar o usuário pelo ID
                $user = $userRepository->find($userId);

                if ($user) {
                    // Marcar o cliente como verificado
                    $user->getCustomer()->setIsChecked(true); // Altere para o campo correto
                    $em->persist($user);
                }
            }

            $em->flush();
            $this->addFlash('success', 'Clientes Aceitos com Sucesso!');
        } else {
            $this->addFlash('error', 'Nenhum cliente foi selecionado.');
        }

        return $this->redirectToRoute('app_admin'); // Redireciona de volta para a página do administrador
    }

    #[Route('/Administrador/RecusarCliente', name: 'RecusarCliente', methods: ['POST'])]
    public function RecusarClientes(Request $request, UserRepository $userRepository, EntityManagerInterface $em): RedirectResponse
    {
        // Recebe os IDs dos usuários marcados nas checkboxes
        $userIds = $request->request->get('users'); // Isso deve ser um array de IDs

        if (is_array($userIds)) {
            foreach ($userIds as $userId) {
                // Buscar o usuário pelo ID
                $user = $userRepository->find($userId);

                if ($user) {
                    // Marcar o cliente como não verificado
                    $user->getCustomer()->setIsChecked(false);
                    $em->persist($user);
                }
            }

            $em->flush();
            $this->addFlash('success', 'Clientes Recusados com Sucesso!');
        } else {
            $this->addFlash('error', 'Nenhum cliente foi selecionado.');
        }
        
        return $this->redirectToRoute('app_admin'); // Redireciona de volta para a página do administrador
    }
}
