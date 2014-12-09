<?php

/**
 * @package   netzmacht-bootstrap
 * @author    netzmacht creative David Molineus
 * @license   MPL/2.0
 * @copyright 2013 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Components\Contao\ContentElement;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Bootstrap\Core\Contao\ContentElement\Wrapper;

/**
 * Tab content element.
 *
 * @package Netzmacht\Bootstrap
 */
class Tab extends Wrapper
{
    /**
     * Template name.
     *
     * @var string
     */
    protected $strTemplate = 'ce_bootstrap_tab';

    /**
     * Tab definition.
     *
     * @var array
     */
    protected $tabDefinition;

    /**
     * Prepared tabs.
     *
     * @var array
     */
    protected $tabs = array();

    /**
     * Current tab.
     *
     * @var array
     */
    protected $currentTab;

    /**
     * Construct. Prepare tab content element.
     *
     * @param \ContentModel $element Content model.
     */
    public function __construct($element)
    {
        parent::__construct($element);

        // load tab definitions
        if ($this->wrapper->isTypeOf(Wrapper\Helper::TYPE_START)) {
            $this->initializeStartElement();
        } elseif ($this->wrapper->isTypeOf(Wrapper\Helper::TYPE_SEPARATOR)) {
            $this->initializeSeparator();
        }
    }

    /**
     * Compile tabs.
     *
     * @return void
     */
    protected function compile()
    {
        $this->Template->tabs       = $this->tabs;
        $this->Template->currentTab = $this->currentTab;
        $this->Template->toggle     = Bootstrap::getConfigVar('dropdown.toggle');
    }

    /**
     * Generate title.
     *
     * @return string
     */
    protected function generateTitle()
    {
        if ($this->currentTab['title'] != '') {
            return '<strong class="title">' . $this->currentTab['title'] . '</strong>';
        }

        return '';
    }

    /**
     * Initialize start element.
     *
     * @return void
     */
    private function initializeStartElement()
    {
        $tabs = deserialize($this->bootstrap_tabs, true);
        $tab  = null;
        $ids  = array();

        foreach ($tabs as $i => $t) {
            $cssId = standardize($t['title']);

            if (in_array($cssId, $ids)) {
                $cssId = $i . '-' . $cssId;
            }

            $ids[]           = $cssId;
            $tabs[$i]['id'] = $cssId;

            if ($t['type'] != 'dropdown' && !$tab) {
                $tab = $tabs[$i];
            }
        }

        $this->currentTab = $tab;
        $this->tabs       = $tabs;
        $this->fade       = $this->bootstrap_fade;
    }

    /**
     * Initialize separator.
     *
     * @return void
     */
    private function initializeSeparator()
    {
        $elements = \Database::getInstance()
            ->prepare('SELECT id FROM tl_content WHERE bootstrap_parentId=? ORDER by sorting')
            ->execute($this->bootstrap_parentId);

        $elements = array_merge(array($this->bootstrap_parentId), $elements->fetchEach('id'));
        $parent   = \ContentModel::findByPK($this->bootstrap_parentId);
        $index    = 0;

        if ($parent) {
            $this->fade = $parent->bootstrap_fade;
        }

        $tabs = deserialize($parent->bootstrap_tabs, true);
        $ids  = array();

        foreach ($tabs as $i => $t) {
            $cssId = standardize($t['title']);

            if (in_array($cssId, $ids)) {
                $cssId = $i . '-' . $cssId;
            }

            $ids[]           = $cssId;
            $tabs[$i]['id'] = $cssId;

            if ($t['type'] != 'dropdown') {
                if ($elements[$index] == $this->id) {
                    $this->currentTab = $tabs[$i];
                    break;
                }
                $index++;
            }
        }

        $this->tabs = $tabs;
    }
}
