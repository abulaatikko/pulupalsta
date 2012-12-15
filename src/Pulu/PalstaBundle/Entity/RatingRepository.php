<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Article;
use Doctrine\ORM\EntityRepository;

class RatingRepository extends EntityRepository {

    public function getArticleRatings(Article $article) {
        return $this->createQueryBuilder('A')
            ->where("A.article = :article_id")
            ->setParameter(':article_id', $article->getId())
            ->getQuery()->getResult();
    }

}
