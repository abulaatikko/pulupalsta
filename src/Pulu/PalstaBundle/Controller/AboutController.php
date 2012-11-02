<?php
namespace Pulu\PalstaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller {
    public function indexAction() {
        return $this->render('PuluPalstaBundle:About:index.html.php');
    }
}
