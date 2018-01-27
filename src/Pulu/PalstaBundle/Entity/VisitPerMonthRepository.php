<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Article;
use Doctrine\ORM\EntityRepository;

class VisitPerMonthRepository extends EntityRepository {

    protected $article;

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }

    protected function getArticle() {
        return $this->article;
    }

    public function findVisitsPerMonth() {
        $article = $this->getArticle();
        return $this->createQueryBuilder('A')
            ->select('A.month, A.visits, A.article_id')
            ->where('A.article_id = :article_id')
            ->setParameter('article_id', $article->getId())
            ->orderBy('A.month', 'ASC')
            ->getQuery()->getResult();
    }

}
