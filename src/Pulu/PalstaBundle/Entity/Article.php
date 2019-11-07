<?php
namespace Pulu\PalstaBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;
use \Pulu\PalstaBundle\Entity\ArticleLocalization;
use \Pulu\PalstaBundle\Entity\ArticleRevision;
use \Pulu\PalstaBundle\Entity\Comment;
use \Pulu\PalstaBundle\Entity\Visit;
use \Pulu\PalstaBundle\Entity\Module;

class Article {

    protected $id;
    protected $article_number;
    protected $type;
    protected $rating;
    protected $visits;
    protected $old_visits; // from puluprojects
    protected $last_month_visits;
    protected $average_monthly_visits;
    protected $is_one_of_best;
    protected $is_commentable;
    protected $use_translator;
    protected $language;
    protected $is_public;
    protected $access;
    protected $created;
    protected $modified;
    protected $modified_public;
    protected $published;
    protected $written_at;
    protected $deleted;

    protected $localizations;
    protected $revisions;
    protected $comments;
    protected $keywords;
    protected $raw_visits;
    protected $raw_ratings;
    protected $modules;

    const ACCESS_ADMIN = 1;
    const ACCESS_FRIEND = 10;
    const ACCESS_ALL = 100;

    const TYPE_UNDEFINED = 0;
    const TYPE_TRAVELLING = 1;
    const TYPE_RESEARCH = 2;
    const TYPE_ART = 3;
    const TYPE_ESSAY = 4;

    public function __construct() {
        $this->localizations = new ArrayCollection();
        $this->revisions = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->keywords = new ArrayCollection();
        $this->raw_visits = new ArrayCollection();
        $this->raw_ratings = new ArrayCollection();
        $this->modules = new ArrayCollection();

        $this->type = self::TYPE_UNDEFINED;
        $this->rating = 1.00;
        $this->visits = 0;
        $this->use_translator = false;
        $this->language = 'fi';
        $this->is_public = false;
        $this->is_one_of_best = false;
        $this->is_commentable = false;
        $this->access = self::ACCESS_ADMIN;
    }

    public function getId() {
        return $this->id;
    }

    public function getArticleNumber() {
        return $this->article_number;
    }

    public function setArticleNumber($articleNumber) {
        $this->article_number = $articleNumber;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getUseTranslator() {
        return $this->use_translator;
    }

    public function setUseTranslator($useTranslator) {
        $this->use_translator = $useTranslator;
        return $this;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
        return $this->language;
    }

    public function getIsPublic() {
        return $this->is_public;
    }

    public function setIsPublic($isPublic) {
        $this->is_public = $isPublic;
        return $this;
    }

    public function getIsOneOfBest() {
        return $this->is_one_of_best;
    }

    public function setIsOneOfBest($isOneOfBest) {
        $this->is_one_of_best = $isOneOfBest;
        return $this->is_one_of_best;
    }

    public function getIsCommentable() {
        return $this->is_commentable;
    }

    public function setIsCommentable($isCommentable) {
        $this->is_commentable = $isCommentable;
        return $this->is_commentable;
    }

    public function getAccess() {
        return $this->access;
    }

    public function setAccess($access) {
        $this->access = $access;
        return $this;
    }

    public function setCreated() {
        $this->created = new \DateTime('now');
        return $this;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getModified() {
        return $this->modified;
    }

    public function setModified() {
        $this->modified = new \DateTime('now');
        return $this;
    }

    public function getModifiedPublic() {
        return $this->modified_public;
    }

    public function setModifiedPublic($modified_public) {
        $this->modified_public = $modified_public;
        return $this;
    }

    public function setPublished($published) {
        if (empty($this->published) && empty($published)) {
            $this->published = new \DateTime('now');
        } else {
            $this->published = $published;
        }
        return $this;
    }

    public function getPublished() {
        return $this->published;
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

    public function setWrittenAt($at) {
        $this->written_at = $at;
        return $this;
    }

    public function getWrittenAt() {
        return $this->written_at;
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

    public function getRatingCount() {
        return count($this->raw_ratings);
    }

    public function getLocalizations() {
        return $this->localizations;
    }

    public function setLocalizations(ArrayCollection $localizations) {
        $this->localizations = $localizations;
    }

    public function getLocalization($lang) {
        if (empty($lang)) {
            $lang = $this->getLanguage();
        }

        $translations = $this->getLocalizations();
        foreach ($translations as $trans) {
            if ($trans->getLanguage() == $lang) {
                return $trans;
            }
        }
        return new ArticleLocalization();
    }

    public function getRevisions() {
        return $this->revisions;
    }

    public function setRevisions(ArrayCollection $revisions) {
        $this->revisions = $revisions;
        return $this;
    }

    public function setRevision(ArticleRepository $repository) {
        $translations = $this->getLocalizations();
        foreach ($translations as $translation) {
            $articleRevision = new ArticleRevision();
            $articleRevision->article = $this->id;
            $articleRevision->language = $translation->getLanguage();
            $articleRevision->name = $translation->getName();
            $articleRevision->teaser = $translation->getTeaser();
            $articleRevision->body = $translation->getBody();

            $articleRevision->revision = $repository->findNextArticleNumber();;

            $this->revisions[] = $articleRevision;
        }        
    }

    public function getPreviousRevision($lang) {
        $revisions = $this->getRevisions();

        $max = null;
        $return = new ArticleRevision();
        $return->setArticle($this);
        $return->setLanguage($lang);
        foreach ($revisions as $revision) {
            if ($revision->getLanguage() != $lang) {
                continue;
            }
            if ($revision->getRevision() > $max) {
                $max = $revision->getRevision();
                $return = $revision;
            }
        }
        return $return;
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments(ArrayCollection $comments) {
        $this->comments = $comments;
    }

    public function getCommentsCount() {
        $comments = $this->getComments();
        $notDeletedComments = $comments->filter(function($comment) {
            return ! $comment->getDeleted();
        });
        return count($notDeletedComments);
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

    public function getVisits() {
        return $this->visits;
    }

    public function setVisits($visits) {
        $this->visits = $visits;
        return $this;
    }

    // from puluprojects
    public function getOldVisits() {
        return $this->old_visits;
    }

    public function setOldVisits($oldVisits) {
        $this->old_visits = $oldVisits;
        return $this;
    }

    public function getLastMonthVisits() {
        return $this->last_month_visits;
    }

    public function setLastMonthVisits($lastMonthVisits) {
        $this->last_month_visits = $lastMonthVisits;
        return $this;
    }

    public function getAverageMonthlyVisits() {
        return $this->average_monthly_visits;
    }

    public function setAverageMonthlyVisits($averageMonthlyVisits) {
        $this->average_monthly_visits = $averageMonthlyVisits;
        return $this;
    }

    public function getName($lang = null) {
        return $this->getLocalization($lang)->getName();
    }

    public function getTeaser($lang = null) {
        return $this->getLocalization($lang)->getTeaser();
    }

    public function getBody($lang = null) {
        return $this->getLocalization($lang)->getBody();
    }

    public function getKeywords() {
        return $this->keywords;
    }

    public function getModules() {
        return $this->modules;
    }

    public function setModules(ArrayCollection $modules) {
        $this->modules = $modules;
        return $this;
    }

    public function isPublic() {
        return $this->getIsPublic() && ! $this->getDeleted();
    }    

}
