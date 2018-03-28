<?php

/**
 * Put your plugin code here
 */

class RelatedPagesField extends StructureField {

  public function content()
  {
      $wrapper = new Brick('div');
      $wrapper->addClass('RelatedPages');
      return $wrapper;
  }

}

/*
namespace Kirby\Component;

require_once(__DIR__.DS.'lib'.DS.'thumb.php');
require_once(__DIR__.DS.'lib'.DS.'component.php');
require_once(__DIR__.DS.'lib'.DS.'drivers.php');

// Initialize the plugin

$kirby->set('component', 'thumb', 'Kirby\Component\VideoThumb');
*/
