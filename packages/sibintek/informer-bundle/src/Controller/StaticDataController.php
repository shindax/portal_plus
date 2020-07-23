<?php

namespace Sibintek\InformerBundle\Controller;

use Sibintek\InformerBundle\Entity\StaticData;
use Sibintek\InformerBundle\Form\StaticDataType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sibintek\InformerBundle\Repository\StaticDataRepository;

/**
 * @Route("/staticdata")
 */
class StaticDataController extends AbstractController
{
    /**
     * @Route("/", name="static_data_index", methods={"GET"})
     */
    public function index(): Response
    {
        $staticDatas = $this->getDoctrine()
            ->getRepository(StaticData::class)
            ->findAll();

        return $this->render('@Informer/static_data/index.html.twig', [
            'static_datas' => $staticDatas,
        ]);
    }

    /**
     * @Route("/new", name="static_data_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $staticDatum = new StaticData();
        $form = $this->createForm(StaticDataType::class, $staticDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staticDatum);
            $entityManager->flush();

            return $this->redirectToRoute('static_data_index');
        }

        return $this->render('@Informer/static_data/new.html.twig', [
            'static_datum' => $staticDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{type}", name="static_data_show", methods={"GET"})
     */
    public function show(StaticData $staticDatum): Response
    {
        return $this->render('@Informer/static_data/show.html.twig', [
            'static_datum' => $staticDatum,
        ]);
    }

    /**
     * @Route("/{type}/edit", name="static_data_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StaticData $staticDatum): Response
    {
        $form = $this->createForm(StaticDataType::class, $staticDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('static_data_index');
        }

        return $this->render('@Informer/static_data/edit.html.twig', [
            'static_datum' => $staticDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{type}", name="static_data_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StaticData $staticDatum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$staticDatum->getType(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($staticDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('static_data_index');
    }

    public function getCurrency(string $param, StaticDataRepository $repository): Response
    {
        $currency = $repository->findByType($param);
        $currencyFloat = floatval($currency->getValue());
        $currency->setValue(sprintf('%.2f', $currencyFloat));
        return $this->render('@Informer/static_data/currency.html.twig', [
            'static_datum' => $currency,
        ]);
    }
}
