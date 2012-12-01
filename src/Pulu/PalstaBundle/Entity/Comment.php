<?php
namespace Pulu\PalstaBundle\Entity;
use Pulu\PalstaBundle\Entity\Article;

class Comment {

    protected $id;
    protected $article;
    protected $language;
    protected $body;
    protected $account_id;
    protected $author_name;
    protected $author_ip_address;
    protected $author_useragent;
    protected $created;
    protected $modified;
    protected $deleted;

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

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    public function getAuthorId() {
        return $this->author_id;
    }

    public function setAuthorId($author_id) {
        $this->author_id = $author_id;
        return $this;
    }

    public function getAuthorName() {
        return $this->author_name;
    }

    public function setAuthorName($author_name) {
        $this->author_name = $author_name;
        return $this;
    }

    public function getAuthorIpAddress() {
        return $this->author_ip_address;
    }    

    public function setAuthorIpAddress($author_ip_address) {
        $this->author_ip_address = $author_ip_address;
        return $this;
    }

    public function getAuthorUserAgent() {
        return $this->author_useragent;
    }

    public function setAuthorUserAgent($author_useragent) {
        $this->author_useragent = $author_useragent;
        return $this;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated() {
        $this->created = new \DateTime('now');
        return $this;
    }

    public function getModified() {
        return $this->modified;
    }

    public function setModified() {
        $this->modified = new \DateTime('now');
        return $this;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function setDeleted() {
        $this->deleted = new \DateTime('now');
        return $this;
    }

}