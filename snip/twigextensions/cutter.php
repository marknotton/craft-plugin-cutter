<?php
namespace Craft;

use Twig_Filter_Method;

class cutter extends \Twig_Extension
{

	public function getName()	{
		return Craft::t('Cutter');
	}

	public function getFilters() {
		return array(
			'truncate' => new \Twig_Filter_Method($this, 'cut'),
			'snip' 	   => new \Twig_Filter_Method($this, 'cut'),
			'cutter' 	 => new \Twig_Filter_Method($this, 'cut'),
			'cut' 		 => new \Twig_Filter_Method($this, 'cut'),
			'chars' 	 => new \Twig_Filter_Method($this, 'cut'),
			'words' 	 => new \Twig_Filter_Method($this, 'words')
		);
	}

	// {{ entry.description|snip(200, '..') }}
	public function cut($string, $limit=150, $suffix='…', $delimiter='chars')	{
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

	// {{ entry.description|words(20) }}
	public function words($string, $limit=40, $suffix='…')	{
		return $this->cut($string, $limit, $suffix, 'words');
	}
}
