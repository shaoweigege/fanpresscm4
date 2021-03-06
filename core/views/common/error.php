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

        <div class="row fpcm-ui-position-absolute fpcm-ui-position-absolute-0">

            <div class="col-12 align-self-center fpcm-ui-center fpcm-ui-background-white-50p fpcm-ui-padding-lg-tb" id="fpcm-ui-errorbox">
                <?php $theView->icon($icon.' fa-inverse')->setStack('square')->setClass('fa-5x fpcm-ui-important-text'); ?>
                <p><?php print $errorMessage; ?></p>
                <p><?php $theView->linkButton('backBtn')->setUrl($backController ? $backController : 'javascript:window.history.back();')->setText('GLOBAL_BACK')->setIcon('chevron-circle-left'); ?></p>
            </div>
        </div>
        
    </body>
</html>