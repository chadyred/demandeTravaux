<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;


class Pdf extends \FPDI
{
	//Valeur définis dans le controller et insérer dans le footer
	public $numServiceResponsable = "";

	/**
	*
	* Checkbox qui cochera la demande
	*
	*/
	function checkboxDemandeDt()
	{


		$style = array('width' => 0.75, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(11.3, 55.8, 13, 58.5, $style);
		$draw->Line(13, 58.5, 15, 54.5, $style);
	}

	/**
	* Checkbox qui cochera la demande
	*/
	function checkboxDemandeDict()
	{

		$style = array('width' => 0.75, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(11.3, 62.8, 13, 65.5, $style);
		$draw->Line(13, 65.5, 15, 61.5, $style);
	}

	/**
	* Checkbox qui cochera la demande
	*/
	function checkboxDemandeDtDictConjointe()
	{

		
		$style = array('width' => 0.75, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));

		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(11.3, 69.8, 13, 72.5, $style);
		$draw->Line(13, 72.5, 15, 68.5, $style);
	}



	/**
	*
	* Partie destinataire
	*
	*/

	//Fonction qui représente une zone ciblée destinataireDenomination
	function destinataireDenomination($string)
	{ 
		// Décalage de 10 cm vers la droite et 40 vers le bas
		$this->SetXY(102, 47.5);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	} 

	//Fonction qui représente une zone ciblée destinataireComplement
	function destinataireComplement($string)
	{ 
		$this->SetXY(102, 52.5);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	} 


	//Fonction qui représente une zone ciblée concernant la rue du destinataire
	function destinataireNumeroRueTravaux($string)
	{ 
		$this->SetXY(102, 57.5);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	} 

	//Fonction qui représente une zone ciblée concernant l'adresse peut avoir un lieuDit  du destinataire
	function destinataireLieuDitBp($string)
	{ 

		$this->SetXY(102, 62.5);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0);
 	} 

	//Fonction qui représente une zone ciblée concernant le code postale de l'adresse   du destinataire
	function destinataireCodePostal($string)
	{ 

		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		//PdfDraw enrichie avec la pattern Decorator mon PDF
		//$draw = new \PDF_Draw($this);
		$cellfit = new \FPDF_CellFit($this);

		 //Position du code poste
		$this->SetXY(102, 67.3);

		//Permet d'espacer les lettres de manière égale
		$cellfit->CellFitSpaceForce(15.5, 10, utf8_decode($string), 0, 0, 'l', 0);

		//Retour à la police normal
		$this->mainFont();
	}


	//Fonction qui représente une zone ciblée concernant l'adresse peut avoir un lieuDit  du destinataire
	function destinataireCommune($string)
	{ 
		$this->SetXY(120, 67.4);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}


	//Fonction qui représente une zone ciblée concernant la ville du destinataire
	function destinataireVille($string)
	{ 
		$this->SetXY(102, 73);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}



	/***************
	* 
	* Gestion de la partie des information général sur le récépissé, en haut à gauche
	*
	************/
	function infoNumTeleservice($string)
	{

		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		$cellfit = new \FPDF_CellFit($this);

		$this->SetXY(54.4, 81);
		$cellfit->CellFitSpaceForce(48.3,10,utf8_decode($string),0,0,'l',0); 

		//Retour à la police normal
		$this->mainFont();
	}

