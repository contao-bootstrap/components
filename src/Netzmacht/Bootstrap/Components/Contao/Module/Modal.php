<?php


namespace Netzmacht\Bootstrap\Components\Contao\Module;

use Netzmacht\Bootstrap\Components\Button\Factory;
use Netzmacht\Bootstrap\Components\Modal\Modal as Component;
use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\FormHelper\Element\StaticHtml;
use Netzmacht\Html\Attributes;
use Netzmacht\Html\Element;

class Modal extends \Module
{
	/**
	 * template
	 * @var string
	 */
	protected $strTemplate = 'mod_bootstrap_modal';

	/**
	 * @var
	 */
	private $formButtons;


	/**
	 * compile
	 */
	protected function compile()
	{
		if($this->cssID[0] == '') {
			$cssID = $this->cssID;
			$cssID[0] = 'modal-' . $this->id;
			$cssID[1] .= $this->bootstrap_modalDynamicContent ? ' modal-reloadable' : '';
			$this->cssID = $cssID;
		}

		$modal = new Component();
		$modal
			->setId($this->cssID[0])
			->addClass($this->cssID[1]);

		// check if ajax is used
		if($this->bootstrap_modalAjax) {
			$this->Template->hideFrame = (bool) $this->bootstrap_isAjax;
			$this->Template->hideContent = !$this->Template->bootstrap_hideFrame;
		}

		if($this->Template->hideContent) {
			$url = sprintf(Bootstrap::getConfigVar('modal.remoteUrl'), $GLOBALS['objPage']->id, $this->id);
			$this->Template->dataRemote = ' data-remote="' . $url . '"';
			return;
		}

		// load dynamic content
		elseif($this->bootstrap_isAjax && $this->bootstrap_modalDynamicContent)
		{
			$dynamic = \Input::get('dynamic');

			if($dynamic != '' && in_array($dynamic, array('article', 'module', 'form')))
			{
				$this->{$dynamic} = \Input::get('id');
				$this->bootstrap_modalContentType = $dynamic;

			}
		}

		if($this->headline) {
			$headline = Element::create($this->hl)
				->addClass('modal-title')
				->addChild($this->headline);

			$modal->setTitle($headline);
		}

		$modal
			->setContent($this->getContent())
			->setFooter($this->getButtons())
			->setCloseButton(Bootstrap::getConfigVar('modal.dismiss'), true)
			->render($this->Template);
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		// add content to TL_BODY
		if(!$this->bootstrap_modalAjax || !$this->bootstrap_isAjax) {
			$content = parent::generate();
			$content = $this->replaceInsertTags($content);

			$GLOBALS['TL_BODY']['bootstrap-modal-' . $this->id] = $content;
			return '';
		}

		return parent::generate();
	}

	private function getContent()
	{
		$config = Bootstrap::getConfig();

		switch($this->bootstrap_modalContentType) {
			case 'article':
				return $this->getArticle($this->bootstrap_article, false, true);
				break;

			case 'form':
				$config->set('runtime.modal-footer', '');
				$content     = $this->getForm($this->form);
				$this->formButtons = $config->get('runtime.modal-footer');
				$config->set('runtime.modal-footer', false);

				// render style select if it is used
				// TODO move this to an event or hook
				if($this->bootstrap_isAjax && $config->get('form.styleSelect.enabled')) {
					$content .= sprintf(
						'<script>$(\'.%s\').selectpicker(\'render\');</script>',
						$config->get('form.styleSelect.class')
					);
				}

				return $content;
				break;

			case 'module':
				return $this->getFrontendModule($this->bootstrap_module);
				break;

			case 'html':
				return (TL_MODE == 'FE') ? $this->html : htmlspecialchars($this->bootstrap_html);
				break;

			case 'template':
				ob_start();
				include $this->getTemplate($this->bootstrap_modalTemplate);
				$buffer = ob_get_contents();
				ob_end_clean();

				return $buffer;
				break;

			case 'text':
				return \String::toHtml5($this->bootstrap_text);
				break;
		}
	}


	public function getButtons()
	{
		if($this->bootstrap_addModalFooter) {
			$style   = $this->bootstrap_buttonStyle ? : 'btn-default';
			$buttons = Factory::createFromFieldset($this->bootstrap_buttons);

			if($formButtons) {
				$old     = $buttons;
				$buttons = Factory::createGroup();

				foreach($formButtons as $button) {
					if(is_string($button)) {
						$button = new StaticHtml($button);
					}

					$buttons->addChild($button);
				}

				foreach($old->getChildren() as $button) {
					$buttons->addChild($button);
				}
			}

			$buttons->eachChild(function($item) use($style) {
				if(!$item instanceof Attributes) {
					return;
				}

				$classes = $item->getAttribute('class');
				$classes = array_filter($classes, function($class) {
					return strpos($class, 'btn-') !== false;
				});

				if(empty($classes)) {
					$item->addClass($style);
				}
			});

			$buttons->removeClass('btn-group');
		}
		else {
			$buttons = implode('', (array)$formButtons);
		}

		return $buttons;
	}
} 