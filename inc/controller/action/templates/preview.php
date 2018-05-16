<?php

/**
 * Template preview controller
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\action\templates;

class preview extends \fpcm\controller\abstracts\controller {

    use \fpcm\controller\traits\templates\preview;

    /**
     *
     * @var \fpcm\model\pubtemplates\template
     */
    protected $template;

    /**
     *
     * @var int 
     */
    protected $tid;

    /**
     * 
     * @return array
     */
    protected function getPermissions()
    {
        return ['system' => 'templates'];
    }

    /**
     * Request-Handler
     * @return boolean
     */
    public function request()
    {
        $this->tid = $this->getRequestVar('tid');

        if (!$this->tid) {
            return false;
        }

        return true;
    }

    /**
     * Controller-Processing
     * @return boolean
     */
    public function process()
    {
        $this->template = $this->getTemplateById($this->tid);

        switch ($this->tid) {
            case \fpcm\model\pubtemplates\article::TEMPLATE_ID :
                $this->getArticlesPreview();
                break;
            case \fpcm\model\pubtemplates\article::TEMPLATE_ID_SINGLE :
                $this->getArticlePreview();
                break;
            case \fpcm\model\pubtemplates\comment::TEMPLATE_ID :
                $this->getCommentPreview();
                break;
            case \fpcm\model\pubtemplates\commentform::TEMPLATE_ID :
                $this->getCommentFormPreview();
                break;
            case \fpcm\model\pubtemplates\latestnews::TEMPLATE_ID :
                $this->getLatestNewsPreview();
                break;
            default :
                $this->view = new \fpcm\view\error('Invalid template data');
                return;
        }

        $this->view->assign('showToolbars', false);
        $this->view->assign('hideDebug', true);
        $this->view->assign('systemMode', 1);
        $this->view->showHeaderFooter(\fpcm\view\view::INCLUDE_HEADER_SIMPLE);

        $cssfiles = [];
        if (trim($this->config->system_css_path)) {
            $cssfiles[] = trim($this->config->system_css_path);
        }

        $this->view->overrideJsFiles($this->events->trigger('pub\addJsFiles', [
            \fpcm\classes\dirs::getLibUrl('jquery/jquery-3.3.1.min.js'),
            \fpcm\classes\dirs::getRootUrl('js/fpcm.js')
        ]));
        
        $this->view->overrideCssFiles($this->events->trigger('pub\addCssFiles', $cssfiles));
        $this->view->render();
    }

    private function getArticlesPreview()
    {
        $this->view = new \fpcm\view\view('public/showall');

        $parsed = [];

        $categoryTexts = array('<span class="fpcm-pub-category-text">Category 1</span>', '<span class="fpcm-pub-category-text">Category 2</span>');
        $shareButtonParser = new \fpcm\model\pubtemplates\sharebuttons($this->config->system_url, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr!');

        $this->template->setReplacementTags([
            '{{headline}}' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr!',
            '{{text}}' => 'Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
            '{{author}}' => $this->session->getCurrentUser()->getUsername(),
            '{{authorEmail}}' => '<a href="mailto:' . $this->session->getCurrentUser()->getEmail() . '">' . $this->session->getCurrentUser()->getDisplayname() . '</a>',
            '{{authorAvatar}}' => \fpcm\model\users\author::getAuthorImageDataOrPath($this->session->getCurrentUser(), 0),
            '{{authorInfoText}}' => $this->session->getCurrentUser()->getUsrinfo(),
            '{{date}}' => date($this->config->system_dtmask, time()),
            '{{changeDate}}' => date($this->config->system_dtmask, time()),
            '{{changeUser}}' => $this->session->getCurrentUser()->getDisplayname(),
            '{{statusPinned}}' => '',
            '{{shareButtons}}' => $shareButtonParser->parse(),
            '{{categoryIcons}}' => '',
            '{{categoryTexts}}' => implode(PHP_EOL, $categoryTexts),
            '{{commentCount}}' => 0,
            '{{permaLink}}:{{/permaLink}}' => $this->config->system_url,
            '{{commentLink}}:{{/commentLink}}' => $this->config->system_url . '#comments',
            '<readmore>:</readmore>' => md5(time()),
            '{{articleImage}}' => '',
            '{{sources}}' => $this->config->system_url
        ]);
        $parsed[] = $this->template->parse();

        $categoryTexts = array('<span class="fpcm-pub-category-text">Category 3</span>', '<span class="fpcm-pub-category-text">Category 4</span>');
        $shareButtonParser = new \fpcm\model\pubtemplates\sharebuttons($this->config->system_url, 'Ut wisi enim ad minim veniam?');

        $this->template->setReplacementTags([
            '{{headline}}' => 'Ut wisi enim ad minim veniam?',
            '{{text}}' => 'Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. ',
            '{{author}}' => $this->session->getCurrentUser()->getUsername(),
            '{{authorEmail}}' => '<a href="mailto:' . $this->session->getCurrentUser()->getEmail() . '">' . $this->session->getCurrentUser()->getDisplayname() . '</a>',
            '{{authorAvatar}}' => '',
            '{{authorInfoText}}' => '',
            '{{date}}' => date($this->config->system_dtmask, time() - 3600),
            '{{changeDate}}' => date($this->config->system_dtmask, time() - 3600),
            '{{changeUser}}' => $this->session->getCurrentUser()->getDisplayname(),
            '{{statusPinned}}' => '',
            '{{shareButtons}}' => $shareButtonParser->parse(),
            '{{categoryIcons}}' => '',
            '{{categoryTexts}}' => implode(PHP_EOL, $categoryTexts),
            '{{commentCount}}' => 0,
            '{{permaLink}}:{{/permaLink}}' => $this->config->system_url,
            '{{commentLink}}:{{/commentLink}}' => $this->config->system_url . '#comments',
            '<readmore>:</readmore>' => md5(time()),
            '{{articleImage}}' => '',
            '{{sources}}' => ''
        ]);
        $parsed[] = $this->template->parse();

        $this->view->assign('content', implode(PHP_EOL, $parsed));
        $this->view->assign('commentform', '');
    }

    private function getArticlePreview()
    {
        $this->view = new \fpcm\view\view('public/showsingle');

        $categoryTexts = array('<span class="fpcm-pub-category-text">Category 1</span>', '<span class="fpcm-pub-category-text">Category 2</span>');
        $shareButtonParser = new \fpcm\model\pubtemplates\sharebuttons($this->config->system_url, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr!');

        $this->template->setReplacementTags([
            '{{headline}}' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr!',
            '{{text}}' => 'Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
            '{{author}}' => $this->session->getCurrentUser()->getDisplayname(),
            '{{authorEmail}}' => '<a href="mailto:' . $this->session->getCurrentUser()->getEmail() . '">' . $this->session->getCurrentUser()->getDisplayname() . '</a>',
            '{{authorAvatar}}' => \fpcm\model\users\author::getAuthorImageDataOrPath($this->session->getCurrentUser(), 0),
            '{{authorInfoText}}' => $this->session->getCurrentUser()->getUsrinfo(),
            '{{date}}' => date($this->config->system_dtmask, time()),
            '{{changeDate}}' => date($this->config->system_dtmask, time()),
            '{{changeUser}}' => $this->session->getCurrentUser()->getDisplayname(),
            '{{statusPinned}}' => '',
            '{{shareButtons}}' => $shareButtonParser->parse(),
            '{{categoryIcons}}' => '',
            '{{categoryTexts}}' => implode(PHP_EOL, $categoryTexts),
            '{{commentCount}}' => 0,
            '{{permaLink}}:{{/permaLink}}' => $this->config->system_url,
            '{{commentLink}}:{{/commentLink}}' => $this->config->system_url . '#comments',
            '<readmore>:</readmore>' => md5(time()),
            '{{articleImage}}' => '',
            '{{sources}}' => $this->config->system_url
        ]);

        $this->view->assign('article', $this->template->parse());
        $this->view->assign('comments', '');
        $this->view->assign('commentform', '');
    }

    private function getCommentPreview()
    {
        $this->view = new \fpcm\view\view('public/showsingle');
        $this->view->assign('article', '');

        $this->template->setReplacementTags([
            '{{author}}' => $this->session->getCurrentUser()->getDisplayname(),
            '{{email}}' => $this->session->getCurrentUser()->getEmail(),
            '{{website}}' => $this->config->system_url,
            '{{text}}' => 'Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. ',
            '{{date}}' => date($this->config->system_dtmask, time() - 600),
            '{{number}}' => 1,
            '{{id}}' => 1,
            '{{mentionid}}' => 'id="c1"',
            '{{mention}}:{{/mention}}' => 1
        ]);
        $this->view->assign('comments', $this->template->parse());
        $this->view->assign('commentform', '');
    }

    private function getCommentFormPreview()
    {
        $this->view = new \fpcm\view\view('public/showsingle');
        $this->view->assign('article', '');
        $this->view->assign('comments', '');

        $captcha = $this->events->trigger('pub\replaceSpamCaptcha');

        if (!is_a($captcha, '\fpcm\model\abstracts\spamCaptcha')) {
            $captcha = new \fpcm\model\captchas\fpcmDefault();
        }

        $smileyList = new \fpcm\model\files\smileylist();
        $smileys = $smileyList->getDatabaseList();

        $smileyHtml = [];
        $smileyHtml[] = "<ul class=\"fpcm-pub-smileys\">";
        foreach ($smileys as $smiley) {
            $smileyHtml[] = '<li><a class="fpcm-pub-commentsmiley" smileycode="' . $smiley->getSmileyCode() . '" href="#"><img src="' . $smiley->getSmileyUrl() . '" alt="' . $smiley->getSmileyCode() . '()" ' . $smiley->getWhstring() . '></a></li>';
        }
        $smileyHtml[] = '</ul>';

        $this->template->setReplacementTags([
            '{{formHeadline}}' => $this->lang->translate('COMMENTS_PUBLIC_FORMHEADLINE'),
            '{{submitUrl}}' => $this->config->system_url,
            '{{nameDescription}}' => $this->lang->translate('COMMMENT_AUTHOR'),
            '{{nameField}}' => '<input type="text" class="fpcm-pub-textinput" name="newcomment[name]" value="">',
            '{{emailDescription}}' => $this->lang->translate('GLOBAL_EMAIL'),
            '{{emailField}}' => '<input type="text" class="fpcm-pub-textinput" name="newcomment[email]" value="">',
            '{{websiteDescription}}' => $this->lang->translate('COMMMENT_WEBSITE'),
            '{{websiteField}}' => '<input type="text" class="fpcm-pub-textinput" name="newcomment[website]" value="">',
            '{{textfield}}' => '<textarea class="fpcm-pub-textarea" id="newcommenttext" name="newcomment[text]"></textarea>',
            '{{smileysDescription}}' => $this->lang->translate('HL_OPTIONS_SMILEYS'),
            '{{smileys}}' => implode(PHP_EOL, $smileyHtml),
            '{{tags}}' => htmlentities(\fpcm\model\comments\comment::COMMENT_TEXT_HTMLTAGS_FORM),
            '{{spampluginQuestion}}' => $captcha->createPluginText(),
            '{{spampluginField}}' => $captcha->createPluginInput(),
            '{{privateCheckbox}}' => '<input type="checkbox" class="fpcm-pub-checkboxinput" name="newcomment[private]" value="1">',
            '{{privacyComfirmation}}' => '<input type="checkbox" class="fpcm-pub-checkboxinput" name="newcomment[privacy]" value="1">',
            '{{submitButton}}' => '<button type="submit" name="btnSendComment">' . $this->lang->translate('GLOBAL_SUBMIT') . '</button>',
            '{{resetButton}}' => '<button type="reset">' . $this->lang->translate('GLOBAL_RESET') . '</button>'
        ]);
        $this->view->assign('commentform', $this->template->parse());
    }

    private function getLatestNewsPreview()
    {
        $this->view = new \fpcm\view\view('public/showlatest');

        $this->template->setReplacementTags([
            '{{headline}}' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr!',
            '{{author}}' => $this->session->getCurrentUser()->getDisplayname(),
            '{{date}}' => date($this->config->system_dtmask, time()),
            '{{permaLink}}:{{/permaLink}}' => $this->config->system_url,
            '{{commentLink}}:{{/commentLink}}' => $this->config->system_url . '#comments'
        ]);
        $parsed[] = $this->template->parse();

        $this->template->setReplacementTags([
            '{{headline}}' => 'Ut wisi enim ad minim veniam?',
            '{{author}}' => $this->session->getCurrentUser()->getDisplayname(),
            '{{date}}' => date($this->config->system_dtmask, time() - 3600),
            '{{permaLink}}:{{/permaLink}}' => $this->config->system_url,
            '{{commentLink}}:{{/commentLink}}' => $this->config->system_url . '#comments'
        ]);
        $parsed[] = $this->template->parse();

        $this->view->assign('content', implode(PHP_EOL, $parsed));
    }

}

?>