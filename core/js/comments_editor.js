/**
 * FanPress CM Comments Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 3.5
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.editor = {

    init: function () {
        fpcm.editor[fpcm.vars.jsvars.editorInitFunction].call();
        fpcm.editor.initToolbar();
        fpcm.ui.setFocus('commentname');
    },

    initCodeMirror: function() {

        fpcm.editor.cmInstance = fpcm.editor_codemirror.create({
           editorId  : 'htmleditor',
           elementId : 'commenttext',
           extraKeys : fpcm.editor_codemirror.defaultShortKeys
        });

    },
    
    initTinyMce: function() {
        fpcm.editor_tinymce.create(fpcm.vars.jsvars.editorConfig);
    }

};