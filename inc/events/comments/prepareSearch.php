<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\events\comments;

/**
 * Module-Event: prepareSearch
 * 
 * Event wird ausgeführt, wenn Kommentar-Suche durchgeführt wird
 * Parameter: array mit Liste der Suchparameter aus dem Suchformular
 * Rückgabe: array mit Liste der Suchparameter aus dem Suchformular
 * 
 * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @package fpcm/events
 * @since FPCM 3.3
 */
final class prepareSearch extends \fpcm\events\abstracts\event {

    protected function getReturnType()
    {
        return '\fpcm\model\comments\search';
    }

}
