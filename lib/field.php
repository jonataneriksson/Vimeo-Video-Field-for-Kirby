<?php

class VimeoField extends TextField {

  static public $assets = array(
    'js' => array(
      'vimeo.js'
    ),
    'css' => array(
      'vimeo.css'   // /path/to/field/assets/css/styles.css
    )
  );

  public function element() {
    $element = parent::element();
    return $element;
  }

  public function input() {
    //start
    $input = parent::input();
    $input->attr('class', 'hidden');
    return $input;
  }

  public function layout() {
    //start
    $wrapper = new Brick('div');
    $wrapper->attr('class','vimeo wrapper');
    $wrapper->data(array('field' => 'vimeo'));

    //Return
    return $wrapper;
  }

  public function content() {
    $main = new Brick('div');
    $main->attr('class','');
    $main->append($this->layout());
    $main->append($this->input());
    $content = $main;
    return $content;
  }

  public function value() {
    $clean_string = $this->value; //str_replace(">", "",$this->value);
    $array = yaml::decode($clean_string);
    $json = json_encode($array);
    return !empty($this->value) ? print_r($json, true) : null;
  }

  public function result() {
    $input = stripslashes(parent::result());
    $object = (array)json_decode($input, true); //, 4
    $yaml = yaml::encode($object);
    return $yaml;
  }

}
