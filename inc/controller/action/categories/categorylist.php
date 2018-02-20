<?php

/**
 * Category list controller
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\action\categories;

class categorylist extends \fpcm\controller\abstracts\controller {

    protected $list;
    protected $rollList;

    protected function getViewPath()
    {
        return 'categories/categorylist';
    }

    protected function getPermissions()
    {
        return ['system' => 'categories'];
    }

    public function request()
    {

        $this->list = new \fpcm\model\categories\categoryList();
        $this->rollList = new \fpcm\model\users\userRollList();

        if ($this->getRequestVar('added')) {
            $this->view->addNoticeMessage('SAVE_SUCCESS_ADDCATEGORY');
        }

        if ($this->getRequestVar('edited')) {
            $this->view->addNoticeMessage('SAVE_SUCCESS_EDITCATEGORY');
        }

        if ($this->buttonClicked('delete') && !$this->checkPageToken()) {
            $this->view->addErrorMessage('CSRF_INVALID');
            return true;
        }

        if ($this->buttonClicked('delete') && !is_null($this->getRequestVar('ids'))) {
            $category = new \fpcm\model\categories\category($this->getRequestVar('ids'));

            if ($category->delete()) {
                $this->view->addNoticeMessage('DELETE_SUCCESS_CATEGORIES');
            } else {
                $this->view->addErrorMessage('DELETE_FAILED_CATEGORIES');
            }
        }

        return true;
    }

    protected function getHelpLink()
    {
        return 'hl_options';
    }

    public function process()
    {
        $categoryList = $this->list->getCategoriesAll();

        foreach ($categoryList as &$category) {
            $rolls = $this->rollList->getRollsbyIdsTranslated(explode(';', $category->getGroups()));
            $category->setGroups(implode(', ', array_keys($rolls)));
        }

        $this->view->assign('categorieList', $categoryList);
        $this->view->setFormAction('categories/list');
        $this->view->addButtons([
            (new \fpcm\view\helper\linkButton('addnew'))->setUrl(\fpcm\classes\tools::getFullControllerLink('categories/add'))->setText('CATEGORIES_ADD')->setIcon('file-o')->setClass('fpcm-loader'),
            (new \fpcm\view\helper\deleteButton('delete'))->setClass('fpcm-ui-button-confirm')
        ]);

        $this->view->render();
    }

}

?>
