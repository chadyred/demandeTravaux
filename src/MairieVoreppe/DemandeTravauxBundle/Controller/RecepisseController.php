<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Model\Recepisse;
use MairieVoreppe\DemandeTravauxBundle\Model\Travaux;
use MairieVoreppe\DemandeTravauxBundle\Form\RecepisseType;
use MairieVoreppe\DemandeTravauxBundle\Entity\Pdf;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;

/**
 * Recepisse controller.
 *
 */
class RecepisseController extends Controller
{

    /**
     * Lists all Recepisse entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Recepisse:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    /**
    *
    * Fonction qui permet de générer le PDF relatif au récépissé.
    *
    *
    * @param Travaux $demande: il s'agit de la demande de travaux relative au récépissé
    */
    public function generationFullPdfExemple(Travaux $demande)
    {

       $pdf = new Pdf();
       $phoneUtil = PhoneNumberUtil::getInstance();
        /*
        // Test avant mise en place initiate FPDI
        
        $dt = new \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux();
        $recepisseDT = new \MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT();
        $reponse = new \MairieVoreppe\DemandeTravauxBundle\Entity\NonConcerne();

        $numeroTelephone = "+334 76 91 12 38";

        try {
            $numeroTelephoneProto = $phoneUtil->parse($numeroTelephone, "FR");
            // var_dump($numeroTelephoneProto);
        } catch (\libphonenumber\NumberParseException $e) {
            var_dump($e);
        }

        $recepisseDT->setTelephoneRepresentant($numeroTelephoneProto);
        $recepisseDT->setReponse(null, $reponse);
        $dt->setRecepisseDt($recepisseDT);*/


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
        *
        * Partie récépissé type 
        * 
        */
        $classeTypeDemande = get_class($demande);
        $recepisse = null;

        switch($classeTypeDemande)
        {
            case 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux':
            {

                // On récupère le typpe de récépissé DICT
                $recepisse = $demande->getRecepisseDT();

                /**
                *
                * Une DT/DICT conjointe = adresse d’envoi => celle de la DICT
                *
                */

                //Variable afin de voir si la dt à une dict conjointe. Si c'est cas on récupérera les informations de celle-ci
                $dictConjointe = null;

                if(count($demande->getDicts()) > 0)
                {   
                    foreach($demande->getDicts() as $dict)
                    {
                        if($dict->getDtDictConjointe())
                            $dictConjointe = $dict;
                    }
                }

                //Si la DT n'est conjointe à une DICT, on coche la première case et le destinataire sera celui de la DT
                if($dictConjointe === NULL) {
                    $pdf->checkboxDemandeDt();
                    $destinataireDemande = $demande->getMaitreOuvrage();
                }
                else {
                    $pdf->checkboxDemandeDtDictConjointe();
                    $destinataireDemande = $dictConjointe->getMaitreOeuvre();
                }

                //cas uniquement dans une DT - Partie : Emplaement de nos réseaux / ouvrages
                if($recepisse->getPrevoirInvestiguation())
                    $pdf->reseauCheckboxRecepisseDtInvestigationComplementaire();

                //Le destinataire de la demande est relatif au lien tissé entre une DT avec une DICT : conjointe => le MOE, pas conjointe ou inexistant:
                //Soit un MOA soit un MOE
                $classeTypeDeclarant = get_class($destinataireDemande);

                //Variable qui contiendra le déclarant
                $declarant = "";
                switch($classeTypeDeclarant)
                {
                    //La MOE personne physique existe dans le cas où l'on récupère ls informations de la DICT lorsque la DT est conjointe à celle-ci
                    case 'MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonnePhysique':
                    {
                        /**
                        *
                        * Partie destinataire
                        * Rappel: Une DT/DICT conjointe = adresse d’envoi => celle de la DICT
                        *
                        */

                        //On stock le déclarant
                        $declarant = $destinataireDemande->getMaitreOeuvre()->getCivil();


                        $pdf->destinataireDenomination($declarant);
                        $pdf->destinataireComplement("");

                        $adresse = $destinataireDemande->getMaitreOeuvre()->getCivil()->getAdresse();

                        $pdf->destinataireNumeroRueTravaux($adresse->getAdresseCompleteNumRueAdresse());
                        $pdf->destinataireLieuDitBp($adresse->getLieuDit());
                        $pdf->destinataireCodePostal($adresse->getCp());
                        $pdf->destinataireCommune($adresse->getVille());
                        $pdf->destinataireVille($adresse->getPays());

                        /**
                        *
                        * Partie information général
                        *
                        */
                         // Rappel: DICT conjointe => Lorsque l'on fera DT ce sera son adresse qu'il faudra prendre
                        $pdf->infoNumTeleservice($declarant->getNumeroTeleservice()); 
                        $pdf->infoRefExploitant("");
                        $pdf->infoNumeroAffaireDeclarant("");
                        $pdf->infoPersonneAContacterDeclarant(strtoupper($declarant->getNom()) . ' ' . $declarant->getPrenom());
                        $pdf->infoDateReceptionDeclaration($declarant->getDateReceptionDemande());
                        $pdf->infoCommunePrincipalTravaux($declarant->getAdresses()[0]->getVille());
                        $pdf->infoAdresseTravauxPrevus($declarant->getAdresses()[0]->getAdresseCompleteNumRueAdresse());      




                        break;
                    }
                    case 'MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonnePhysique':
                    {
                        /**
                        *
                        * Partie destinataire
                        * Rappel: Une DT/DICT conjointe = adresse d’envoi => celle de la DICT
                        *
                        */

                        //On stock le déclarant
                        $declarant = $destinataireDemande->getCivil();


                        $pdf->destinataireDenomination($declarant);
                        $pdf->destinataireComplement("");

                        $adresse = $destinataireDemande->getCivil()->getAdresse();

                        if($adresse !== null)
                        {
                            $pdf->destinataireNumeroRueTravaux($adresse->getAdresseCompleteNumRueAdresse());
                            $pdf->destinataireLieuDitBp($adresse->getLieuDit());
                            $pdf->destinataireCodePostal($adresse->getCp());
                            $pdf->destinataireCommune($adresse->getVille());
                            $pdf->destinataireVille($adresse->getPays());
                        }

                        /**
                        *
                        * Partie information général
                        *
                        */
                         // Rappel: DICT conjointe => Lorsque l'on fera DT ce sera son adresse qu'il faudra prendre
                        $pdf->infoNumTeleservice($demande->getNumeroTeleservice()); 
                        $pdf->infoRefExploitant("");
                        $pdf->infoNumeroAffaireDeclarant("");
                        $pdf->infoPersonneAContacterDeclarant(strtoupper($declarant->getNom()) . ' ' . $declarant->getPrenom());
                        $pdf->infoDateReceptionDeclaration($demande->getDateReceptionDemande());
                        $pdf->infoCommunePrincipalTravaux($demande->getAdresses()[0]->getVille());
                        $pdf->infoAdresseTravauxPrevus($demande->getAdresses()[0]->getAdresseCompleteNumRueAdresse());      




                        break;
                    }

                     case 'MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonneMorale':
                    {
                        /**
                        *
                        * Partie destinataire
                        * Rappel: Une DT/DICT conjointe = adresse d’envoi => celle de la DICT
                        *
                        */
                        //On récupère la personne morale
                        $declarantPersonneMorale = $destinataireDemande->getPersonneMorale();

                        //On récupère son type                        
                        $classeTypePersonneMorale = get_class($declarantPersonneMorale);

                        switch($classeTypePersonneMorale)
                        {
                            //S'il s'agit d'une entreprise
                             case 'MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise':
                             {
                                 //On stock le déclarant

                                    $pdf->destinataireDenomination($declarantPersonneMorale->getRaisonSociale());
                                    $pdf->destinataireComplement("");

                                    $adresse = $declarantPersonneMorale->getAdresse();

                                    $pdf->destinataireNumeroRueTravaux($adresse->getAdresseCompleteNumRueAdresse());
                                    $pdf->destinataireLieuDitBp($adresse->getLieuDit());
                                    $pdf->destinataireCodePostal($adresse->getCp());
                                    $pdf->destinataireCommune($adresse->getVille());
                                    $pdf->destinataireVille($adresse->getPays());

                                    /**
                                    *
                                    * Partie information général
                                    *
                                    */
                                     // Rappel: DICT conjointe => Lorsque l'on fera DT ce sera son adresse qu'il faudra prendre
                                    $pdf->infoNumTeleservice($demande->getNumeroTeleservice()); 
                                    $pdf->infoRefExploitant("");
                                    $pdf->infoNumeroAffaireDeclarant("");

                                    //TODO : les personnes à contacter peuvent être nombreuse. On prend la première de la pile. S'il n'y en a pas on prend le gérant.
                                    if(count($demande->getContactsUrgent()) > 0)
                                    {
                                        $pdf->infoPersonneAContacterDeclarant(strtoupper($demande->getContactsUrgent()[0]->getNom()) . ' ' . $demande->getContactsUrgent()[0]->getPrenom());
                                    }
                                    else
                                    {
                                        $pdf->infoPersonneAContacterDeclarant(strtoupper($declarantPersonneMorale->getGerant()->getNom()) . ' ' . $declarantPersonneMorale->getGerant()->getPrenom());
                                    }
                                        
                                    $pdf->infoDateReceptionDeclaration($demande->getDateReceptionDemande());
                                    $pdf->infoCommunePrincipalTravaux($demande->getAdresses()[0]->getVille());
                                    $pdf->infoAdresseTravauxPrevus($demande->getAdresses()[0]->getAdresseCompleteNumRueAdresse());  

                                    break;
                             }
                             default:
                             {
                                echo "C'est un personne morale mais le type n'a pas pu être déterminé !";
                                break;
                             }

                        } 

                        break;
                    }
                }

                 break;
            }
            case 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT':
            {
                // On récupère le typpe de récépissé DICT
                $recepisse = $demande->getRecepisseDICT();

                //On coche le type de demande
                if($demande->getDtDictConjointe())
                    $pdf->checkboxDemandeDtDictConjointe();
                else
                    $pdf->checkboxDemandeDict();


                //On récupère le déclarant qui est forcement un maître d'oeuvre
                $classeTypeDeclarant = get_class($demande->getEntreprise());

                //Variable qui contiendra le déclarant
                $declarant = "";

                switch($classeTypeDeclarant)
                {
                    case 'MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonnePhysique':
                    {
                        /**
                        *
                        * Partie destinataire
                        * Rappel: Une DT/DICT conjointe = adresse d’envoi => celle de la DICT
                        *
                        */

                        //On stock le déclarant
                        $declarant = $demande->getMaitreOeuvre()->getCivil();


                        $pdf->destinataireDenomination($declarant);
                        $pdf->destinataireComplement("");

                        $adresse = $demande->getMaitreOeuvre()->getCivil()->getAdresse();

                        $pdf->destinataireNumeroRueTravaux($adresse->getAdresseCompleteNumRueAdresse());
                        $pdf->destinataireLieuDitBp($adresse->getLieuDit());
                        $pdf->destinataireCodePostal($adresse->getCp());
                        $pdf->destinataireCommune($adresse->getVille());
                        $pdf->destinataireVille($adresse->getPays());

                        /**
                        *
                        * Partie information général
                        *
                        */
                         // Rappel: DICT conjointe => Lorsque l'on fera DT ce sera son adresse qu'il faudra prendre
                        $pdf->infoNumTeleservice($demande->getNumeroTeleservice()); 
                        $pdf->infoRefExploitant("");
                        $pdf->infoNumeroAffaireDeclarant("");
                        $pdf->infoPersonneAContacterDeclarant(strtoupper($declarant->getNom()) . ' ' . $declarant->getPrenom());
                        $pdf->infoDateReceptionDeclaration($demande->getDateReceptionDemande());
                        $pdf->infoCommunePrincipalTravaux($demande->getAdresses()[0]->getVille());
                        $pdf->infoAdresseTravauxPrevus($demande->getAdresses()[0]->getAdresseCompleteNumRueAdresse());

                        break;
                    }
                    //Une MOE Persoone morale est forcement une entreprise
                    case 'MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale':
                    {
                         //On récupère la personne morale
                        $declarantPersonneMorale = $demande->getMaitreOeuvre()->getEntreprise();

                        //On récupère son type                        
                        $classeTypePersonneMorale = get_class($declarantPersonneMorale);

                        //On stock le déclarant

                        $pdf->destinataireDenomination($declarantPersonneMorale->getRaisonSociale());
                        $pdf->destinataireComplement("");

                        $adresse = $declarantPersonneMorale->getAdresse();

                        $pdf->destinataireNumeroRueTravaux($adresse->getAdresseCompleteNumRueAdresse());
                        $pdf->destinataireLieuDitBp($adresse->getLieuDit());
                        $pdf->destinataireCodePostal($adresse->getCp());
                        $pdf->destinataireCommune($adresse->getVille());
                        $pdf->destinataireVille($adresse->getPays());

                        /**
                        *
                        * Partie information général
                        *
                        */
                         // Rappel: DICT conjointe => Lorsque l'on fera DT ce sera son adresse qu'il faudra prendre
                        $pdf->infoNumTeleservice($demande->getNumeroTeleservice()); 
                        $pdf->infoRefExploitant("");
                        $pdf->infoNumeroAffaireDeclarant("");

                        //TODO : les personnes à contacter peuvent être nombreuse. On prend la première de la pile. S'il n'y en a pas on prend le gérant.
                        if(count($demande->getContactsUrgent()) > 0)
                        {
                            $pdf->infoPersonneAContacterDeclarant(strtoupper($demande->getContactsUrgent()[0]->getNom()) . ' ' . $demande->getContactsUrgent()[0]->getPrenom());
                        }
                        else
                        {
                            $pdf->infoPersonneAContacterDeclarant(strtoupper($declarantPersonneMorale->getGerant()->getNom()) . ' ' . $declarantPersonneMorale->getGerant()->getPrenom());
                        }
                            
                        $pdf->infoDateReceptionDeclaration($demande->getDateReceptionDemande());
                        $pdf->infoCommunePrincipalTravaux($demande->getAdresses()[0]->getVille());
                        $pdf->infoAdresseTravauxPrevus($demande->getAdresses()[0]->getAdresseCompleteNumRueAdresse());  

                   
                        break;
                    }
                
                }
                break;
            }// -- Fin du case DICT
        }

        
          /**
        *
        * Partie exploitant
        *
        */
        //DO : remplacer mairie par exploitant.
        $exploitant = $demande->getServiceExploitant()->getExploitant();
        $pdf->exploitantRS($exploitant->getRaisonSociale());

        //Personne à contacté: l'utilisateur qui a créé le travaux. Seul l'administrateur peut changer ce dernier.
        $pdf->exploitantPersonneContact($demande->getUser());

        $adresseExploitant = $exploitant->getAdresse();

        $pdf->exploitantNumeroVoie($adresseExploitant->getAdresseCompleteNumRueAdresse());

        //TODO: Le BP n'est pas encore géré
        $pdf->exploitantLieuDitBp($adresseExploitant->getLieuDit());
        $pdf->exploitantCp($adresseExploitant->getCp());
        $pdf->exploitantCommune($adresseExploitant->getVille());

        /**
        *
        * libphonenumber est une bibliothèque bien répendu. On va rendre le noméro préfixé ou non par +33 4 en 04
        *
        */
        if($exploitant->getTelFixe() != null)
            $pdf->exploitantTel($phoneUtil->format($exploitant->getTelFixe(), \libphonenumber\PhoneNumberFormat::NATIONAL));

        if($exploitant->getTelFax() != null)
            $pdf->exploitantFax($phoneUtil->format($exploitant->getTelFax(), \libphonenumber\PhoneNumberFormat::NATIONAL));

        /**
        *
        * Partie réponse
        *
        */
        $this->gestionReponse($recepisse->getReponse()[0], $pdf);      

       

        //Partie 'Modification ou extension de nos réseau ou ouvrage'
        $pdf->modificationOuvrageEnvisagee($recepisse->getExtensionPrevue());

        //On vérifie si des modification sont en cours
        if($recepisse->getModificationEnCours())
            $pdf->modificationCheckboxOuvrageEnCours();

        $pdf->modificationContactRepresentant($recepisse->getNomRepresentant());

        if($recepisse->getTelephoneRepresentant() !== null)
            $pdf->modificationAjouterNumeroRepresentant($phoneUtil->format($recepisse->getTelephoneRepresentant(), \libphonenumber\PhoneNumberFormat::NATIONAL));
        
        //Partie Emplacement réseaux et ouvrages
        if($recepisse->getPlanJoint())
            $pdf->reseauCheckboxPlanJoint();

        //On récupère les deux ligne des emplacement réseau et ouvrage
        $ero1 = $recepisse->getEmplacementsReseauOuvrage()[0];
        $ero2 = $recepisse->getEmplacementsReseauOuvrage()[1];

        //Première ligne
        if($ero1 !== null)
        {
            $pdf->reseauPremiereReference($ero1->getReference());
            $pdf->reseauPremiereEchelle($ero1->getEchelle());
            $ero1->getDateEdition() != NULL ? $pdf->reseauPremiereDateEditionPlan($ero1->getDateEdition()) : "";
            if($ero1->getSensible())
                $pdf->reseauPremiereCheckboxSensible();
            $pdf->reseauPremiereProfReglMini($ero1->getProfondeurReglMini());
            $pdf->reseauPremiereMateriaux($ero1->getMateriauxReseau());
        }

        //Deuxième ligne
        if($ero2 !== null)
        {
            $pdf->reseauDeuxiemeReference($ero2->getReference());
            $pdf->reseauDeuxiemeEchelle($ero2->getEchelle());
            $pdf->reseauDeuxiemeDateEditionPlan($ero2->getDateEdition());
            
            if($ero2->getSensible())
                $pdf->reseauDeuxiemeCheckboxSensible();

            $pdf->reseauDeuxiemeProfReglMini($ero2->getProfondeurReglMini());
            $pdf->reseauDeuxiemeMateriaux($ero2->getMateriauxReseau());
        }

        //Gestion des rendez-vous
        if($recepisse->getPriseRendezVous())
            $pdf->reseauCheckboxReunionChantier();

        //Rapel:  le bundle infinite bundle retourne un tableau
        $this->gestionRdv($recepisse->getRendezVous()[0], $pdf);

        if($recepisse->getPrendreEnCompteServitude())
            $pdf->reseauCheckboxTenirCompteServitude();

        if($recepisse->getBranchementRattache())
            $pdf->reseauCheckboxBranchementRattache();

        //Partie sur les recommandations de sécurité
        $pdf->securiteRecommandationTechnique($recepisse->getRecommandationSecurite());
        $pdf->securiteRubriqueGuideTechnique($recepisse->getRubriqueGuideTechSecurite());
        $pdf->securiteMesureMettreEnOeuvre($recepisse->getMesureSecurite());

        if($recepisse->getDispositifSecurite() != null)
            $pdf->securiteDispositifImportant($recepisse->getDispositifSecurite()->getDescription());

        //gestion de la mise hors tension
        $recepisse->getMiseHorsTension()->getLibelle() == "Possible" ? $mht = true : $mht = false;
        $pdf->securiteMiseHorsTension($mht);

        //Partie dégradation
        if($recepisse->getTelServiceDegradation() !== null)
            $pdf->degradationNumeroService($phoneUtil->format($recepisse->getTelServiceDegradation(), \libphonenumber\PhoneNumberFormat::NATIONAL));

        $pdf->securiteAnomalie($recepisse->getServiceDepartementIncendieSecours());

        //Partie responsable projet
        $pdf->responsableDossierNom($demande->getUser());
        $pdf->designationService($demande->getServiceExploitant()->getService()->getName());
        //Dans le FOSUSerBundle, le téléphone est définis comme un simple champs de type chaine.
        $pdf->numServiceResponsable = $demande->getUser()->getPhone();

        //Partie signature
        // $pdf->signatureExploitantReprésentant("signatureExploitantReprésentant");


        $pdf->Output();
    }

