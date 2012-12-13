<?php
namespace Pulu\PalstaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository {

    public function findByCreated($max = null, $article_id = null, $language = null, $direction = 'DESC') {
        $a = $this->createQueryBuilder('A');
        $where = "A.deleted IS NULL";
        if (! empty($article_id)) {
            $where .= " AND A.article = " . $article_id;
        }
        if (! empty($language)) {
            $where .= " AND A.language = '" . $language . "'";
        }
        $a->where($where);
        $a->orderBy('A.created', $direction);
        if (! empty($max)) {
            $a->setMaxResults($max);
        }
        return $a->getQuery()->getResult();
    }

}