<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FollowUpExport
 *
 * @ORM\Table(name="follow_up_export")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FollowUpExportRepository")
 */
class FollowUpExport
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="filleul_nom", type="string", length=255, nullable=true)
     */
    private $filleulNom;

    /**
     * @var string
     *
     * @ORM\Column(name="filleul_prenom", type="string", length=255, nullable=true)
     */
    private $filleulPrenom;

    /**
     * @var string
     *
     * @ORM\Column(name="filleul_sexe", type="string", length=255, nullable=true)
     */
    private $filleulSexe;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_parrainage", type="string", length=255, nullable=true)
     */
    private $statutParrainage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="filleul_date_de_naissance", type="datetimetz", nullable=true)
     */
    private $filleulDateDeNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="filleul_adresse", type="text", nullable=true)
     */
    private $filleulAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="filleul_ecole", type="string", length=255, nullable=true)
     */
    private $filleulEcole;

    /**
     * @var string
     *
     * @ORM\Column(name="filleul_classe", type="string", length=255, nullable=true)
     */
    private $filleulClasse;

    /**
     * @var string
     *
     * @ORM\Column(name="filleul_situation_familiale", type="text", nullable=true)
     */
    private $filleulSituationFamiliale;

    /**
     * @var string
     *
     * @ORM\Column(name="coordinateur", type="string", length=255, nullable=true)
     */
    private $coordinateur;

    /**
     * @var string
     *
     * @ORM\Column(name="type_parrainage", type="string", length=255, nullable=true)
     */
    private $typeParrainage;

    /**
     * @var string
     *
     * @ORM\Column(name="parrain_nom", type="string", length=255, nullable=true)
     */
    private $parrainNom;

    /**
     * @var string
     *
     * @ORM\Column(name="parrain_prenom", type="string", length=255, nullable=true)
     */
    private $parrainPrenom;

    /**
     * @var string
     *
     * @ORM\Column(name="parrain_adresse", type="text", nullable=true)
     */
    private $parrainAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="parrain_telephone", type="string", length=255, nullable=true)
     */
    private $parrainTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="parrain_email", type="string", length=255, nullable=true)
     */
    private $parrainEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="parrain_mode_de_versement", type="string", length=255, nullable=true)
     */
    private $parrainModeDeVersement;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="text", nullable=true)
     */
    private $remarque;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_janvier", type="string", length=255, nullable=true)
     */
    private $suiviJanvier;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_fevrier", type="string", length=255, nullable=true)
     */
    private $suiviFevrier;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mars", type="string", length=255, nullable=true)
     */
    private $suiviMars;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_avril", type="string", length=255, nullable=true)
     */
    private $suiviAvril;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mai", type="string", length=255, nullable=true)
     */
    private $suiviMai;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juin", type="string", length=255, nullable=true)
     */
    private $suiviJuin;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juillet", type="string", length=255, nullable=true)
     */
    private $suiviJuillet;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_aout", type="string", length=255, nullable=true)
     */
    private $suiviAout;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_septembre", type="string", length=255, nullable=true)
     */
    private $suiviSeptembre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_octobre", type="string", length=255, nullable=true)
     */
    private $suiviOctobre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_novembre", type="string", length=255, nullable=true)
     */
    private $suiviNovembre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_decembre", type="string", length=255, nullable=true)
     */
    private $suiviDecembre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_octobre_lettre", type="string", length=255, nullable=true)
     */
    private $suiviOctobreLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_novembre_lettre", type="string", length=255, nullable=true)
     */
    private $suiviNovembreLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_decembre_lettre", type="string", length=255, nullable=true)
     */
    private $suiviDecembreLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_janvier_lettre", type="string", length=255, nullable=true)
     */
    private $suiviJanvierLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_fevrier_lettre", type="string", length=255, nullable=true)
     */
    private $suiviFevrierLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mars_lettre", type="string", length=255, nullable=true)
     */
    private $suiviMarsLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_avril_lettre", type="string", length=255, nullable=true)
     */
    private $suiviAvrilLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mai_lettre", type="string", length=255, nullable=true)
     */
    private $suiviMaiLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juin_lettre", type="string", length=255, nullable=true)
     */
    private $suiviJuinLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juillet_lettre", type="string", length=255, nullable=true)
     */
    private $suiviJuilletLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_aout_lettre", type="string", length=255, nullable=true)
     */
    private $suiviAoutLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_septembre_lettre", type="string", length=255, nullable=true)
     */
    private $suiviSeptembreLettre;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_octobre_photo", type="string", length=255, nullable=true)
     */
    private $suiviOctobrePhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_novembre_photo", type="string", length=255, nullable=true)
     */
    private $suiviNovembrePhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_decembre_photo", type="string", length=255, nullable=true)
     */
    private $suiviDecembrePhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_janvier_photo", type="string", length=255, nullable=true)
     */
    private $suiviJanvierPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_fevrier_photo", type="string", length=255, nullable=true)
     */
    private $suiviFevrierPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mars_photo", type="string", length=255, nullable=true)
     */
    private $suiviMarsPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_avril_photo", type="string", length=255, nullable=true)
     */
    private $suiviAvrilPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mai_photo", type="string", length=255, nullable=true)
     */
    private $suiviMaiPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juin_photo", type="string", length=255, nullable=true)
     */
    private $suiviJuinPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juillet_photo", type="string", length=255, nullable=true)
     */
    private $suiviJuilletPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_aout_photo", type="string", length=255, nullable=true)
     */
    private $suiviAoutPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_septembre_photo", type="string", length=255, nullable=true)
     */
    private $suiviSeptembrePhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_octobre_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviOctobreNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_novembre_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviNovembreNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_decembre_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviDecembreNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_janvier_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviJanvierNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_fevrier_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviFevrierNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mars_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviMarsNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_avril_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviAvrilNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mai_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviMaiNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juin_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviJuinNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juillet_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviJuilletNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_aout_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviAoutNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_septembre_nouvelle", type="string", length=255, nullable=true)
     */
    private $suiviSeptembreNouvelle;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_octobre_resultat", type="string", length=255, nullable=true)
     */
    private $suiviOctobreResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_novembre_resultat", type="string", length=255, nullable=true)
     */
    private $suiviNovembreResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_decembre_resultat", type="string", length=255, nullable=true)
     */
    private $suiviDecembreResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_janvier_resultat", type="string", length=255, nullable=true)
     */
    private $suiviJanvierResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_fevrier_resultat", type="string", length=255, nullable=true)
     */
    private $suiviFevrierResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mars_resultat", type="string", length=255, nullable=true)
     */
    private $suiviMarsResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_avril_resultat", type="string", length=255, nullable=true)
     */
    private $suiviAvrilResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_mai_resultat", type="string", length=255, nullable=true)
     */
    private $suiviMaiResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juin_resultat", type="string", length=255, nullable=true)
     */
    private $suiviJuinResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_juillet_resultat", type="string", length=255, nullable=true)
     */
    private $suiviJuilletResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_aout_resultat", type="string", length=255, nullable=true)
     */
    private $suiviAoutResultat;

    /**
     * @var string
     *
     * @ORM\Column(name="suivi_septembre_resultat", type="string", length=255, nullable=true)
     */
    private $suiviSeptembreResultat;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set filleulNom
     *
     * @param string $filleulNom
     *
     * @return FollowUpExport
     */
    public function setFilleulNom($filleulNom)
    {
        $this->filleulNom = $filleulNom;

        return $this;
    }

    /**
     * Get filleulNom
     *
     * @return string
     */
    public function getFilleulNom()
    {
        return $this->filleulNom;
    }

    /**
     * Set filleulPrenom
     *
     * @param string $filleulPrenom
     *
     * @return FollowUpExport
     */
    public function setFilleulPrenom($filleulPrenom)
    {
        $this->filleulPrenom = $filleulPrenom;

        return $this;
    }

    /**
     * Get filleulPrenom
     *
     * @return string
     */
    public function getFilleulPrenom()
    {
        return $this->filleulPrenom;
    }

    /**
     * Set filleulSexe
     *
     * @param string $filleulSexe
     *
     * @return FollowUpExport
     */
    public function setFilleulSexe($filleulSexe)
    {
        $this->filleulSexe = $filleulSexe;

        return $this;
    }

    /**
     * Get filleulSexe
     *
     * @return string
     */
    public function getFilleulSexe()
    {
        return $this->filleulSexe;
    }

    /**
     * Set statutParrainage
     *
     * @param string $statutParrainage
     *
     * @return FollowUpExport
     */
    public function setStatutParrainage($statutParrainage)
    {
        $this->statutParrainage = $statutParrainage;

        return $this;
    }

    /**
     * Get statutParrainage
     *
     * @return string
     */
    public function getStatutParrainage()
    {
        return $this->statutParrainage;
    }

    /**
     * Set filleulDateDeNaissance
     *
     * @param \DateTime $filleulDateDeNaissance
     *
     * @return FollowUpExport
     */
    public function setFilleulDateDeNaissance($filleulDateDeNaissance)
    {
        $this->filleulDateDeNaissance = $filleulDateDeNaissance;

        return $this;
    }

    /**
     * Get filleulDateDeNaissance
     *
     * @return \DateTime
     */
    public function getFilleulDateDeNaissance()
    {
        return $this->filleulDateDeNaissance;
    }

    /**
     * Set filleulAdresse
     *
     * @param string $filleulAdresse
     *
     * @return FollowUpExport
     */
    public function setFilleulAdresse($filleulAdresse)
    {
        $this->filleulAdresse = $filleulAdresse;

        return $this;
    }

    /**
     * Get filleulAdresse
     *
     * @return string
     */
    public function getFilleulAdresse()
    {
        return $this->filleulAdresse;
    }

    /**
     * Set filleulEcole
     *
     * @param string $filleulEcole
     *
     * @return FollowUpExport
     */
    public function setFilleulEcole($filleulEcole)
    {
        $this->filleulEcole = $filleulEcole;

        return $this;
    }

    /**
     * Get filleulEcole
     *
     * @return string
     */
    public function getFilleulEcole()
    {
        return $this->filleulEcole;
    }

    /**
     * Set filleulClasse
     *
     * @param string $filleulClasse
     *
     * @return FollowUpExport
     */
    public function setFilleulClasse($filleulClasse)
    {
        $this->filleulClasse = $filleulClasse;

        return $this;
    }

    /**
     * Get filleulClasse
     *
     * @return string
     */
    public function getFilleulClasse()
    {
        return $this->filleulClasse;
    }

    /**
     * Set filleulSituationFamiliale
     *
     * @param string $filleulSituationFamiliale
     *
     * @return FollowUpExport
     */
    public function setFilleulSituationFamiliale($filleulSituationFamiliale)
    {
        $this->filleulSituationFamiliale = $filleulSituationFamiliale;

        return $this;
    }

    /**
     * Get filleulSituationFamiliale
     *
     * @return string
     */
    public function getFilleulSituationFamiliale()
    {
        return $this->filleulSituationFamiliale;
    }

    /**
     * Set coordinateur
     *
     * @param string $coordinateur
     *
     * @return FollowUpExport
     */
    public function setCoordinateur($coordinateur)
    {
        $this->coordinateur = $coordinateur;

        return $this;
    }

    /**
     * Get coordinateur
     *
     * @return string
     */
    public function getCoordinateur()
    {
        return $this->coordinateur;
    }

    /**
     * Set typeParrainage
     *
     * @param string $typeParrainage
     *
     * @return FollowUpExport
     */
    public function setTypeParrainage($typeParrainage)
    {
        $this->typeParrainage = $typeParrainage;

        return $this;
    }

    /**
     * Get typeParrainage
     *
     * @return string
     */
    public function getTypeParrainage()
    {
        return $this->typeParrainage;
    }

    /**
     * Set parrainNom
     *
     * @param string $parrainNom
     *
     * @return FollowUpExport
     */
    public function setParrainNom($parrainNom)
    {
        $this->parrainNom = $parrainNom;

        return $this;
    }

    /**
     * Get parrainNom
     *
     * @return string
     */
    public function getParrainNom()
    {
        return $this->parrainNom;
    }

    /**
     * Set parrainPrenom
     *
     * @param string $parrainPrenom
     *
     * @return FollowUpExport
     */
    public function setParrainPrenom($parrainPrenom)
    {
        $this->parrainPrenom = $parrainPrenom;

        return $this;
    }

    /**
     * Get parrainPrenom
     *
     * @return string
     */
    public function getParrainPrenom()
    {
        return $this->parrainPrenom;
    }

    /**
     * Set parrainAdresse
     *
     * @param string $parrainAdresse
     *
     * @return FollowUpExport
     */
    public function setParrainAdresse($parrainAdresse)
    {
        $this->parrainAdresse = $parrainAdresse;

        return $this;
    }

    /**
     * Get parrainAdresse
     *
     * @return string
     */
    public function getParrainAdresse()
    {
        return $this->parrainAdresse;
    }

    /**
     * Set parrainTelephone
     *
     * @param string $parrainTelephone
     *
     * @return FollowUpExport
     */
    public function setParrainTelephone($parrainTelephone)
    {
        $this->parrainTelephone = $parrainTelephone;

        return $this;
    }

    /**
     * Get parrainTelephone
     *
     * @return string
     */
    public function getParrainTelephone()
    {
        return $this->parrainTelephone;
    }

    /**
     * Set parrainEmail
     *
     * @param string $parrainEmail
     *
     * @return FollowUpExport
     */
    public function setParrainEmail($parrainEmail)
    {
        $this->parrainEmail = $parrainEmail;

        return $this;
    }

    /**
     * Get parrainEmail
     *
     * @return string
     */
    public function getParrainEmail()
    {
        return $this->parrainEmail;
    }

    /**
     * Set parrainModeDeVersement
     *
     * @param string $parrainModeDeVersement
     *
     * @return FollowUpExport
     */
    public function setParrainModeDeVersement($parrainModeDeVersement)
    {
        $this->parrainModeDeVersement = $parrainModeDeVersement;

        return $this;
    }

    /**
     * Get parrainModeDeVersement
     *
     * @return string
     */
    public function getParrainModeDeVersement()
    {
        return $this->parrainModeDeVersement;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     *
     * @return FollowUpExport
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * Set suiviJanvier
     *
     * @param string $suiviJanvier
     *
     * @return FollowUpExport
     */
    public function setSuiviJanvier($suiviJanvier)
    {
        $this->suiviJanvier = $suiviJanvier;

        return $this;
    }

    /**
     * Get suiviJanvier
     *
     * @return string
     */
    public function getSuiviJanvier()
    {
        return $this->suiviJanvier;
    }

    /**
     * Set suiviFevrier
     *
     * @param string $suiviFevrier
     *
     * @return FollowUpExport
     */
    public function setSuiviFevrier($suiviFevrier)
    {
        $this->suiviFevrier = $suiviFevrier;

        return $this;
    }

    /**
     * Get suiviFevrier
     *
     * @return string
     */
    public function getSuiviFevrier()
    {
        return $this->suiviFevrier;
    }

    /**
     * Set suiviMars
     *
     * @param string $suiviMars
     *
     * @return FollowUpExport
     */
    public function setSuiviMars($suiviMars)
    {
        $this->suiviMars = $suiviMars;

        return $this;
    }

    /**
     * Get suiviMars
     *
     * @return string
     */
    public function getSuiviMars()
    {
        return $this->suiviMars;
    }

    /**
     * Set suiviAvril
     *
     * @param string $suiviAvril
     *
     * @return FollowUpExport
     */
    public function setSuiviAvril($suiviAvril)
    {
        $this->suiviAvril = $suiviAvril;

        return $this;
    }

    /**
     * Get suiviAvril
     *
     * @return string
     */
    public function getSuiviAvril()
    {
        return $this->suiviAvril;
    }

    /**
     * Set suiviMai
     *
     * @param string $suiviMai
     *
     * @return FollowUpExport
     */
    public function setSuiviMai($suiviMai)
    {
        $this->suiviMai = $suiviMai;

        return $this;
    }

    /**
     * Get suiviMai
     *
     * @return string
     */
    public function getSuiviMai()
    {
        return $this->suiviMai;
    }

    /**
     * Set suiviJuin
     *
     * @param string $suiviJuin
     *
     * @return FollowUpExport
     */
    public function setSuiviJuin($suiviJuin)
    {
        $this->suiviJuin = $suiviJuin;

        return $this;
    }

    /**
     * Get suiviJuin
     *
     * @return string
     */
    public function getSuiviJuin()
    {
        return $this->suiviJuin;
    }

    /**
     * Set suiviJuillet
     *
     * @param string $suiviJuillet
     *
     * @return FollowUpExport
     */
    public function setSuiviJuillet($suiviJuillet)
    {
        $this->suiviJuillet = $suiviJuillet;

        return $this;
    }

    /**
     * Get suiviJuillet
     *
     * @return string
     */
    public function getSuiviJuillet()
    {
        return $this->suiviJuillet;
    }

    /**
     * Set suiviAout
     *
     * @param string $suiviAout
     *
     * @return FollowUpExport
     */
    public function setSuiviAout($suiviAout)
    {
        $this->suiviAout = $suiviAout;

        return $this;
    }

    /**
     * Get suiviAout
     *
     * @return string
     */
    public function getSuiviAout()
    {
        return $this->suiviAout;
    }

    /**
     * Set suiviSeptembre
     *
     * @param string $suiviSeptembre
     *
     * @return FollowUpExport
     */
    public function setSuiviSeptembre($suiviSeptembre)
    {
        $this->suiviSeptembre = $suiviSeptembre;

        return $this;
    }

    /**
     * Get suiviSeptembre
     *
     * @return string
     */
    public function getSuiviSeptembre()
    {
        return $this->suiviSeptembre;
    }

    /**
     * Set suiviOctobre
     *
     * @param string $suiviOctobre
     *
     * @return FollowUpExport
     */
    public function setSuiviOctobre($suiviOctobre)
    {
        $this->suiviOctobre = $suiviOctobre;

        return $this;
    }

    /**
     * Get suiviOctobre
     *
     * @return string
     */
    public function getSuiviOctobre()
    {
        return $this->suiviOctobre;
    }

    /**
     * Set suiviNovembre
     *
     * @param string $suiviNovembre
     *
     * @return FollowUpExport
     */
    public function setSuiviNovembre($suiviNovembre)
    {
        $this->suiviNovembre = $suiviNovembre;

        return $this;
    }

    /**
     * Get suiviNovembre
     *
     * @return string
     */
    public function getSuiviNovembre()
    {
        return $this->suiviNovembre;
    }

    /**
     * Set suiviDecembre
     *
     * @param string $suiviDecembre
     *
     * @return FollowUpExport
     */
    public function setSuiviDecembre($suiviDecembre)
    {
        $this->suiviDecembre = $suiviDecembre;

        return $this;
    }

    /**
     * Get suiviDecembre
     *
     * @return string
     */
    public function getSuiviDecembre()
    {
        return $this->suiviDecembre;
    }

    /**
     * Set suiviOctobreLettre
     *
     * @param string $suiviOctobreLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviOctobreLettre($suiviOctobreLettre)
    {
        $this->suiviOctobreLettre = $suiviOctobreLettre;

        return $this;
    }

    /**
     * Get suiviOctobreLettre
     *
     * @return string
     */
    public function getSuiviOctobreLettre()
    {
        return $this->suiviOctobreLettre;
    }

    /**
     * Set suiviNovembreLettre
     *
     * @param string $suiviNovembreLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviNovembreLettre($suiviNovembreLettre)
    {
        $this->suiviNovembreLettre = $suiviNovembreLettre;

        return $this;
    }

    /**
     * Get suiviNovembreLettre
     *
     * @return string
     */
    public function getSuiviNovembreLettre()
    {
        return $this->suiviNovembreLettre;
    }

    /**
     * Set suiviDecembreLettre
     *
     * @param string $suiviDecembreLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviDecembreLettre($suiviDecembreLettre)
    {
        $this->suiviDecembreLettre = $suiviDecembreLettre;

        return $this;
    }

    /**
     * Get suiviDecembreLettre
     *
     * @return string
     */
    public function getSuiviDecembreLettre()
    {
        return $this->suiviDecembreLettre;
    }

    /**
     * Set suiviJanvierLettre
     *
     * @param string $suiviJanvierLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviJanvierLettre($suiviJanvierLettre)
    {
        $this->suiviJanvierLettre = $suiviJanvierLettre;

        return $this;
    }

    /**
     * Get suiviJanvierLettre
     *
     * @return string
     */
    public function getSuiviJanvierLettre()
    {
        return $this->suiviJanvierLettre;
    }

    /**
     * Set suiviFevrierLettre
     *
     * @param string $suiviFevrierLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviFevrierLettre($suiviFevrierLettre)
    {
        $this->suiviFevrierLettre = $suiviFevrierLettre;

        return $this;
    }

    /**
     * Get suiviFevrierLettre
     *
     * @return string
     */
    public function getSuiviFevrierLettre()
    {
        return $this->suiviFevrierLettre;
    }

    /**
     * Set suiviMarsLettre
     *
     * @param string $suiviMarsLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviMarsLettre($suiviMarsLettre)
    {
        $this->suiviMarsLettre = $suiviMarsLettre;

        return $this;
    }

    /**
     * Get suiviMarsLettre
     *
     * @return string
     */
    public function getSuiviMarsLettre()
    {
        return $this->suiviMarsLettre;
    }

    /**
     * Set suiviAvrilLettre
     *
     * @param string $suiviAvrilLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviAvrilLettre($suiviAvrilLettre)
    {
        $this->suiviAvrilLettre = $suiviAvrilLettre;

        return $this;
    }

    /**
     * Get suiviAvrilLettre
     *
     * @return string
     */
    public function getSuiviAvrilLettre()
    {
        return $this->suiviAvrilLettre;
    }

    /**
     * Set suiviMaiLettre
     *
     * @param string $suiviMaiLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviMaiLettre($suiviMaiLettre)
    {
        $this->suiviMaiLettre = $suiviMaiLettre;

        return $this;
    }

    /**
     * Get suiviMaiLettre
     *
     * @return string
     */
    public function getSuiviMaiLettre()
    {
        return $this->suiviMaiLettre;
    }

    /**
     * Set suiviJuinLettre
     *
     * @param string $suiviJuinLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviJuinLettre($suiviJuinLettre)
    {
        $this->suiviJuinLettre = $suiviJuinLettre;

        return $this;
    }

    /**
     * Get suiviJuinLettre
     *
     * @return string
     */
    public function getSuiviJuinLettre()
    {
        return $this->suiviJuinLettre;
    }

    /**
     * Set suiviJuilletLettre
     *
     * @param string $suiviJuilletLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviJuilletLettre($suiviJuilletLettre)
    {
        $this->suiviJuilletLettre = $suiviJuilletLettre;

        return $this;
    }

    /**
     * Get suiviJuilletLettre
     *
     * @return string
     */
    public function getSuiviJuilletLettre()
    {
        return $this->suiviJuilletLettre;
    }

    /**
     * Set suiviAoutLettre
     *
     * @param string $suiviAoutLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviAoutLettre($suiviAoutLettre)
    {
        $this->suiviAoutLettre = $suiviAoutLettre;

        return $this;
    }

    /**
     * Get suiviAoutLettre
     *
     * @return string
     */
    public function getSuiviAoutLettre()
    {
        return $this->suiviAoutLettre;
    }

    /**
     * Set suiviSeptembreLettre
     *
     * @param string $suiviSeptembreLettre
     *
     * @return FollowUpExport
     */
    public function setSuiviSeptembreLettre($suiviSeptembreLettre)
    {
        $this->suiviSeptembreLettre = $suiviSeptembreLettre;

        return $this;
    }

    /**
     * Get suiviSeptembreLettre
     *
     * @return string
     */
    public function getSuiviSeptembreLettre()
    {
        return $this->suiviSeptembreLettre;
    }

    /**
     * Set suiviOctobrePhoto
     *
     * @param string $suiviOctobrePhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviOctobrePhoto($suiviOctobrePhoto)
    {
        $this->suiviOctobrePhoto = $suiviOctobrePhoto;

        return $this;
    }

    /**
     * Get suiviOctobrePhoto
     *
     * @return string
     */
    public function getSuiviOctobrePhoto()
    {
        return $this->suiviOctobrePhoto;
    }

    /**
     * Set suiviNovembrePhoto
     *
     * @param string $suiviNovembrePhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviNovembrePhoto($suiviNovembrePhoto)
    {
        $this->suiviNovembrePhoto = $suiviNovembrePhoto;

        return $this;
    }

    /**
     * Get suiviNovembrePhoto
     *
     * @return string
     */
    public function getSuiviNovembrePhoto()
    {
        return $this->suiviNovembrePhoto;
    }

    /**
     * Set suiviDecembrePhoto
     *
     * @param string $suiviDecembrePhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviDecembrePhoto($suiviDecembrePhoto)
    {
        $this->suiviDecembrePhoto = $suiviDecembrePhoto;

        return $this;
    }

    /**
     * Get suiviDecembrePhoto
     *
     * @return string
     */
    public function getSuiviDecembrePhoto()
    {
        return $this->suiviDecembrePhoto;
    }

    /**
     * Set suiviJanvierPhoto
     *
     * @param string $suiviJanvierPhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviJanvierPhoto($suiviJanvierPhoto)
    {
        $this->suiviJanvierPhoto = $suiviJanvierPhoto;

        return $this;
    }

    /**
     * Get suiviJanvierPhoto
     *
     * @return string
     */
    public function getSuiviJanvierPhoto()
    {
        return $this->suiviJanvierPhoto;
    }

    /**
     * Set suiviFevrierPhoto
     *
     * @param string $suiviFevrierPhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviFevrierPhoto($suiviFevrierPhoto)
    {
        $this->suiviFevrierPhoto = $suiviFevrierPhoto;

        return $this;
    }

    /**
     * Get suiviFevrierPhoto
     *
     * @return string
     */
    public function getSuiviFevrierPhoto()
    {
        return $this->suiviFevrierPhoto;
    }

    /**
     * Set suiviMarsPhoto
     *
     * @param string $suiviMarsPhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviMarsPhoto($suiviMarsPhoto)
    {
        $this->suiviMarsPhoto = $suiviMarsPhoto;

        return $this;
    }

    /**
     * Get suiviMarsPhoto
     *
     * @return string
     */
    public function getSuiviMarsPhoto()
    {
        return $this->suiviMarsPhoto;
    }

    /**
     * Set suiviAvrilPhoto
     *
     * @param string $suiviAvrilPhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviAvrilPhoto($suiviAvrilPhoto)
    {
        $this->suiviAvrilPhoto = $suiviAvrilPhoto;

        return $this;
    }

    /**
     * Get suiviAvrilPhoto
     *
     * @return string
     */
    public function getSuiviAvrilPhoto()
    {
        return $this->suiviAvrilPhoto;
    }

    /**
     * Set suiviMaiPhoto
     *
     * @param string $suiviMaiPhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviMaiPhoto($suiviMaiPhoto)
    {
        $this->suiviMaiPhoto = $suiviMaiPhoto;

        return $this;
    }

    /**
     * Get suiviMaiPhoto
     *
     * @return string
     */
    public function getSuiviMaiPhoto()
    {
        return $this->suiviMaiPhoto;
    }

    /**
     * Set suiviJuinPhoto
     *
     * @param string $suiviJuinPhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviJuinPhoto($suiviJuinPhoto)
    {
        $this->suiviJuinPhoto = $suiviJuinPhoto;

        return $this;
    }

    /**
     * Get suiviJuinPhoto
     *
     * @return string
     */
    public function getSuiviJuinPhoto()
    {
        return $this->suiviJuinPhoto;
    }

    /**
     * Set suiviJuilletPhoto
     *
     * @param string $suiviJuilletPhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviJuilletPhoto($suiviJuilletPhoto)
    {
        $this->suiviJuilletPhoto = $suiviJuilletPhoto;

        return $this;
    }

    /**
     * Get suiviJuilletPhoto
     *
     * @return string
     */
    public function getSuiviJuilletPhoto()
    {
        return $this->suiviJuilletPhoto;
    }

    /**
     * Set suiviAoutPhoto
     *
     * @param string $suiviAoutPhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviAoutPhoto($suiviAoutPhoto)
    {
        $this->suiviAoutPhoto = $suiviAoutPhoto;

        return $this;
    }

    /**
     * Get suiviAoutPhoto
     *
     * @return string
     */
    public function getSuiviAoutPhoto()
    {
        return $this->suiviAoutPhoto;
    }

    /**
     * Set suiviSeptembrePhoto
     *
     * @param string $suiviSeptembrePhoto
     *
     * @return FollowUpExport
     */
    public function setSuiviSeptembrePhoto($suiviSeptembrePhoto)
    {
        $this->suiviSeptembrePhoto = $suiviSeptembrePhoto;

        return $this;
    }

    /**
     * Get suiviSeptembrePhoto
     *
     * @return string
     */
    public function getSuiviSeptembrePhoto()
    {
        return $this->suiviSeptembrePhoto;
    }

    /**
     * Set suiviOctobreNouvelle
     *
     * @param string $suiviOctobreNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviOctobreNouvelle($suiviOctobreNouvelle)
    {
        $this->suiviOctobreNouvelle = $suiviOctobreNouvelle;

        return $this;
    }

    /**
     * Get suiviOctobreNouvelle
     *
     * @return string
     */
    public function getSuiviOctobreNouvelle()
    {
        return $this->suiviOctobreNouvelle;
    }

    /**
     * Set suiviNovembreNouvelle
     *
     * @param string $suiviNovembreNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviNovembreNouvelle($suiviNovembreNouvelle)
    {
        $this->suiviNovembreNouvelle = $suiviNovembreNouvelle;

        return $this;
    }

    /**
     * Get suiviNovembreNouvelle
     *
     * @return string
     */
    public function getSuiviNovembreNouvelle()
    {
        return $this->suiviNovembreNouvelle;
    }

    /**
     * Set suiviDecembreNouvelle
     *
     * @param string $suiviDecembreNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviDecembreNouvelle($suiviDecembreNouvelle)
    {
        $this->suiviDecembreNouvelle = $suiviDecembreNouvelle;

        return $this;
    }

    /**
     * Get suiviDecembreNouvelle
     *
     * @return string
     */
    public function getSuiviDecembreNouvelle()
    {
        return $this->suiviDecembreNouvelle;
    }

    /**
     * Set suiviJanvierNouvelle
     *
     * @param string $suiviJanvierNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviJanvierNouvelle($suiviJanvierNouvelle)
    {
        $this->suiviJanvierNouvelle = $suiviJanvierNouvelle;

        return $this;
    }

    /**
     * Get suiviJanvierNouvelle
     *
     * @return string
     */
    public function getSuiviJanvierNouvelle()
    {
        return $this->suiviJanvierNouvelle;
    }

    /**
     * Set suiviFevrierNouvelle
     *
     * @param string $suiviFevrierNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviFevrierNouvelle($suiviFevrierNouvelle)
    {
        $this->suiviFevrierNouvelle = $suiviFevrierNouvelle;

        return $this;
    }

    /**
     * Get suiviFevrierNouvelle
     *
     * @return string
     */
    public function getSuiviFevrierNouvelle()
    {
        return $this->suiviFevrierNouvelle;
    }

    /**
     * Set suiviMarsNouvelle
     *
     * @param string $suiviMarsNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviMarsNouvelle($suiviMarsNouvelle)
    {
        $this->suiviMarsNouvelle = $suiviMarsNouvelle;

        return $this;
    }

    /**
     * Get suiviMarsNouvelle
     *
     * @return string
     */
    public function getSuiviMarsNouvelle()
    {
        return $this->suiviMarsNouvelle;
    }

    /**
     * Set suiviAvrilNouvelle
     *
     * @param string $suiviAvrilNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviAvrilNouvelle($suiviAvrilNouvelle)
    {
        $this->suiviAvrilNouvelle = $suiviAvrilNouvelle;

        return $this;
    }

    /**
     * Get suiviAvrilNouvelle
     *
     * @return string
     */
    public function getSuiviAvrilNouvelle()
    {
        return $this->suiviAvrilNouvelle;
    }

    /**
     * Set suiviMaiNouvelle
     *
     * @param string $suiviMaiNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviMaiNouvelle($suiviMaiNouvelle)
    {
        $this->suiviMaiNouvelle = $suiviMaiNouvelle;

        return $this;
    }

    /**
     * Get suiviMaiNouvelle
     *
     * @return string
     */
    public function getSuiviMaiNouvelle()
    {
        return $this->suiviMaiNouvelle;
    }

    /**
     * Set suiviJuinNouvelle
     *
     * @param string $suiviJuinNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviJuinNouvelle($suiviJuinNouvelle)
    {
        $this->suiviJuinNouvelle = $suiviJuinNouvelle;

        return $this;
    }

    /**
     * Get suiviJuinNouvelle
     *
     * @return string
     */
    public function getSuiviJuinNouvelle()
    {
        return $this->suiviJuinNouvelle;
    }

    /**
     * Set suiviJuilletNouvelle
     *
     * @param string $suiviJuilletNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviJuilletNouvelle($suiviJuilletNouvelle)
    {
        $this->suiviJuilletNouvelle = $suiviJuilletNouvelle;

        return $this;
    }

    /**
     * Get suiviJuilletNouvelle
     *
     * @return string
     */
    public function getSuiviJuilletNouvelle()
    {
        return $this->suiviJuilletNouvelle;
    }

    /**
     * Set suiviAoutNouvelle
     *
     * @param string $suiviAoutNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviAoutNouvelle($suiviAoutNouvelle)
    {
        $this->suiviAoutNouvelle = $suiviAoutNouvelle;

        return $this;
    }

    /**
     * Get suiviAoutNouvelle
     *
     * @return string
     */
    public function getSuiviAoutNouvelle()
    {
        return $this->suiviAoutNouvelle;
    }

    /**
     * Set suiviSeptembreNouvelle
     *
     * @param string $suiviSeptembreNouvelle
     *
     * @return FollowUpExport
     */
    public function setSuiviSeptembreNouvelle($suiviSeptembreNouvelle)
    {
        $this->suiviSeptembreNouvelle = $suiviSeptembreNouvelle;

        return $this;
    }

    /**
     * Get suiviSeptembreNouvelle
     *
     * @return string
     */
    public function getSuiviSeptembreNouvelle()
    {
        return $this->suiviSeptembreNouvelle;
    }

    /**
     * Set suiviOctobreResultat
     *
     * @param string $suiviOctobreResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviOctobreResultat($suiviOctobreResultat)
    {
        $this->suiviOctobreResultat = $suiviOctobreResultat;

        return $this;
    }

    /**
     * Get suiviOctobreResultat
     *
     * @return string
     */
    public function getSuiviOctobreResultat()
    {
        return $this->suiviOctobreResultat;
    }

    /**
     * Set suiviNovembreResultat
     *
     * @param string $suiviNovembreResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviNovembreResultat($suiviNovembreResultat)
    {
        $this->suiviNovembreResultat = $suiviNovembreResultat;

        return $this;
    }

    /**
     * Get suiviNovembreResultat
     *
     * @return string
     */
    public function getSuiviNovembreResultat()
    {
        return $this->suiviNovembreResultat;
    }

    /**
     * Set suiviDecembreResultat
     *
     * @param string $suiviDecembreResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviDecembreResultat($suiviDecembreResultat)
    {
        $this->suiviDecembreResultat = $suiviDecembreResultat;

        return $this;
    }

    /**
     * Get suiviDecembreResultat
     *
     * @return string
     */
    public function getSuiviDecembreResultat()
    {
        return $this->suiviDecembreResultat;
    }

    /**
     * Set suiviJanvierResultat
     *
     * @param string $suiviJanvierResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviJanvierResultat($suiviJanvierResultat)
    {
        $this->suiviJanvierResultat = $suiviJanvierResultat;

        return $this;
    }

    /**
     * Get suiviJanvierResultat
     *
     * @return string
     */
    public function getSuiviJanvierResultat()
    {
        return $this->suiviJanvierResultat;
    }

    /**
     * Set suiviFevrierResultat
     *
     * @param string $suiviFevrierResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviFevrierResultat($suiviFevrierResultat)
    {
        $this->suiviFevrierResultat = $suiviFevrierResultat;

        return $this;
    }

    /**
     * Get suiviFevrierResultat
     *
     * @return string
     */
    public function getSuiviFevrierResultat()
    {
        return $this->suiviFevrierResultat;
    }

    /**
     * Set suiviMarsResultat
     *
     * @param string $suiviMarsResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviMarsResultat($suiviMarsResultat)
    {
        $this->suiviMarsResultat = $suiviMarsResultat;

        return $this;
    }

    /**
     * Get suiviMarsResultat
     *
     * @return string
     */
    public function getSuiviMarsResultat()
    {
        return $this->suiviMarsResultat;
    }

    /**
     * Set suiviAvrilResultat
     *
     * @param string $suiviAvrilResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviAvrilResultat($suiviAvrilResultat)
    {
        $this->suiviAvrilResultat = $suiviAvrilResultat;

        return $this;
    }

    /**
     * Get suiviAvrilResultat
     *
     * @return string
     */
    public function getSuiviAvrilResultat()
    {
        return $this->suiviAvrilResultat;
    }

    /**
     * Set suiviMaiResultat
     *
     * @param string $suiviMaiResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviMaiResultat($suiviMaiResultat)
    {
        $this->suiviMaiResultat = $suiviMaiResultat;

        return $this;
    }

    /**
     * Get suiviMaiResultat
     *
     * @return string
     */
    public function getSuiviMaiResultat()
    {
        return $this->suiviMaiResultat;
    }

    /**
     * Set suiviJuinResultat
     *
     * @param string $suiviJuinResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviJuinResultat($suiviJuinResultat)
    {
        $this->suiviJuinResultat = $suiviJuinResultat;

        return $this;
    }

    /**
     * Get suiviJuinResultat
     *
     * @return string
     */
    public function getSuiviJuinResultat()
    {
        return $this->suiviJuinResultat;
    }

    /**
     * Set suiviJuilletResultat
     *
     * @param string $suiviJuilletResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviJuilletResultat($suiviJuilletResultat)
    {
        $this->suiviJuilletResultat = $suiviJuilletResultat;

        return $this;
    }

    /**
     * Get suiviJuilletResultat
     *
     * @return string
     */
    public function getSuiviJuilletResultat()
    {
        return $this->suiviJuilletResultat;
    }

    /**
     * Set suiviAoutResultat
     *
     * @param string $suiviAoutResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviAoutResultat($suiviAoutResultat)
    {
        $this->suiviAoutResultat = $suiviAoutResultat;

        return $this;
    }

    /**
     * Get suiviAoutResultat
     *
     * @return string
     */
    public function getSuiviAoutResultat()
    {
        return $this->suiviAoutResultat;
    }

    /**
     * Set suiviSeptembreResultat
     *
     * @param string $suiviSeptembreResultat
     *
     * @return FollowUpExport
     */
    public function setSuiviSeptembreResultat($suiviSeptembreResultat)
    {
        $this->suiviSeptembreResultat = $suiviSeptembreResultat;

        return $this;
    }

    /**
     * Get suiviSeptembreResultat
     *
     * @return string
     */
    public function getSuiviSeptembreResultat()
    {
        return $this->suiviSeptembreResultat;
    }
}

