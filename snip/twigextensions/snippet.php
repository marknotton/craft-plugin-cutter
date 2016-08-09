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

	// Does exactly what the snip filter does, only predefined to cut down by a word count.
	// Also, this will look for a field with the handle 'snippet'. If the snippet not found or it is empty, fallback to
	// to the given $fallbackField. 'body' by default. If the fallback field doesn't exist or is empty, return nothing.
	// {{ entry|snippet(20) }}
	public function snippet($entry, $limit=10, $fallbackField='body', $ending='…')	{

    $snip = new snip();

		$snippet = !is_null(craft()->fields->getFieldByHandle('snippet')) ? $entry->snippet : null;
		$fallbackField   = !is_null(craft()->fields->getFieldByHandle($fallbackField)) ? $entry->$fallbackField : null;

    if (isset($snippet) && !empty($snippet)) {
      if ($limit == false) {
        return $entry->snippet;
      } else {
      	return $snip->words($entry->snippet, $limit, $ending);
      }
    } elseif (isset($fallbackField)) {
      if ($limit == false) {
        return $snip->$fallbackField;
      } else {
        return $snip->words($fallbackField, $limit, $ending);
      }
    } else {
    	return null;
    }

	}

}
