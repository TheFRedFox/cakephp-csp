<?php
/**
 * Created by PhpStorm.
 * User: frederik.bauer
 * Date: 2016-04-13
 * Time: 14:32
 */

namespace Csp\View\Helper;

use Cake\Log\Log;

trait HtmlHelperTrait
{

  /**
   * @inheritdoc
   */
  public function link($title, $url = null, array $options = [])
  {
    $confirmMessage = null;
    if (isset($options['confirm'])) {
      $confirmMessage = $options['confirm'];
      unset($options['confirm']);
    }
    if ($confirmMessage) {
      $classOptions = ['csp-link'];
      $options['class'] = isset($options['class']) ? $options['class'] : [];
      $options['class'] = array_merge($options['class'], $classOptions);
      if (isset( $options['escape'] ) && $options['escape'] === false) {
        $confirmMessage = h($confirmMessage);
      }
      $options['data-csp-confirm'] = $confirmMessage;
    }

    return parent::link($title, $url, $options);
  }

}
