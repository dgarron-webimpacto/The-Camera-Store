<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Informacioproducto extends Module implements WidgetInterface
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'informacioproducto';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'diego';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Modulo de informacion de productos');
        $this->description = $this->l('Modulo de informacion de productos');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('INFORMACIOPRODUCTO_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader')&&
            $this->registerHook('displayAdminProductsMainStepLeftColumnMiddle') &&
            $this->registerHook('displayProductAdditionalInfo');
    }

    public function uninstall()
    {
        Configuration::deleteByName('INFORMACIOPRODUCTO_LIVE_MODE');

        return parent::uninstall();
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function renderWidget($hookName, array $configuration)
    {
        $this->context->smarty->assign($this->getWidgetVariables($hookName, $configuration));

        if ($hookName == 'displayAdminProductsMainStepLeftColumnMiddle') {
            $template = '/views/templates/admin/displayBack.tpl';
        } elseif ($hookName == 'displayProductAdditionalInfo') {
            $template = '/views/templates/front/displayFront.tpl';
        }
        return $this->fetch('module:informacioproducto'.$template);
    }
     
    public function getWidgetVariables($hookName, array $configuration)
    {
        if (isset($configuration['product']->id_product) && $configuration['product']->id_product != null) {
            $product = new Product($configuration['product']->id_product);
        } elseif (isset($configuration['id_product']) && $configuration['id_product'] != null) {
            $product = new Product($configuration['id_product']);
        }
        $this->context->smarty->assign(array('custom_field' => $product->custom_field));
    }
}
