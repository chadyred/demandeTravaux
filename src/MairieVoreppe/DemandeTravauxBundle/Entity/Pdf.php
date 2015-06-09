<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;


class Pdf extends \FPDI
{
	
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
	* Cette fonction cochera la case sur le PDF
	*/
	function checkboxTypeDemande($typeDemande)
	{
		$classeTypeDemande = get_class($typeDemande);

		switch($classeTypeDemande)
		{
			case 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux':
			{
				$this->checkboxDemandeDt();

				//TODO : Controle si conjointe avec une DICT
				break;
			}
			case 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT':
			{
				$this->checkboxDemandeDict();

				//TODO : Controle si conjointe avec une DT
				break;
			}
		}

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
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 

	//Fonction qui représente une zone ciblée destinataireComplement
	function destinataireComplement($string)
	{ 
		$this->SetXY(102, 52.5);
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 


	//Fonction qui représente une zone ciblée concernant la rue du destinataire
	function destinataireNumeroRueTravaux($string)
	{ 
		$this->SetXY(102, 57.5);
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 

	//Fonction qui représente une zone ciblée concernant l'adresse peut avoir un lieuDit  du destinataire
	function destinataireLieuDitBp($string)
	{ 

		$this->SetXY(102, 62.5);
		$this->Cell(200,10,$string,0,0,'l',0);
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
		$cellfit->CellFitSpaceForce(15.5, 10, $string, 0, 0, 'l', 0);

		//Retour à la police normal
		$this->mainFont();
	}


	//Fonction qui représente une zone ciblée concernant l'adresse peut avoir un lieuDit  du destinataire
	function destinataireCommune($string)
	{ 
		$this->SetXY(120, 67.4);
		$this->Cell(200,10,$string,0,0,'l',0); 
	}


	//Fonction qui représente une zone ciblée concernant la ville du destinataire
	function destinataireVille($string)
	{ 
		$this->SetXY(102, 73);
		$this->Cell(200,10,$string,0,0,'l',0); 
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
		$cellfit->CellFitSpaceForce(48.3,10,$string,0,0,'l',0); 

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
		$cellfit->CellFitSpaceForce(15.5, 10, $string, 0, 0, 'l', 0);

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
		$cellfit->CellFitSpaceForce(30.3, 10, $string, 0, 0, 'l', 0);
		
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
		$cellfit->CellFitSpaceForce(30.3, 10, $string, 0, 0, 'l', 0);
		
		//Retour à la police normal
		$this->mainFont();
	}


	/**
	*
	* Partie 'Elément généraux de réponse'
	*
	*/ 
	/**
	* Cette fonction cochera la case sur le PDF
	*/
	function reponseCheckboxTypeReponse($typeReponse)
	{
		$classeTypeReponse = get_class($typeReponse);

		switch($classeTypeReponse)
		{
			case 'MairieVoreppe\DemandeTravauxBundle\Entity\Concerne':
			{
				$this->reponseCheckboxConcerne();
				//TODO: Mettre les précisions
				break;
			}
			case 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeImprecise':
			{
				$this->reponseCheckboxDemandeImprecise();
				break;
			}
			case 'MairieVoreppe\DemandeTravauxBundle\Entity\NonConcerne':
			{
				$this->reponseCheckboxNonConcerne();

				break;
			}
		}
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

	function reponseCheckboxConcerne()
	{
		

		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 134.7, 11.5, 136.2, $style);
		$draw->Line(11.5, 136.2, 12.5, 133.9, $style);
	}

	function reponseCheckboxNonConcerne()
	{
		
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));


		//PdfDraw enrichie avec la pattern Decorator mon PDF
		$draw = new \PDF_Draw($this);

		$draw->Line(10.5, 130.7, 11.5, 132.2, $style);
		$draw->Line(11.5, 132.2, 12.5, 129.9, $style);
	}

	
	/**
	*
	* Partie 'Modification ou extension de nos réseau ou ouvrage'
	*
	*/ 
	/**
	* Insertion du numéro de téléphone du représentant
	*/
	public function ajouterNumeroRepresentant($string)
	{
		
		// Helvetica 12
		$this->SetFont('Helvetica',"",12);

		$this->SetXY(170, 150);
		$this->Cell(200,10,$string,0,0,'l',0); 

		//Retour à la police normal
		$this->mainFont();

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