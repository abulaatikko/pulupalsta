<?php
namespace Pulu\PalstaBundle\Entity;
use Pulu\PalstaBundle\Entity\Rating;

class Rating {

    protected $id;
    protected $article;
    protected $rating;
    protected $account_id;
    protected $author_ip_address;
    protected $author_useragent;
    protected $author_hash;
    protected $created;
    
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

    public function getRating() {
        return $this->rating;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function getAccountId() {
        return $this->account_id;
    }

    public function setAccountId($account_id) {
        $this->account_id = $account_id;
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

    public function getAuthorHash() {
        return $this->author_hash;
    }

    public function setAuthorHash($author_hash) {
        $this->author_hash = $author_hash;
        return $this;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated() {
        $this->created = new \DateTime('now');
        return $this;
    }

}