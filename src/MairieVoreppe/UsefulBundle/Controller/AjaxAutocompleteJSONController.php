<?php

namespace MairieVoreppe\UsefulBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Shtumi\UsefulBundle\Controller\AjaxAutocompleteJSONController As ParentController;

use Symfony\Component\HttpFoundation\Response;

class AjaxAutocompleteJSONController extends ParentController
{

    public function getJSONAction()
    {

        $em = $this->get('doctrine')->getManager();
        $request = $this->getRequest();

        $entities = $this->get('service_container')->getParameter('shtumi.autocomplete_entities');

        $entity_alias = $request->get('entity_alias');
        $entity_inf = $entities[$entity_alias];

        if ($entity_inf['role'] !== 'IS_AUTHENTICATED_ANONYMOUSLY'){
            if (false === $this->get('security.context')->isGranted( $entity_inf['role'] )) {
                throw new AccessDeniedException();
            }
        }

        $letters = $request->get('letters');
        $maxRows = $request->get('maxRows');

        switch ($entity_inf['search']){
            case "begins_with":
                $like = $letters . '%';
            break;
            case "ends_with":
                $like = '%' . $letters;
            break;
            case "contains":
                $like = '%' . $letters . '%';
            break;
            default:
                throw new \Exception('Unexpected value of parameter "search"');
        }

	$property = $entity_inf['property'];

        if ($entity_inf['case_insensitive']) {
                $where_clause_lhs = 'WHERE LOWER(e.' . $property . ')';
                $where_clause_rhs = 'LIKE LOWER(:like)';
        } else {

                $where_clause_lhs = 'WHERE e.' . $property;
                $where_clause_rhs = 'LIKE :like';
        }


        //Etape0 : adapté la requête
        $results = $em->createQuery(
            'SELECT e.' . $property . ', e.villeCp
             FROM ' . $entity_inf['class'] . ' e ' .
             $where_clause_lhs . ' ' . $where_clause_rhs . ' ' .
            'ORDER BY e.' . $property)
            ->setParameter('like', $like )
            ->setMaxResults($maxRows)
            ->getScalarResult();
        
        #Etape1 : associé l'ensemble des champs que l'on souhaite (bien modifier la requête auparavant +> Etape 2: fields.html.twig
        $res = array();
        foreach ($results AS $r){
            $res[] = array("villeNom" => $r[$entity_inf['property']], "villeCp" => $r['villeCp']);
            
        }

        return new Response(json_encode($res));

    }
}
