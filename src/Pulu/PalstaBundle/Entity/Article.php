<?php
// src/Pulu/PalstaBundle/Entity/Article.php
namespace Pulu\PalstaBundle\Entity;

class Article {

    protected $id;
    protected $points;
    protected $visits;
    protected $created;
    protected $modified;

    protected $localizations;

    public function __construct() {
        $this->localizations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getName($lang = 'FI') {
        $translations = $this->getLocalization();
        //\Doctrine\Common\Util\Debug::dump($translations);
        foreach ($translations as $trans) {
            if ($trans->getLanguage() == $lang) {
                return $trans->getName();
            }
        }
        return '';
    }

    public function getTeaser($lang = 'FI') {
        $translations = $this->getLocalization();
        foreach ($translations as $trans) {
            if ($trans->getLanguage() == $lang) {
                return $trans->getTeaser();
            }
        }
        return '';
    }

    public function setCreated() {
        $this->created = new \DateTime('now');
        return $this;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setModified() {
        $this->modified = new \DateTime('now');
        return $this;
    }

    public function getModified() {
        return $this->modified;
    }

    public function setPoints($points) {
        $this->points = $points;
        return $this;
    }

    public function getPoints() {
        return $this->points;
    }

    public function setVisits($visits) {
        $this->visits = $visits;
        return $this;
    }

    public function getVisits() {
        return $this->visits;
    }

    /*public function removeTranslation(\Pulu\PalstaBundle\Entity\ArticleLocalization $localizations)
    {
        $this->localizations->removeElement($localizations);
    }*/

    public function getLocalization() {
        return $this->localizations;
    }

    public function setLocalization(\Pulu\PalstaBundle\Entity\ArticleLocalization $a)
    {
         //if (!$this->translations->contains($a)) {
            $a->setArticle($this);
            $this->localizations[] = $a;
         //}
    }

}