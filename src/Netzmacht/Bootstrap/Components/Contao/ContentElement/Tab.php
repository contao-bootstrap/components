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
 * Class ContentTab
 *
 * @package Netzmacht\Bootstrap
 */
class Tab extends Wrapper
{

    /**
     * @var string
     */
    protected $strTemplate = 'ce_bootstrap_tab';

    /**
     * @var
     */
    protected $tabDefinition;

    /**
     * @var mixed
     */
    protected $tabs;

    /**
     * @var
     */
    protected $currentTab;

    /**
     * prepare tab content element
     * @param $objElement
     */
    public function __construct($objElement)
    {
        parent::__construct($objElement);

        // load tab definitions
        if ($this->wrapper->isTypeOf(Wrapper\Helper::TYPE_START)) {
            $tabs = deserialize($this->bootstrap_tabs, true);
            $tab  = null;

            foreach ($tabs as $i => $t) {
                $tabs[$i]['id'] = standardize($t['title']);

                if ($t['type'] != 'dropdown' && !$tab) {
                    $tab = $tabs[$i];
                }
            }

            $this->currentTab = $tab;
            $this->tabs       = $tabs;
            $this->fade       = $this->bootstrap_fade;
        } elseif ($this->wrapper->isTypeOf(Wrapper\Helper::TYPE_SEPARATOR)) {
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

            foreach ($tabs as $i => $t) {
                $tabs[$i]['id'] = standardize($t['title']);

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

    /**
     * compile tabs
     */
    protected function compile()
    {
        $this->Template->tabs       = $this->tabs;
        $this->Template->currentTab = $this->currentTab;
        $this->Template->toggle     = Bootstrap::getConfigVar('dropdown.toggle');
    }

    /**
     * @return string
     */
    protected function generateTitle()
    {
        if ($this->currentTab['title'] != '') {
            return '<strong class="title">' . $this->currentTab['title'] . '</strong>';
        }

        return '';
    }
}
