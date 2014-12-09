<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Components\Contao\DataContainer;

use Netzmacht\Bootstrap\Core\Contao\ContentElement\Wrapper\Helper;

class Content
{

    /**
     * count existing tab separators elements
     *
     * @param \Database\Result $model
     * @param Helper $helper
     *
     * @return int
     */
    public function countExistingTabSeparators(\Database\Result $model, Helper $helper)
    {
        if ($helper->isTypeOf(Helper::TYPE_START)) {
            $modelId = $model->id;
        } else {
            $modelId = $model->bootstrap_parentId;
        }

        $number = \ContentModel::countBy(
            'type=? AND bootstrap_parentId',
            array($helper->getTypeName(Helper::TYPE_SEPARATOR), $modelId)
        );

        return $number;
    }

    /**
     * count required tab separator elements
     *
     * @param \Database\Result $model
     * @param Helper $helper
     *
     * @return int
     */
    public function countRequiredTabSeparators(\Database\Result $model, Helper $helper)
    {
        if (!$helper->isTypeOf(Helper::TYPE_START)) {
            $model = \ContentModel::findByPk($model->bootstrap_parentId);
        }

        $tabs = array();

        if ($model->bootstrap_tabs) {
            $tabs = deserialize($model->bootstrap_tabs, true);
        } elseif (\Input::post('bootstrap_tabs')) {
            $tabs = \Input::post('bootstrap_tabs');
        }

        $count = 0;

        foreach ($tabs as $tab) {
            if ($tab['type'] != 'dropdown') {
                $count++;
            }
        }

        return $count > 0 ? ($count - 1 ) : 0;
    }

}
