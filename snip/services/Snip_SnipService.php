<?php
namespace Craft;

class Snip_SnipService extends BaseApplicationComponent {

	public function snip()	{

		// Fail if no parameters are passed
    if ( func_num_args() < 1 ){
      return false;
    }

		// The first argument is the entry that is automatically passed.
    $string = (string) func_get_arg(0);

    // Remove the first argument and set the arguments array
    $arguments = array_slice(func_get_args(), 1);

		$limit     = null;
    $delimiter = null;
		$suffix    = null;
    $stripHTML = null;

		// Run through the settings and define the appropriate variables
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

		// Default settings
		$limit     = !is_null($limit) ? $limit : 150 ;
		$delimiter = !is_null($delimiter) ? $delimiter : 'chars' ;
		$suffix    = !is_null($suffix) ? $suffix : '…' ;
		$stripHTML = !is_null($stripHTML) ? $stripHTML : true ;

		// Multibyte string check
		$mb_ok = function_exists('mb_get_info');
		$addSuffix = false;

		// Get Twig charset
		$charset = craft()->templates->getTwig()->getCharset();

		// Strip any markup tags
		if ( $stripHTML ) {
			$string = strip_tags($string);
		}


		if ( $delimiter == 'chars') {
			// Trim by character count
			if (strlen($string) > $limit) {
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

		// Suffix
		if (!empty($string)) {
			if ($addSuffix) {
				return rtrim($string, ',": |()&*!`~.[]{-_=+}').html_entity_decode($suffix);
			} else {
				return rtrim($string);
			}
		}
	}

	// Words
	public function words($string, $limit=40, $suffix='…')	{
		return $this->snip($string, $limit, $suffix, 'words');
	}


	// Sentences
	public function sentences($string, $limit=2, $suffix='')	{
		$limit = !is_null($limit) ? $limit : 2 ;
		$sentences = '';
		$count = 0;
		foreach (explode('.', $string) as $sentence) {
			$count ++;
			if ( $count <= $limit) {
				$sentences .= $sentence.'.';
			}
		}

		return $sentences.$suffix;
	}

	// Description
	public function description($string, $chars=null, $words=20, $sentence=null, $suffix=null) {
		$string = $this->snip($string, $chars, $suffix, 'chars');
		$string = $this->words($string, $words, $suffix);
		$string = $this->sentences($string, $sentence, $suffix);
		return $string;
	}

}
