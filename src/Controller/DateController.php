<?php
// src/Controller/DateController.php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DateController extends AbstractController
{
    public function getData(){
        return $this->render(
            'date.html.twig',
            [
                'today_date' => '1111'
            ]
        );
    }
}