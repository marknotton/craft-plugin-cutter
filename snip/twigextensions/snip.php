<?php
namespace Craft;

use Twig_Filter_Method;

class cutter extends \Twig_Extension
{

	public function getName()	{
		return Craft::t('Snip');
	}

	public function getFilters() {
		return array(
			'snip' => new \Twig_Filter_Method($this, 'snip'),
			'truncate' => new \Twig_Filter_Method($this, 'snip'),
			'cut' => new \Twig_Filter_Method($this, 'snip'),
			'chars' => new \Twig_Filter_Method($this, 'snip'),
			'words' => new \Twig_Filter_Method($this, 'words')
		);
	}

	public function snip($string, $limit=150, $suffix='…', $delimiter='chars')	{
		// Multibyte string check
		$mb_ok = function_exists('mb_get_info');
		$addSuffix = false;

		// Get Twig charset
		$charset = craft()->templates->getTwig()->getCharset();

		$string = strip_tags($string);

		if ( $delimiter == 'chars') {
			// Trim by character count
			if (strlen($string) > $limit) {
				$trimmed = true;
				$string  = ($mb_ok) ? mb_substr($string, 0, $limit, $charset) : substr($string, 0, $limit);
				$addSuffix = true;
			}
		} elseif ( $delimiter == 'words') {
			// Trim by word count
			if (str_word_count($string, 0) > $limit) {
				$words  = str_word_count($string, 2);
				$pos    = array_keys($words);
				$string = ($mb_ok) ? mb_substr($string, 0, $pos[$limit], $charset) : substr($string, 0, $pos[$limit]);
				$addSuffix = true;
			}
		}

		if (!empty($string)) {
			if ($addSuffix) {
				return rtrim($string).html_entity_decode($suffix);
			} else {
				return rtrim($string);
			}
		}
	}

	public function words($string, $limit=40, $suffix='…')	{
		return $this->snip($string, $limit, $suffix, 'words');
	}
}
