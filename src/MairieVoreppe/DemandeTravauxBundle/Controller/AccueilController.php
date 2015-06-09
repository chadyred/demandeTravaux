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
        $this->generationFullPdfExemple();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Accueil:index.html.twig');
    }

    public function generationFullPdfExemple()
	{

		// initiate FPDI
		$pdf = new Pdf();
		$dt = new \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux();
		$recepisseDT = new \MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT();
		$reponse = new \MairieVoreppe\DemandeTravauxBundle\Entity\NonConcerne();

		$numeroTelephone = "+334 76 91 12 38";
		$phoneUtil = PhoneNumberUtil::getInstance();

		try {
		    $numeroTelephoneProto = $phoneUtil->parse($numeroTelephone, "FR");
		    // var_dump($numeroTelephoneProto);
		} catch (\libphonenumber\NumberParseException $e) {
		    var_dump($e);
		}

		$recepisseDT->setTelephoneRepresentant($numeroTelephoneProto);
		$recepisseDT->setReponse($reponse);
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

		//Partie récépissé type 
		$pdf->checkboxTypeDemande($dt);

		//Partie destinataire
		$pdf->destinataireDenomination("Zone destinataire>denomination");
		$pdf->destinataireComplement("Zone destinataire>complement");
		$pdf->ajouterNumeroRepresentant($phoneUtil->format($recepisseDT->getTelephoneRepresentant(), \libphonenumber\PhoneNumberFormat::NATIONAL));
		$pdf->destinataireNumeroRueTravaux("Zone destinataire>numeroRue");
		$pdf->destinataireLieuDitBp("Zone destinataire>lieuDitBp");
		$pdf->destinataireCodePostal("38140");
		$pdf->destinataireCommune("Zone destinataire>commune");
		$pdf->destinataireVille("Zone destinataire>ville");

		//Parite inforlation général
		$pdf->infoNumTeleservice("2015050703952DE3");
		$pdf->infoRefExploitant("Info> Référence de l'exploitant");
		$pdf->infoNumeroAffaireDeclarant("infoNumeroAffaireDeclarant");
		$pdf->infoPersonneAContacterDeclarant("personneAContacterDeclarant");
		$pdf->infoDateReceptionDeclaration(new \DateTime('now'));
		$pdf->infoCommunePrincipalTravaux("infoCommunePrincipalTravaux");
		$pdf->infoAdresseTravauxPrevus("infoAdresseTravauxPrevus");

		//Partie exploitant
		$pdf->exploitantRS("exploitantRS");
		$pdf->exploitantPersonneContact("exploitantPersonneContact");
		$pdf->exploitantNumeroVoie("exploitantNumeroVoie");
		$pdf->exploitantLieuDitBp("exploitantLieuDitBp");
		$pdf->exploitantCp("11111");
		$pdf->exploitantCommune("exploitantCommune");
		$pdf->exploitantTel($phoneUtil->format($numeroTelephoneProto, \libphonenumber\PhoneNumberFormat::NATIONAL));
		$pdf->exploitantFax($phoneUtil->format($numeroTelephoneProto, \libphonenumber\PhoneNumberFormat::NATIONAL));

		//Partie réponse
		$pdf->reponseCheckboxTypeReponse($recepisseDT->getReponse());
		
		$pdf->SetFont('Helvetica', "", 8);
		$pdf->SetTextColor(0, 0, 0);


		$pdf->Output();
	}

	
}
