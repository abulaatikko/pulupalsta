<?php
namespace Pulu\PalstaBundle\Entity;

class ArticleLocalization {

    // Stupid Doctrine restriction http://docs.doctrine-project.org/projects/doctrine-orm/en/2.0.x/reference/limitations-and-known-issues.html
    protected $id;
    protected $article;
    protected $language = 'FI';
    protected $name;
    protected $teaser;

    public function getId() {
        return $this->id;
    }

    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setTeaser($teaser) {
        $this->teaser = $teaser;
        return $this;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function getName() {
        return $this->name;
    }

    public function getTeaser() {
        return $this->teaser;
    }

    public function setArticle(\Pulu\PalstaBundle\Entity\Article $article) {
        $this->article = $article;    
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

}