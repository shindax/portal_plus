<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Autologin extends AbstractController
{
    public static function autologin( String $login, AbstractController $absctractController )
    {
        $request = new Request;
        $dispatcher = new EventDispatcher();
        $user = $absctractController->getDoctrine()->getManager()->getRepository("App\Entity\SysUser")->findOneBy(['UserLogin' => $login ]);

        if( $user ){ // User exists
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $absctractController->get('security.token_storage')->setToken($token);
            $absctractController->get('session')->set('_security_main', serialize($token));
            $event = new InteractiveLoginEvent($request, $token);
            $dispatcher->dispatch($event);
        }
        else{  // User not exists
            $absctractController->get('session')->set('_security_main', null);
        }
    }
}