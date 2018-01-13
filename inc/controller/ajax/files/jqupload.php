<?php
    /**
     * AJAX jQuery uploader controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\files;
    
    /**
     * AJAX Controller für jQuery Datei uploader
     * 
     * @package fpcm\controller\ajax\files\jqupload
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class jqupload extends \fpcm\controller\abstracts\ajaxController {
        
        /**
         * Konstruktor
         */
        public function __construct() {
            $this->config       = \fpcm\classes\loader::getObject('\fpcm\model\system\config');
            $this->session      = \fpcm\classes\loader::getObject('\fpcm\model\system\session');
            
            if (!$this->session->getCurrentUser()) {
                return;
            }

            $this->permissions  = new \fpcm\model\system\permissions($this->session->getCurrentUser()->getRoll());
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {
            return $this->session->exists() && is_object($this->permissions) && $this->permissions->check(['uploads' => 'add']);
        }
        
        /**
         * Controller-Processing
         */
        public function process() {

            require_once \fpcm\classes\loader::libGetFilePath('jqupload/UploadHandler.php');

            $options = array(
                'script_url' => \fpcm\classes\tools::getFullControllerLink('ajax/jqupload'),
                'upload_dir' => \fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_UPLOADS),
                'upload_url' => \fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_UPLOADS),
                'accept_file_types'  => '/\.(gif|jpe?g|png|bmp)$/i',
                'image_versions'     => array(
                    'thumbnail'      => array(
                        'upload_dir' => \fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_UPLOADS, 'thumbs'.DIRECTORY_SEPARATOR),
                        'upload_url' => \fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_UPLOADS, 'thumbs'.DIRECTORY_SEPARATOR),
                        'crop'       => false,
                        'max_width'  => $this->config->file_img_thumb_width,
                        'max_height' => $this->config->file_img_thumb_height
                    )
                )
            );

            $handler = new \UploadHandler($options);

        }

    }
?>