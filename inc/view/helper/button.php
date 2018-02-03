<?php
    /**
     * FanPress CM 4
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\view\helper;
    
    /**
     * Button view helper object
     * 
     * @package fpcm\view\helper
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    class button extends helper {
        
        use traits\iconHelper,
            traits\typeHelper;

        /**
         * Return element string
         * @return string
         */
        protected function getString()
        {
            return implode(' ', [
                ($this->readonly ? '<span ' : "<button type=\"{$this->type}\" "),
                $this->getDataString(),
                ($this->readonly ? $this->getClassString() : $this->getNameIdString().' '.$this->getClassString()),
                ($this->iconOnly ? "title=\"{$this->text}\">" : ">{$this->getIconString()} {$this->getDescriptionTextString()}"),
                ($this->readonly ? '</span>' : "</button>")
            ]);
        }

        /**
         * Optional init function
         * @return void
         */
        protected function init()
        {
            $this->prefix = 'btn';
            $this->class  = 'fpcm-ui-button';
        }

    }
?>