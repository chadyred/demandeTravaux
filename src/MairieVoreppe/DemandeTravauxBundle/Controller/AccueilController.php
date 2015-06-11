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

		$pdf->footer = 1;	

		// import page 1
		$tplIdx = $pdf->importPage(1);

		// use the imported page and place it at point 0,0 with a width of 210 mm
		$pdf->useTemplate($tplIdx, 0, 0, 210, 297, true);

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
		$pdf->reponseInformationDemandeImprecise('reponseInformationDemandeImprecise');
		$pdf->reponseDistanceNonConcerne(150);
		$categories = array('HC', 'PC', 'GA');
		$pdf->reponseCategorieConcernee($categories);

		//Partie 'Modification ou extension de nos réseau ou ouvrage'
		$pdf->modificationOuvrageEnvisagee("modificationOuvrageEnvisagee");
		$pdf->modificationCheckboxOuvrageEnCours();
		$pdf->modificationContactRepresentant("modificationContactRepresentant");
		$pdf->modificationAjouterNumeroRepresentant($phoneUtil->format($recepisseDT->getTelephoneRepresentant(), \libphonenumber\PhoneNumberFormat::NATIONAL));
		
		//Partie Emplacement réseaux et ouvrages
		$pdf->reseauCheckboxPlanJoint();
		$pdf->reseauCheckboxReunionChantier();
		$pdf->reseauCheckboxTenirCompteServitude();
		$pdf->reseauCheckboxRecepisseDtInvestigationComplementaire();
		$pdf->reseauCheckboxBranchementRattache();
		$pdf->reseauPremiereReference("premiereReference");
		$pdf->reseauPremiereEchelle("premiereEchelle");
		$pdf->reseauPremiereDateEditionPlan(new \DateTime('now'));
		$pdf->reseauPremiereCheckboxSensible();
		$pdf->reseauPremiereProfReglMini(133);
		$pdf->reseauPremiereMateriaux("materiaux1");
		$pdf->reseauDeuxiemeReference("DeuxiemeReference");
		$pdf->reseauDeuxiemeEchelle("DeuxiemeEchelle");
		$pdf->reseauDeuxiemeDateEditionPlan(new \DateTime('now'));
		$pdf->reseauDeuxiemeCheckboxSensible();
		$pdf->reseauDeuxiemeProfReglMini(133);
		$pdf->reseauDeuxiemeMateriaux("materiaux2");
		$pdf->reseauCheckboxDateRetenueCommunAccord();
		$pdf->reseauDateHeureRetenueCommunAccord(new \DateTime('now'));
		$pdf->reseauCheckboxPriseRendezVousInitiativeDeclarant();
		$pdf->reseauPriseRendezVousInitiativeDeclarant(new \DateTime('now'));
		$pdf->securiteRecommandationTechnique("securiteRecommandationTechnique");
		$pdf->securiteRubriqueGuideTechnique("securiteRubriqueGuideTechnique");
		$pdf->securiteMesureMettreEnOeuvre("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant im. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un peintre anonyme ");
		$pdf->securiteDispositifImportant("securiteDispositifImportant");
		$pdf->securiteMiseHorsTension(true);

		//Partie dégradation
		$pdf->degradationNumeroService($phoneUtil->format($recepisseDT->getTelephoneRepresentant(), \libphonenumber\PhoneNumberFormat::NATIONAL));
		$pdf->securiteAnomalie("securiteAnomalie");

		//Partie responsable projet
		$pdf->responsableDossierNom("responsableDossierNom");
		$pdf->responsableDossierService("responsableDossierService");
		$pdf->numServiceResponsable = $phoneUtil->format($recepisseDT->getTelephoneRepresentant(), \libphonenumber\PhoneNumberFormat::NATIONAL);

		//Partie signature
		$pdf->signatureExploitantReprésentant("signatureExploitantReprésentant");


		$pdf->Output();
	}

	
}
