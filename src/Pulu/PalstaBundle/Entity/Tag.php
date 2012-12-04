<?php
namespace Pulu\PalstaBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;
use \Pulu\PalstaBundle\Entity\ArticleLocalization;

class Tag {

    protected $id;
    protected $weight;
    protected $created;
    protected $modified;
    protected $deleted;

    protected $localizations;

    public function __construct() {
        $this->localizations = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getWeight() {
        return empty($this->weight) ? 1.0 : $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
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

    public function getLocalizations() {
        return $this->localizations;
    }

    public function setLocalizations(ArrayCollection $localizations) {
        $this->localizations = $localizations;
    }

    public function getLocalization($lang = 'fi') {
        $translations = $this->getLocalizations();
        foreach ($translations as $trans) {
            if ($trans->getLanguage() == $lang) {
                return $trans;
            }
        }
        return new ArticleLocalization();
    }

    public function setLocalization(ArticleLocalization $localization) {
        $a->setArticle($this);
        $this->localizations[] = $localization;
    }

    public function getName($lang = 'fi') {
        return $this->getLocalization($lang)->getName();
    }

}