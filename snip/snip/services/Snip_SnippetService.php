<?php
namespace Craft;

class Snip_SnippetService extends BaseApplicationComponent {

	public function snippet($entry, $limit=10, $fallbackField='body', $ending='…')	{

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

    if ( isset($arguments) ){
      foreach ($arguments as &$setting) {
        if (gettype($setting) == 'integer') {
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
		$limit     = !is_null($limit) ? $limit : 10 ;
		$suffix    = !is_null($suffix) ? $suffix : '…' ;
		// $stripHTML = !is_null($stripHTML) ? $stripHTML : true ;

		$snippet = !is_null(craft()->fields->getFieldByHandle('snippet')) ? $entry->snippet : null;
		$fallbackField = !is_null(craft()->fields->getFieldByHandle($fallbackField)) ? $entry->$fallbackField : null;

    if (isset($snippet) && !empty($snippet)) {
      if ($limit == false) {
        return $entry->snippet;
      } else {
      	return craft()->snip_snip->words($entry->snippet, $limit, $ending);
      }
    } elseif (isset($fallbackField)) {
      if ($limit == false) {
        return $fallbackField;
      } else {
        return craft()->snip_snip->words($fallbackField, $limit, $ending);
      }
    } else {
    	return null;
    }

	}

}
