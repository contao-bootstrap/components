<?php

namespace Netzmacht\Bootstrap\Components\Modal;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Bootstrap\Core\Event\InitializeEnvironmentEvent;
use Netzmacht\Bootstrap\Core\Event\ReplaceInsertTagsEvent;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Html\Element;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Subscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array (
            InitializeEnvironmentEvent::NAME => 'presetConfig',
            ReplaceInsertTagsEvent::NAME     => 'replaceInsertTags',
            'form-helper.generate-view'      =>  'createModalFooter',
        );
    }

    /**
     * @param InitializeEnvironmentEvent $event
     */
    public function presetConfig(InitializeEnvironmentEvent $event)
    {
        $config = $event->getEnvironment()->getConfig();
        $config->set('runtime.modal-footer', false);
    }

    /**
     * @param ViewEvent $event
     */
    public function createModalFooter(ViewEvent $event)
    {
        $widget  = $event->getWidget();
        $element = $event->getContainer()->getElement();

        if ($this->isPartOfModalFooter($widget)) {
            $buttons = (array) Bootstrap::getConfigVar('runtime.modal-footer');

            // create copy for footer
            /** @var Element $element */
            $copy = clone $element;
            $copy->setAttribute('onclick', sprintf('$(\'#ctrl_%s\').click();', $widget->id));
            $copy->setId('md_' . $element->getId());
            $copy->addClass('btn');

            $event->getView()->getAttributes()->addClass('sr-only');

            $buttons[] = $copy;
            Bootstrap::setConfigVar('runtime.modal-footer', $buttons);
        }
    }

    /**
     * Replace modal tag, modal tag supports following formats:
     *
     * modal::id
     *      - SimpleAjax.php?modal=id?page=Pageid
     * modal::link::id
     *      - <a href="#modal-id" data-toggle="modal">Module name</a>
     * modal::url::id
     *      - #modal-id
     * modal::link::id::title
     *      - <a href="#modal-id" data-toggle="modal">Title</a>
     *
     * modal::id::type::typeid
     *      - SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid
     * modal::link::id::type::typeid
     *      - <a href="SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid" data-toggle="modal" data-remote="SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid">Module name</a>
     *      - The data-target is nessecary because Bootstrap ony checks for data-remote if content is cached
     *      - href attribute is set for accessibility issues
     * modal::link::id::type::typeid::title
     *      - <a href="SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid" data-toggle="modal" data-remote="SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid">Title</a>
     *
     * modal::url::
     *
     * @param  ReplaceInsertTagsEvent $event
     * @return void
     */
    public function replaceInsertTags(ReplaceInsertTagsEvent $event)
    {
        if ($event->getTag() != 'modal') {
            return;
        }

        $params = $event->getParams();

        if (is_numeric($params[0])) {
            array_insert($params, 0, array('remote'));
        }

        if (!isset($GLOBALS['TL_BODY']['bootstrap-modal-' . $params[1]])) {
            $model = \ModuleModel::findByPk($params[1]);

            if ($model != null && $model->type == 'bootstrap_modal') {
                $event->setHtml(\Controller::getFrontendModule($params[1]));
            }
        }

        $count = count($params);

        if ($count == 2 || $count == 3) {
            switch ($params[0]) {
                case 'remote':
                    if (TL_MODE === 'FE') {
                        $buffer = \Controller::generateFrontendUrl($GLOBALS['objPage']->row()) . '?bootstrap_modal=' . $params[1];
                    } else {
                        $buffer = '{{modal::' . $params[1] . '}}';
                    }

                    break;

                case 'url':
                case 'link':
                    $model = \ModuleModel::findByPk($params[1]);

                    if ($model === null || $model->type != 'bootstrap_modal') {
                        return;
                    }

                    $cssId = deserialize($model->cssID, true);
                    $buffer = '#' . ($cssId[0] != '' ? $cssId[0] : 'modal-' . $model->id);

                    if ($params[0] != 'link') {
                        break;
                    }

                    $params[2] = ($count == 3) ? $params[2] : $model->name;
                    $buffer    = sprintf('<a href="%s" data-toggle="modal">%s</a>', $buffer, $params[2]);
                    break;

                default:
                    return;
            }

            $event->setHtml($buffer);
        } elseif ($count == 4 || $count == 5) {
            switch ($params[0]) {
                case 'url':
                case 'link':
                case 'remote':
                    $params[0] = $GLOBALS['objPage']->id;
                    $buffer = vsprintf(Bootstrap::getConfigVar('modal.remoteDynamicUrl'), $params);

                    if ($params[0] != 'link') {
                        break;
                    }

                    if ($count == 4) {
                        $model = \ModuleModel::findByPk($params[1]);

                        if ($model === null || $model->type != 'bootstrap_modal') {
                            return;
                        }

                        $params[6] = $model->name;

                        $cssId  = deserialize($model->cssID, true);
                        $cssId  = '#' . ($cssId[0] != '' ? $cssId[0] : 'modal-' . $model->id);
                        $buffer = sprintf( '<a href="%s" data-toggle="modal" data-remote="%s">%s</a>', $cssId, $buffer, $params[6]);
                    }

                    break;

                default:
                    return;
            }

            $event->setHtml($buffer);
        }
    }

    /**
     * @param  \Widget $widget
     * @return bool
     */
    protected function isPartOfModalFooter(\Widget $widget)
    {
        $isModal =
            Bootstrap::getConfigVar('runtime.modal-footer') !== false &&
            Bootstrap::getConfigVar('modal.adjustForm') &&
            Bootstrap::getConfigVar(sprintf('form.widgets.%s.modal-footer', $widget->type));

        return $isModal;
    }

}
