<?php
namespace Cloudcogs\WooCommerceProxy;

/**
 * Proxy for \Automattic\WooCommerce\Client
 */
class WooCommerce
{
    protected $WC;

    public function __construct(\ArrayAccess $wc_config)
    {
        $WC = new \Automattic\WooCommerce\Client($wc_config->url, $wc_config->consumer_key, $wc_config->consumer_secret,$wc_config->options);

        $this->WC = $WC;
    }

    public function proxy()
    {
        return $this->WC;
    }

    public function getProductBySku($sku)
    {
        $params = ['sku'=>$sku];
        $pdt = $this->WC->get('products',$params);
        return $pdt;
    }

    public function getProductAttributes()
    {
        $atts = $this->WC->get('products/attributes');
        return $atts;
    }

    public function getProductVariations($item_id)
    {
        $variations = $this->WC->get("products/$item_id/variations");
        return $variations;
    }

    public function getProductCategories($params = ['orderby'=>'slug','per_page'=>100])
    {
        $cats = $this->WC->get('products/categories',$params);
        return $cats;
    }

    public function addProduct($data = ['status' => 'draft', 'type' => 'simple', 'manage_stock' => true])
    {
        $pdt = $this->WC->post('products',$data);
        return $pdt;
    }

    public function addCategory($name,$slug = null,$parent = null,$image = null)
    {
        $data = ['name'=>$name];
        if ($image != null){
            $data['image']['src'] = $image;
        }
        if ($slug != null){
            $data['slug'] = $slug;
        }
        if ($parent != null){
            $data['parent'] = $parent;
        }

        $cat = $this->WC->post("products/categories",$data);
        return $cat;
    }

    public function updateProduct($itemId,$data = [])
    {
        $pdt = $this->WC->put('products/'.$itemId, $data);
        return $pdt;
    }

    public function updateProductVariation($itemId,$varId,$data = [])
    {
        $pdt = $this->WC->put('products/'.$itemId.'/variations/'.$varId, $data);
        return $pdt;
    }
}