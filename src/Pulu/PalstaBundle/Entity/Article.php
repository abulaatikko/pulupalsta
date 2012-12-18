<?php
namespace Pulu\PalstaBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;
use \Pulu\PalstaBundle\Entity\ArticleLocalization;
use \Pulu\PalstaBundle\Entity\Comment;
use \Pulu\PalstaBundle\Entity\Visit;

class Article {

    protected $id;
    protected $article_number;
    protected $rating;
    protected $visits;
    protected $use_translator;
    protected $is_public;
    protected $created;
    protected $modified;
    protected $deleted;

    protected $localizations;
    protected $comments;
    protected $keywords;
    protected $raw_visits;
    protected $raw_ratings;

    public function __construct() {
        $this->localizations = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->keywords = new ArrayCollection();
        $this->raw_visits = new ArrayCollection();
        $this->raw_ratings = new ArrayCollection();
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

    public function getUseTranslator() {
        return $this->use_translator;
    }

    public function setUseTranslator($useTranslator) {
        $this->use_translator = $useTranslator;
    }

    public function getIsPublic() {
        return $this->is_public;
    }

    public function setIsPublic($isPublic) {
        $this->is_public = $isPublic;
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

    public function setRating($rating) {
        $this->rating = $rating;
        return $this;
    }

    public function getRating() {
        return $this->rating;
    }

    public function setRawVisits(ArrayCollection $raw_visits) {
        $this->raw_visits = $raw_visits;
        return $this;
    }

    public function getRawVisits() {
        return $this->raw_visits;
    }

    public function setRawRatings(ArrayCollection $raw_ratings) {
        $this->raw_ratings = $raw_ratings;
        return $this;
    }

    public function getRawRatings() {
        return $this->raw_ratings;
    }

    public function getLocalizations() {
        return $this->localizations;
    }

    public function setLocalizations(ArrayCollection $localizations) {
        $this->localizations = $localizations;
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments(ArrayCollection $comments) {
        $this->comments = $comments;
    }

    public function getVisits() {
        return $this->visits;
    }

    public function setVisits($visits) {
        $this->visits = $visits;
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

    public function setComment(Comment $comment) {
        $a->setComment($this);
        $this->comments[] = $comment;
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

    public function getKeywords() {
        //return $this->keywords->toArray();
        return $this->keywords;
    }

    public function getCommentsCount() {
        $comments = $this->getComments();
        return count($comments);
    }

    public function getLastCommented() {
        $comments = $this->getComments();
        $return = null;
        foreach ($comments as $comment) {
            $created = $comment->getCreated();
            if ($created > $return) {
                $return = $created;
            }
        }
        return $return;
    }

}