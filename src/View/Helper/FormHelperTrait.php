<?php
/**
 * Created by PhpStorm.
 * User: frederik.bauer
 * Date: 2016-04-13
 * Time: 13:52
 */

namespace Csp\View\Helper;


use Cake\Utility\Hash;
use Cake\View\View;

trait FormHelperTrait
{

  /**
   * Default Csp string templates.
   *
   * @var array
   */
  protected $_csp_templates = [
    'hiddenBlock' => '<div class="csp-hidden">{{content}}</div>',
  ];

  //todo:
  /**
   * Construct the widgets and binds the default context providers.
   *
   * @param \Cake\View\View $View   The View this helper is being attached to.
   * @param array           $config Configuration settings for the helper.
   */
  public function __construct(View $View, array $config = [])
  {
    $this->_defaultConfig = ['templates' => $this->_csp_templates + $this->_defaultConfig['templates']] + $this->_defaultConfig;

    parent::__construct($View, $config);
  }

  /**
   * @inheritdoc
   */
  public function postLink($title, $url = null, array $options = [])
  {
    $options += ['block' => null, 'confirm' => null];

    $requestMethod = 'POST';
    if (!empty( $options['method'] ))
    {
      $requestMethod = strtoupper($options['method']);
      unset( $options['method'] );
    }

    $confirmMessage = $options['confirm'];
    unset( $options['confirm'] );

    $formName = str_replace('.', '', uniqid('post_', true));
    $formOptions = [
      'name'   => $formName,
      'class'  => 'csp-hidden',
      'method' => 'post',
    ];
    if (isset( $options['target'] ))
    {
      $formOptions['target'] = $options['target'];
      unset( $options['target'] );
    }
    $templater = $this->templater();

    $this->_lastAction($url);
    $action = $templater->formatAttributes(
      [
        'action' => $this->Url->build($url),
        'escape' => false
      ]
    );

    $out = $templater->format(
      'formStart',
      [
        'attrs' => $templater->formatAttributes($formOptions) . $action
      ]
    );
    $out .= $this->hidden('_method', ['value' => $requestMethod]);
    $out .= $this->_csrfField();

    $fields = [];
    if (isset( $options['data'] ) && is_array($options['data']))
    {
      foreach ( Hash::flatten($options['data']) as $key => $value )
      {
        $fields[ $key ] = $value;
        $out .= $this->hidden($key, ['value' => $value]);
      }
      unset( $options['data'] );
    }
    $out .= $this->secure($fields);
    $out .= $templater->format('formEnd', []);

    if ($options['block'])
    {
      if ($options['block'] === true)
      {
        $options['block'] = __FUNCTION__;
      }
      $this->_View->append($options['block'], $out);
      $out = '';
    }
    unset( $options['block'] );

    $url = '#';

    if (!empty( $options['class'] ))
    {
      $options['class'] .= ' csp-' . __FUNCTION__;
    }
    else
    {
      $options['class'] = 'csp-' . __FUNCTION__;
    }

    $options['data-csp-form'] = $formName;

    if ($confirmMessage)
    {
      if (isset( $options['escape'] ) && $options['escape'] === false)
      {
        $confirmMessage = h($confirmMessage);
      }
      $options['data-csp-confirm'] = $confirmMessage;
    }

    $out .= $this->Html->link($title, $url, $options);

    return $out;
  }

}
