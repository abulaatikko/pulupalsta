<?php
namespace Pulu\PalstaBundle\Entity;

class Article {

    protected $id;
    protected $points;
    protected $visits;
    protected $created;
    protected $modified;
    protected $deleted;

    protected $localizations;

    public function __construct() {
        $this->localizations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getName($lang = 'FI') {
        return $this->getLocalization($lang)->getName();
    }

    public function getTeaser($lang = 'FI') {
        return $this->getLocalization($lang)->getTeaser();
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

    public function setDeleted() {
        $this->deleted = new \DateTime('now');
        return $this;
    }

    public function getDeleted() {
        return $this->deleted;
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

    /*public function removeTranslation(\Pulu\PalstaBundle\Entity\ArticleLocalization $localizations) {
        $this->localizations->removeElement($localizations);
    }*/

    public function getLocalization($lang = 'FI') {
        $translations = $this->localizations;
        foreach ($translations as $trans) {
            if ($trans->getLanguage() == $lang) {
                return $trans;
            }
        }
        return new ArticleLocalization();
    }

    /*public function setName($name, $lang = 'FI') {
        $translations = $this->getLocalization();
        foreach ($translations as $trans) {
            if ($trans->getLanguage() == $lang) {
                $trans->setName($name);
                return $this;
            }
        }
    }*/

    /*public function setTeaser($teaser, $lang = 'FI') {
        $translations = $this->getLocalization();
        foreach ($translations as $trans) {
            if ($trans->getLanguage() == $lang) {
                $trans->setName($teaser);
                return $this;
            }
        }
    }*/

    public function setLocalization(\Pulu\PalstaBundle\Entity\ArticleLocalization $a) {
         //if (!$this->translations->contains($a)) {
            $a->setArticle($this);
            $this->localizations[] = $a;
         //}
    }

}