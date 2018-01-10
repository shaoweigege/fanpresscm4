<?php
    /**
     * FanPress CM 3.x
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\classes;
    
    /**
     * Loader
     * 
     * @package fpcm\classes\loader
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2017, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */ 
    final class loader {

        /**
         * Globaler Generator für Objekte
         * @param string $class
         * @param mixed $params
         * @return object
         */
        public static function getObject($class, $params = null)
        {
            if (!class_exists($class)) {
                trigger_error('Undefined class '.$class);
                return false;
            }

            $hash = (strpos($class, 'fpcm\classes') !== false ? explode('\\', $class, 3)[3] : $class);
            $hash = hash(security::defaultHashAlgo, $hash.(is_array($params) || is_object($params) ? json_encode($params) : $params));
            if (isset($GLOBALS['fpcm']['objects'][$hash]) && is_object($GLOBALS['fpcm']['objects'][$hash])) {
                return $GLOBALS['fpcm']['objects'][$hash];
            }
            
            $GLOBALS['fpcm']['objects'][$hash] = $params ? new $class($params) : new $class();

            return $GLOBALS['fpcm']['objects'][$hash];
        }

        /**
         * 
         * @param string $libPath
         * @param boolean $exists
         * @return string
         */
        public static function libGetFilePath($libPath, $exists = true)
        {
            $path = dirs::getFullDirPath('lib', $libPath);
            if ($exists && !file_exists($path)) {
                trigger_error('Lib path '.$path.' does not exists!');
            }

            return $path;
        }
        
        /**
         * 
         * @param string $libPath
         * @return string
         */
        public static function libGetFileUrl($libPath)
        {
            return dirs::getLibUrl($libPath);
        }
        
        
    }
