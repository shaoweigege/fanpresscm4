<?php /* @var $theView \fpcm\view\viewVars */ ?>
<div class="row no-gutters fpcm-ui-form-login fpcm-ui-full-height">
    <div class="col-sm-8 col-md-4 fpcm-ui-margin-center align-self-center">
        <div class="ui-widget-content ui-corner-all ui-state-normal fpcm-ui-padding-md-tb">

            <div id="fpcm-ui-logo" class="row fpcm-ui-logo fpcm-ui-center fpcm-ui-margin-none">
                <div class="col-12">
                    <h1><span class="fpcm-ui-block">FanPress CM</span> <span class="fpcm-ui-block">News System</span></h1>
                </div>
            </div>
            
            <div class="row fpcm-ui-padding-md-tb">
                <div class="col-12">
                    <?php $theView->textInput($userNameField)->setText('GLOBAL_USERNAME')->setPlaceholder(true)->setAutocomplete(false)->setAutoFocused(true); ?>
                </div>
            </div>

            <div class="row fpcm-ui-padding-md-tb">
                <div class="col-12">
                <?php if ($resetPasswort) : ?>
                    <?php $theView->textInput('email')->setText('GLOBAL_EMAIL')->setPlaceholder(true)->setAutocomplete(false); ?>
                <?php else : ?>
                    <?php $theView->passwordInput('login[password]')->setText('GLOBAL_PASSWORD')->setPlaceholder(true)->setAutocomplete(false); ?>
                <?php endif; ?>
                </div>
            </div>
            
            <?php if ($twoFactorAuth) : ?>
            <div class="row fpcm-ui-padding-md-tb fpcm-ui-hidden" id="fpcm-loginauthcode-box">
                <div class="col-12">
                <?php $theView->textInput('login[authcode]')->setText('LOGIN_AUTHCODE')->setPlaceholder(true)->setAutocomplete(false); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($resetPasswort) : ?>
            <div class="row fpcm-ui-padding-md-tb">
                <div class="col-6">
                    <?php print $captcha->createPluginText(); ?>
                </div>
                <div class="col-6">
                    <?php print $captcha->createPluginInput(true); ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="fpcm-ui-margin-center fpcm-ui-margin-md-top fpcm-ui-margin-md-bottom fpcm-ui-center">
                <div class="fpcm-ui-controlgroup">
            <?php if ($resetPasswort) : ?>
                <?php $theView->submitButton('reset')->setText('GLOBAL_OK')->setClass('fpcm-loader fpcm-ok-button')->setIcon('check'); ?>
                <?php $theView->linkButton('loginback')->setText('GLOBAL_BACK')->setUrl($theView->self.'?module='.$theView->currentModule)->setClass('fpcm-loader fpcm-back-button')->setIcon('chevron-circle-left'); ?>
            <?php else : ?>
                <?php $theView->submitButton('login')->setText('LOGIN_BTN')->setClass('fpcm-loader fpcm-login-btn')->setIcon('sign-in-alt'); ?>
                <?php $theView->linkButton('newpass')->setText('LOGIN_NEWPASSWORD')->setUrl($theView->self.'?module='.$theView->currentModule.'&reset')->setClass('fpcm-loader fpcm-passreset-btn')->setIcon('key'); ?>
            <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="row fpcm-ui-padding-md-tb">
            <div class="col-12 fpcm-ui-center fpcm-ui-font-small">
                <?php include $theView->getIncludePath('common/footer_copy.php'); ?>                
            </div>
        </div>
    </div>
</div>