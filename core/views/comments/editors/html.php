<?php include $theView->getIncludePath('comments/editors/html_dialogs.php'); ?>

<div class="row ui-widget-content ui-corner-all ui-state-normal fpcm-ui-padding-md-lr fpcm-ui-padding-md-tb">
    
    <div class="fpcm-ui-controlgroup fpcm-ui-editor-buttons">

        <?php if (count($editorStyles)) : ?>
        <select class="fpcm-ui-input-select" id="fpcm-editor-styles">
            <option value=""><?php $theView->write('EDITOR_SELECTSTYLES'); ?></option>
            <?php foreach ($editorStyles as $description => $tag) : ?>
            <option class="fpcm-editor-select-click fpcm-editor-cssclick" value="<?php print $tag; ?>"><?php print $description; ?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>

        <select class="fpcm-ui-input-select" id="fpcm-editor-paragraphs">
            <option value=""><?php $theView->write('EDITOR_PARAGRAPH'); ?></option>
            <?php foreach ($editorParagraphs as $descr => $tag) : ?>
            <option class="fpcm-editor-select-click fpcm-editor-html-click" value="<?php print $tag; ?>"><?php print $descr; ?></option>
            <?php endforeach; ?>
        </select>

        <select class="fpcm-ui-input-select" id="fpcm-editor-fontsizes">
            <option value=""><?php $theView->write('EDITOR_SELECTFS'); ?></option>
            <?php foreach ($editorFontsizes as $editorFontsize) : ?>
            <option class="fpcm-editor-htmlfontsize" value="<?php print $editorFontsize; ?>"><?php print $editorFontsize; ?>pt</option>
            <?php endforeach; ?>
        </select>

        <?php foreach ($editorButtons as $editorButton) : ?>
            <?php print $editorButton->setClass('fpcm-editor-html-click')->setIconOnly(true); ?>
        <?php endforeach; ?>
    </div>                
</div>

<div class="fpcm-ui-padding-md-tb" style="font-size: <?php print $editorDefaultFontsize; ?>">
    <?php $theView->textarea('comment[text]')->setClass('fpcm-ui-full-width')->setValue($comment->getText(), ENT_QUOTES); ?>
</div>

<div class="fpcm-ui-dialog-layer fpcm-ui-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-filemanager"></div>     