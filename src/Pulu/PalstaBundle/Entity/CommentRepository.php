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

    public function tooFast($article_id, $ip_address, $user_agent, $delay = '2 mins') {
        return (bool) $this->createQueryBuilder('A')
            ->where("A.article = :article_id AND A.author_ip_address = :author_ip_address AND A.author_useragent = :author_useragent AND A.created > :interval")
            ->setParameter('article_id', $article_id)
            ->setParameter('author_ip_address', $ip_address)
            ->setParameter('author_useragent', $user_agent)
            ->setParameter('interval', new \DateTime('- ' . $delay))
            ->getQuery()->getResult();
    }

    public function isAuthorNameReserved($author_name) {
        return (bool) $this->createQueryBuilder('A')
            ->select("COUNT(A)")
            ->where("A.author_name = :author_name")
            ->setParameter('author_name', $author_name)
            ->setMaxResults(1)
            ->getQuery()->getSingleScalarResult();
    }

    public function isAuthorSecured($author_name, $key) {
        if (! $this->isAuthorNameReserved($author_name)) {
            return true;
        }
        return (bool) $this->createQueryBuilder('A')
            ->select("COUNT(A)")
            ->where("A.author_name = :author_name AND A.author_key = :author_key")
            ->setParameter('author_name', $author_name)
            ->setParameter('author_key', $key)
            ->setMaxResults(1)
            ->getQuery()->getSingleScalarResult();
    }

}
