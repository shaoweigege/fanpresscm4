<?php
    /**
     * Log view controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class logs extends \fpcm\controller\abstracts\controller {
        
        /**
         * Controller-View
         * @var \fpcm\view\view
         */
        protected $view;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'logs');

            $this->view   = new \fpcm\view\view('overview', 'logs');
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;

            $this->view->assign('customLogs', $this->events->runEvent('logsAddList', []));
            $this->view->assign('reloadBaseLink', \fpcm\classes\tools::getFullControllerLink('ajax/logs/reload', [
                'log' => ''
            ]));
            $this->view->setViewJsFiles(['logs.js']);
            $this->view->setHelpLink('hl_options');
            
            $this->view->render();
        }
        
    }
?>
