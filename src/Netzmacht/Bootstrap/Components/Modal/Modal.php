<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Components\Modal;

use Netzmacht\Html\Attributes;
use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Element\StaticHtml;
use Netzmacht\Html\Element;

class Modal extends Attributes
{
    /**
     * @var CastsToString
     */
    private $closeButton;

    /**
     * @var CastsToString
     */
    private $title;

    /**
     * @var string
     */
    private $size;

    /**
     * @var CastsToString
     */
    private $content;

    /**
     * @var CastsToString
     */
    private $footer;

    /**
     * @var string
     */
    private $template = 'bootstrap_modal';

    /**
     * @param array       $attributes
     * @param string|null $template
     */
    public function __construct(array $attributes = array(), $template=null)
    {
        $attributes = array_merge(array(
                'class' => array('modal', 'fade')
            ),
            $attributes
        );

        if ($template) {
            $this->template = $template;
        }

        parent::__construct($attributes);
    }

    /**
     * @return string
     */
    public function generate()
    {
        $template = new \FrontendTemplate($this->template);
        $this->render($template);

        return $template->parse();
    }

    /**
     * @param  \Template $template
     * @return $this
     */
    public function render(\Template $template)
    {
        $template->attributes  = parent::generate();
        $template->closeButton = $this->closeButton;
        $template->title       = $this->title;
        $template->content     = $this->content;
        $template->footer      = $this->footer;
        $template->size        = $this->size ? (' ' . $this->size) : '';

        return $this;
    }

    /**
     * @param  CastsToString $closeButton
     * @param  bool          $create
     * @return $this
     */
    public function setCloseButton($closeButton, $create=false)
    {
        if ($create) {
            $closeButton = Element::create('button')
                ->addClass('close')
                ->setAttribute('data-dismiss', 'modal')
                ->setAttribute('aria-hidden', 'true')
                ->addChild($closeButton);
        }

        $this->closeButton = $closeButton;

        return $this;
    }

    /**
     * @return CastsToString
     */
    public function getCloseButton()
    {
        return $this->closeButton;
    }

    /**
     * @param  CastsToString|string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $this->convertToCastsToString($content);

        return $this;
    }

    /**
     * @return CastsToString
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param  CastsToString|string $footer
     * @return $this
     */
    public function setFooter($footer)
    {
        $this->footer = $content = $this->convertToCastsToString($footer);

        return $this;
    }

    /**
     * @return CastsToString|string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param  CastsToString|string $title
     * @return $this
     */
    public function setTitle($title)
    {
        if ($title instanceof Attributes) {
            $title->addClass('modal-title');
        } else {
            $title = $this->convertToCastsToString($title);
        }

        $this->title = $title;

        return $this;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return CastsToString
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param $content
     * @return CastsToString
     */
    private function convertToCastsToString($content)
    {
        if (!$content instanceof CastsToString) {
            $content = new StaticHtml((string) $content);
        }

        return $content;
    }

}
