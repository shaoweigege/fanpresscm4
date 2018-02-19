/**
 * FanPress CM Options Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.options = {

    init: function () {

        fpcm.ui.tabs('.fpcm-tabs-general', {
            active   : (!fpcm.vars.jsvars.runSysCheck ?  0 : (window.showTwitter ? 8 : 7)),
            activate : function(event, ui) {

                if (jQuery(ui.newTab).attr('id') === 'tabs-options-syscheck') {
                    jQuery('#syschecksubmitstats').show();
                    jQuery('#btnConfigSave').hide();
                    return false;
                }

                jQuery('#btnConfigSave').show();
                jQuery('#syschecksubmitstats').hide();
                
                fpcm.ui.controlgroup(fpcm.ui.mainToolbar, 'refresh');
            },
            addTabScroll: true
        });

        fpcm.ui.datepicker('#articles_archive_datelimit', {
            maxDate: "-3m"
        });

        jQuery('#tabs-options-syscheck').click(function () {
            fpcm.systemcheck.execute();
        });

        jQuery('#fpcmsyschecksubmitstats').click(function () {
            fpcm.options.submitStatsData();
        });
        
        fpcm.ui.selectmenu('#smtp_enabled', {
            change: function( event, data ) {
                var status = (data.item.value == 1 ? false : true);
                fpcm.ui.isReadonly('input.fpcm-ui-options-smtp-input', status);
                fpcm.ui.selectmenu('#smtp_settingsencr', {
                    disabled: status
                });
                return true;
            }
        });
    },
    
    submitStatsData: function () {
        fpcm.ui.showLoader(true);
        fpcm.ajax.get('syscheck', {
            data: {
                sendstats: 1
            },
            execDone: function () {
                fpcm.ui.showLoader(false);
            }
        });
        
    }

};