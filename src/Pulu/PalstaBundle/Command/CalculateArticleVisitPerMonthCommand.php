<?php
namespace Pulu\PalstaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pulu\PalstaBundle\Entity\VisitPerMonth;

class CalculateArticleVisitPerMonthCommand extends ContainerAwareCommand {

    const FIRST_MONTH = '2014-01-01 00:00:00';

    protected function configure()     {
        $this->setName('pulupalsta:calculate-article-visit-per-month')->setDescription('Calculate article visits per month');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // Get Articles
        $D = $this->getContainer()->get('doctrine');
        $EM = $D->getManager();
        $articleRepository = $D->getRepository('PuluPalstaBundle:Article');
        $visitRepository = $D->getRepository('PuluPalstaBundle:Visit');

        $articles = $articleRepository->findAllOrderedByName();
        foreach ($articles as $article) {
            $i = time();
            while ($i > strtotime(self::FIRST_MONTH)) {
                $from = date('Y-m', $i) . '-01 00:00:00';
                $to = date('Y-m-t', $i) . ' 23:59:59';

                $visitsPerMonthCount = $visitRepository->getArticleVisitsBetween($article, strtotime($from), strtotime($to));

                if (self::FIRST_MONTH === $from) {
                    $visitsPerMonthCount += $article->getOldVisits();
                }
                $fromToDb = date('Y-m', strtotime($from));
                $stm = $EM->getConnection()->prepare('SELECT * FROM visit_per_month WHERE article_id = ? AND month = ?');
                $stm->execute(array($article->getId(), $fromToDb));
                $res = $stm->fetchAll();

                if (! empty($res)) {
                    $upd = $EM->getConnection()->prepare('UPDATE visit_per_month SET visits = ? WHERE article_id = ? AND month = ?');
                    $upd->execute(array($visitsPerMonthCount, $article->getId(), $fromToDb));
                } else {
                    $ins = $EM->getConnection()->prepare('INSERT INTO visit_per_month (article_id, month, visits) VALUES (?, ?, ?)');
                    $ins->execute(array($article->getId(), $fromToDb, $visitsPerMonthCount));
                }

                $i = strtotime('-1 month', $i);
            }
        }
    }

}