    /**
    *
    * Partie 'Elément généraux de réponse'
    *
    */ 
    /**
    * Cette fonction cochera la case sur le PDF selon la réponse choisi et personnaliser les données correspondantes.
    */
    function gestionReponse($reponse, $pdf)
    {
        $classeTypeReponse = get_class($reponse);

        switch($classeTypeReponse)
        {
            case 'MairieVoreppe\DemandeTravauxBundle\Entity\Concerne':
            {
                $pdf->reponseCheckboxConcerne();
                //TODO: Mettre les précisions

                $categories = $reponse->getCategorieReseauOuvrage();
                $pdf->reponseCategorieConcernee($categories);
                break;
            }
            case 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeImprecise':
            {
                $pdf->reponseCheckboxDemandeImprecise();

                $pdf->reponseInformationDemandeImprecise($reponse->getDescription());
                break;
            }
            case 'MairieVoreppe\DemandeTravauxBundle\Entity\NonConcerne':
            {
                $pdf->reponseCheckboxNonConcerne();

                $pdf->reponseDistanceNonConcerne($reponse->getDistanceNc());
                break;
            }
        }
    }

    /**
    * Fonction qui va cocher la case des rendez-vous avec les informations complémentaires.
    */
    function gestionRdv($rdv, $pdf)
    {
        $classeTypeRdv = get_class($rdv);

        switch($classeTypeRdv)
        {
            case 'MairieVoreppe\DemandeTravauxBundle\Entity\InitiativeDeclarant':
            {
                $pdf->reseauCheckboxPriseRendezVousInitiativeDeclarant();
                //TODO: Mettre les précisions

                $pdf->reseauPriseRendezVousInitiativeDeclarant($rdv->getDateRetenue());
                break;
            }
            case 'MairieVoreppe\DemandeTravauxBundle\Entity\CommunAccord':
            {
                $pdf->reseauCheckboxDateRetenueCommunAccord();

                
                 $pdf->reseauDateHeureRetenueCommunAccord($rdv->getDateRetenue()); 
                break;
            }
        }
    }
}
