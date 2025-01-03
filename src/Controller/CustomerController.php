<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CustomerRepository;

class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'app_customer')]
    public function listCheckedCustomers(CustomerRepository $customerRepository): Response
    {
        // Busca todos os clientes com isChecked = true
        $customers = $customerRepository->findCheckedCustomers();

        return $this->render('customer/list.html.twig', [
            'customers' => $customers,
        ]);
    }
}
