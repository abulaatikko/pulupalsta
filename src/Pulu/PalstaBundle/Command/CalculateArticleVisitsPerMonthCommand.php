<?php
namespace Pulu\PalstaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateArticleVisitsPerMonthCommand extends ContainerAwareCommand {

    const DAYS_IN_MONTH = 30;

    protected function configure()     {
        $this->setName('pulupalsta:calculate-article-visit-per-month')->setDescription('Calculate article visits per month');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $D = $this->getContainer()->get('doctrine');
        $EM = $D->getManager();
        $articleRepository = $D->getRepository('PuluPalstaBundle:Article');
        $visitRepository = $D->getRepository('PuluPalstaBundle:Visit');
        $articles = $articleRepository->findAllOrderedByName();
        foreach ($articles as $article) {
            $allTimeVisits = $article->getVisits();

            $secondsInMonth = 60 * 60 * 24 * self::DAYS_IN_MONTH;
            $secondsBetweenNowAndPublished = time() - strtotime($article->getPublished()->format('r'));
            if ($secondsBetweenNowAndPublished < 0) {
                continue;
            }
            $monthsBetweenNowAndPublished = ceil($secondsBetweenNowAndPublished / $secondsInMonth);
            $allTimeVisitsPerMonth = $allTimeVisits / $monthsBetweenNowAndPublished;

            $lastMonthVisits = $visitRepository->getArticleVisitsBetween($article, strtotime('-' . self::DAYS_IN_MONTH . ' day'), time());

            $EM->persist($article);
            $article->setLastMonthVisits($lastMonthVisits);
            $article->setAverageMonthlyVisits($allTimeVisitsPerMonth);
        }
        $EM->flush();
    }

}
