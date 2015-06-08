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
        $this->generationPdf();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Accueil:index.html.twig');
    }

    public function generationPdf()
	{
		// initiate FPDI
		$pdf = new Pdf();
		$dt = new \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux();
		$recepisseDT = new \MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT();

		$numeroTelephone = "0476911238";
		$phoneUtil = PhoneNumberUtil::getInstance();

		try {
		    $numeroTelephoneProto = $phoneUtil->parse($numeroTelephone, "FR");
		    // var_dump($swissNumberProto);
		} catch (\libphonenumber\NumberParseException $e) {
		    var_dump($e);
		}

		$recepisseDT->setTelephoneRepresentant($numeroTelephoneProto);
		$dt->setRecepisseDt($recepisseDT);


		// add a page
		$pdf->AddPage();

		// set the source file
		$pdf->setSourceFile($pdf->getWebPath());

		// import page 1
		$tplIdx = $pdf->importPage(1);

		// use the imported page and place it at point 0,0 with a width of 210 mm
		$pdf->useTemplate($tplIdx, 0, 0, 210);

		// now write some text above the imported page
		$pdf->SetFont('Helvetica', "", 8);
		$pdf->SetTextColor(0, 0, 0);
		
		
		/**
		* Affichage des différents éléments
		*/
		$pdf->checkboxTypeDemande($dt);
		$pdf->destinataireDenomination("Zone destinataire>denomination");
		$pdf->destinataireComplement("Zone destinataire>complement");
		$pdf->ajouterNumeroRepresentant($phoneUtil->format($recepisseDT->getTelephoneRepresentant(), \libphonenumber\PhoneNumberFormat::NATIONAL));
		$pdf->destinataireNumeroRueTravaux("Zone destinataire>numeroRue");
		$pdf->destinataireLieuDitBp("Zone destinataire>lieuDitBp");
		$pdf->destinataireCodePostal("38140");
		$pdf->destinataireCommune("Zone destinataire>commune");

		
		$pdf->SetFont('Helvetica', "", 8);
		$pdf->SetTextColor(0, 0, 0);


		$pdf->Output();
	}

	
}
