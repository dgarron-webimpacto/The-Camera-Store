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

class CartRule extends CartRuleCore
{
   
    public function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Devuelve array asociativo con todos los descuentos en DB
     */
    public static function getAllCartRules()
    {
        $db = Db::getInstance();
        
        $request = "SELECT *"
                . " FROM ". _DB_PREFIX_ ."cart_rule";
        
        $request = "SELECT c.id_customer , c.firstname , c.lastname , c.email , cr.code , cr.date_from "
                . " FROM "._DB_PREFIX_."cart_rule as cr, "._DB_PREFIX_."customer as c "
                . " WHERE c.id_customer = cr.id_customer ";
        
        return $db->executeS($request);
    }
    
    public function generateDiscountCode()
    {
        $code = Tools::passwdGen();
        while (CartRule::cartRuleExists($code)) {
            $code = Tools::passwdGen();
        }
        /*
        $permitted_chars = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
        return Tools::substr(str_shuffle($permitted_chars), 3, $length);
        */
        return $code;
    }
}