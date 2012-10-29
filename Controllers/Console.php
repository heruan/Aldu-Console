<?php
/**
 * Aldu\Console\Controllers\Console
 *
 * AlduPHP(tm) : The Aldu Network PHP Framework (http://aldu.net/php)
 * Copyright 2010-2012, Aldu Network (http://aldu.net)
 *
 * Licensed under Creative Commons Attribution-ShareAlike 3.0 Unported license (CC BY-SA 3.0)
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Giovanni Lovato <heruan@aldu.net>
 * @copyright     Copyright 2010-2012, Aldu Network (http://aldu.net)
 * @link          http://aldu.net/php AlduPHP(tm) Project
 * @package       Aldu\Console\Controllers
 * @since         AlduPHP(tm) v1.0.0
 * @license       Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 */

namespace Aldu\Console\Controllers;
use Aldu\Core;

class Console extends Core\Controller
{

  public function main()
  {
    if (!$this->model->authorized($this->request->aro, __FUNCTION__)) {
      return $this->response->status(401);
    }
    $stdin = '';
    $stdout = '';
    $data = $this->request->data(get_class($this->model));
    foreach ($data as $console) {
      $stdin = $console['stdin'];
      $stdout = $this->evaluate($stdin);
    }
    return $this->view->main($stdin, $stdout);
  }

  private function evaluate($stdin)
  {
    $html_errors = ini_get('html_errors');
    ob_start();
    ini_set('html_errors', 'off');
    eval($stdin);
    ini_set('html_errors', $html_errors);
    return ob_get_clean();
  }
}
