{* <div>
    <span class="label-tooltip">
        {l s={$custom_field|escape:'htmlall':'UTF-8'} mod='productmodule'}
    </span>
</div> *}
<div class="m-b-1 m-t-1">
    <h2>{l s='Texto de iformación del producto' d='Modules.Checkpayment.Shop'}</h2>
    
        <fieldset class="form-group">
            <div class="col-lg-12 col-xl-4">
                <label class="form-control-label">{l s='Mi texto personalizado' d='Modules.Modulo de productos.Shop'}</label>
                <input type="text" name="custom_field" class="form-control" {if $custom_field && $custom_field != ''}value="{$custom_field}"{/if}/>
            </div>
        </fieldset>
    
        <div class="clearfix"></div>
</div>