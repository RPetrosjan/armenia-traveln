<?php

namespace AppBundle\Controller;


use AppBundle\Entity\OptimizerCss;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Twig\Loader\LoaderInterface;
use Twig_Environment;

class WebController extends Controller
{
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/{_locale}/", name="home_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/{_locale}/{page}", name="page_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/{_locale}/{page}/{page1}", name="page1_locale", requirements={"_locale" = "%app.locales%"})
     */
    public function pageAction(Request $request, $page='homepage', $page1='none', $_locale='en', $route = 'none'){
            $this->CheckLangue($request);
            $this->redirect('google.fr',301);
            $node = 'homepage';
            $html = $this->render('armenia-travel/pages/'.$node.'.html.twig', array(
        ));
        $this->CssJavascriptController();
        return $html;
    }

    // Control par 2 eme parameter si lui contient language defini, sinon rediriger vers
    private function CheckLangue(Request $request){
        $getPathArray = explode('/',$request->getPathInfo());
        $getLangue = $getPathArray[1];
        if(array_search($getLangue,$this->container->getParameter('languages'))===false)
        {
            $getPathArray[1] = $this->container->getParameter('locale');
            $urlredirect = implode("/",$getPathArray);
           $this->redirect('google.fr'.$urlredirect,301);
        }

    }

    // Controller permet de Recuperer tous les Css et JS deini
    // CSS et Js deini par Twig Extesnion AppExtension cssloader
    private function CssJavascriptController($filecss = null){
        // Je recuper controler sur l'extension
        $cssArray = $this->twig->getExtension('AppBundle\Twig\AppExtension');
        // Deinition tous les Css files

        //Si le css existent a la AppExtension
        if(sizeof((array)$cssArray)>0)
        {
            $csstext = '';
            $kernel= $this->get('kernel');
            // Ici sera une array tous les css
            foreach ((array)$cssArray as $key=>$cssArray){
                foreach ($cssArray as $keycss){
                    if ('@' !== $keycss[0]) {
                        $csstext.=\file_get_contents($keycss);
                    }
                    else{
                        $path = $kernel->locateResource($keycss);
                        $csstext.=\file_get_contents($path);
                    }

                }
            }
            // Ici on va compresser nos css sur une seule fishe
            $optimcss = new OptimizerCss();
            $optimcss->optimizeCss($csstext);

            if(is_null($filecss))
            {
                // Recuperation nouvelle css file name deini sur parameters.yml
                $filecss = $this->container->getParameter('cssFileName');
            }
            // REcuperation la route du notre web site
            $path = $this->get('kernel')->getRootDir() . '/../web/css/';
            // Mettre nouvelle css sur son bonne endtroit
            \file_put_contents($path.$filecss,$optimcss->optimizeCss($csstext));
        }
    }
}