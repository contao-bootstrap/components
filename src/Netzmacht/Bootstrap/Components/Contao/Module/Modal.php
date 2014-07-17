<?php


namespace Netzmacht\Bootstrap\Components\Contao\Module;


use Netzmacht\Bootstrap\Components\Button\Factory;
use Netzmacht\Bootstrap\Core\Bootstrap;

class Modal extends \Module
{
	/**
	 * template
	 * @var string
	 */
	protected $strTemplate = 'mod_bootstrap_modal';


	/**
	 * compile
	 */
	protected function compile()
	{
		if($this->cssID[0] == '')
		{
			$cssID = $this->cssID;
			$cssID[0] = 'modal-' . $this->id;
			$cssID[1] .= $this->bootstrap_modalDynamicContent ? ' modal-reloadable' : '';
			$this->cssID = $cssID;
		}

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

		$config = Bootstrap::getConfig();

		switch($this->bootstrap_modalContentType)
		{
			case 'article':
				$this->Template->content = $this->getArticle($this->bootstrap_article, false, true);
				break;

			case 'form':
				$config->set('runtime.modal-footer', '');
				$this->Template->content = $this->getForm($this->form);
				$this->Template->footer  = $config->get('runtime.modal-footer');
				$config->set('runtime.modal-footer', false);

				// render style select if it is used
				// TODO move this to an event or hook
				if($this->bootstrap_isAjax && $config->get('form.styleSelect.enabled')) {
					$this->Template->content .= sprintf(
						'<script>$(\'.%s\').selectpicker(\'render\');</script>',
						$config->get('form.styleSelect.class')
					);
				}

				break;

			case 'module':
				$this->Template->content = $this->getFrontendModule($this->bootstrap_module);
				break;

			case 'html':
				$this->Template->content = (TL_MODE == 'FE') ? $this->html : htmlspecialchars($this->bootstrap_html);
				break;

			case 'template':
				ob_start();
				include $this->getTemplate($this->bootstrap_modalTemplate);
				$buffer = ob_get_contents();
				ob_end_clean();

				$this->Template->content = $buffer;

				break;

			case 'text':
				$this->Template->content = \String::toHtml5($this->bootstrap_text);
				break;
		}

		if($this->bootstrap_addModalFooter) {
			$buttons = Factory::createFromFieldset($this->bootstrap_buttons);
			$buttons->addClass($this->bootstrap_buttonStyle ? $this->bootstrap_buttonStyle : 'btn-default');

			$this->Template->footerButtons = $buttons;
		}

		$this->Template->headerClose = $config->get('modal.dismiss');
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		// add content to TL_BODY
		if(!$this->bootstrap_modalAjax || !$this->bootstrap_isAjax) {
			$GLOBALS['TL_BODY']['bootstrap-modal-' . $this->id] = parent::generate();
			return '';
		}

		return parent::generate();
	}
} 