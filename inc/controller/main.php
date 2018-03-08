<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller;

/**
 * Main controller
 * 
 * @package fpcm\controller\main
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
class main {

    /**
     *
     * @var array
     */
    protected $controllers = [];

    /**
     * Konstruktor
     */
    public function __construct()
    {
        if (version_compare(PHP_VERSION, FPCM_PHP_REQUIRED, '<')) {
            exit('FanPress CM requires at least PHP ' . FPCM_PHP_REQUIRED . ' or better!');
        }

        \fpcm\classes\http::init();

        if (!\fpcm\classes\baseconfig::installerEnabled() && !\fpcm\classes\baseconfig::dbConfigExists()) {
            exit('You have to install FanPress CM 3 before using it.');
        }
    }

    /**
     * Controller registrieren
     */
    public function registerController()
    {
        $this->controllers = \fpcm\classes\baseconfig::getControllers();
    }

    /**
     * Controller-Processing
     * @return boolean
     */
    public function exec()
    {
        $this->registerController();

        $module = \fpcm\classes\http::get('module');
        if (!$module) {
            header('Location: ' . \fpcm\classes\tools::getControllerLink('system/login'));
            return true;
        }

        $controllerName = (isset($this->controllers[$module]) ? $this->controllers[$module] : '');

        if (strpos($controllerName, 'fpcm/modules/') === false) {
            $controllerName = "fpcm/controller/" . $controllerName;
        }

        $controllerName = str_replace('/', '\\', $controllerName);
        
        if (defined('FPCM_DEBUG_ROUTES') && FPCM_DEBUG_ROUTES) {
            fpcmLogSystem("Route for {$module} to destionation {$controllerName}");
        }
        
        if (!class_exists($controllerName)) {
            trigger_error('Undefined controller called: ' . $module);
            $this->errorPage("The requested controller <b>$module</b> does not exist! <span class=\"fa fa-frown-o\"></span>");
        }


        /**
         * @var abstracts\controller
         */
        $controller = new $controllerName();

        if (!is_a($controller, 'fpcm\controller\abstracts\controller')) {
            trigger_error("ERROR: The controller for <b>$module</b> must be an instance of <b>fpcm\controller\abstracts\controller</b>.");
            exit("Controller class <b>$module</b> must be an instance of <b>fpcm\controller\abstracts\controller</b>. <span class=\"fa fa-frown-o\"></span>");
        }

        if (!$controller->hasAccess() || !$controller->request()) {
            return false;
        }

        $controller->process();
    }

    /**
     * Fehlerseite ausgeben
     * @param string $text
     */
    private function errorPage($text)
    {
        $view = new \fpcm\view\error($text);
        $view->render();
        exit;
    }

}
