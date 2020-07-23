<?php

namespace Sibintek\ConsentPersData\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartPageController extends AbstractController
{
    /**
     * @Route("/pd/start", name="start_page")
     */
    public function index()
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        return $this->render('@ConsentPersData/start_page/index.html.twig', [
//        return $this->render('@consentpd/start_page/index.html.twig', [
            'controller_name' => 'StartPageController',
        ]);
    }
}
