<table class="fpcm-ui-table">
    <?php include $theView->getIncludePath('templates/replacementhead.php'); ?>
    <tr>
        <td class="fpcm-ui-template-replacements ui-widget-content ui-corner-all ui-state-normal">
            <dl>
            <?php foreach ($replacementsLatestNews as $tag => $descr) : ?>
                <dt><?php print $tag; ?></dt>        
                <dd><?php print $descr; ?></dd>
            <?php endforeach; ?>
            </dl>
        </td>
    </tr>
    <?php include $theView->getIncludePath('templates/editorhead.php'); ?>
    <tr>
        <td>
            <?php fpcm\view\helper::textArea('template[latestNews]', 'fpcm-full-width', $contentLatestNews); ?>
        </td>
    </tr>                    
</table>