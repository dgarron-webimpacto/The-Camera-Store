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

class Productmodule extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'productmodule';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'diego';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Modulo de productos');
        $this->description = $this->l('Modulo para ver información del producto');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('PRODUCTMODULE_LIVE_MODE', false);

        return parent::install() &&
            //$this->_installSql() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayRightColumnProduct') &&
            $this->registerHook('displayAdminProductsMainStepLeftColumnMiddle') &&
            $this->registerHook('actionProductSave') &&
            $this->registerHook('displayProductButtons')&&
            $this->registerHook('displayProductAdditionalInfo');
    }

    public function uninstall()
    {
        Configuration::deleteByName('PRODUCTMODULE_LIVE_MODE');

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

    public function hookDisplayAdminProductsMainStepLeftColumnMiddle($params)
    {
        $product = new Product($params['id_product']);
        $languages = Language::getLanguages($active);
        $this->context->smarty->assign(array(
            'custom_field' => $product->custom_field,
            'languages' => $languages,
            'default_language' => $this->context->employee->id_lang,
            )
        );
        return $this->display(__FILE__, 'views/templates/front/productText.tpl');
    }

    protected function _installSql()
    {
        $sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "product "
                ."ADD custom_field VARCHAR(255) NULL";
        
        $returnSql = Db::getInstance()->execute($sqlInstall);

        return $returnSql;
    }

   /*  protected function hookActionProductSave($params)
    {
        $product = new Product($params['id_product']);
        $sqlInsert = 'INSERT INTO ' . _DB_PREFIX_ . 'product 
            (custom_field) VALUES ("'.$custom_field.'")';

        $returnSql = Db::getInstance()->execute($sqlInsert);
        //exit(Tools::getValue('custom_field'));

        return $returnSql;
    } */

    /* protected function hookDisplayProductButtons($params)
    {
        return $this->display(__FILE__, 'views/templates/front/textoFront.tpl');
    } */

    public function hookDisplayProductAdditionalInfo($params)
    {
        $product = new Product($params['id_product']);
        $this->context->smarty->assign(array(
            'custom_field' => $product->custom_field,
            )
           );

        return $this->display(__FILE__, 'views/templates/hook/textoFront.tpl');
    }
    
}
