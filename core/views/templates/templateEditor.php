<?php /* @var $theView \fpcm\view\viewVars */ ?>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12">
        <fieldset class="fpcm-ui-margin-none-left fpcm-ui-margin-none-right fpcm-ui-margin-md-top" style="height: 100px;overflow-y: auto;">
            <legend><?php $theView->write('TEMPLATE_REPLACEMENTS'); ?></legend>

            <?php $theView->write('TEMPLATE_NOTES'); ?>
            
            <dl>
            <?php foreach ($replacements as $tag => $descr) : ?>
                <dt><?php print $tag; ?></dt>        
                <dd><?php print $descr; ?></dd>
            <?php endforeach; ?>
            </dl>
        </fieldset>
    </div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-bottom">
    <div class="col-12">
        <fieldset class="fpcm-ui-margin-none-left fpcm-ui-margin-none-right fpcm-ui-margin-md-top">
            <legend><?php $theView->write('GLOBAL_HTMLTAGS_ALLOWED'); ?></legend>

            <p class="fpcm-ui-monospace fpcm-ui-margin-none"><?php print $allowedTags; ?> </p>
        </fieldset>
    </div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12">
        <?php $theView->textarea('template[content]', 'content_'.$tplId)->setValue($content, ENT_QUOTES)->setClass('fpcm-ui-template-textarea'); ?>
    </div>
</div>

<?php $theView->hiddenInput('template[id]')->setValue($tplId); ?>