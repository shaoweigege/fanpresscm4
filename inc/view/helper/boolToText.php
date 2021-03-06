<?php

/**
 * FanPress CM 4
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\view\helper;

/**
 * Bool select menu view helper object
 * 
 * @package fpcm\view\helper
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
final class boolToText extends helper {

    use traits\valueHelper;

    /**
     * Return element string
     * @return string
     */
    protected function getString()
    {
        $this->class = 'fa';

        if ($this->value) {
            if (!$this->text) {
                $this->setText('GLOBAL_YES');
            }
            $this->class .= ' fa-check-square fpcm-ui-booltext-yes';
        } else {
            if (!$this->text) {
                $this->setText('GLOBAL_NO');
            }
            $this->class .= ' fa-minus-square fpcm-ui-booltext-no';
        }

        return "<span {$this->getIdString()}{$this->getClassString()} title=\"{$this->text}\"></span>";
    }

}

?>