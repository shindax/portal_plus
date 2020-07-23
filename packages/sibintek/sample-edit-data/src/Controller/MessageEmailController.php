<?php

namespace Sibintek\ConsentPersData\Controller;

use Sibintek\ConsentPersData\Entity\MessageEmail;
use Sibintek\ConsentPersData\Form\MessageEmailType;
use Sibintek\ConsentPersData\Repository\MessageEmailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pd/messageemail")
 */
class MessageEmailController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods="GET", name="message_email_index")
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="message_email_index_paginated")*
     */
    public function index(Request $request, int $page, MessageEmailRepository $messageEmailRepository): Response
    {
        $sort = $request->query->get('sort');
        $pageSize = $request->query->get('pageSize')?$request->query->get('pageSize'):10;
        $find['subject'] = $request->query->get('subject');
        $find['body'] = $request->query->get('body');
        $find['sender'] = $request->query->get('sender');
        $find['fdatereceipt'] = $request->query->get('fdatereceipt');
        $find['ldatereceipt'] = $request->query->get('ldate');
        $find['fdatesent'] = $request->query->get('fdatesent');
        $find['ldatesent'] = $request->query->get('ldatesent');

        $latestMessageEmail = $messageEmailRepository->findLatest($page, $pageSize, $sort, $find);

        return $this->render('@ConsentPersData/message_email/index.html.twig', [
            'paginator' => $latestMessageEmail,
            'sort' => $sort,
            'find' => $find,
        ]);
    }

    /**
     * @Route("/new", name="message_email_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $messageEmail = new MessageEmail();
        $form = $this->createForm(MessageEmailType::class, $messageEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($messageEmail);
            $entityManager->flush();

            return $this->redirectToRoute('message_email_index');
        }

        return $this->render('@ConsentPersData/message_email/new.html.twig', [
            'message_email' => $messageEmail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_email_show", methods={"GET"})
     */
    public function show(MessageEmail $messageEmail): Response
    {
        return $this->render('@ConsentPersData/message_email/show.html.twig', [
            'message_email' => $messageEmail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_email_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MessageEmail $messageEmail): Response
    {
        $form = $this->createForm(MessageEmailType::class, $messageEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_email_index');
        }

        return $this->render('@ConsentPersData/message_email/edit.html.twig', [
            'message_email' => $messageEmail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_email_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MessageEmail $messageEmail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messageEmail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($messageEmail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_email_index');
    }
}
