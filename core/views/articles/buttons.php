<?php /* @var $theView \fpcm\view\viewVars */ ?>

<?php if (!$isRevision) : ?>
<fieldset class="fpcm-ui-margin-none-left fpcm-ui-margin-none-right fpcm-ui-margin-md-top">
    <legend><?php $theView->write('GLOBAL_EXTENDED'); ?></legend>

    <div class="row no-gutters fpcm-ui-margin-md-top fpcm-ui-margin-md-bottom">
        <div class="col-12">
            <div class="fpcm-ui-controlgroup">
            <?php if (!$article->getArchived()) : ?>
                <?php $theView->checkbox('article[pinned]')->setText('EDITOR_PINNED')->setSelected($article->getPinned()); ?>
                <?php $theView->checkbox('article[draft]')->setText('EDITOR_DRAFT')->setSelected($article->getDraft()); ?>
            <?php endif; ?>
            <?php $theView->checkbox('article[comments]')->setText('EDITOR_COMMENTS')->setSelected($article->getComments()); ?>
            <?php if (!$approvalRequired) : ?><?php $theView->checkbox('article[approval]')->setText('EDITOR_STATUS_APPROVAL')->setSelected($article->getApproval()); ?><?php endif; ?>
            <?php if ($editorMode) : ?><?php $theView->checkbox('article[archived]')->setText('EDITOR_ARCHIVE')->setSelected($article->getArchived()); ?><?php endif; ?>
            <?php if ($changeAuthor) : ?><?php $theView->select('article[author]')->setOptions($changeuserList)->setSelected($article->getCreateuser())->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?><?php endif; ?>
            </div>
        </div>
    </div>
</fieldset>

<fieldset class="fpcm-ui-margin-none-left fpcm-ui-margin-none-right fpcm-ui-margin-lg-top">
    <legend><?php $theView->write('TEMPLATE_ARTICLE_SOURCES'); ?></legend>
    <div class="row fpcm-ui-padding-md-tb">
        <?php $theView->textInput('article[sources]')
                ->setWrapper(false)
                ->setPlaceholder(true)
                ->setText('TEMPLATE_ARTICLE_SOURCES')
                ->setValue($article->getSources())
                ->setIcon('external-link-alt')
                ->setSize('lg')
                ->setClass('col-6 col-md-8 fpcm-ui-border-blue-light fpcm-ui-border-radius-right fpcm-ui-input-wrapper-inner fpcm-ui-element-min-height-md')
                ->setLabelClass('col-6 col-md-1 fpcm-ui-padding-none-lr fpcm-ui-border-blue-light fpcm-ui-border-none-right fpcm-ui-label-bg-grey fpcm-ui-input-wrapper-inner fpcm-ui-border-radius-left fpcm-ui-element-min-height-md'); ?>
    </div>
</fieldset>

<?php if (!$editorMode || $article->getPostponed()) : ?>
<fieldset class="fpcm-ui-margin-none-left fpcm-ui-margin-none-right fpcm-ui-margin-lg-top">
    <legend><?php $theView->write('EDITOR_POSTPONETO'); ?></legend>

    <div class="row fpcm-ui-padding-md-tb fpcm-ui-padding-none-lr-small">
        <?php $theView->textInput('article[postponedate]')
                ->setWrapper(false)
                ->setPlaceholder(true)
                ->setText('EDITOR_POSTPONED_DATE')
                ->setValue($theView->dateText($postponedTimer, 'Y-m-d'))
                ->setIcon('calendar-plus')
                ->setSize('lg')
                ->setClass('col-6 col-md-8 fpcm-ui-border-blue-light fpcm-ui-border-radius-right fpcm-ui-input-wrapper-inner fpcm-ui-element-min-height-md fpcm-ui-datepicker')
                ->setLabelClass('col-6 col-md-1 fpcm-ui-border-blue-light fpcm-ui-border-none-right fpcm-ui-label-bg-grey fpcm-ui-input-wrapper-inner fpcm-ui-border-radius-left fpcm-ui-element-min-height-md'); ?>

        <?php $theView->textInput('article[postponehour]')->setClass('fpcm-ui-spinner-hour')->setValue($theView->dateText($postponedTimer, 'H'))->setWrapper(false); ?>
        <?php $theView->textInput('article[postponeminute]')->setClass('fpcm-ui-spinner-minutes')->setValue($theView->dateText($postponedTimer, 'i'))->setWrapper(false); ?>
        <?php $theView->checkbox('article[postponed]')->setText('EDITOR_POSTPONETO')->setSelected($article->getPostponed())->setLabelClass('fpcm-ui-margin-md-left')->setIconOnly(true); ?>
    </div>
    <?php endif; ?>