	//Fonction qui représente le numéro de référence de l'exploitant
	function infoRefExploitant($string)
	{
		$this->SetXY(54, 85.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}

	//Fonction qui représente le numéro d'affaire de l'exploitant
	function infoNumeroAffaireDeclarant($string)
	{
		$this->SetXY(54, 89.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}

	//Fonction qui représente la personnea  contacter du déclarant
	function infoPersonneAContacterDeclarant($string)
	{
		$this->SetXY(54, 93.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}

	//Fonction qui représente la date de réception de la déclaration
	function infoDateReceptionDeclaration(\DateTime $date)
	{
		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		$this->SetXY(54, 97.5);
		$this->Cell(200,10,$date->format('d      m      Y'),0,0,'l',0); 

		//Retour à la police normal
		$this->mainFont();
	}

	//Fonction qui représente la commune principale des travaux
	function infoCommunePrincipalTravaux($string)
	{
		$this->SetXY(54, 101.5);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}

	//Fonction qui représente l'adrese des travaux prévus
	function infoAdresseTravauxPrevus($string)
	{
		$this->SetXY(54, 105.5);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}


	/********************
	*
	* Partie 'Coordonnées de l'exploitant'
	*
	********************/ 
	//Raison sociale
	function exploitantRS($string)
	{
		$this->SetXY(128.5, 85.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0);

	}

	//Personne à contacter chez l'exploitant Mairie
	function exploitantPersonneContact($string)
	{
		$this->SetXY(137, 89.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0);

	}

	//Numéro de la voie de l'adresse de l'exploitant Mairie
	function exploitantNumeroVoie($string)
	{
		$this->SetXY(129, 93.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0);

	}

	//Lieu dit/bp de l'adresse de l'exploitant Mairie
	function exploitantLieuDitBp($string)
	{
		$this->SetXY(127, 97.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0);

	}

	//CP de l'adresse de l'exploitant Mairie
	function exploitantCp($string)
	{

		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		//PdfDraw enrichie avec la pattern Decorator mon PDF
		//$draw = new \PDF_Draw($this);
		$cellfit = new \FPDF_CellFit($this);

		 //Position du code poste
		$this->SetXY(141.5, 101);

		//Permet d'espacer les lettres de manière égale
		$cellfit->CellFitSpaceForce(15.5, 10, utf8_decode($string), 0, 0, 'l', 0);

		//Retour à la police normal
		$this->mainFont();

	}


	//Commune de l'adresse de l'exploitant Mairie
	function exploitantCommune($string)
	{
		$this->SetXY(159, 101.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0);
	}



	//Tel de l'exploitant Mairie
	function exploitantTel($string)
	{
		// Helvetica 10
		$this->SetFont('Helvetica',"",10);

		//PdfDraw enrichie avec la pattern Decorator mon PDF
		//$draw = new \PDF_Draw($this); 
		$cellfit = new \FPDF_CellFit($this);

		$this->SetXY(117, 105.3);
		// $this->Cell(113,10,utf8_decode($string),0,0,'l',0);

		//Permet d'espacer les lettres de manière égale
		// Le calcul se fait en divisant la taille de la chaine. Si le numéro est vide, on ne fait rien
		$cellfit->CellFitSpaceForce(30.3, 10, utf8_decode($string), 0, 0, 'l', 0);
		
		//Retour à la police normal
		$this->mainFont();
	}



	//Tel de l'exploitant Mairie
	function exploitantFax($string)
	{
		// Helvetica 10
		$this->SetFont('Helvetica',"",10);


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		//$draw = new \PDF_Draw($this);
		$cellfit = new \FPDF_CellFit($this);

		$this->SetXY(169.3, 105.3);

		//Permet d'espacer les lettres de manière égale
		$cellfit->CellFitSpaceForce(30.3, 10, utf8_decode($string), 0, 0, 'l', 0);
		
		//Retour à la police normal
		$this->mainFont();
	}


	

	//Checkbox qui permet de cocher le fait que la demande est imprécise
	function reponseCheckboxDemandeImprecise()
	{

		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.3, 122, 11.5, 123.8, $style);
		$draw->Line(11.5, 123.8, 12.5, 121.3, $style);
	}

	function reponseCheckboxNonConcerne()
	{
		
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 130.7, 11.5, 132.2, $style);
		$draw->Line(11.5, 132.2, 12.5, 129.9, $style);
	}

	function reponseCheckboxConcerne()
	{
		

		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 134.7, 11.5, 136.2, $style);
		$draw->Line(11.5, 136.2, 12.5, 133.9, $style);
	}


