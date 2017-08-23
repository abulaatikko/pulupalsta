<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Article;
use Doctrine\ORM\EntityRepository;

class VisitRepository extends EntityRepository {

    public function isRegistered($article_id, $author_hash) {
        return (bool) $this->createQueryBuilder('A')
            ->where("A.article = :article_id AND A.author_hash = :author_hash AND A.created > :interval")
            ->setParameter('article_id', $article_id)
            ->setParameter('author_hash', $author_hash)
            ->setParameter('interval', new \DateTime('-15 minutes'))
            ->getQuery()->getResult();
    }

    public function getArticleVisitCount(Article $article) {
        return $this->createQueryBuilder('A')
            ->select("COUNT(A)")
            ->where("A.article = :article_id")
            ->setParameter(':article_id', $article->getId())
            ->setMaxResults(1)
            ->getQuery()->getSingleScalarResult();
    }

    public function getArticleVisitsBetween(Article $article, $from, $to) {
        return (int) $this->createQueryBuilder('A')
            ->select("COUNT(A)")
            ->where("A.article = :article_id AND A.created BETWEEN :from AND :to")
            ->setParameter(':article_id', $article->getId())
            ->setParameter(':from', date('Y-m-d H:i:s', $from))
            ->setParameter(':to', date('Y-m-d H:i:s', $to))
            ->setMaxResults(1)
            ->getQuery()->getSingleScalarResult();
    }

}
