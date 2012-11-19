<?php
namespace Pulu\PalstaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository {

    public function findByCreated($max = null, $article_id = null, $language = null) {
        $a = $this->createQueryBuilder('A');
        $where = '';
        if (! empty($article_id)) {
            $where = "A.article = " . $article_id;
        }
        if (! empty($language)) {
            if (! empty($where)) {
                $where .= " AND ";
            }
            $where .= "A.language = '" . $language . "'";
        }
        if (! empty($where)) {
            $a->where($where);
        }
        $a->orderBy('A.created', 'DESC');
        if (! empty($max)) {
            $a->setMaxResults($max);
        }
        return $a->getQuery()->getResult();
    }

}