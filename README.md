# Csp plugin for CakePHP

## Description

This plugin does some slight changes in the FormHelper and HtmlHelper, so there won't be any inline script resp. style anymore, so the developer can easily add CSP headers.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require thefredfox/cakephp-csp
```

## Configuration

To load this Plugin inside CakePHP:

``` php
// in bootstrap.php file
Plugin::load('Csp');
```

In your layout or your pages, you have to load the css and js files of the csp plugin:

``` php
// in your layout/page file
$this->Html->css('Csp.csp');
$this->Html->script('Csp.csp'); //this script has to be loaded at the bottom
```

If you don't use any other FormHelper or HtmlHelper yet, you can easily use the Helpers of this plugin:

``` php
// in your AppView
public function initialize()
{
  $this->loadHelper('Csp.Html');
  $this->loadHelper('Csp.Form');
}
```

### Extending third party helpers
If you are using another FormHelper or HtmlHelper (e.g. the BootstrapUI helpers), you may use the Traits provided by this plugin in an own extending Helper class:

``` php
// in src/View/Helper/FormHelper

class FormHelper extends \BootstrapUI\View\Helper\FormHelper {

  use \Csp\View\Helper\FormHelperTrait;

}
```

### Extending your own helpers
If you already extends one of the helpers, you can try to use the Trait like above, but you may want to extend your helper again to not override something.

``` php
// in src/View/Helper/CspFormHelper (or the like)

class CspFormHelper extends FormHelper {

  use \Csp\View\Helper\FormHelperTrait;

}
```

I tried it with my own Helper classes, which extends the BootstrapUI classes. In the HtmlHelper class I already override the link function which also is overridden by the Csp-plugin's HtmlHelper, so I create another CspHtmlHelper class which extends my other HtmlHelper and uses the HtmlHelperTrait by the csp plugin. It works. ;)
