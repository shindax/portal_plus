<?php

namespace Sibintek\ConsentPersData\Controller;

use Sibintek\ConsentPersData\Entity\Candidate;
use Sibintek\ConsentPersData\Form\CandidateType;
use Sibintek\ConsentPersData\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Controller used to manage candidate. --- везде добавить и исправить
 *
 * @Route("/pd/candidate")
 *
 * @author Alexander Nikitin <NikitinAY@sibintek.ru>
 */
class CandidateController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods="GET", name="candidate_index")
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="candidate_index_paginated")
     */
    public function index(Request $request, int $page, CandidateRepository $candidateRepository): Response
    {
        $sort = $request->query->get('sort');
        $pageSize = $request->query->get('pageSize')?$request->query->get('pageSize'):10;
//        $find['lname'] = $request->query->get('lname');
        $find['name'] = $request->query->get('name');
//        $find['pat'] = $request->query->get('pat');
        $find['fdate'] = $request->query->get('fdate');
        $find['ldate'] = $request->query->get('ldate');

        $latestCandidates = $candidateRepository->findLatest($page, $pageSize, $sort, $find);

        return $this->render('@ConsentPersData/candidate/index.html.twig', [
            'paginator' => $latestCandidates,
            'sort' => $sort,
            'find' => $find,
        ]);
    }

    /**
     * @Route("/new", name="candidate_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $candidate = new Candidate();
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidate);
            $entityManager->flush();
            foreach ($form->get('emailaddress')->getData() as $item) {

                $emailaddress = $this->getDoctrine()->getManager()->find('Sibintek\ConsentPersData\Entity\EmailAddress', $item);
                $emailaddress->setCandidate($candidate);
                $this->getDoctrine()->getManager()->flush();
            }

            return $this->redirectToRoute('candidate_index');
        }

        return $this->render('@ConsentPersData/candidate/new.html.twig', [
            'candidate' => $candidate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidate_show", methods={"GET"})
     */
    public function show(Candidate $candidate): Response
    {
        return $this->render('@ConsentPersData/candidate/show.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="candidate_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Candidate $candidate): Response
    {
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            var_dump($form->get('emailaddress')->getData()); die;
            $this->getDoctrine()->getManager()->flush();
//            var_dump($form->get('emailaddress')->getData());die;
            foreach ($form->get('emailaddress')->getData() as $item) {

                $emailaddress = $this->getDoctrine()->getManager()->find('Sibintek\ConsentPersData\Entity\EmailAddress', $item);
                $emailaddress->setCandidate($candidate);
                $this->getDoctrine()->getManager()->flush();
            }

            return $this->redirectToRoute('candidate_index');
        }

        return $this->render('@ConsentPersData/candidate/edit.html.twig', [
            'candidate' => $candidate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidate_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Candidate $candidate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidate);
            $entityManager->flush();

        }

        return $this->redirectToRoute('candidate_index');
    }

    /**
     * @Route("/search", name="candidate_search", methods={"GET"})
     */
    public function search(Request $request, CandidateRepository $candidateRepository): Response
    {
        $query = $request->query->get('q');
        $limit = $request->query->get('l', 10);

        $foundCandidats = $candidateRepository->findBySearchQuery($query, $limit);

        $results = [];
        foreach ($foundCandidats as $candidate) {
            $results[] = [
                'value' => $candidate->getFullName(),
                'data' => [
                    'id' => $candidate->getId(),
                    'name' => $candidate->getFullName()
                ]
            ];
        }

        return $this->json(['suggestions' => $results]);
    }
}
