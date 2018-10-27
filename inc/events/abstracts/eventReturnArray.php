<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\events\abstracts;

/**
 * Event model base with return type array
 * 
 * @package fpcm\events\abstracts
 * @abstract
 * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
abstract class eventReturnArray extends event {

    /**
     * Defines type of returned data
     * @return string
     */
    final protected function getReturnType()
    {
        return self::RETURNTYPE_ARRAY;
    }

}
