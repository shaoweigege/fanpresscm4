<?php

/**
 * Dashboard controller
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\action\system;

class dashboard extends \fpcm\controller\abstracts\controller {

    /**
     * Get view path for controller
     * @return string
     */
    protected function getViewPath() : string
    {
        return 'dashboard/index';
    }

    /**
     * 
     * @return string
     */
    protected function getHelpLink()
    {
        return 'hl_dashboard';
    }

    /**
     * Controller-Processing
     * @return bool
     */
    public function process()
    {
        $this->view->addJsLangVars(['DASHBOARD_LOADING']);
        $this->view->addJsFiles(['dashboard.js']);

        $buttons = [];
        $buttons[] = (new \fpcm\view\helper\linkButton('openProfile'))
                ->setUrl(\fpcm\classes\tools::getFullControllerLink('system/profile'))
                ->setIcon('wrench')
                ->setText('PROFILE_OPEN');

        if ($this->permissions->check(['system' => 'options'])) {
            $buttons[] = (new \fpcm\view\helper\linkButton('runSyscheck'))
                    ->setUrl(\fpcm\classes\tools::getFullControllerLink('system/options', ['syscheck' => 1]))
                    ->setIcon('sync')
                    ->setText('SYSCHECK_COMPLETE');
        }

        $this->view->addButtons($buttons);
    }

}

?>