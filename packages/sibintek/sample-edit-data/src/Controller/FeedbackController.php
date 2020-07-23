<?php

namespace Sibintek\ConsentPersData\Controller;

use Sibintek\ConsentPersData\Service\FileUploader;
use Sibintek\ConsentPersData\Entity\Feedback;
use Sibintek\ConsentPersData\Entity\Candidate;
use Sibintek\ConsentPersData\Entity\Template;
use Sibintek\ConsentPersData\Entity\EmailAddress;
use Sibintek\ConsentPersData\Form\FeedbackType;
use Sibintek\ConsentPersData\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pd/feedback")
 */
class FeedbackController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods="GET", name="feedback_index")
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="feedback_index_paginated")*
     */
    public function index(Request $request, int $page, FeedbackRepository $feedbackRepository): Response
    {
        $sort = $request->query->get('sort');
        $pageSize = $request->query->get('pageSize')?$request->query->get('pageSize'):10;
        $find['email'] = $request->query->get('email');
        $find['subject'] = $request->query->get('subject');
        $find['body'] = $request->query->get('body');
        $find['fdatesent'] = $request->query->get('fdatesent');
        $find['ldatesent'] = $request->query->get('ldatesent');

        $latestFeedback = $feedbackRepository->findLatest($page, $pageSize, $sort, $find);

        return $this->render('@ConsentPersData/feedback/index.html.twig', [
            'paginator' => $latestFeedback,
            'sort' => $sort,
            'find' => $find,
        ]);
    }

    /**
     * @Route("/new", name="feedback_new", methods={"GET","POST"})
     */
    public function new_message(Request $request, FileUploader $fileUploader, MailerInterface $mailer): Response
    {
        $feedback = new Feedback();
        $template = $request->query->get('template')?$request->query->get('template'):null;
        $idCandidate = $request->query->get('candidate_id')?$request->query->get('candidate_id'):null;

/*        if ($idCandidate) {
            $candidate = $this->getDoctrine()->getManager()->find(Candidate::class, $idCandidate);
            $arrAddress = [];
            foreach ($candidate->getEmailAddress() as $address) {
                $arrAddress[] = $address->getId();
            }
            $feedback->setEmailAddresses($arrAddress);
        }*/

        if($template) {
            $template_message = $this->getDoctrine()->getManager()->find(Template::class, $template);
            $feedback->setSubject($template_message->getSubject());
            $feedback->setBody($template_message->getBody());
            $feedback->setFiles($template_message->getFiles());
            $feedback->setFilesName($template_message->getFilesName());
        }

        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $arrEmail = [];
            foreach ($form->get('emailaddress')->getData() as $item) {
                $arrEmail[] = $this->getDoctrine()->getManager()->find(EmailAddress::class, $item)->getName();
            }
            $feedback->setEmailAddresses($arrEmail);

            if(!$template) {
                $files = $form['fileupload']->getData();

                $arrFiles = [];
                $arrFilesName = [];
                foreach ($files as $file) {
                    $arrFiles[] = $fileUploader->upload($file);
                    $arrFilesName[] = $file->getClientOriginalName();
                }
                $feedback->setFiles($arrFiles);
                $feedback->setFilesName($arrFilesName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedback);
            $entityManager->flush();

            $email = (new Email())
                ->from($_ENV["SENDER"])
//                ->to('NikitinAIU@sibintek.ru')
//                ->to($feedback->getEmailAddresses()[0])
                ->subject($feedback->getSubject())
                ->html($feedback->getBody());

            for ($i=0;$i<count($feedback->getFiles());$i++) {
                $email->attachFromPath($fileUploader->getTargetDirectory(). "//" . $feedback->getFiles()[$i], $feedback->getFilesName()[$i]);
            }
            for ($i=0;$i<count($feedback->getEmailAddresses());$i++) {
                $email->addTo($feedback->getEmailAddresses()[$i]);
            }
            $mailer->send($email);
            $feedback->setDateTimeSent(new \DateTime());
            $entityManager->flush();

            return $this->redirectToRoute('feedback_index');
        }

        return $this->render('@ConsentPersData/feedback/new.html.twig', [
            'feedback' => $feedback,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="feedback_show", methods={"GET"})
     */
    public function show(Feedback $feedback): Response
    {
        return $this->render('@ConsentPersData/feedback/show.html.twig', [
            'feedback' => $feedback,
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name="feedback_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Feedback $feedback): Response
//    {
//        $form = $this->createForm(FeedbackType::class, $feedback);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('feedback_index');
//        }
//
//        return $this->render('@ConsentPersData/feedback/edit.html.twig', [
//            'feedback' => $feedback,
//            'form' => $form->createView(),
//        ]);
//    }

//    /**
//     * @Route("/{id}", name="feedback_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, Feedback $feedback): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$feedback->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($feedback);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('feedback_index');
//    }
}
