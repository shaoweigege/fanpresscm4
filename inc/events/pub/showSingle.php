<?php
    /**
     * Module-Event: publicShowSingle
     * 
     * Event wird ausgeführt, bevor Inhalt in public-Controller showSingle ausgegeben wird
     * Parameter: array Daten für Ausgabe
     * Rückgabe: array Daten für Ausgabe
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\events\pub;

    /**
     * Module-Event: publicShowSingle
     * 
     * Event wird ausgeführt, bevor Inhalt in public-Controller showSingle ausgegeben wird
     * Parameter: array Daten für Ausgabe
     * Rückgabe: array Daten für Ausgabe
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm/model/events
     */
    final class publicShowSingle extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, bevor Inhalt in public-Controller showSingle ausgegeben wird
         * @param array $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = $this->getEventClasses();
            
            if (!count($eventClasses)) return $data;
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'publicShowSingle');
                
                /**
                 * @var \fpcm\model\abstracts\event
                 */
                $module = new $eventClass();

                if (!$this->is_a($module)) continue;
                
                $mdata = $module->run($mdata);
            }

            if (!$mdata) return $data;

            return $mdata;
            
        }
    }