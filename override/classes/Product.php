<?php
class Product extends ProductCore
{
    /*
    * module: informacioproducto
    * date: 2020-10-14 12:42:24
    * version: 1.0.0
    */
    public $additional_text;
    /*
    * module: informacioproducto
    * date: 2020-10-14 12:51:11
    * version: 1.0.0
    */
    public $custom_field;
    /*
    * module: informacioproducto
    * date: 2020-10-14 12:51:11
    * version: 1.0.0
    */
    public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null)
    {
        self::$definition['fields']['custom_field'] = [
            'type' => self::TYPE_STRING,
            'required' => false,
            'size' => 255,
        ];
        parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
    }
}