<?php
namespace Pulu\PalstaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository {

    public function findAllOrderedByName() {
        return $this->createQueryBuilder('A')->innerJoin('A.localizations', 'B')->where('A.deleted IS NULL')->orderBy('B.name', 'ASC')->getQuery()->getResult();
    }

}
