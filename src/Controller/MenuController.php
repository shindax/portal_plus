<?php
// src/Service/MenuController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    const TOP_MENU = 1;
    const DOWN_MENU = 2;
    const DOWN_SIDEBAR_MENU = 3;

    private function executeQuery( $query ){
        $em = $this->getDoctrine()->getManager();
        $query_res = $em->createQuery( $query );
        return $query_res->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
    }

    public function getTopMenu(){
        return $this -> getMenu( self::TOP_MENU );
    }

    public function getDownMenu(){
        return $this -> getMenu( self::DOWN_MENU );
    }
    public function getDownSidebarMenu(){
        return array_merge( $this -> getMenu( self::DOWN_SIDEBAR_MENU ), []);
    }

    public function getMenu( $category )
    {
        $nav = [];
        $result = $this -> executeQuery(" SELECT m
                                    FROM App\Entity\Menu m
                                    WHERE m.category=$category
                                    AND
                                    m.pid=0
                                    AND
                                    m.enabled=1
                                    ");
        foreach ( $result AS $key => $value){
            $nav[ $value['id'] ] = [
                'name' => $value['title'],
                'href' => $value['controller']."/".$value['action'],
                'class' => $value['class'],
                'childs' => [],
            ];
        }

        $result = $this -> executeQuery("   SELECT m
                                            FROM App\Entity\Menu m
                                            WHERE m.category=$category
                                            AND
                                            m.pid<>0
                                            AND
                                            m.enabled=1
                                            ");

        foreach ( $result AS $key => $value){
            if( isset( $nav[ $value['pid'] ] ) )
            $nav[ $value['pid'] ]['childs'][] = [
                'name' => $value['title'],
                'href' => $value['controller']."/".$value['action'],
                'class' => $value['class'],
            ];
        }

        return $nav;
    }

    public function topMenuAction()
    {
        return $this->render(
            'nav.html.twig',
            ['main_nav' => $this -> getTopMenu() ]
        );
    }

    public function downMenuAction()
    {
        return $this->render(
            'footer.html.twig',
            [
                'footer_nav' => $this -> getDownMenu(),
                'footer_sidebar_nav' => $this->getDownSidebarMenu()
            ]
        );
    }

}