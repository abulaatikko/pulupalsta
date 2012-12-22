<?php
namespace Pulu\PalstaBundle\Entity;

use Pulu\PalstaBundle\Entity\Article;
use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository {

	protected static $language = 'fi';

    public function findAllOrderedByName() {
    	$lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.deleted IS NULL AND B.language = :language")
            ->setParameter("language", $lang)
            ->orderBy('B.name', 'ASC')
            ->getQuery()->getResult();
    }

    public function findAllOrderedByNameForPublic() {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language")
            ->setParameter("language", $lang)
            ->orderBy('B.name', 'ASC')
            ->getQuery()->getResult();
    }

    public function findNextArticleNumber() {
        return (int) $this->createQueryBuilder('A')
            ->select('MAX(A.article_number)')
            ->getQuery()->getSingleScalarResult() + 1;
    }

    public function findOrderedByCreated($max = '10') {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.deleted IS NULL AND B.language = :language")
            ->setParameter("language", $lang)
            ->orderBy('A.created', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByCreatedForPublic($max = '10') {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language")
            ->setParameter("language", $lang)
            ->orderBy('A.created', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByRating($max = 10) {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.deleted IS NULL AND B.language = :language AND A.rating IS NOT NULL")
            ->setParameter("language", $lang)
            ->orderBy('A.rating', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByRatingForPublic($max = 10) {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language AND A.rating IS NOT NULL")
            ->setParameter("language", $lang)
            ->orderBy('A.rating', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByVisitsForPublic($max = 10, $keyword_id = null) {
        $lang = $this->getLanguage();
        $builder = $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B');
        if (! empty($keyword_id)) {
            $builder->innerJoin('A.keywords', 'C');
        }
        $where = "A.is_public = TRUE AND A.deleted IS NULL AND B.language = :language AND A.visits IS NOT NULL";
        if (! empty($keyword_id)) {
            $where .= " AND C.keyword = :keyword_id";
        }
        $builder
            ->where($where)
            ->setParameter("language", $lang);
        if (! empty($keyword_id)) {
            $builder->setParameter("keyword_id", $keyword_id);
        }
        $query = $builder
            ->orderBy('A.visits', 'DESC')
            ->setMaxResults($max)
            ->getQuery();
        return $query->getResult();
    }

    public function setLanguage($lang = 'fi') {
    	self::$language = $lang;
    }

    protected function getLanguage() {
    	return self::$language;
    }

}
