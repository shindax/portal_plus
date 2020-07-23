<?php

namespace Sibintek\ConsentPersData\Controller;

use Sibintek\ConsentPersData\Entity\EmailAddress;
use Sibintek\ConsentPersData\Form\EmailAddressType;
use Sibintek\ConsentPersData\Repository\EmailAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pd/emailaddress")
 */
class EmailAddressController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods="GET", name="email_address_index")
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="email_address_index_paginated")
     */
    public function index(Request $request, int $page, EmailAddressRepository $emailAddressRepository): Response
    {
        $sort = $request->query->get('sort');
        $pageSize = $request->query->get('pageSize')?$request->query->get('pageSize'):10;
        $find['name'] = $request->query->get('name');
        $find['fdate'] = $request->query->get('fdate');
        $find['ldate'] = $request->query->get('ldate');

        $latestCandidates = $emailAddressRepository->findLatest($page, $pageSize, $sort, $find);

        return $this->render('@ConsentPersData/email_address/index.html.twig', [
            'paginator' => $latestCandidates,
            'sort' => $sort,
            'find' => $find,
        ]);
    }

    /**
     * @Route("/new", name="email_address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emailAddress = new EmailAddress();
        $form = $this->createForm(EmailAddressType::class, $emailAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emailAddress);
            $entityManager->flush();

            return $this->redirectToRoute('email_address_index');
        }

        return $this->render('@ConsentPersData/email_address/new.html.twig', [
            'email_address' => $emailAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_address_show", methods={"GET"})
     */
    public function show(EmailAddress $emailAddress): Response
    {
        return $this->render('@ConsentPersData/email_address/show.html.twig', [
            'email_address' => $emailAddress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="email_address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EmailAddress $emailAddress): Response
    {
        $form = $this->createForm(EmailAddressType::class, $emailAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//      autocomplite
//            $emailAddress->setCandidate(
//                $this->getDoctrine()->getManager()->find('Sibintek\ConsentPersData\Entity\Candidate', $form->get('candidate_id')->getData())
//            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('email_address_index');
        }
//      autocomplite
//        $form->get('candidate_name')->setData($emailAddress->getCandidate());
//        $form->get('candidate_id')->setData(
//            $emailAddress->getCandidate()? $emailAddress->getCandidate()->getId():$emailAddress->getCandidate()
//        );
        return $this->render('@ConsentPersData/email_address/edit.html.twig', [
            'email_address' => $emailAddress,

            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmailAddress $emailAddress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailAddress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emailAddress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_address_index');
    }

}
