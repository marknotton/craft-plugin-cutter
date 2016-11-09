<?php
namespace Craft;

use Twig_Filter_Method;

class snip extends \Twig_Extension
{

	public function getName()	{
		return Craft::t('Snip');
	}

	public function getFilters() {
		return array(
			'snip' 		  => new \Twig_Filter_Method($this, 'snip'),
			'truncate'  => new \Twig_Filter_Method($this, 'snip'),
			'cut' 		  => new \Twig_Filter_Method($this, 'snip'),
			'chars' 	  => new \Twig_Filter_Method($this, 'snip'),
			'words' 	  => new \Twig_Filter_Method($this, 'words'),
			'sentences' => new \Twig_Filter_Method($this, 'sentences', array('is_safe' => array('html')) ),
		);
	}

	public function snip()	{
		$args = func_get_args();
		return call_user_func_array(array(craft()->snip_snip, 'snip'), $args);
	}

	public function words($string, $limit=40, $suffix='…')	{
		$args = func_get_args();
		return call_user_func_array(array(craft()->snip_snip, 'words'), $args);
	}

	public function sentences($string, $limit=3, $suffix='')	{
		$args = func_get_args();
		return call_user_func_array(array(craft()->snip_snip, 'sentences'), $args);
	}
}
