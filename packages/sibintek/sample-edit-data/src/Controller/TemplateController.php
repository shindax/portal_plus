<?php

namespace Sibintek\ConsentPersData\Controller;

use Sibintek\ConsentPersData\Entity\Template;
use Sibintek\ConsentPersData\Form\TemplateType;
use Sibintek\ConsentPersData\Repository\TemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sibintek\ConsentPersData\Service\FileUploader;

/**
 * @Route("/pd/template")
 */
class TemplateController extends AbstractController
{
    /**
     * @Route("/", name="template_index", methods={"GET"})
     */
    public function index(TemplateRepository $templateRepository): Response
    {
        return $this->render('@ConsentPersData/template/index.html.twig', [
            'templates' => $templateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/select", name="template_select", methods={"GET"})
     */
    public function select(TemplateRepository $templateRepository): Response
    {
        return $this->render('@ConsentPersData/template/select.html.twig', [
            'templates' => $templateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="template_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $template = new Template();
        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $form['fileupload']->getData();

            $arrFiles = [];
            $arrFilesName = [];
            foreach ($files as $file) {
                $arrFiles[] = $fileUploader->upload($file);
                $arrFilesName[] = $file->getClientOriginalName();
            }
            $template->setFiles($arrFiles);
            $template->setFilesName($arrFilesName);
//            var_dump($template);die;
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($template);
            $entityManager->flush();

            return $this->redirectToRoute('template_index');
        }

        return $this->render('@ConsentPersData/template/new.html.twig', [
            'template' => $template,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="template_show", methods={"GET"})
     */
    public function show(Template $template): Response
    {
        return $this->render('@ConsentPersData/template/show.html.twig', [
            'template' => $template,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="template_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Template $template): Response
    {
        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('template_index');
        }

        return $this->render('@ConsentPersData/template/edit.html.twig', [
            'template' => $template,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="template_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Template $template): Response
    {
        if ($this->isCsrfTokenValid('delete'.$template->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($template);
            $entityManager->flush();
        }

        return $this->redirectToRoute('template_index');
    }
}
