<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//On va utiliser la classe UploadedFile afin de pouvoir étendre nos type à celui des fichier média, en l'occurence
//ici nos images.
use Symfony\Component\HttpFoundation\File\UploadedFile;
//On va mettre le namespace de notre méthode Classe interface Constraints de notre validator
use Symfony\Component\Validator\Constraints as Assert;

//Permet de récupérer les valeur des objets en cours de vie dans notre classe
use Symfony\Component\Validator\ExecutionContextInterface;

use Symfony\Component\HttpFoundation\Response;

/**
 * Logo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\LogoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Logo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     * 
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     * @var string
     * 
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    
    
                          /*******************
                            Upload logo
                            *******************/
   /**
    * @var file
    *
    * Le fichier uploader hydratera cette attribut. Il n'est pas persisté puisuqe l'on en ércupère le nom, l'extension puis on le déplace
    */
    /**
    * @Assert\Image(mimeTypes={"image/png", "image/jpeg"}, 
    *  mimeTypesMessage="Le type du fichier n'est pas le bon. Veuillez mettre une image en .png ou .jpg")
    */
    private $file;

    /**
    *@var tempFilename
    *
    * On ne met pas d'annotation parce que cette attribut ne sera pas persisté.
    * Cette attribut va guarder temporairement le nom. Il sera utilise pour mes évènement doctrine de cycle de vie
    */
    private $tempFilename;

     /**
     * @var Exploitant
     *
     * Je décide de mettre mon entité user comme entité propriétaire. Ainsi pour persisté un logo pour une personne
     * je le fait via l'accesseur 'setAvatar()' de user et ainsi de par l'association tissé entre User et avatar 
     * cette image sera persisté en cascade avec l'utilisateur
     *
     * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant", mappedBy="logo")
     */
    private $exploitant;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Logo
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Logo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Logo
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }
    
         /**
     * Set file
     *
     * @param UploadedFile $file
     * @return Image
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        //Si il y a pas de fichier pour cette entité. 
        if($this->getUrl() != null)
        {
            //On sauvegarde son nom via celui de l'url qui est le nom du fichier parce que ce dernier sera modifier par la suite
            $this->setTempFilename($this->getUrl());

            //On réinitialise les valeur d nos attributs Url et Alt
            $this->setUrl(null);
            $this->setAlt(null);
            $this->setExtension(null);
        } 
        //Sinon on a pas de fichier, tout l'entité est alors instancié comme nouelle entité de avatar sans 
        //persistence existance en BDD
                
        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
    * Set tempFilename
    *
    * @return Image
    */
    public function setTempFilename($tempFilename)
    {
        $this->tempFilename = $tempFilename;

        return $this;
    }

    /**
    * Get tempFilename
    *
    * @return string
    */
    public function getTempFilename()
    {
        return $this->tempFilename;
    }


    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate() 
    */
    public function preUpload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
        if ($this->getFile() == null) 
        {
            return;
        }

        //Je concatène le nom et l'extension
        $nomFichier = $this->getFile()->getClientOriginalName();
        $extensionFichier = $this->getFile()->getClientOriginalExtension();

        // On va recupérer l'extension du fichier
        $this->setExtension($extensionFichier); 

        //On va générer le texte alt de notre balise "<img/>"
        $this->setAlt($nomFichier);

        if($this->getFile() != null)
        {
            //L'ULR sera un identifiant aléatoire et unique
            $idAleatoire = sha1(uniqid(mt_rand(), true));
            $this->setUrl($idAleatoire . '.' . $this->getExtension());
        }


    }

    /**
    * 
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload()
    {

        // Si jamais il n'y a pas de fichier (champ facultatif)
        if ($this->getFile() == null)
        {
            return;
        }
        

        //On déplace notre fichier où ont le désire dans le premier paramêtre, et on le renomme dans le second paramêtre
        //Rappel : $url contient un id aléatoire et unique. Si une erreur survient, celle ci sera lié à la non
        //persistence de celle-ci en base de données 
        
        
        $this->getFile()->move($this->getUploadRootDir(), $this->getUrl());
        chmod($this->getUploadRootDir() . '/' . $this->getUrl(), 0700);
        
        
        //Si on a un nom de fichier temporaire, c'est qu'un fichier existe
        if($this->getTempFilename() != null)
        {
            //On récupère l'ancien nom pour le concaténer avec le chemin relatif racine vers web/uploads/img
            //getUrl contient toujours l'ancienne url
            $ancienFichier= $this->getUploadRootDir().'/'. $this->getTempFilename();

            //Si le fichier existe on le supprime
            if(file_exists($ancienFichier))
            {
                unlink($ancienFichier);
            }

            //On vide le fichier temporaire
            $this->setTempFilename(null);
        }
    }

    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload()
    {
        //On va sauvegarder le chemin et le nom du fichier avant suppression
        $this->setTempFilename($this->getUploadDir().'/'.$this->getUrl());
    }

    /**
    * @ORM\PostRemove()
    */
    public function removeUpload()
    {
        //Ici on a plus accès au nom du fichier, on va alors utiliser le nom du fichier enregistré dans notre tempFileName
        if(file_exists($this->getTempFilename()))
        {
            //On supprime le fichier, puis le répertoire avant de supprimer le répertoire (voir cette foncton astuciese)
            $this->deleteDirectory($this->getUploadRootDir());
        }
    }
    
    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'uploads/logo_exploitant';
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
        return $this->getUploadDir() . '/' . $this->getUrl();
    }

    /**
     * Set mairie
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant $exploitant
     * @return Logo
     */
    public function setMairie(\MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant $exploitant = null)
    {
        $this->exploitant = $exploitant;

        return $this;
    }

    /**
     * Get mairie
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant 
     */
    public function getExploitant()
    {
        return $this->exploitant;
    }  

    /**
     * Set exploitant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant $exploitant
     *
     * @return Logo
     */
    public function setExploitant(\MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant $exploitant = null)
    {
        $this->exploitant = $exploitant;

        return $this;
    }
    
    function deleteDirectory($dir) 
    {
        //Si ce n'est pas un fichier, c'est un dossier. On va alors vider l'ensemble de ses fichiers avec la fonction suivante
        if (!file_exists($dir)) {
            return true;
        }
        
        //Si ce n'est pas un dossier, c'est un fichier on le supprimer
        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            
            //On supprimera les sous dossier avec tout les fichier en exécutant cette fonction
            //de manière récurssive
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }
    
    public function __toString()
    {
        return '<img src="{{ asset("' . $this->getWebPath().'") }}"/>';
    }


  
}
