<?php

namespace MairieVoreppe\AdminBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

abstract class AbstractAdmin extends Admin
{
    //Classe qui me 
    /** @var int */
    protected $maxPerPage = 10;
    //other attributes

    public function __construct($code, $class, $baseControllerName)
    {
            parent::__construct($code, $class, $baseControllerName);

            // custome arguments
            if (!$this->hasRequest()) {
                $this->datagridValues = array(
                  '_per_page' => $this->maxPerPage //passing ***_per_page*** argument
            );
        }
    }
}