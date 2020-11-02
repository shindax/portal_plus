<?php
// src/EventListener/OrgNewsCurrentUserListener.php

namespace App\EventListener;

use App\Entity\OrgNews;
use App\Entity\OrgUser;
use App\Entity\SysUser;
use App\Repository\SysUserRepository;

use Doctrine\Persistence\Event\LifecycleEventArgs;

class OrgNewsEntityListener
{
    private $current_user;

    public function __construct( $security_context )
    {
        if ($security_context->getToken() != null)
            $this->current_user = $security_context->getToken()->getUser();
    }

    public function postPersist( LifecycleEventArgs $args )
    {
        $entity = $args->getObject();

        if ( $entity instanceof OrgNews )
        {
            $em = $args->getObjectManager();
            $sys_user_id = $this -> current_user -> getId();
            $rec_id = $entity -> getId();

            $org_user_id = $em -> getRepository(SysUser::class) -> find( $sys_user_id ) -> getOrgUserID();

            $org_user = $em -> getRepository(OrgUser::class) -> find( $org_user_id );
            $entity -> setAuthorID( $org_user );
            $entity -> setIsPublished( false );
            $em -> flush();
        }
            else
               return;
    }

    public function preUpdate( LifecycleEventArgs $args )
    {
        // Not used yet
    }

    public function postUpdate( LifecycleEventArgs $args )
    {
        // Not used yet
    }
}
