<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\events\logs;

/**
 * Module-Event: getRow
 * 
 * Event wird ausgeführt, wenn Systemlogs angezeigt werden
 * Parameter: object
 * Rückgabe: \fpcm\components\dataView\row
 * 
 * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @package fpcm/events
 */
final class getRow extends \fpcm\events\abstracts\event {

    /**
     * Defines type of returned data
     * @return string
     */
    protected function getReturnType()
    {
        return '\\fpcm\\components\\dataView\\row';
    }

}
