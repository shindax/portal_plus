<?php
// src/EventSubscriber/EventSubscriber.php
namespace App\EventSubscriber;

use App\Controller\MainController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Service\Autologin;

class EventSubscriber implements EventSubscriberInterface
{
    private $controller;

    public function __construct(MainController $controller)
    {
        $this->controller = $controller;
    }

    public function onKernelController( ControllerEvent $event )
    {
        Autologin::autologin( $_SERVER['AUTH_USER'], $this -> controller );
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
