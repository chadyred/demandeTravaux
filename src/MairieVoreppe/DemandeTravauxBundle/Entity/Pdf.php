<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

class Pdf extends \FPDI
{

	//Fonction qui représente une zone ciblée destinataireDenomination
	function destinataireDenomination($string)
	{ 

		// Décalage de 10 cm vers la droite et 40 vers le bas
		$this->SetXY(102, 47);
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 

	//Fonction qui représente une zone ciblée destinataireComplement
	function destinataireComplement($string)
	{ 
		// Décalage de 8 cm à droite
		$this->SetXY(102, 52);
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 

	
	/**
	* Checkbox qui cochera la demande
	*/
	function checkboxDemandeDt()
	{

		$style = array('width' => 0.75, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));

		$this->Line(11.3, 55.8, 13, 58.5, $style);
		$this->Line(13, 58.5, 15, 54.5, $style);
	}

	/**
	* Checkbox qui cochera la demande
	*/
	function checkboxDemandeDict()
	{

		$style = array('width' => 0.75, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));

		$this->Line(11.3, 62.8, 13, 65.5, $style);
		$this->Line(13, 65.5, 15, 61.5, $style);
	}

	/**
	* Checkbox qui cochera la demande
	*/
	function checkboxDemandeDtDictConjointe()
	{

		
		$style = array('width' => 0.75, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));

		$this->Line(11.3, 69.8, 13, 72.5, $style);
		$this->Line(13, 72.5, 15, 68.5, $style);
	}

	/**
	* Cette fonction cochera la case sur le PDF
	*/
	function checkboxTypeDemande($classeTypeDemande)
	{

		switch($classeTypeDemande)
		{
			case 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux':
			{
				$this->checkboxDemandeDt();
				break;
			}
			case 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT':
			{
				$this->checkboxDemandeDict();
				break;
			}
		}

	}

	/**
	* Insertion du numéro de téléphone du représentant
	*/
	public function ajouterNumeroRepresentant($string)
	{
		// Décalage de 8 cm à droite
		$this->SetXY(105, 150);
		$this->Cell(200,10,$string,0,0,'l',0); 
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


}