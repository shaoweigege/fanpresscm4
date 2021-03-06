<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="row no-gutters">
    <div class="col-12">
        <fieldset>
            <legend><?php $theView->write('SYSTEM_HL_OPTIONS_GENERAL'); ?></legend>
            
            <div class="row fpcm-ui-padding-md-tb">
                <div class="align-self-center col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                    <?php $theView->write('USERS_DISPLAYNAME'); ?>:
                </div>
                <div class="col-sm-12 col-md-6 fpcm-ui-padding-none-lr">
                    <?php $theView->textInput('data[displayname]')->setValue($author->getDisplayName())->setAutocomplete(false); ?>
                </div>
            </div>

            <div class="row fpcm-ui-padding-md-tb">
                <div class="align-self-center col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                    <?php $theView->write('GLOBAL_USERNAME'); ?>:
                </div>
                <div class="col-sm-12 col-md-6 fpcm-ui-padding-none-lr">
                    <?php $theView->textInput('data[username]')->setValue($author->getUserName())->setReadonly((isset($inProfile) && $inProfile))->setAutocomplete(false); ?>
                </div>
            </div>

            <div class="row fpcm-ui-padding-md-tb">
                <div class="align-self-center col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                    <?php $theView->write('GLOBAL_PASSWORD'); ?>:
                </div>
                <div class="col-sm-11 col-md-6 fpcm-ui-padding-none-lr">
                    <?php $theView->textInput('data[password]', 'password')->setAutocomplete(false); ?>
                </div>
                <div class="col-auto">
                    <?php $theView->button('genPasswd', 'genPasswd')->setText('USERS_PASSGEN')->setIcon('key')->setIconOnly(true); ?>
                    <?php $theView->shorthelpButton('dtmask')->setText('USERS_REQUIREMENTS'); ?>
                </div>
            </div>

            <div class="row fpcm-ui-padding-md-tb">
                <div class="align-self-center col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                    <?php $theView->write('USERS_PASSWORD_CONFIRM'); ?>:
                </div>
                <div class="col-sm-12 col-md-6 fpcm-ui-padding-none-lr">
                    <?php $theView->textInput('data[password_confirm]', 'password_confirm')->setAutocomplete(false); ?>
                </div>
            </div>

            <div class="row fpcm-ui-padding-md-tb">
                <div class="align-self-center col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                    <?php $theView->write('GLOBAL_EMAIL'); ?>:
                </div>
                <div class="col-sm-12 col-md-6 fpcm-ui-padding-none-lr">
                    <?php $theView->textInput('data[email]')->setValue($author->getEmail()); ?>
                </div>
            </div>

            <div class="row fpcm-ui-padding-md-tb <?php print $inProfile ? 'fpcm-ui-hidden' : '' ?>">
                <div class="col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                    <?php $theView->write('USERS_ROLL'); ?>:
                </div>
                <div class="col-sm-12 col-md-6 fpcm-ui-padding-none-lr">
                    <?php $theView->select('data[roll]')
                            ->setOptions($userRolls)
                            ->setSelected($author->getRoll())
                            ->setReadonly(($inProfile))
                            ->setFirstOption(\fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
                </div>
            </div>
            
            <?php if($inProfile) : ?>
            <div id="fpcm-ui-currentpass-box" class="row fpcm-ui-padding-md-tb fpcm-ui-hidden">
                <div class="align-self-center col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                    <?php $theView->icon('exclamation-triangle ')->setClass('fpcm-ui-important-text')->setSize('lg'); ?>
                    <?php $theView->write('GLOBAL_PASSWORD_CONFIRM'); ?>:
                </div>
                <div class="col-sm-12 col-md-6 fpcm-ui-padding-none-lr">
                    <?php $theView->textInput('data[current_pass]')->setAutocomplete(false); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($showDisableButton) : ?>
            <div class="row fpcm-ui-padding-md-tb">
                <div class="align-self-center col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                    <?php $theView->write('GLOBAL_DISABLE'); ?>:
                </div>
                <div class="col-sm-12 col-md-6 fpcm-ui-padding-none-lr">
                    <?php $theView->boolSelect('data[disabled]')->setSelected($author->getDisabled()); ?>
                </div>
            </div>
            <?php endif; ?>
        </fieldset>
    </div>
</div>

<?php if ($showExtended) : ?>
    <div class="row no-gutters">
        <div class="col-12">
            <fieldset class="fpcm-ui-margin-md-top">
                <legend><?php $theView->write('GLOBAL_EXTENDED'); ?></legend>

                <div class="row fpcm-ui-padding-md-tb">
                    <div class="col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                        <?php $theView->write('USERS_BIOGRAPHY'); ?>:
                    </div>
                    <div class="col-sm-12 col-md-6 fpcm-ui-padding-none-lr">
                        <?php $theView->textarea('data[usrinfo]')->setValue($author->getUsrinfo())->setClass('fpcm-ui-textarea-medium fpcm-ui-full-width') ?>
                    </div>
                </div>

                <?php if ($showImage) : ?>
                <div class="row fpcm-ui-padding-md-tb">
                    <div class="col-sm-12 col-md-3 fpcm-ui-padding-none-lr">
                        <?php $theView->write('USERS_AVATAR'); ?>:
                    </div>
                    <div class="col-sm-12 col-md-9 fpcm-ui-padding-none-lr">
                        <div class="fpcm-ui-controlgroup fpcm-ui-margin-lg-bottom" id="user_profile_image_buttons">
                            <?php $theView->button('addFile')->setText('FILE_FORM_FILEADD')->setIcon('plus'); ?>
                            <?php $theView->submitButton('uploadFile')->setText('FILE_FORM_UPLOADSTART')->setIcon('upload'); ?>
                            <?php $theView->resetButton('cancelUpload')->setText('FILE_FORM_UPLOADCANCEL')->setIcon('ban'); ?>
                            <?php if ($avatar) : ?><?php $theView->deleteButton('fileDelete')->setClass('fpcm-ui-button-confirm'); ?><?php endif; ?>
                            <input type="file" name="files" class="fpcm-ui-fileinput-select fpcm-ui-hidden">
                        </div>

                        <?php if ($avatar) : ?>
                            <p><img src="<?php print $avatar; ?>"></p>
                        <?php else: ?>
                            <p class="fpcm-ui-padding-none fpcm-ui-margin-none"><?php $theView->icon('image')->setStack('ban fpcm-ui-important-text')->setStackTop(true); ?>
                            <?php $theView->write('GLOBAL_NOTFOUND'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </fieldset>
        </div>
    </div>

    <?php if ($twoFaAuth) : ?>
    <div class="row no-gutters">
        <div class="col-12">
            <fieldset class="fpcm-ui-margin-md-top">
                <legend><?php $theView->write('SYSTEM_OPTIONS_LOGIN_TWOFACTORAUTH'); ?></legend>

                <?php if ($secret !== false && $qrCode !== false) : ?>
                <div class="row fpcm-ui-padding-md-tb">
                    <div class="col-12 col-md-3 fpcm-ui-padding-md-bottom fpcm-ui-padding-none-left">
                        <?php $theView->write('USERS_AUTHTOKEN_SAVE'); ?>:
                    </div>
                    <div class="col-sm-12 col-md-3 fpcm-ui-padding-none-left">
                        <?php $theView->textInput('data[authCodeConfirm]', 'authCodeConfirm')->setValue('')->setMaxlenght(6); ?>
                        <?php $theView->hiddenInput('data[authSecret]', 'authSecret')->setValue($secret); ?>
                    </div>
                </div>
                <div class="row fpcm-ui-padding-md-tb fpcm-ui-center">
                    <div class="col-sm-12">
                        <img src="<?php echo $qrCode; ?>">
                    </div>
                </div>
                <?php else : ?>
                <div class="row fpcm-ui-padding-md-tb">
                    <div class="col-12">
                        <?php $theView->icon('user-secret')->setStack('check fpcm-ui-editor-metainfo fpcm-ui-status-075')->setSize('lg')->setStackTop(true); ?>
                        <?php $theView->write('USERS_AUTHTOKEN_ACTIVE'); ?>
                        <?php $theView->checkbox('disable2Fa')->setText('GLOBAL_DISABLE'); ?>

                    </div>
                </div>
                <?php endif; ?>
            </fieldset>
        </div>
    </div>
    <?php endif; ?>

<?php endif; ?>
