<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MairieVoreppe\DemandeTravauxBundle\Entity\Pdf;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;

class AccueilController extends Controller
{
    public function indexAction()
    {	
        // $this->generationFullPdfExemple();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Accueil:index.html.twig');
    }


	
}
