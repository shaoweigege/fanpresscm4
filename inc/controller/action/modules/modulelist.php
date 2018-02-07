<?php
    /**
     * Module list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\modules;
    
    class modulelist extends \fpcm\controller\abstracts\controller {

        use \fpcm\controller\traits\modules\moduleactions;

        /**
         * Modul-Actions
         * @var array
         */
        protected $moduleActions = [];
        
        /**
         * Modul-Liste
         * @var \fpcm\model\modules\modulelist
         */
        protected $moduleList;

        public function getViewPath()
        {
            return 'modules/list';
        }

        protected function getPermissions()
        {
            return [
                'system' => 'options',
                'modules' => 'configure'
            ];
        }

        public function request() {
            
            $this->moduleList = new \fpcm\model\modules\modulelist();
            
            $this->moduleActions = array(
                $this->lang->translate('MODULES_LIST_INSTALL')      => 'install',
                $this->lang->translate('MODULES_LIST_UNINSTALL')    => 'uninstall',
                $this->lang->translate('MODULES_LIST_UPDATE')       => 'update',
                $this->lang->translate('MODULES_LIST_ENABLE')       => 'enable',
                $this->lang->translate('MODULES_LIST_DISABLE')      => 'disable'
            );

            if (!is_null(\fpcm\classes\http::getFiles())) {
                $uploader = new \fpcm\model\files\fileuploader(\fpcm\classes\http::getFiles());
                $res = $uploader->processModuleUpload();
                
                if ($res == true) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_UPLOADMODULE');
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_UPLOADMODULE');
                }
            }
            
            return true;
        }

        
        public function process() {
            
            
            $this->assignModules($this->moduleList);

            $this->view->addJsLangVars(array('detailsHeadline' => $this->lang->translate('MODULES_LIST_INFORMATIONS')));
            $this->view->addJsVars(array('fpcmJqUploadInit' => 0));

            $this->view->addJsFiles(['modulelist.js', 'fileuploader.js']);
            
            if (!$this->permissions->check(array('modules' => 'install'))) {
                unset($this->moduleActions[$this->lang->translate('MODULES_LIST_INSTALL')],
                      $this->moduleActions[$this->lang->translate('MODULES_LIST_UPDATE')]);
            }
            if (!$this->permissions->check(array('modules' => 'uninstall'))) {
                unset($this->moduleActions[$this->lang->translate('MODULES_LIST_UNINSTALL')]);
            }
            if (!$this->permissions->check(array('modules' => 'enable'))) {
                unset($this->moduleActions[$this->lang->translate('MODULES_LIST_ENABLE')],
                      $this->moduleActions[$this->lang->translate('MODULES_LIST_DISABLE')]);
            }
            
            $this->view->assign('moduleManagerMode', true);
            $this->view->assign('styleLeftMargin', true);
            
            if (!\fpcm\classes\baseconfig::canConnect()) {
                unset($this->moduleActions[$this->lang->translate('MODULES_LIST_INSTALL')],
                      $this->moduleActions[$this->lang->translate('MODULES_LIST_UPDATE')]);
                $this->view->assign('moduleManagerMode', false);
            }

            $translInfo = array(
                '{{filecount}}' => 1,
                '{{filesize}}'  => \fpcm\classes\tools::calcSize(\fpcm\classes\baseconfig::uploadFilesizeLimit(true), 0)
            );
            $this->view->assign('maxFilesInfo', $this->lang->translate('FILE_LIST_PHPMAXINFO', $translInfo));
            $this->view->assign('actionPath', \fpcm\classes\tools::getFullControllerLink('modules/list'));
            $this->view->assign('styleLeftMargin', true);
            $this->view->assign('moduleActions', $this->moduleActions);
            $this->view->render();
            
        }

        protected function getHelpLink()
        {
            return 'hl_modules';
        }
        
    }
?>
