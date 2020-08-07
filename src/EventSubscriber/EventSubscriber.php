<?php
// src/EventSubscriber/EventSubscriber.php
namespace App\EventSubscriber;

use App\Controller\MainController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Service\Autologin;
use Twig\Environment;

class EventSubscriber implements EventSubscriberInterface
{
    private $controller;
    private $twig;

    public function __construct(MainController $controller, Environment $twig)
    {
        $this->controller = $controller;
        $this->twig = $twig;
    }

    public function onKernelController( ControllerEvent $event )
    {
        // Ванкор
        $months = [
            1 => "Январь",
            2 => "Февраль",
            3 => "Март",
            4 => "Апрель",
            5 => "Май",
            6 => "Июнь",
            7 => "Июль",
            8 => "Август",
            9 => "Сентябрь",
            10 => "Октябрь",
            11 => "Ноябрь",
            12 => "Декабрь",
        ];

        $week_day = [
                1 => "понедельник",
                2 => "вторник",
                3 => "среда",
                4 => "четверг",
                5 => "пятница",
                6 => "суббота",
                0 => "воскресение",
            ];

        date_default_timezone_set('Asia/Krasnoyarsk');

        $this->twig->addGlobal('today_date', date("d"));
        $this->twig->addGlobal('today_day', $week_day[ + date("w") ]);
        $this->twig->addGlobal('today_month', $months[ + date("m")]);
        $this->twig->addGlobal('today_time', date("H:i"));
        $this->twig->addGlobal('currentUser', [
                    'photo' => 'photo',
                    // 'getPhoto' => 'photo',
                    'employeeImage' => 'photo',
                    'name' => 'Иванов Иван Иванович',
                    'employeeId' => 123
                ]);
        $this->twig->addGlobal('months', $months);

        $this->twig->addGlobal('oilCounter', '209150');
        $this->twig->addGlobal('oilCounterForDay', '41173');
        $this->twig->addGlobal('gazCounterGazprom', '33200');
        $this->twig->addGlobal('gazCounterPpd', '8622');

        Autologin::autologin( $_SERVER['AUTH_USER'], $this -> controller );
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
