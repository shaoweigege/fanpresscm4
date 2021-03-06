<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\components\editor;

/**
 * TinyMCE based editor plugin
 * 
 * @package fpcm\components\editor
 * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
class tinymceEditor5 extends tinymceEditor {

    /**
     * Liefert zu ladender Javascript-Dateien für Editor zurück
     * @return array
     */
    public function getJsFiles()
    {
        return [\fpcm\classes\loader::libGetFileUrl('tinymce5/tinymce.min.js'), 'editor_tinymce.js', 'editor_tinymce5.js', 'editor_filemanager.js'];
    }

    /**
     * Array von Javascript-Variablen, welche in Editor-Template genutzt werden
     * @return array
     */
    public function getJsVars()
    {
        $editorStyles = array(array('title' => $this->language->translate('GLOBAL_SELECT'), 'value' => ''));

        if (defined('FPCM_TINYMCE_PLUGINS') && FPCM_TINYMCE_PLUGINS) {
            $pluginFolders = FPCM_TINYMCE_PLUGINS;

            $this->notifications->addNotification(new \fpcm\model\theme\notificationItem(
                'EDITOR_TINYMCE_PLUGIN_OVERRIDE',
                'fa fa-plug fa-lg fa-fw'
            ));
        } elseif ($this->cache->isExpired('tinymce_plugins')) {

            $path = dirname(\fpcm\classes\loader::libGetFilePath('tinymce5/tinymce.min.js'));
            $path .= '/plugins/*';

            $pluginFolders = array_map('basename', glob($path, GLOB_ONLYDIR));
            $this->cache->write('tinymce_plugins', $pluginFolders, $this->config->system_cache_timeout);
        } else {
            $pluginFolders = $this->cache->read('tinymce_plugins');
        }

        $cssClasses = array_merge($editorStyles, $this->getEditorStyles());

        return $this->events->trigger('editor\initTinymce', [
            'editorConfig' => [
                'theme' => 'silver',
                'language' => $this->config->system_lang,
                'plugins' => $pluginFolders,
                'custom_elements' => 'readmore',
                'toolbar' => 'formatselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify outdent indent | subscript superscript table toc | bullist numlist | fpcm_readmore hr blockquote | link unlink anchor image media | fpcm_emoticons charmap insertdatetime template | undo redo removeformat searchreplace fullscreen code restoredraft | emoticons | help',
                'link_class_list' => $cssClasses,
                'image_class_list' => $cssClasses,
                'link_list' => \fpcm\classes\tools::getFullControllerLink('ajax/autocomplete', ['src' => 'editorlinks']),
                'image_list' => \fpcm\classes\tools::getFullControllerLink('ajax/autocomplete', ['src' => 'editorfiles']),
                'textpattern_patterns' => $this->getTextPatterns(),
                'templates' => $this->getTemplateDrafts(),
                'autosave_prefix' => 'fpcm-editor-as-' . $this->session->getUserId(),
                'images_upload_url' => $this->config->articles_imageedit_persistence ? \fpcm\classes\tools::getFullControllerLink('ajax/editor/imgupload') : false,
                'automatic_uploads' => $this->config->articles_imageedit_persistence ? 1 : 0,
                'width' => '100%',
                'min_height' => 500,
                'file_picker_types' => ['image', 'file']
            ],
            'editorDefaultFontsize' => $this->config->system_editor_fontsize,
            'editorInitFunction' => 'initTinyMce'
        ]);
    }

}
