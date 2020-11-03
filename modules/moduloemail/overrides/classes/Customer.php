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

class Customer extends CustomerCore
{
    public $money_spent_total;
    //public $money_spent_after_coupon;

    public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null)
    {
        self::$definition['fields']['money_spent_total'] = [
            'type' => self::TYPE_FLOAT,
            'required' => false,
        ];

        parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
    }
    
    public function getMoneySpentTotal()
    {
        $db = Db::getInstance();
        $request ="SELECT money_spent_total "
               . "FROM ". _DB_PREFIX_."customer "
               . "WHERE id_customer = ".(int)$this->id." ";
        $result = $db->getValue($request);
        return $result;
    }
    
    public function addMoneySpentTotal($money)
    {
        $this->money_spent_total = $this->money_spent_total + (float)$money;
        $this->update();
    }
}