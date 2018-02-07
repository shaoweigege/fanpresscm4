<?php
    /**
     * AJAX module update controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\packagemgr;
    
    class modupdate extends \fpcm\controller\abstracts\controller {
        
        use \fpcm\controller\traits\packagemgr\initialize;

        /**
         * Modul-Keys
         * @var array
         */
        protected $keys;

        /**
         * Module-Liste
         * @var \fpcm\model\modules\modulelist
         */
        protected $modulelist;

        /**
         * Update-Check aktiv
         * @var bool
         */
        protected $updateCheckEnabled = false;
        
        /**
         * Auszuführender Schritt
         * @var bool
         */
        protected $forceStep = false;
        
        /**
         * Auszuführender Schritt
         * @var bool
         */
        protected $legacy = true;

        public function getViewPath()
        {
            return 'packagemgr/modules';
        }

        protected function getPermissions()
        {
            return ['system' => 'options', 'modules' => 'configure', 'modules' => 'install'];
        }
        
        public function request() {

            $this->modulelist = new \fpcm\model\modules\modulelist();
            $this->view->assign('modeHeadline', 'MODULES_LIST_UPDATE');

            if ($this->getRequestVar('step')) {
                $this->forceStep = (int) $this->getRequestVar('step');
            }
            
            \fpcm\classes\baseconfig::enableAsyncCronjobs(false);
            
            return parent::request();
        }
        
        public function process() {

            
            
            $this->view->addJsFiles(['moduleinstaller.js']);
            
            $tempFile = new \fpcm\model\files\tempfile('installkeys');            
            if (!$tempFile->getContent()) {                
                trigger_error('No module key data found!');
                $this->view->addErrorMessage('MODULES_FAILED_TEMPKEYS');
                $this->view->assign('nokeys', true);
                $this->view->render();
                return false;
            }
            
            $startStep  = $this->forceStep ? $this->forceStep : (\fpcm\classes\baseconfig::canConnect() ? 1 : 4);

            $keys = json_decode($tempFile->getContent(), true);
            $params     = $this->initPkgManagerData();
            $params['fpcmModuleKeys']                 = $keys;
            $params['fpcmModuleUrl']                  = \fpcm\classes\baseconfig::$moduleServer.'packages/{{pkgkey}}.zip';
            $params['fpcmUpdaterStartStep']           = ($this->forceStep ? $this->forceStep : (\fpcm\classes\baseconfig::canConnect() ? 1 : 4));
            $params['fpcmProgressbarMax']             = count($keys);            
            $params['fpcmUpdaterMessages']['EXIT_1']  = $this->lang->translate('MODULES_SUCCESS_UPDATE');
            $params['fpcmUpdaterMessages']['4_0']     = $this->lang->translate('MODULES_FAILED_UPDATE');
            $params['fpcmModulesMode']                = 'update';
            $this->view->addJsVars($params);                        

            $this->view->addJsLangVars([
                'statusinfo' => $this->lang->translate('MODULES_LIST_UPDATING')
            ]);
            $this->view->render();
            
            $tempFile->delete();
        }
    }