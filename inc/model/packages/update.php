<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\model\packages;

/**
 * Update package objekt
 * 
 * @package fpcm\model\packages
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 3.1
 */
class update extends package {

    /**
     *
     * @var \fpcm\model\updater\system
     */
    protected $updater;

    /**
     * Initializes interval objects
     * @return boolean
     */
    public function initObjects()
    {
        $this->updater = new \fpcm\model\updater\system();
        return true;
    }

    /**
     * 
     * @return string
     */
    public function getLocalDestinationPath()
    {
        return \fpcm\classes\dirs::getFullDirPath(DIRECTORY_SEPARATOR);
    }

    /**
     * 
     * @return string
     */
    public function getLocalPath()
    {
        return \fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_TEMP, basename($this->updater->url));
    }

    /**
     * 
     * @return string
     */
    protected function getExtractionPath()
    {
        return \fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_TEMP, 'update');
    }

    /**
     * 
     * @return string
     */
    public function getLocalSignature()
    {
        return \fpcm\model\files\ops::hashFile($this->getLocalPath());
    }

    /**
     * 
     * @return string
     */
    protected function getPackageKey()
    {
        return \fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_CONFIG, 'package.key');
    }

    /**
     * 
     * @return string
     */
    public function getRemotePath()
    {
        return $this->updater->url;
    }

    /**
     * 
     * @return string
     */
    public function getRemoteSignature()
    {
        return $this->updater->signature;
    }

    /**
     * Check if local files are writable
     * @return boolean
     */
    public function checkFiles()
    {;
        $files = $this->getFileList(\fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_CONFIG, 'files.txt'), 1);
        if (!count($files)) {
            return false;
        }

        $excludes = $this->getExcludes();
        $notWritable = [];

        foreach ($files as $file) {

            if (in_array($file, $excludes) || is_writable($this->replaceFanPressBaseFolder($file))) {
                continue;
            }
            
            $notWritable[] = $file.' > NOT WRIATBLE';
        }

        if (count($notWritable)) {
            fpcmLogSystem('Update check failed due to unwritable files.');
            fpcmLogSystem(implode(PHP_EOL, $notWritable));
            return self::FILESCHECK_ERROR;
        }

        return true;
    }

    /**
     * Kopiert Inhalt von Paket von Quelle nach Ziel
     * @return boolean
     */
    public function copy()
    {
        $srcBasePath    = $this->getExtractionPath();        
        $files          = $this->getFileList($srcBasePath. DIRECTORY_SEPARATOR. 'fanpress'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'files.txt', 1);
        
        if (!count($files)) {
            return self::FILESCOPY_ERROR;
        }
        
        $excludes = $this->getExcludes();

        $proto = [];
        $failed = [];
        foreach ($files as $file) {

            if (!trim($file) || in_array($file, $excludes)) {
                continue;
            }
            
            $src = $srcBasePath.DIRECTORY_SEPARATOR.$file;
            $dest = $this->replaceFanPressBaseFolder($file);

            if (!trim($src) || !trim($dest)) {
                continue;
            }
            
            $isDir = is_dir($src);
            $srcExists = file_exists($src);
            $destExists = file_exists($dest);

            if ($isDir && $destExists) {
                continue;
            }

            if ($isDir && !mkdir($dest, 0777)) {
                $proto[] = $dest.' new folder failed';
                $failed++;
            }
            
            if ($isDir) {
                continue;;
            }

            if ($destExists) {

                if (\fpcm\model\files\ops::hashFile($src) === \fpcm\model\files\ops::hashFile($dest)) {
                    $proto[] = $dest.' > file update skipped';
                    continue;
                }

                $backFile = $dest.'.back';
                if (file_exists($backFile)) {
                    unlink($backFile);
                }

                if (!copy($dest, $backFile)) {
                    $failed[] = $backFile.' > backup creation failed';
                    $proto[] = $backFile.' > backup creation failed';
                }

            }

            if (!copy($src, $dest)) {
                $failed[] = $dest.' > file update failed';
                $proto[] = $dest.' > file update failed';
                continue;
            }

            $proto[] = $dest.' > file update OK';
        }

        $fopt = new \fpcm\model\files\fileOption('updatecopy');
        $fopt->write($proto);
        
        if (count($failed)) {
            fpcmLogPackages($this->packageName.' - failed files', $failed);
            return self::FILESCOPY_ERROR;
        }
        
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function updateLog()
    {
        $fopt = new \fpcm\model\files\fileOption('updatecopy');
        
        if (!fpcmLogPackages($this->packageName, $fopt->read())) {
            return false;
        }

        return $fopt->remove();
    }

    /**
     * 
     * @return array
     */
    private function getExcludes()
    {
        return ['fanpress'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'installer.enabled'];
    }

}
