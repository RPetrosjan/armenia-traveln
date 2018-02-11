<?php

namespace AppBundle\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouteCollection;

class LocaleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 20)),
        );
    }

    public function __construct(RouterInterface $router, $defaultLocale = 'en', array $supportedLocales = array('en'), $localeRouteParam = '_locale')
    {
        $this->router = $router;
        $this->routeCollection = $router->getRouteCollection();
        $this->defaultLocale = $defaultLocale;
        $this->supportedLocales = $supportedLocales;
        $this->localeRouteParam = $localeRouteParam;
    }

    public function isLocaleSupported($locale)
    {
        return in_array($locale, $this->supportedLocales);
    }

    public function onKernelRequest(GetResponseEvent $event){


        $request = $event->getRequest();
        $path = $request->getPathInfo();

        $route_exists = false; //by default assume route does not exist.
        foreach($this->routeCollection as $routeObject){
            $routePath = $routeObject->getPath();
            if($routePath == "/{_locale}".$path){
                $route_exists = true;
                break;
            }
        }

        //If the route does indeed exist then lets redirect there.
        if($route_exists == true){
            //Get the locale from the users browser.
            $locale = $request->getPreferredLanguage();
            //If no locale from browser or locale not in list of known locales supported then set to defaultLocale set in config.yml
            if($locale==""  || $this->isLocaleSupported($locale)==false){
                $locale = $request->getDefaultLocale();
            }
            $event->setResponse(new RedirectResponse("/".$locale.$path));
        }


    }
}