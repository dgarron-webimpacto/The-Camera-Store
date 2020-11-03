{**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License 3.0 (AFL-3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/AFL-3.0
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
* @author PrestaShop SA <contact@prestashop.com>
    * @copyright 2007-2017 PrestaShop SA
    * @license https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
    * International Registered Trademark & Property of PrestaShop SA
    *}
    <div class="product-add-to-cart">
        {if !$configuration.is_catalog}

        {block name='product_quantity'}
        <div class="product-quantity row align-items-center no-gutters texto" style="padding-bottom: 10px;">
            <div class="col-xs-12 col-sm-3">
                <label for="quantity_wanted" class="quantity__label subtitulos"><b>{l s='Quantity' d='Shop.Theme.Catalog'}</b></label>
            </div>
            <div class="col-xs-12 col-sm-3">
                <input type="number" name="qty" id="quantity_wanted" value="{$product.quantity_wanted}" class="input-group" min="{$product.minimal_quantity}" aria-label="{l s='Quantity' d='Shop.Theme.Actions'}" {if isset($product.product_url)}data-update-url="{$product.product_url}" {/if}>
            </div>
        </div>
        {/block}
        {block name="ofertas"}
        <div class="row texto">
            <div class="col-xs-12 col-sm-3 subtitulos"><b>Promoción:</b></div>
            <div class="col-xs-12 col-sm-9 oferta"> Ofertas especiales de la semana</div>
        </div>

        <div class="row texto" id="articleInStock">
            <div class="col-xs-12 col-sm-3 subtitulos"><b>Disponibilidad:</b></div>
            <div class="col-xs-12 col-sm-9 p-a-0 en-stock">
                <div id="availabilityBlock" class="acc-pccom disponibilidad-inmediata green" role="tablist" aria-multiselectable="true">
                    <section class="acc-block">
                        <a class="disponibilidad" id="GTM-desplegableFicha-disponibilidad" aria-expanded="false" aria-controls="accp-002" data-toggle="collapse" href="#accp-002"><span id="enstock" style="color: #458057">¡En stock!
                                ¡Recíbelo mañana!</span><span id="recibelo" style="display:none">Recíbelo
                                mañana</span></a>
                        <div id="accp-002" class="acc-block-contenido collapse">
                            <div class="acc-block-body">
                                Plazo de entrega estimado para envíos a península
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3"></div>
            <div class="col-xs-12 col-sm-9 p-a-0">
                <div class="acc-pccom disponibilidad-inmediata white" role="tablist" aria-multiselectable="true">
                    <section class="acc-block">
                        <a id="GTM-desplegableFicha-disponibilidadTienda" aria-expanded="false" aria-controls="accp-012" data-toggle="collapse" href="#accp-012" style="color: #888">
                            ¿Recoges en tienda? Comprueba disponibilidad</a>
                        <div id="accp-012" class="acc-block-contenido collapse ">
                            <div class="caja-mensaje acc-block-mensaje-tienda">Te
                                recomendamos que realices la compra antes de acudir a la
                                tienda para <strong>asegurar la disponibilidad</strong> del
                                producto.</div>
                            <div class="acc-block-body"><strong class="texto-verde m-r-1">Stocks:</strong><span class="store m-r-1">
                                    Tienda Murcia
                                    <strong><i id="tienda-murcia" class="pccom-icon texto-verde">/</i></strong></span><span class="store m-r-1">
                                    Tienda Madrid
                                    <strong><i id="tienda-madrid" class="pccom-icon texto-rojo"></i></strong></span>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        {/block}

        {block name="add_buttons"}
        <div>
            <div class="row add">
                <div class="col-sm-2" style="padding: 2px;">
                    <button class="btn btn-secondary add-to-cart btn-lg btn-block btn-add-to-cart js-add-to-cart" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url} disabled {/if}>
                        {* <i class="material-icons shopping-cart btn-add-to-cart__icon">&#xE547;</i><span class="btn-add-to-cart__spinner" role="status" aria-hidden="true"></span>
                        {l s='Add to cart' d='Shop.Theme.Actions'} *}
                        <span class="material-icons iconos">
                            favorite
                        </span>
                    </button>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-5" style="padding: 2px;">
                    <button class="btn btn-secondary add-to-cart btn-lg btn-block btn-add-to-cart js-add-to-cart" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url} disabled {/if}>
                        <span class="material-icons iconos">
                            add_shopping_cart
                        </span>
                        <span class="hidden-lg-down" style="color:#888; font-size:18px;">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
                    </button>
                </div>
                <div class="col-sm-8 col-md-8 col-lg-5" style="padding: 2px;">
                    <button class="btn btn-primary add-to-cart btn-lg btn-block btn-add-to-cart js-add-to-cart" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url} disabled {/if}>
                        <span class="btn-add-to-cart__spinner" role="status" aria-hidden="true"></span>
                        Comprar
                    </button>
                </div>
            </div>
            {hook h='displayProductActions' product=$product}
        </div>
        {/block}

        {block name='product_availability'}
        <span id="product-availability">
            {if $product.show_availability && $product.availability_message}
            {if $product.availability == 'available'}
            <i class="material-icons rtl-no-flip product-available text-success">&#xE5CA;</i>
            {elseif $product.availability == 'last_remaining_items'}
            <i class="material-icons product-last-itemstext-warning">&#xE002;</i>
            {else}
            <i class="material-icons product-unavailable text-danger">&#xE14B;</i>
            {/if}
            {$product.availability_message}
            {/if}
        </span>
        {/block}

        {block name='product_minimal_quantity'}
        <p class="product-minimal-quantity">
            {if $product.minimal_quantity > 1}
            {l
            s='The minimum purchase order quantity for the product is %quantity%.'
            d='Shop.Theme.Checkout'
            sprintf=['%quantity%' => $product.minimal_quantity]
            }
            {/if}
        </p>
        {/block}
        {/if}
        {block name="informacion_pedido"}


        <div class="col-xs-12 "><label class="c-input c-checkbox label-con-icono"><input id="insurance" type="checkbox"><span class="c-indicator"></span>Extensión de garantía + 3años por 25,00€
            </label><a data-toggle="collapse" href="#garantia-drop-down"><b style="color: #ff6000;">+ info</b></a>
            <div id="garantia-drop-down" class="collapse m-y-1">
                <div class="texto p-a-1">
                    <p class="h6">3 años de garantía para tus productos </p>
                    <p>¿Eres de los que les falla un producto justo cuando finalizan los dos años de garantía? Se llama Ley de Murphy y nosotros, ¡te animamos a desafiarla!</p>
                    <p>La extensión de 3 años proporciona una garantía total de 5 años, yaque los 2 primeros años la garantía están cubiertos porPcComponentes. A partir del tercer año entraría en vigor e incluye lareparación o sustitución, durante 3 años más, de piezas, mano obra ytransporte o desplazamiento.</p>
                    <p>Tu tranquilidad cuesta muy poco.</p>
                    <p class="m-b-0"><a href="">Condiciones para la extensión de garantía.</a></p>
                </div>
            </div>
        </div>
        <div class="info" style="">
            <div class="row" style="padding-left: 110px;">
                <div class="col-xs-4 text-xs-center">
                    <div style="padding:10px;">
                        <span class="material-icons info" style="color: #888;">stars</span><strong data-toggle="tooltip">2 años</strong><br>de garantía</em></div>
                </div>
                <div class="col-xs-4 text-xs-center">
                    <div style="padding:10px;">
                        <span class="material-icons info" style="color: #888;">update</span><strong>30 días</strong><br>de devolución</em></div>
                </div>
                <div class="col-xs-4 text-xs-center">
                    <div style="padding:10px;">
                        <span class="material-icons info" style="color: #888;">verified_user</span><strong>100%</strong><br>pago seguro</em></div>
                </div>
            </div>
        </div>

        {/block}