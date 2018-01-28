<?php
namespace Pulu\PalstaBundle\Entity;
use Pulu\PalstaBundle\Entity\VisitPerMonth;

class VisitPerMonth {

    protected $article_id;
    protected $month;
    protected $visits;

    public function setArticleId($article_id) {
        $this->article_id = $article_id;
        return $this;
    }

    public function getMonth() {
        return $this->month;
    }

    public function setMonth($month) {
        $this->month = $month->format('Y-m');
        return $this;
    }

    public function getVisits() {
        return $this->visits;
    }

    public function setVisits($visits) {
        $this->visits = $visits;
        return $this;
    }

}
