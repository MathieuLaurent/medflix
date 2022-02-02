<?php 

namespace App\Controller;

use App\Form\SearchNavType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchNavController extends AbstractController
{

    public function renderSearchNav(Request $request)
    {
        $formSearchNav = $this->createForm(SearchNavType::class);
        $formSearchNav->handleRequest($request);

        if($formSearchNav->isSubmitted() && $formSearchNav->isValid())
        {
            return $this->redirectToRoute('files', [
                'files' => $formSearchNav->getData('name')->getName(),
            ]);
        }

        return $this->render('inc/_searchNav.html.twig', [
            'formSearchNav' => $formSearchNav->createView()
        ]);
    }

}
