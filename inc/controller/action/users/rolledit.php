<?php

/**
 * User roll add controller
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\action\users;

class rolledit extends rollbase {

    protected function getViewPath() : string
    {
        return 'users/rolledit';
    }

    public function request()
    {
        if (is_null($this->getRequestVar('id'))) {
            $this->redirect('users/list');
            return false;
        }

        $this->userRoll = new \fpcm\model\users\userRoll($this->getRequestVar('id'));
        $this->view->setFormAction($this->userRoll->getEditLink(), [], true);

        if (!$this->userRoll->exists()) {
            $this->view = new \fpcm\view\error('LOAD_FAILED_ROLL', 'users/list');
            return true;
        }

        $this->save(true);

        return parent::request();
    }

}

?>
