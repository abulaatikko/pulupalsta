<?php
namespace Pulu\PalstaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository {

	protected static $language = 'fi';

    public function findAllOrderedByName() {
    	$lang = $this->getLanguage();
        return $this->createQueryBuilder('A')->innerJoin('A.localizations', 'B')->where("A.deleted IS NULL AND B.language = '" . $lang . "'")->orderBy('B.name', 'ASC')->getQuery()->getResult();
    }

    public function findAllOrderedByNameForPublic() {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')->innerJoin('A.localizations', 'B')->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = '" . $lang . "'")->orderBy('B.name', 'ASC')->getQuery()->getResult();
    }

    public function findNextArticleNumber() {
        return intval($this->createQueryBuilder('A')->select('MAX(A.article_number)')->getQuery()->getSingleScalarResult() + 1);
    }

    public function findOrderedByCreated($max = '10') {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.deleted IS NULL AND B.language = '" . $lang . "'")
            ->orderBy('A.created', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByCreatedForPublic($max = '10') {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = '" . $lang . "'")
            ->orderBy('A.created', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByPoint($max = 10) {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.deleted IS NULL AND B.language = '" . $lang . "'")
            ->orderBy('A.points', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function findOrderedByPointForPublic($max = 10) {
        $lang = $this->getLanguage();
        return $this->createQueryBuilder('A')
            ->innerJoin('A.localizations', 'B')
            ->where("A.is_public = TRUE AND A.deleted IS NULL AND B.language = '" . $lang . "'")
            ->orderBy('A.points', 'DESC')
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }

    public function setLanguage($lang = 'fi') {
    	self::$language = $lang;
    }

    protected function getLanguage() {
    	return self::$language;
    }

}
