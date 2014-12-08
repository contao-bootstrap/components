<?php


namespace Netzmacht\Bootstrap\Components\Contao\Module;

use Netzmacht\Bootstrap\Components\Button\Factory;
use Netzmacht\Bootstrap\Components\Button\Group;
use Netzmacht\Bootstrap\Components\Button\Toolbar;
use Netzmacht\Bootstrap\Components\Modal\Modal as Component;
use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;
use Netzmacht\Html\Element;
use Netzmacht\Html\Element\StaticHtml;

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
			$this->cssID = $cssID;
		}

		$modal = new Component();
		$modal
			->setId($this->cssID[0])
			->setSize($this->bootstrap_modalSize);

		if($this->cssID[1]) {
			$modal->addClass($this->cssID[1]);
		}

		// check if ajax is used
		if($this->bootstrap_modalAjax) {
			$this->Template->hideFrame   = $this->isAjax;
			$this->Template->hideContent = !$this->Template->hideFrame;
		}

		if($this->Template->hideContent) {
			$url = \Controller::generateFrontendUrl($GLOBALS['objPage']->row()) . '?bootstrap_modal=' . $this->id;
			//$url = sprintf(Bootstrap::getConfigVar('modal.remoteUrl'), $GLOBALS['objPage']->id, $this->id);
			$modal
				->setAttribute('data-remote', $url)
				->render($this->Template);

			return;
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
		if(TL_MODE == 'BE') {
			$template = new \FrontendTemplate('be_wildcard');
			$template->wildcard = '### modal window ###';

			return $template->parse();
		}

		if($this->bootstrap_modalAjax && \Input::get('bootstrap_modal') == $this->id ) {
			$this->isAjax = true;
		}

		$content = parent::generate();
		$content = $this->replaceInsertTags($content);

		// add content to TL_BODY
		if($this->isAjax) {
			echo $content;
			exit;
		}

        Bootstrap::setConfigVar('runtime.modals.' . $this->id, $content);
		return '';
	}


	/**
	 * @return string
	 */
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
				if($this->isAjax && $config->get('form.styleSelect.enabled')) {
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

		return '';
	}


	/**
	 * @return Group|Toolbar|string
	 */
	public function getButtons()
	{
		if($this->bootstrap_addModalFooter) {
			$style   = $this->bootstrap_buttonStyle ? : 'btn-default';
			$buttons = Factory::createFromFieldset($this->bootstrap_buttons);

			if($this->formButtons) {
				$old     = $buttons;
				$buttons = Factory::createGroup();

				foreach($this->formButtons as $button) {
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
			$buttons = implode('', (array)$this->formButtons);
		}

		return $buttons;
	}
}
