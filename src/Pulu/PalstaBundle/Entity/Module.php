<?php
namespace Pulu\PalstaBundle\Entity;

use \Pulu\PalstaBundle\Entity\Article;

class Module {

    const TYPE_ADMIN_BEER_TASTING = 1;

    protected $id;
    protected $article;
    protected $name;
    protected $type;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;    
        return $this;
    }

    public function getType() {
        return $this->type;
    }    

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

}