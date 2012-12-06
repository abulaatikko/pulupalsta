<?php
namespace Pulu\PalstaBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;
#use \Pulu\PalstaBundle\Entity\ArticleLocalization;
#use \Pulu\PalstaBundle\Entity\Comment;

class ArticleTag {

    protected $id;
    protected $weight;
    protected $tag;
    protected $article;

    //protected $tags;
    //protected $articles;    

    public function getId() {
        return $this->id;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function getTag() {
        return $this->tag;
    }

    public function setTag(Tag $tag) {
        $this->tag = $tag;    
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;    
        return $this;
    }

    /*public function getTags() {
        return $this->tags;
    }

    public function getArticles() {
        return $this->articles;
    }*/

    public function getName() {
        return $this->getTag()->getName();
    }

}