<?php /* @var $theView fpcm\view\viewVars */ ?>
<!DOCTYPE HTML>
<HTML lang="<?php print $theView->langCode; ?>">
    <head>
        <title><?php $theView->write('HEADLINE'); ?></title>
        <meta http-equiv="content-type" content= "text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php print $theView->themePath; ?>favicon.png" type="image/png" /> 
        <?php include_once 'includefiles.php'; ?>
        <?php include_once 'vars.php'; ?>

    </head>    

    <body class="fpcm-body" id="fpcm-body">

        <div id="fpcm-messages"></div>

        <?php if ($theView->formActionTarget) : ?><form method="post" action="<?php print $theView->formActionTarget; ?>" enctype="multipart/form-data" id="fpcm-ui-form"><?php endif; ?>

        <?php include_once $theView->getIncludePath('common/menutop.php'); ?>
            
        <div class="row">

            <div class="<?php if ($theView->fullWrapper) : ?>fpcm-ui-hidden<?php else : ?>col-sm-12 col-md-2<?php endif; ?> fpcm-ui-padding-none-lr fpcm-ui-background-white-50p" id="fpcm-wrapper-left">

                <div class="row no-gutters fpcm-ui-full-height">
                    <div class="col-12">
                        <div id="fpcm-ui-logo" class="fpcm-ui-logo fpcm-ui-center fpcm-ui-margin-none">
                            <h1><span class="fpcm-ui-block">FanPress CM</span> <span class="fpcm-ui-block">News System</span></h1>
                        </div>

                        <?php include_once $theView->getIncludePath('common/navigation.php'); ?>
                        
                        <div class="fpcm-footer fpcm-ui-font-small fpcm-ui-center fpcm-footer-bottom d-none d-md-block">
                            <?php include $theView->getIncludePath('common/footer_copy.php'); ?>
                        </div>
                        
                    </div>
                </div>
                

            </div>

            <div class="<?php if ($theView->fullWrapper) : ?>col-sm-12<?php else : ?>col-md-10<?php endif; ?> fpcm-ui-padding-none-lr" id="fpcm-wrapper-right">
                <?php include_once $theView->getIncludePath('common/buttons.php'); ?>