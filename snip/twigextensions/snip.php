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
			'snip' 		 => new \Twig_Filter_Method($this, 'snip'),
			'truncate' => new \Twig_Filter_Method($this, 'snip'),
			'cut' 		 => new \Twig_Filter_Method($this, 'snip'),
			'chars' 	 => new \Twig_Filter_Method($this, 'snip'),
			'words' 	 => new \Twig_Filter_Method($this, 'words')
		);
	}

	public function snip()	{

		// Fail if not parameters are passed
    if ( func_num_args() < 1 ){
      return false;
    }

		// The first argument is the entry that is automatically passed.
    $string = func_get_arg(0);

    // Remove the first argument and set the arguments array
    $arguments = array_slice(func_get_args(), 1);

		$limit     = null;
    $delimiter = null;
		$suffix    = null;
    $stripHTML = null;

    if ( isset($arguments) ){
      foreach ($arguments as &$setting) {
        if ( gettype($setting) == 'boolean') {
          $stripHTML = $setting;
        } else if (gettype($setting) == 'integer') {
          $limit = $setting;
        } else if (gettype($setting) == 'string') {
					if ($setting == 'words' || $setting == 'chars') {
						$delimiter = $setting;
					} else {
						$suffix = $setting;
					}
        }
      }
    }

		// Defaults
		$limit     = !is_null($limit) ? $limit : 150 ;
		$delimiter = !is_null($delimiter) ? $delimiter : 'chars' ;
		$suffix    = !is_null($suffix) ? $suffix : '…' ;
		$stripHTML = !is_null($stripHTML) ? $stripHTML : true ;

		// Multibyte string check
		$mb_ok = function_exists('mb_get_info');
		$addSuffix = false;

		// Get Twig charset
		$charset = craft()->templates->getTwig()->getCharset();

		if ( $stripHTML ) {
			$string = strip_tags($string);
		}

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
