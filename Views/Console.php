<?php
/**
 * Aldu\Console\Views\Console
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
 * @package       Aldu\Console\Views
 * @since         AlduPHP(tm) v1.0.0
 * @license       Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 */

namespace Aldu\Console\Views;
use Aldu\Core;
use Aldu\Core\View\Helper;

class Console extends Core\View
{

  public function main($stdin = '', $stdout = '')
  {
    switch ($this->render) {
    case 'cli':
      $this->response->type('text');
      return $this->response->body($stdout);
    default:
      $page = Helper\HTML\Page::instance();
      $page->theme();
      $form = new Helper\HTML\Form($this->model, __FUNCTION__);
      if ($stdout) {
        $_console = $form->textarea('stdout')->node('textarea');
        $_console->readonly = true;
        $_console->data(array(
            'editor' => 'codemirror', 'mode' => 'text/x-php', 'theme' => 'monokai'
          ));
        $_console->text($stdout);
      }
      $console = $form->textarea('stdin', array(
          'readonly' => false
        ))->node('textarea');
      $console->data(array(
          'editor' => 'codemirror', 'mode' => 'text/x-php', 'theme' => 'monokai'
        ));
      $console->text($stdin);
      $form->submit('execute', array(
          'title' => $this->locale->t('Evaluate')
        ));

      return $this->response->body($page->compose($form));
    }
  }
}
