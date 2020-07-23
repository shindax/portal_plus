<?php

namespace Sibintek\InformerBundle\Controller;

use Sibintek\InformerBundle\Entity\Weather;
use Sibintek\InformerBundle\Form\WeatherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sibintek\InformerBundle\Repository\WeatherRepository;

/**
 * @Route("/weather")
 */
class WeatherController extends AbstractController
{
    /**
     * @Route("/", name="weather_index", methods={"GET"})
     */
    public function index(): Response
    {
        $weather = $this->getDoctrine()
            ->getRepository(Weather::class)
            ->findAll();

        return $this->render('@Informer/weather/index.html.twig', [
            'weather' => $weather,
        ]);
    }

    /**
     * @Route("/new", name="weather_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $weather = new Weather();
        $form = $this->createForm(WeatherType::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($weather);
            $entityManager->flush();

            return $this->redirectToRoute('weather_index');
        }

        return $this->render('@InformerBundle/weather/new.html.twig', [
            'weather' => $weather,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weather_show", methods={"GET"})
     */
    public function show(Weather $weather): Response
    {
        return $this->render('@InformerBundle/weather/show.html.twig', [
            'weather' => $weather,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="weather_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Weather $weather): Response
    {
        $form = $this->createForm(WeatherType::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('weather_index');
        }

        return $this->render('@InformerBundle/weather/edit.html.twig', [
            'weather' => $weather,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weather_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Weather $weather): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weather->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($weather);
            $entityManager->flush();
        }

        return $this->redirectToRoute('weather_index');
    }

    public function getTemp(string $param, WeatherRepository $repository): Response
    {
        $weather = $repository->findByPlace($param);
        return $this->render('@Informer/weather/temperature.html.twig', [
            'weather' => $weather,
        ]);
    }
}
