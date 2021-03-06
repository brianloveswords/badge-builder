<?php
class BadgeScript {
  public $path_prefix = 'script/';
  public $raw_html = '<li style=\'list-style: none\'><a href=\'%1$s\' target=\'_blank\' style=\'color: black; text-decoration: none;cursor: pointer;display: block; padding: 5px; min-height: 60px;border-radius: 5px; background: #fff; border: 1px solid #aaa;\'>    <img src=\'%2$s\' alt=\'%3$s\' style=\'height: 60px; width: 60px; float: left; margin-right: 5px;\'>    <h1 style=\'font-family: Helvetica Neue, sans-serif; font-size: 16px; line-height: 17px; margin: 0; padding: 0;letter-spacing: 0;\'>%3$s</h1>    <h2 style=\'font-family: Helvetica Neue, sans-serif; font-size: 13px; line-height: 15px; margin: 2px 0 0; padding: 0;letter-spacing: 0; color: #444;\'>%4$s</h2>    </a></li>'; /* path, title, description */
  
  public function __construct($badge) {
    $this->badge = $badge;
  }
  public function html() {
    $badge = $this->badge;
    return sprintf($this->raw_html, $badge->validation, $badge->webimage(), $badge->name, $badge->description);
  }
  public function script() {
    return sprintf("
      (function(global, document){
        var container = document.getElementById('badge%s');
        var badge_html = \"%s\";
        if (container && badge_html) {
         var iframe = document.createElement('iframe');
         iframe.style.border = '0';
         iframe.onload = function(){
           iframe.contentDocument.body.innerHTML = badge_html;
           iframe.style.height = '90px';
         };
         container.appendChild(iframe);
        }
      })(this, this.document)", $this->badge->uuid(), $this->html());
  }
  public function path() {
    return sprintf('http://%s/%s%s.js', $_SERVER['SERVER_NAME'], $this->path_prefix, $this->badge->uuid());
  }
  public function containerTag() {
    return sprintf('<div id="badge%s"></div>', $this->badge->uuid());
  }
  public function scriptTag() {
    return sprintf('<script src="%s"></script>', $this->path());
  }
  public function snippet() {
    return sprintf("%s\n%s", $this->containerTag(), $this->scriptTag());
  }
}
