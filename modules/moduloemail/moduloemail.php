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

class Moduloemail extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'moduloemail';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'diego';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Modulo de email');
        $this->description = $this->l('Modulo para enviar emails y cupones');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('MODULOEMAIL_CANTIDAD_CUPON', false);
        Configuration::updateValue('MODULOEMAIL_CANTIDAD_CUPON_NECESARIO', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader')&&
            $this->registerHook('actionPaymentConfirmation');
    }

    public function uninstall()
    {
        Configuration::deleteByName('MODULOEMAIL_CANTIDAD_CUPON');
        Configuration::deleteByName('MODULOEMAIL_CANTIDAD_CUPON_NECESARIO');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitModuloemailModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitModuloemailModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-ticket',
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'step' => '0.01',
                        'min' => '0.01',
                        'desc' => $this->l('Introduce una cantidad.'),
                        'name' => 'MODULOEMAIL_CANTIDAD_CUPON_NECESARIO',
                        'label' => $this->l('Cantidad necesaria para crear un cupon.'),
                    ),
                     array(
                        'col' => 3,
                        'type' => 'text',
                        'step' => '0.01',
                        'min' => '0.01',
                        'desc' => $this->l('Introduce una cantidad.'),
                        'name' => 'MODULOEMAIL_CANTIDAD_CUPON',
                        'label' => $this->l('Cantidad de cupon.'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'MODULOEMAIL_CANTIDAD_CUPON' => Configuration::get('MODULOEMAIL_CANTIDAD_CUPON'),
            'MODULOEMAIL_CANTIDAD_CUPON_NECESARIO' => Configuration::get('MODULOEMAIL_CANTIDAD_CUPON_NECESARIO'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
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

    public function hookActionPaymentConfirmation($params)
    {
      
        //Recopilacion datos
        $gastoNecesarioCupon = Configuration::get('MODULOEMAIL_CANTIDAD_CUPON_NECESARIO');
        $customer = new Customer($params['cart']->id_customer);
        $order = new Order($params['id_order']);
        $totalGastado = $customer->getMoneySpentTotal();
        $discount = false;
        
        $template = 'gastoTotal';
        $asunto = 'Informacion gasto generado';
        $datosMail = [
            '{firstname}'=> $customer->firstname,
            '{lastname}'=> $customer->lastname,
            '{totalamount}'=> (float)$totalGastado + (float)$order->total_paid,
            '{order}'=> $order->reference,
            '{currency}' => $this->context->currency->iso_code,
        ];
        
        //Comprobando si hay que generar cupon
        if ($totalGastado < $gastoNecesarioCupon) {
            if ($totalGastado + $order->total_paid >= $gastoNecesarioCupon) {
                //Generando cupon
                $discount = new CartRule();
                $discount->id_customer = $customer->id;
                $discount->date_from = date('Y-m-d H:i:s');
                $discount->date_to = date('Y-12-31 H:i:s');
                $discount->reduction_amount = (float)Configuration::get('MODULOEMAIL_CANTIDAD_CUPON');
                $discount->code = $discount->generateDiscountCode();
                $names = $this->createLangNamesDiscount("Discount250");
                $discount->name = $names;
                $discount->quantity_per_user = 1;
                $discount->quantity = 1;
                $discount->add();
            }
        }
        
        //Actualizando el total gastado por el cliente en DB
        $customer->addMoneySpentTotal($order->total_paid);
        
        
        if ($discount) {
            $template = 'gastoTotalYCupon';
            $asunto = 'Has generado un Cupon descuento';
            $datosMail['{coupon}'] = $discount->code;
            $datosMail['{money}'] = $discount->reduction_amount;
        }
    
        //Preparando y enviando email
        Mail::send(
            $this->context->language->id,         //Lenguage id
            $template,                                   //template
            $asunto,                                     //Asunto
            $datosMail,                                  //Variables
            $customer->email,                            //destinatario
            $customer->firstname.' '.$customer->lastname, //toname = null
            null,                                        //from = null
            'PrestaImpacto',                              //fromName = null
            null,
            null,
            $this->local_path.'/mails/'
        );
    }
            
    public function createLangNamesDiscount($name)
    {
        $names = array();
        foreach (Language::getLanguages(true) as $language) {
            $names[$language['id_lang']] = $name ;
        }
        return $names;
    }

}
