<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller
{
    public function showAction($route, $route_params)
    {
          //Etant donné que l'on récupère un tableau de paramêtre et que le deuxième paramêtre est de type tableau, il nous suffit de le passer
          //en tant que tel
          $url = $this->generateUrl($route, $route_params);
          
          return $this->render("MairieVoreppeDemandeTravauxBundle:Menu:view.html.twig", array("route_en_cours" => $url));
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