	//Information complémentaire lorsque la demande est imprécise
	function reponseInformationDemandeImprecise($string)
	{
		$this->SetXY(13.3, 121);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0);

	}

	//Information sur la distance lorsque la demande n'est pas concernée
	function reponseDistanceNonConcerne($string)
	{

		// Helvetica 12
		$this->SetFont('Helvetica',"",12);

		$this->SetXY(163, 125);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0);		


		//Retour à la police normal
		$this->mainFont();
	}
	


	//Categorie concernée 
	function reponseCategorieConcernee($categories)
	{
		// Helvetica 12
		$this->SetFont('Helvetica',"",12);

		foreach($categories as $key => $categorie)
	    {

			if($key < 3)
			{
		    	//On rajoute l'écart à key position
				$this->SetXY(110 + ($key * 8), 129.5);
			}
			else
			{
				$this->SetXY(155 + ($key * 8), 130);
			}

			$this->Cell(200,10,utf8_decode($categorie->getCode()),0,0,'l',0);

	    }

		//Retour à la police normal
		$this->mainFont();
	}

	/**
	*
	* Partie 'Modification ou extension de nos réseau ou ouvrage'
	*
	*/ 

	//Modification envisagee
	public function modificationOuvrageEnvisagee($string)
	{

		$this->SetXY(122.8, 141);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}


	//Modification case modification en cours
	public function modificationCheckboxOuvrageEnCours()
	{

		
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 150.5, 11.5, 152, $style);
		$draw->Line(11.5, 152, 12.5, 149.5, $style);
	}

	//Modification contact representant
	public function modificationContactRepresentant($string)
	{

		$this->SetXY(59, 150);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 
	}


	/**
	* Insertion du numéro de téléphone du représentant
	*/
	public function modificationAjouterNumeroRepresentant($string)
	{
		
		// Helvetica 10
		$this->SetFont('Helvetica',"",10);

		
		//PdfDraw enrichie avec la pattern Decorator mon PDF
		//$draw = new \PDF_Draw($this);
		$cellfit = new \FPDF_CellFit($this);


		$this->SetXY(170, 149.5);

		//Permet d'espacer les lettres de manière égale
		$cellfit->CellFitSpaceForce(30.3, 10, utf8_decode($string), 0, 0, 'l', 0);

		//Retour à la police normal
		$this->mainFont();

	}

	/****************
	*
	* Partie Emplacement réseaux et ouvrages
	*
	********************/

	public function reseauCheckboxPlanJoint()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 169.8, 11.5, 171.3, $style);
		$draw->Line(11.5, 171.3, 12.5, 168.8, $style);
	}

	//Fonction qui indique la première référence 
	public function reseauPremiereReference($string)
	{
		$this->SetXY(41.9, 168.6);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 		
	}


	//Fonction qui indique la première échelle 
	public function reseauPremiereEchelle($string)
	{
		$this->SetXY(72, 168.6);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 		
	}

	//Fonction qui représente la date de réception de la déclaration
	function reseauPremiereDateEditionPlan(\DateTime $date)
	{
		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		$this->SetXY(97.3, 168.9);
		$this->Cell(200,10,$date->format('d    m    Y'),0,0,'l',0); 

		//Retour à la police normal
		$this->mainFont();
	}

	//Fonction qui coche si sur le plan la zone est sensible
	public function reseauPremiereCheckboxSensible()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(135.5, 173.2, 136.5, 174.8, $style);
		$draw->Line(136.5, 174.8, 137.5, 172.3, $style);
	}


	//Fonction qui représente la date de réception de la déclaration
	function reseauPremiereProfReglMini($string)
	{
		$this->SetXY(152.1, 168.6);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 		
	}

	//Fonction choix matériaux réseau
	function reseauPremiereMateriaux($string)
	{
		$this->SetXY(177.5, 168.6);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 		
	}

	//Fonction qui indique la première référence 
	public function reseauDeuxiemeReference($string)
	{
		$this->SetXY(41.9, 173.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 		
	}


	//Fonction qui indique la première échelle 
	public function reseauDeuxiemeEchelle($string)
	{
		$this->SetXY(72, 173.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 		
	}

	//Fonction qui représente la date de réception de la déclaration
	function reseauDeuxiemeDateEditionPlan(\DateTime $date)
	{
		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		$this->SetXY(97.3, 173.3);
		$this->Cell(200,10,$date->format('d    m    Y'),0,0,'l',0); 

		//Retour à la police normal
		$this->mainFont();
	}

	//Fonction qui coche si sur le plan la zone est sensible
	public function reseauDeuxiemeCheckboxSensible()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(135.5, 177.7, 136.5, 179.3, $style);
		$draw->Line(136.5, 179.5, 137.5, 176.8, $style);
	}


	//Fonction qui représente la date de réception de la déclaration
	function reseauDeuxiemeProfReglMini($string)
	{
		$this->SetXY(152.1, 173.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 		
	}

	//Fonction choix matériaux réseau
	function reseauDeuxiemeMateriaux($string)
	{
		$this->SetXY(177.5, 173.3);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 		
	}

	//Checkbox réunion de chantier
	public function reseauCheckboxReunionChantier()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 182.2, 11.5, 183.8, $style);
		$draw->Line(11.5, 183.8, 12.5, 181.2, $style);
	}

		//Checkbox réunion de chantier > date sur commun d'accord
	public function reseauCheckboxDateRetenueCommunAccord()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(84, 182.8, 85, 184.4, $style);
		$draw->Line(85, 184.4, 86, 181.8, $style);
	}

		//Réunion de chantier > date - heure sur commun d'accord
	public function reseauDateHeureRetenueCommunAccord(\DateTime $date)
	{
		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		$this->SetXY(129, 177.5);
		$this->Cell(200,10,$date->format('d   m   Y      h    i'),0,0,'l',0); 

		//Retour à la police normal
		$this->mainFont();
	}

	//Checkbox réunion initiative déclarant
	public function reseauCheckboxPriseRendezVousInitiativeDeclarant()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(84, 186.8, 85, 188.4, $style);
		$draw->Line(85, 188.4, 86, 186, $style);
	}

	//réunion initiative déclarant > date - heure
	public function reseauPriseRendezVousInitiativeDeclarant(\DateTime $date)
	{
		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		$this->SetXY(178.6, 181.8);
		$this->Cell(200,10,$date->format('d   m   Y'),0,0,'l',0); 

		//Retour à la police normal
		$this->mainFont();
	}

	//Checkbox servitude
	public function reseauCheckboxTenirCompteServitude()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));

		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 190.7, 11.5, 192.3, $style);
		$draw->Line(11.5, 192.3, 12.5, 189.7, $style);
	}

	//Checkbox investiguation complémentaire
	public function reseauCheckboxRecepisseDtInvestigationComplementaire()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 195.2, 11.5, 196.8, $style);
		$draw->Line(11.5, 196.8, 12.5, 194.2, $style);
	}
	
	//Checkbox branchement
	public function reseauCheckboxBranchementRattache()
	{
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 199.2, 11.5, 200.8, $style);
		$draw->Line(11.5, 200.8, 12.5, 198.2, $style);
	}

	/*******
	*
	* Partie de recommandations sur la sécurité
	*
	*********/
	public function securiteRecommandationTechnique($string)
	{
		$this->SetXY(9, 215.8);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 	

	}


	public function securiteRubriqueGuideTechnique($string)
	{
		$this->SetXY(110.3, 219.8);
		$this->Cell(200,10,utf8_decode($string),0,0,'l',0); 	
	}

	public function securiteMiseHorsTension($bool)
	{
		//Permet de faire un point noir
		$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => null, 
			'color' => array(0, 0, 0));

		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);
		//Cercle classique
		// $draw->Circle(110.3, 219.8, 20);

		//Le premier point sera pour la mise hors tension
		if($bool)
			$draw->Circle(152.1, 229.3, 0.8, 0, 360, 'F', $style);
		else
			$draw->Circle(170.3, 229.3, 0.8, 0, 360, 'F', $style);			
	}

	//Fonction qui permet d'indiquer sur deux ligne les mesure de sécurité à mettre en oeuvre
	public function securiteMesureMettreEnOeuvre($string)
	{
		//On commence à la lettre max de la première ligne qui est 243(taille max en mm) / ((2 (lettre mini) + 3 (lettre maxi)) / 2 (moyenne des deux)) = 97.2
		$maxCharacterePremiereLigne = 105;

		$string1 = "";
		$string2 = "";
		// var_dump(count(str_split($string)));
		
		if(count(str_split($string)) > $maxCharacterePremiereLigne)
		{
			if($string[$maxCharacterePremiereLigne] == " ")
			{
				$string1 = substr($string, 0, $maxCharacterePremiereLigne);
				$string2 = substr($string, $maxCharacterePremiereLigne + 1);
			}
			else
			{
				$espaceTrouve = false;

				//initialisation de l'index
				$i = $maxCharacterePremiereLigne;

				while(!$espaceTrouve && $i > 0)
				{
					//On vérifie si en remontant les lettres on a un espace
					if(substr($string, $i, 1) == " ")
						$espaceTrouve = true;
					else 
						$i--;
				}

				//Si un espace est trouvé, on va garder en taille de la chaine 1, la $i position et la chaine commencerai à cette même position
				if($espaceTrouve)
				{
					$string1 = substr($string, 0, $i);
					$string2 = substr($string, $i);
				}
			}

			//string1 dans la première ligne
			$this->SetXY(61.5, 231);
			$this->Cell(140,4,utf8_decode($string1),0, 0,'l',0); 	


			//string2 dans la deuxième ligne
			$this->SetXY(9, 235);
			$this->Cell(192.5,4,utf8_decode($string2),0, 0,'l',0); 
		}
		else
		{
			//Sinon seul la première ligne existe
			$this->SetXY(61.5, 231);
			$this->Cell(140,4,utf8_decode($string), 0, 0,'l',0); 	
		}

	
	}

	//Fonction qui permet d'indiquer les dispositif de sécurité importants.
	public function securiteDispositifImportant($string)
	{
			//Sinon seul la première ligne existe
			$this->SetXY(64.5, 239.4);
			$this->Cell(140,4,utf8_decode($string), 0, 0,'l',0); 	
	}

	/***********
	*
	* Partie cas de dégradation d'un ouvrage
	*
	******/
	//Numéro de téléphone a contacté en cas de dégradation
	public function degradationNumeroService($string)
	{
		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		$cellfit = new \FPDF_CellFit($this);

		//Sinon seul la première ligne existe
		$this->SetXY(138.3, 246.8);

		//Permet d'espacer les lettres de manière égale
		$cellfit->CellFitSpaceForce(30.3, 10, utf8_decode($string), 0, 0, 'l', 0);

		//Retour à la police normal
		$this->mainFont();
	}


	//Anomalie suceptible de mettre en cause la sécurite
	public function securiteAnomalie($string)
	{
		//Sinon seul la première ligne existe
		$this->SetXY(57, 258);
		$this->Cell(140,4,utf8_decode($string), 0, 0,'l',0); 
	}

	/***********
	*
	* Partie cas 'Responsable du dossier'
	*
	******/
	public function responsableDossierNom($string)
	{
		//Sinon seul la première ligne existe
		$this->SetXY(18.5, 268.3);
		$this->Cell(140,4,utf8_decode($string), 0, 0,'l',0); 

	}

	//NOm du service responsable du dossier
	public function designationService($string)
	{
		//Sinon seul la première ligne existe
		$this->SetXY(40, 272.3);
		$this->Cell(140,4,utf8_decode($string), 0, 0,'l',0); 

	}


	/**
	*
	* CETTE FONCTION EST PLACEE DANS LE FOOTER, CELUI EST DEFINI PAR LA CLASSE MERE A - 1.5 LA Où SE SITUE 
	* LE NUMERO DE TELEPHONE DU RESPONSABLE DU SERVICE. LA FONCTION CELL (ou ici CELLFITSPACEFORCE)
	* REDÉFINIS CEPENDANT CETTE POSITION.
	* 
	* Numéro de téléphone du service responsable du dossier
	*
	*/
	public function responsableNumeroService($string)
	{
		// Helvetica 12
		$this->SetFont('Helvetica',"",10);

		$cellfit = new \FPDF_CellFit($this);

		//Sinon seul la première ligne existe
		$this->SetXY(17, 277);

		//Permet d'espacer les lettres de manière égale
		$cellfit->CellFitSpaceForce(30.3, 5, utf8_decode($string), 0, 0, 'l', 0);

		//Retour à la police normal
		$this->mainFont();
		// Sinon seul la première ligne existe
		// $this->SetXY(15, 272.5);
		// $this->Cell(140,4,utf8_decode($string), 0, 0,'l',0); 
	}

	/***********
	*
	* Partie cas 'Signature exploitant représentant'
	*
	******/
	//Numéro de téléphone du service responsable du dossier
	public function signatureExploitantReprésentant($string)
	{
		$this->SetXY(135, 268.3);
		$this->Cell(140,4,utf8_decode($string), 0, 0,'l',0); 

	}

	/**
	*
	* The footer of FPDF is defined here. I trigger in code whiche instanciate this. 
	*
	*/
    function Footer() 
     {
     	//Le footer comment à -1.5cm de la fin. Le seul moyen de le définir est d'appeler une fonction tel que cell qui insère du contenu.
     	//On va alors appeler celle ci lorsque l'on insère le numéro du responsable du service. En effet, ce numéro ce situe
     	//dans le footer du PDF.
     	$this->responsableNumeroService($this->numServiceResponsable);
     } 

	public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'uploads/pdf';
    }

    public function getUploadRootDir()
    {
        
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }


    /**
    * webPath
    *
    * Cette fonction va nous permettre de récupérer le chemin vers notre fichier
    * 
    * @return chemin de notre fichier de manière relative
    */
    public function getWebPath()
    {
        return $this->getUploadDir() . '/recepisse.pdf';
    }


	/**
	*
	* Lorsque l'on change de police il faut remettre la principale. En effet, il n'y a qu'une seul et même police définissable pour un document
	*
	*/
    public function mainFont()
    {

		$this->SetFont('Helvetica', "", 8);
		$this->SetTextColor(0, 0, 0);
    }
}