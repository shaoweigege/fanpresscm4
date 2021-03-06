<?php

/**
 * System stats Dashboard Container
 * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\model\dashboard;

/**
 * System stats dashboard container object
 * 
 * @package fpcm\model\dashboard
 * @author Stefan Seehafer <sea75300@yahoo.de>
 */
class sysstats extends \fpcm\model\abstracts\dashcontainer {

    /**
     * Container table content
     * @var array
     */
    protected $tableContent = [];

    /**
     * Coutn of deleted items
     * @var int
     */
    protected $deletedCount = 0;

    /**
     * Returns name
     * @return string
     */
    public function getName()
    {
        return 'sysstats';
    }

    /**
     * Returns content
     * @return string
     */
    public function getContent()
    {
        $this->getCacheName();
        $this->runCheck();
        return PHP_EOL.'<div class="row">'.implode('</div>'.PHP_EOL.'<div class="row">'.PHP_EOL, $this->tableContent).'</div>'.PHP_EOL;
    }

    /**
     * Return container headline
     * @return string
     */
    public function getHeadline()
    {
        return 'SYSTEM_STATS';
    }

    /**
     * Returns container position
     * @return int
     */
    public function getPosition()
    {
        return 6;
    }

    /**
     * Returns container height
     * @return string
     */
    public function getHeight()
    {
        return self::DASHBOARD_HEIGHT_SMALL_MEDIUM;
    }

    /**
     * Check ausführen
     */
    protected function runCheck()
    {

        if ($this->cache->isExpired($this->cacheName)) {
            $this->getArticleStats();
            $this->getCommentStats();
            $this->getUserStats();
            $this->getFileStats();

            $this->cache->write($this->cacheName, $this->tableContent, $this->config->system_cache_timeout);
        } else {
            $this->tableContent = $this->cache->read($this->cacheName);
        }

        $this->getCacheStats();
    }

    /**
     * Artikel-Statistiken berechnen
     */
    protected function getArticleStats()
    {
        $articleList = new \fpcm\model\articles\articlelist();

        $sObj = new \fpcm\model\articles\search();
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('book')).' <strong>' . $this->language->translate('SYSTEM_STATS_ARTICLES_ALL') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-padding-none-lr fpcm-ui-center">' . $articleList->countArticlesByCondition($sObj) . '</div>';

