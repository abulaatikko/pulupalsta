<?php
namespace Pulu\PalstaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository {

    public function findAllOrderedByName() {
        return $this->createQueryBuilder('A')->innerJoin('A.localizations', 'B')->where('A.deleted IS NULL')->orderBy('B.name', 'ASC')->getQuery()->getResult();
    }

    public function findNextArticleNumber() {
        return intval($this->createQueryBuilder('A')->select('MAX(A.article_number)')->where('A.deleted IS NULL')->getQuery()->getSingleScalarResult() + 1);
    }

}
