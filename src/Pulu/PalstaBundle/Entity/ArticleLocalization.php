<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Article;

class ArticleLocalization {

    protected $article;
    protected $language = 'fi';
    protected $name;
    protected $teaser;
    protected $body;

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

    public function setBody($body) {
        $this->body = $body;
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

    public function getBody() {
        return $this->body;
    }

    public function setArticle(Article $article) {
        $this->article = $article;    
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

}