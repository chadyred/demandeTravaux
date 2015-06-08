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
		$this->SetXY(102, 47);
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 

	//Fonction qui représente une zone ciblée destinataireComplement
	function destinataireComplement($string)
	{ 
		$this->SetXY(102, 52);
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 


	//Fonction qui représente une zone ciblée concernant la rue du destinataire
	function destinataireNumeroRueTravaux($string)
	{ 
		$this->SetXY(102, 57);
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 

	//Fonction qui représente une zone ciblée concernant l'adresse peut avoir un lieuDit  du destinataire
	function destinataireLieuDitBp($string)
	{ 

		$this->SetXY(102, 62);
		$this->Cell(200,10,$string,0,0,'l',0); 
	} 

	//Fonction qui représente une zone ciblée concernant le code postale de l'adresse   du destinataire
	function destinataireCodePostal($string)
	{ 

		// Helvetica 12
		$this->SetFont('Helvetica',"",12);

		//-1 signifie aucune limite, PREG_SPLIT_NO_EMPTY retourne que ce qui n'est pas vide
		$chars = preg_split('//', $string, -1, PREG_SPLIT_NO_EMPTY);

		//Chaine vide qui comportera le code postale final
		$codePostale = "";

		$cellfit = new \FPDF_CellFit();

		//PArcours des lettre
		for($i = 0;$i < count($chars);$i++)
		{
			//Je met un espace après les deux premier charactères
			if($i != 0)
				$codePostale .= " " . $chars[$i];
			else
				$codePostale .= $chars[$i];
		}


		$this->SetXY(102, 67);
		// $this->Cell(200,10,$codePostale,0,0,'l',0); 
		$cellfit->CellFitSpaceForce(200,10,$codePostale,1,1,'',1);

		//Retour à la police normal
		$this->mainFont();
	}


	//Fonction qui représente une zone ciblée concernant l'adresse peut avoir un lieuDit  du destinataire
	function destinataireCommune($string)
	{ 
		$this->SetXY(120, 67);
		$this->Cell(200,10,$string,0,0,'l',0); 
	}

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