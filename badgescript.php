<?php
class BadgeScript {
  public $raw_html = '    <li style=\'list-style: none\'><a style=\'cursor: pointer;display: block; padding: 5px; min-height: 60px;border-radius: 5px; background: #fff; border: 1px solid #aaa;\'>    <img src=\'%1$s\' alt=\'%2$s\' style=\'height: 60px; width: 60px; float: left;\'>    <h1 style=\'font-family: Helvetica Neue, sans-serif; font-size: 16px; line-height: 17px; margin: 5px 0 0; padding: 0;letter-spacing: 0;\'>%2$s</h1>    <h2 style=\'font-family: Helvetica Neue, sans-serif; font-size: 14px; line-height: 15px; margin: 0; padding: 0;letter-spacing: 0;\'>%3$s</h2>    </a></li>'; /* path, title, description */
  public $destination = 'user/scripts/';
  
  public function __construct($image, $title, $description) {
    $this->image = $image;
    $this->badgeID = 'badge' . time();
    $this->prepared_html = sprintf($this->raw_html, $image->webpath(), $title, $description);    
  }
  
  public function _output() {
    
    return sprintf("
      (function(global, document){
        var container = document.getElementById('%s');
        var badge_html = \"%s\";
        if (container && badge_html) {
         var iframe = document.createElement('iframe');
         iframe.style.border = '0';
         iframe.onload = function(){
           iframe.contentDocument.body.innerHTML = badge_html;
           iframe.style.height = iframe.scrollHeight + 20 + 'px';
         };
         container.appendChild(iframe);
        }
      })(this, this.document)", $this->badgeID, $this->prepared_html);
  }
  
  public function writefile() {
    $contents = $this->_output();
    $scripthash = hash('sha1', $this->image->hash() . $this->badgeID);
    $dest = $this->destination . $scripthash . '.js';
    $fp = fopen($dest, 'w');
    fputs($fp, $contents);
    return ($this->finalpath = $dest);
  }
  
  public function getBadgeID() {
    return $this->badgeID;
  }

  public function badgeHTML() {
    return sprintf("<div id='%s'></div>\n<script src='%s'></script>", $this->getBadgeID(), $this->webpath());
  }
  
  public function webpath() {
    if (empty($this->finalpath)) {
      throw new Exception('Cannot get webpath without first writing file.');
    }
    return sprintf('http://%s/%s', $_SERVER['SERVER_NAME'], $this->finalpath);
  }
}

