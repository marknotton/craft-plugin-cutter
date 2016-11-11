<?php
namespace Craft;

use Twig_Filter_Method;

class snippet extends \Twig_Extension {

	public function getName()	{
		return Craft::t('Snippet');
	}

	public function getFilters() {
		return array(
			'snippet' => new \Twig_Filter_Method($this, 'snippet')
		);
	}

	public function snippet($entry, $limit=10, $fallbackField='body', $ending='…')	{
		$args = func_get_args();
		return call_user_func_array(array(craft()->snip_snippet, 'snippet'), $args);
	}

}
