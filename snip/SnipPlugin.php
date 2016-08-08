<?php
namespace Craft;

class SnipPlugin extends BasePlugin {
  public function getName() {
    return Craft::t('Snip');
  }

  public function getVersion() {
    return '0.1';
  }

  public function getDeveloper() {
    return 'Yello Studio';
  }

  public function getDeveloperUrl() {
    return 'http://yellostudio.co.uk';
  }

  public function getDocumentationUrl() {
    return 'https://github.com/marknotton/craft-plugin-snip';
  }

  public function getReleaseFeedUrl() {
    return 'https://raw.githubusercontent.com/marknotton/craft-plugin-snip/master/snip/releases.json';
  }

  public function addTwigExtension() {
    Craft::import('plugins.snip.twigextensions.cutter');
    Craft::import('plugins.snip.twigextensions.snippet');
    return array(
      new cutter(),
      new snippet()
    );
  }

}
