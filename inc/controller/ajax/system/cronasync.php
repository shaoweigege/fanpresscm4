<?php

/**
 * AJAX cron controller
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\ajax\system;

/**
 * AJAX-Controller - synchrone Ausführung von Cronjobs
 * 
 * @package fpcm\controller\ajax\system\cronasync
 * @author Stefan Seehafer <sea75300@yahoo.de>
 */
class cronasync extends \fpcm\controller\abstracts\ajaxController {

    /**
     * Request-Handler
     * @return bool
     */
    public function request()
    {
        if (\fpcm\classes\baseconfig::asyncCronjobsEnabled()) {
            return true;
        }

        fpcmLogCron('Asynchronous cronjob execution was disabled');
        return false;
    }

    /**
     * @see \fpcm\controller\abstracts\controller::hasAccess()
     * @return boolean
     */
    public function hasAccess()
    {
        return \fpcm\classes\baseconfig::installerEnabled() ||
                !\fpcm\classes\baseconfig::dbConfigExists() ? false : true;
    }

    /**
     * Controller-Processing
     */
    public function process()
    {
        $cjId = $this->getRequestVar('cjId');
        if ($cjId) {

            $cjClassName = \fpcm\model\abstracts\cron::getCronNamespace($cjId);

            /* @var $cronjob \fpcm\model\abstracts\cron */
            $cronjob = new $cjClassName($cjId);

            if (!is_a($cronjob, '\fpcm\model\abstracts\cron')) {
                trigger_error("Cronjob class {$cjId} must be an instance of \"\fpcm\model\abstracts\cron\"!");
                return false;
            }

            $cronjob->run();
            $cronjob->updateLastExecTime();

            return true;
        }

        $cronlist = new \fpcm\model\crons\cronlist();
        $crons = $cronlist->getExecutableCrons();

        if (!count($crons)) {
            return true;
        }

        foreach ($crons as $cron) {
            $cronlist->registerCronAjax($cron);
        }

        return true;
    }

}

?>