<?php
namespace Pulu\PalstaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateArticleVisitCommand extends ContainerAwareCommand {

    protected function configure()     {
        $this->setName('pulupalsta:calculate-article-visit')->setDescription('Calculate article visits');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // Get Articles
        $D = $this->getContainer()->get('doctrine');
        $EM = $D->getManager();
        $articleRepository = $D->getRepository('PuluPalstaBundle:Article');
        $visitRepository = $D->getRepository('PuluPalstaBundle:Visit');
        $articles = $articleRepository->findAllOrderedByName();
        foreach ($articles as $article) {
            // Get visits
            $visits = $visitRepository->getArticleVisitCount($article);
            $EM->persist($article);
            $visits += $article->getOldVisits();
            $article->setVisits($visits);
        }
        $EM->flush();
    }

}