<?php
namespace Pulu\PalstaBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;

class ArticleKeyword {

    protected $id;
    protected $weight;
    protected $keyword;
    protected $article;

    public function getId() {
        return $this->id;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = (float) str_replace(',', '.', $weight);
        return $this;
    }

    public function getKeyword() {
        return $this->keyword;
    }

    public function setKeyword(Keyword $keyword) {
        $this->keyword = $keyword;    
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;    
        return $this;
    }

    public function getName() {
        return $this->getKeyword()->getName();
    }

}