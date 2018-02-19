<?php

/**
 * FanPress CM 4
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\view\helper\traits;

/**
 * View helper with value
 * 
 * @package fpcm\view\helper
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
trait valueHelper {

    use escapeHelper;

    /**
     * Element value
     * @var string
     */
    protected $value = '';

    /**
     * Set input value
     * @param mixed $value
     * @param int $escapeMode
     * @return $this
     */
    public function setValue($value, $escapeMode = null)
    {
        $this->value = $this->escapeVal($value, $escapeMode);
        return $this;
    }

    /**
     * Return value string
     * @return string
     */
    protected function getValueString($value = null)
    {
        return "value=\"{$this->value}\"";
    }

}

?>