        $sObj = new \fpcm\model\articles\search();
        $sObj->approval = -1;
        $sObj->draft = 0;
        $sObj->archived = 0;
        $sObj->deleted = 0;
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('newspaper', 'far')).' <strong>' . $this->language->translate('SYSTEM_STATS_ARTICLES_ACTIVE') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-padding-none-lr fpcm-ui-center">' . $articleList->countArticlesByCondition($sObj) . '</div>';

        $sObj = new \fpcm\model\articles\search();
        $sObj->archived = 1;
        $sObj->approval = -1;
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('archive')).' <strong>' . $this->language->translate('SYSTEM_STATS_ARTICLES_ARCHIVE') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-padding-none-lr fpcm-ui-center">' . $articleList->countArticlesByCondition($sObj) . '</div>';

        $sObj = new \fpcm\model\articles\search();
        $sObj->draft = 1;
        $sObj->approval = -1;
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('file-alt', 'far')).' <strong>' . $this->language->translate('SYSTEM_STATS_ARTICLES_DRAFT') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-padding-none-lr fpcm-ui-center">' . $articleList->countArticlesByCondition($sObj) . '</div>';

        $sObj = new \fpcm\model\articles\search();
        $sObj->deleted = 1;
        $this->deletedCount += $articleList->countArticlesByCondition($sObj);

        $sObj = new \fpcm\model\articles\search();
        $sObj->approval = 1;
        $count = $articleList->countArticlesByCondition($sObj);
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr ' . ($count > 0 ? 'fpcm-ui-important-text' : '') . '">'
                . (new \fpcm\view\helper\icon('thumbs-up', 'far')).' <strong>' . $this->language->translate('SYSTEM_STATS_ARTICLES_APPROVAL') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $count . '</div>';
    }

    /**
     * Kommentar-Statistiken berechnen
     */
    protected function getCommentStats()
    {
        $commentList = new \fpcm\model\comments\commentList();

        $sObj = new \fpcm\model\comments\search();
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('comments')).' <strong>' . $this->language->translate('SYSTEM_STATS_COMMENTS_ALL') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $commentList->countCommentsByCondition($sObj) . '</div>';

        $sObj = new \fpcm\model\comments\search();
        $sObj->unapproved = true;
        $count = $commentList->countCommentsByCondition($sObj);
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr ' . ($count > 0 ? 'fpcm-ui-important-text' : '') . '">'
                . (new \fpcm\view\helper\icon('check-circle', 'far')).' <strong>' . $this->language->translate('SYSTEM_STATS_COMMENTS_UNAPPR') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $count . '</div>';

        $sObj = new \fpcm\model\comments\search();
        $sObj->private = true;
        $count = $commentList->countCommentsByCondition($sObj);
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr ' . ($count > 0 ? 'fpcm-ui-important-text' : '') . '">'
                . (new \fpcm\view\helper\icon('eye-slash')).' <strong>' . $this->language->translate('SYSTEM_STATS_COMMENTS_PRIVATE') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $count . '</div>';

        $sObj = new \fpcm\model\comments\search();
        $sObj->spam = true;
        $count = $commentList->countCommentsByCondition($sObj);
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr ' . ($count > 0 ? 'fpcm-ui-important-text' : '') . '">'
                . (new \fpcm\view\helper\icon('flag')).' <strong>' . $this->language->translate('SYSTEM_STATS_COMMENTS_SPAM') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $count . '</div>';

        $sObj = new \fpcm\model\comments\search();
        $sObj->deleted = true;
        $this->deletedCount += $commentList->countCommentsByCondition($sObj);
    }

    /**
     * Benutzer-Statistiken berechnen
     */
    protected function getUserStats()
    {
        $userCountAll = $this->dbcon->count(\fpcm\classes\database::tableAuthors);
        $userCountAct = $this->dbcon->count(\fpcm\classes\database::tableAuthors, '*', 'disabled = 0');
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('users')).' <strong>' . $this->language->translate('SYSTEM_STATS_USERS') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $userCountAll . ' (' . $userCountAct . ')</div>';

        $categoryCount = $this->dbcon->count(\fpcm\classes\database::tableCategories);
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('file-alt', 'far')).' <strong>' . $this->language->translate('SYSTEM_STATS_CATEGORIES') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $categoryCount . '</div>';
    }

    /**
     * Datei-Statistiken berechnen
     */
    protected function getFileStats()
    {

        $fileCount = $this->dbcon->count(\fpcm\classes\database::tableFiles, '*');
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('copy', 'far')).' <strong>' . $this->language->translate('SYSTEM_STATS_UPLOAD_COUNT') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $fileCount . '</div>';

        $imgList = new \fpcm\model\files\imagelist();
        $folderSize = \fpcm\classes\tools::calcSize($imgList->getUploadFolderSize());
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('calculator')).' <strong>' . $this->language->translate('SYSTEM_STATS_UPLOAD_SIZE') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $folderSize . '</div>';
    }

    /**
     * Cache-Statistiken berechnen
     */
    protected function getCacheStats()
    {
        $folderSize = \fpcm\classes\tools::calcSize($this->cache->getSize());
        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('hdd')).' <strong>' . $this->language->translate('SYSTEM_STATS_CACHE_SIZE') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $folderSize . '</div>';

        $this->tableContent[] = '<div class="col-8 fpcm-ui-padding-none-lr">'
                . (new \fpcm\view\helper\icon('flag')).' <strong>' . $this->language->translate('SYSTEM_STATS_TRASHCOUNT') . ':</strong></div>'
                . '<div class="col-4 fpcm-ui-center">' . $this->deletedCount . '</div>';
    }

}
