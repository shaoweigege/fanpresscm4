<?php
    /**
     * FanPress CM 4
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\view\helper;
    
    /**
     * Edit link button view helper object
     * 
     * @package fpcm\view\helper
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    final class openButton extends linkButton {

        /**
         * Optional init function
         * @return void
         */
        protected function init()
        {
            parent::init();
            $this->class    .= ' fpcm-ui-button-openfe';
            $this->iconOnly  = true;
            $this->setText('GLOBAL_FRONTEND_OPEN');
            $this->setIcon('play');
        }

        final public function setUrlbyObject(\fpcm\model\abstracts\dataset $object, $paramsString = '')
        {
            if (!method_exists($object, 'getElementLink')) {
                trigger_error('Invalid parameter for object of class '.get_class($object).', method getElementLink() not found');
                return $this;
            }

            $this->url   = $object->getElementLink().$paramsString;
            $this->name .= $object->getId();
            $this->id   .= $object->getId();

            return $this;
        }

    }
?>