</fieldset>

<?php if ($showTwitter && !empty($twitterReplacements)) : ?>
<fieldset class="fpcm-ui-margin-none-left fpcm-ui-margin-none-right fpcm-ui-margin-lg-top">
    <legend><?php $theView->write('EDITOR_TWEET_ENABLED'); ?></legend>
    <div class="row fpcm-ui-padding-md-tb fpcm-editor-dialog-fullwidth-items">

        <?php $theView->textInput('article[tweettxt]')
                ->setWrapper(false)
                ->setPlaceholder(true)
                ->setText('EDITOR_TWEET_TEXT')
                ->setValue('')
                ->setSize(280)
                ->setIcon('twitter', 'fab')
                ->setSize('lg')
                ->setClass('col-6 col-md-8 fpcm-ui-border-blue-light fpcm-ui-border-radius-right fpcm-ui-input-wrapper-inner fpcm-ui-element-min-height-md')
                ->setLabelClass('col-6 col-md-1 fpcm-ui-border-blue-light fpcm-ui-border-none-right fpcm-ui-label-bg-grey fpcm-ui-input-wrapper-inner fpcm-ui-border-radius-left fpcm-ui-element-min-height-md'); ?>

        <?php $theView->select('twitterReplacements')->setOptions($twitterReplacements)->setFirstOption(\fpcm\view\helper\select::FIRST_OPTION_DISABLED)->setLabelClass('fpcm-ui-margin-lg-left'); ?>
        <?php $theView->checkbox('article[tweet]')->setText('EDITOR_TWEET_ENABLED')->setSelected($article->tweetCreationEnabled())->setLabelClass('fpcm-ui-margin-md-left')->setIconOnly(true); ?>
    </div>
</fieldset>
<?php endif; ?>

<fieldset class="fpcm-ui-margin-none-left fpcm-ui-margin-none-right fpcm-ui-margin-lg-top">
    <legend><?php $theView->write('TEMPLATE_ARTICLE_ARTICLEIMAGE'); ?></legend>
    <div class="row fpcm-ui-padding-md-tb">
        <?php $theView->textInput('article[imagepath]')
                ->setWrapper(false)
                ->setPlaceholder(true)
                ->setText('TEMPLATE_ARTICLE_ARTICLEIMAGE')
                ->setValue($article->getImagepath())
                ->setMaxlenght(512)
                ->setIcon('image')
                ->setSize('lg')
                ->setClass('col-6 col-md-8 fpcm-ui-border-blue-light fpcm-ui-border-radius-right fpcm-ui-input-wrapper-inner')
                ->setLabelClass('col-6 col-md-1 fpcm-ui-padding-none-lr fpcm-ui-border-blue-light fpcm-ui-border-none-right fpcm-ui-label-bg-grey fpcm-ui-input-wrapper-inner fpcm-ui-border-radius-left fpcm-ui-element-min-height-md'); ?>
        <?php $theView->button('insertarticleimg', 'insertarticleimg')->setText('HL_FILES_MNG')->setIcon('image')->setIconOnly(true)->setClass('fpcm-ui-margin-lg-left'); ?>
    </div>
</fieldset>

<?php if ($showShares && count($shares)) : ?>
<fieldset class="fpcm-ui-margin-none-left fpcm-ui-margin-none-right fpcm-ui-margin-lg-top">
    <legend><?php $theView->write('EDITOR_SHARES'); ?></legend>
    <?php foreach ($shares as $share) : ?>
    <div class="row no-gutters fpcm-ui-padding-md-tb">
        <div class="col-2 col-lg-1"><?php print $share->getIcon(); ?></div>
        <div class="col-6 col-lg-2 align-self-center"><?php print $share->getDescription(); ?>:</div>
        <div class="col-4 col-lg-1 align-self-center fpcm-ui-center"><?php print $share->getSharecount(); ?></div>
        <div class="col-12 col-lg-auto align-self-center"><?php $theView->icon('clock', 'far')->setText('EDITOR_SHARES_LAST'); ?> <?php $theView->dateText($share->getLastshare()); ?></div>
    </div>
    <?php endforeach; ?>
</fieldset>
<?php endif; ?>

<?php endif; ?>