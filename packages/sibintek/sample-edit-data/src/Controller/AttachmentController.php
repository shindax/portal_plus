<?php

namespace Sibintek\ConsentPersData\Controller;

use Sibintek\ConsentPersData\Entity\Attachment;
use Sibintek\ConsentPersData\Form\AttachmentType;
use Sibintek\ConsentPersData\Repository\AttachmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("/pd/attachment")
 */
class AttachmentController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods="GET", name="attachment_index")
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="attachment_index_paginated")**
     */
    public function index(Request $request, int $page, AttachmentRepository $attachmentRepository): Response
    {
        $sort = $request->query->get('sort');
        $pageSize = $request->query->get('pageSize')?$request->query->get('pageSize'):10;
        $pageSize = $request->query->get('pageSize')?$request->query->get('pageSize'):10;
        $find['originName'] = $request->query->get('originName');
        $find['emailAddress'] = $request->query->get('emailAddress');
        $find['fullName'] = $request->query->get('fullName');

        $latestMessageEmail = $attachmentRepository->findLatest($page, $pageSize, $sort, $find);
//    var_dump($latestMessageEmail);die;
        return $this->render('@ConsentPersData/attachment/index.html.twig', [
            'paginator' => $latestMessageEmail,
            'sort' => $sort,
            'find' => $find,
        ]);

    }

    /**
     * @Route("/download/{id}", name="attachment_download", methods={"GET"})
     */
    public function download(Attachment $attachment)
    {
        $file = new File("c:/temp/storage/" . $attachment->getDrive() . $attachment->getPath() . $attachment->getFileName());
//        $file = new File($_ENV['STORAGE'] . $attachment->getDrive() . $attachment->getPath() . $attachment->getFileName());
//        $file = new File($attachment->getDrive() . $attachment->getPath() . $attachment->getFileName());

        return $this->file($file, $attachment->getOriginName());
    }
//    /**
//     * @Route("/new", name="attachment_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $attachment = new Attachment();
//        $form = $this->createForm(AttachmentType::class, $attachment);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($attachment);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('attachment_index');
//        }
//
//        return $this->render('@ConsentPersData/attachment/new.html.twig', [
//            'attachment' => $attachment,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/{id}", name="attachment_show", methods={"GET"})
     */
    public function show(Attachment $attachment): Response
    {
        return $this->render('@ConsentPersData/attachment/show.html.twig', [
            'attachment' => $attachment,
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name="attachment_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Attachment $attachment): Response
//    {
//        $form = $this->createForm(AttachmentType::class, $attachment);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('attachment_index');
//        }
//
//        return $this->render('@ConsentPersData/attachment/edit.html.twig', [
//            'attachment' => $attachment,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/{id}", name="attachment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Attachment $attachment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attachment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attachment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attachment_index');
    }
}
