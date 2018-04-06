<?php /* @var $theView \fpcm\view\viewVars */ ?>
<?php $theView->hiddenInput('newfilename'); ?>
<div class="fpcm-ui-inner-wrapper">
    <div class="fpcm-tabs-general" id="fpcm-files-tabs">
        <ul>
            <li data-toolbar-buttons="1" id="tabs-files-list-reload"><a href="#tabs-files-list"><?php $theView->write('FILE_LIST_AVAILABLE'); ?></a></li>                
            <?php if ($permUpload) : ?><li data-toolbar-buttons="2"><a href="#tabs-files-upload"><?php $theView->write('FILE_LIST_UPLOADFORM'); ?></a></li><?php endif; ?>                
        </ul>

        <div id="tabs-files-list">
            <div id="tabs-files-list-content">
                <?php if (!$hasFiles) : ?>
                <p class="fpcm-ui-padding-none fpcm-ui-margin-none"><?php $theView->icon('images')->setStack('ban fpcm-ui-important-text')->setSize('lg')->setStackTop(true); ?> <?php $theView->write('GLOBAL_NOTFOUND2'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($permUpload) : ?>
        <?php if ($newUploader) : ?></form><?php endif; ?>
        <div id="tabs-files-upload">
            <?php if ($newUploader) : ?>
                <?php include $theView->getIncludePath('filemanager/forms/jqupload.php'); ?>
            <?php else : ?>
                <?php include $theView->getIncludePath('filemanager/forms/phpupload.php'); ?>
            <?php endif; ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<div class="fpcm-ui-dialog-layer fpcm-ui-hidden fpcm-editor-dialog" id="fpcm-dialog-files-rename">
    <div class="row">
        <div class="col-sm-12 col-md-6 fpcm-ui-padding-md-tb align-self-center"><?php $theView->write('FILE_LIST_FILENAME'); ?>:</div>
        <div class="col-sm-12 col-md-6 fpcm-ui-padding-md-tb"><?php $theView->textInput('newFilenameDialog'); ?></div>
    </div>
</div>

<?php include $theView->getIncludePath('filemanager/searchform.php'); ?>

<?php if($mode > 1) : ?><?php $theView->button('opensearch', 'opensearch')->setClass('fpcm-ui-hidden'); ?><?php endif; ?>