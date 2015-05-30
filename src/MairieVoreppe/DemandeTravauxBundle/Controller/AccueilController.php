<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MairieVoreppe\DemandeTravauxBundle\Entity\Pdf;

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
		$recepisseDT = new \MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT();
		$recepisseDT->setTelephoneRepresentant('+33476932334');



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

		$pdf->ajouterNumeroRepresentant($recepisseDT->getTelephoneRepresentant());
		
		//TODO : il faut plutot envoyé la dict directement et identifier son type
		$pdf->checkboxTypeDemande(get_class($dict));
		$pdf->destinataireDenomination("Zone destinataire>denomination");
		$pdf->destinataireComplement("Zone destinataire>complement");


		$pdf->Output();
	}

	
}
