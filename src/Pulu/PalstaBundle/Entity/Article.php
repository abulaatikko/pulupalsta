<?php
namespace Pulu\PalstaBundle\Entity;

class Article {

    protected $id;
    protected $article_number;
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

    public function getArticleNumber() {
        return $this->article_number;
    }

    public function setArticleNumber($articleNumber) {
        $this->article_number = $articleNumber;
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

    public function getName($lang = 'fi') {
        return $this->getLocalization($lang)->getName();
    }

    public function getTeaser($lang = 'fi') {
        return $this->getLocalization($lang)->getTeaser();
    }

    public function getBody($lang = 'fi') {
        return $this->getLocalization($lang)->getBody();
    }

    public function setLocalization(\Pulu\PalstaBundle\Entity\ArticleLocalization $localization) {
        $a->setArticle($this);
        $this->localizations[] = $localization;
    }

}