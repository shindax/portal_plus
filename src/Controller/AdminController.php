<?php
// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminController extends EasyAdminController
{

    public function isUseradmin()
    {
        $user = $this -> getUser();
        if( $user )
        {
            $roles = $user -> getRoles();
            return in_array( "ROLE_ADMIN", $roles );
        }
        return false;
    }


	/**
     * @Route("/dashboard", name="admin_dashboard")
     */

    public function dashboardAction()
    {
        if( $this -> isUseradmin() )
            return $this->render('bundles/EasyAdminBundle/dashboard.html.twig');
            else
                return $this->redirectToRoute('app_homepage');
    }

    /**
     * @Route("/", name="easyadmin")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws ForbiddenActionException
     */

    public function indexAction(Request $request)
    {
        if( !$this -> isUseradmin() )
                return $this->redirectToRoute('app_homepage');

    	$this->initialize($request);
        if (null === $request->query->get('entity')) {
            return $this->redirectToBackendHomepage();
        }

		$userHasPermission = false;
    	$user = $this->get('security.token_storage')->getToken()->getUser();

        $action = $request->query->get('action');

        if (\in_array($action, ['show', 'edit', 'new', 'list'])) {
            $requiredPermission = $this->entity[$action]['item_permission'];

            if( $requiredPermission == null )
           		$userHasPermission = true;
           		else
                {
                    if( gettype( $user ) != 'string' )
		            foreach( $user -> getRcollection() AS $value ){
                        if( gettype( $requiredPermission ) == 'string' )
                        {
                            if( $value -> getName() == $requiredPermission )
                                $userHasPermission = true;
                        }
                            else
                                if( in_array( $value -> getName(), $requiredPermission ) )
		            		    $userHasPermission = true;
                    }
                        else
                            return $this->redirectToRoute('app_homepage');
                }
        }


        if( $userHasPermission )
    		$result = parent::indexAction($request);
    		else
                $result = $this->redirectToBackendHomepage();

        return $result ;
    }
}
