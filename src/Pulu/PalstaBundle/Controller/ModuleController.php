<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Module;
use Pulu\PalstaBundle\Form\Type\ModuleType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;

class ModuleController extends Controller {

    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Module');
        $modules = $repository->findAll();
        return $this->render('PuluPalstaBundle:Module:index.html.php', array(
            'modules' => $modules
        ));
    }

    public function handleAction($id = null) {
        $R = $this->get('request');
        if (empty($id)) {
            $module = new Module();
        } else {
            $module = $this->getDoctrine()->getRepository('PuluPalstaBundle:Module')->find($id);
        }
        $form = $this->createForm(new ModuleType(), $module, array(
            'articles' => $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findAllOrderedByName()
        ));

        if ($R->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $delete = $R->get('delete');
            if ($delete) {
                $em->remove($module);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Moduuli poistettu');
                return $this->redirect($this->generateUrl('pulu_palsta_admin_module'));
            }
            $form->handleRequest($R);
            if ($form->isValid()) {                
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Moduuli tallennettu');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Moduulin tallennus epäonnistui');
            }

            if (! $id > 0) {
                return $this->redirect($this->generateUrl('pulu_palsta_admin_module_edit', array('id' => $module->getId())));
            }
        }

        return $this->render('PuluPalstaBundle:Module:handle.html.php', array(
            'form' => $form->createView(),
            'module' => $module
        ));
    }

    public function useAction($id) {
        $R = $this->get('request');
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Module');
        $module = $repository->find($id);
        $moduleType = $module->getType();

        $data = array();
        $data['beers'] = $repository->getBeers();

        $tablesExist = false;
        $sql = '';
        $formData = array();
        if ($moduleType == Module::TYPE_ADMIN_BEER_TASTING) {
            $tablesExist = $repository->moduleSQLExists(Module::TYPE_ADMIN_BEER_TASTING);

            if (! $tablesExist) {
                $sql = $repository->getModuleSQL(Module::TYPE_ADMIN_BEER_TASTING);
            } else {
                $formData['styles'] = $repository->getBeerStyles();
                $formData['countries'] = $repository->getBeerCountries();

                $GET = $R->query;
                $POST = $R->request;

                if ($GET->has('beer_id')) {
                    $data['beer_id'] = $GET->get('beer_id');
                } else if ($POST->has('beer_id')) {
                    $data['beer_id'] = $POST->get('beer_id');
                } else {
                    $data['beer_id'] = null;
                }

                // Load beer data to form
                if ($R->isXmlHttpRequest() && ! empty($data['beer_id'])) {
                    $beer = $repository->getBeer($data['beer_id']);

                    $response = new Response(json_encode(array('success' => true, 'beer' => $beer)));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                // Add / edit beer
                } else if ($R->isMethod('POST')) {
                    if ($POST->has('delete') && ! empty($data['beer_id'])) {
                        if ($repository->deleteBeer($data['beer_id'])) {
                            $this->get('session')->getFlashBag()->add('notice', 'Olut poistettu');
                            return $this->redirect($this->generateUrl('pulu_palsta_admin_module_use', array('id' => $module->getId())));
                        }
                    } else {
                        $name = $POST->get('name');
                        $price = (float) $POST->get('price');
                        $alc = (float) $POST->get('alc');
                        $grade = (int) $POST->get('grade');
                        $drunk = $POST->get('drunk');
                        $style = (int) $POST->get('style');
                        $new_style = $POST->get('new_style');
                        if (! empty($new_style)) {
                            $style = $new_style;
                        }
                        $country = (int) $POST->get('country');
                        $new_country = $POST->get('new_country');
                        if (! empty($new_country)) {
                            $country = $new_country;
                        }
                        $desc = $POST->get('desc');

                        $beer_id = $repository->saveBeer($data['beer_id'], array(
                            'name' => $name,
                            'price' => $price,
                            'alc' => $alc,
                            'grade' => $grade,
                            'drunk' => $drunk,
                            'style' => $style,
                            'country' => $country,
                            'desc' => $desc
                        ));

                        if ($beer_id > 0) {
                            $this->get('session')->getFlashBag()->add('notice', 'Tallennus onnistui');
                            return $this->redirect($this->generateUrl('pulu_palsta_admin_module_use', array('id' => $module->getId(), 'beer_id' => $beer_id)));
                        } else{
                            $this->get('session')->getFlashBag()->add('error', 'Tallennus epäonnistui');
                        }
                    }
                }
            }
        }

        return $this->render('PuluPalstaBundle:Module:use.html.php', array(
            'tables_exist' => $tablesExist,
            'sql' => $sql,
            'form_data' => $formData,
            'data' => $data,
            'module' => $module
        ));
    }

}
