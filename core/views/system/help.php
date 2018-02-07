<div class="fpcm-content-wrapper">
    
    <div class="fpcm-tabs-general">
        <ul>
            <li><a href="#tabs-help-general"><?php $theView->lang->write('HL_HELP'); ?></a></li>
        </ul>

        <div id="tabs-help-general">
            <div class="fpcm-tabs-accordion">
                
                <p><?php $theView->lang->write('HELP_SELECT'); ?></p>
                
                <?php foreach ($chapters as $headline => $text) : ?>
                    <h2><?php $theView->lang->write($headline); ?></h2>
                    <div><?php print $text; ?></div>
                <?php endforeach; ?>       
            </div>            
        </div>        
    </div>
</div>