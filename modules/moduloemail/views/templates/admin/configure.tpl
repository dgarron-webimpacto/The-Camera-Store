{*
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
*}

<div class="panel">
    <h3><i class="icon icon-ticket"></i>{l s='Cupones creados' mod='moduloemail'}</h3>
    <div class="moduleconfig-content">
        <div class="row">
            <div class="col-md-1">
                <span>{l s='Id' mod='moduloemail'}</span>
            </div>
            <div class="col-md-3">
                <span>{l s='Customer' mod='moduloemail'}</span>
            </div>
            <div class="col-md-3">
                <span>{l s='Email' mod='moduloemail'}</span>
            </div>
            <div class="col-md-3">
                <span>{l s='Code' mod='moduloemail'}</span>
            </div>
            <div class="col-md-1">
                <span>{l s='Date' mod='moduloemail'}</span>
            </div>
        </div>
        {foreach $coupons as $coupon}
            <div class="row">
                <div class="col-md-1">
                    <span>{$coupon['id_customer']|escape:'htmlall':'UTF-8'}</span>
                </div>
                <div class="col-md-3">
                    <span>{$coupon['firstname']|escape:'htmlall':'UTF-8'} {$coupon['lastname']|escape:'htmlall':'UTF-8'}</span>
                </div>
                <div class="col-md-3">
                    <span>{$coupon['email']|escape:'htmlall':'UTF-8'}</span>
                </div>
                <div class="col-md-3">
                    <span>{$coupon['code']|escape:'htmlall':'UTF-8'}</span>
                </div>
                <div class="col-md-1">
                    <span>{$coupon['date_from']|escape:'htmlall':'UTF-8'}</span>
                </div>
            </div>
        {/foreach}
    </div>
</div>

<div class="panel">
	<h3><i class="icon icon-credit-card"></i> {l s='Modulo de email' mod='moduloemail'}</h3>
	<div class="moduleconfig-content">
        <div class="row">
            <div class="col-xs-12">
                <p>
                    {l s='Indica la cantidad minima para crear un cupon y la cantidad del cupon.' mod='moduloemail'}
                </p>
            </div>
        </div>
    </div>
</div>