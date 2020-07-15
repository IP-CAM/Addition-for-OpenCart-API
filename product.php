<?php
class ControllerApiProduct extends Controller
{
    public function index()
    {
        $this->load->language('api/product');
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/manufacturer');
        $this->load->model('tool/image');
        $json = array();
        if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$filter_data = array();
			$results = $this->model_catalog_product->getProducts($filter_data);
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				}
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}
				if ((float) $result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}
				if ($this->config->get('config_review_status')) {
					$rating = (int) $result['rating'];
				} else {
					$rating = false;
				}
				$json['products'][] = array(
					'product_id' => $result['product_id'],
					'thumb' => $image,
					'name' => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price' => $price,
					'special' => $special,
					'tax' => $tax,
					'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating' => $result['rating']
				);
			}
			$result = $this->model_catalog_category->getCategories();
			foreach($result as $res){
				$json['categories'][] = array($res['name']=>$res['category_id']);
			}
			$result = $this->model_catalog_manufacturer->getManufacturers();
			foreach($result as $res){
				$json['manufacturers'][] = array($res['name']=>$res['manufacturer_id']);
			}
		}
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    public function product()
    {
        $this->load->language('api/product');
        $this->load->model('catalog/product');
		$json = array();
        if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$json = $this->model_catalog_product->getProduct($this->request->post['id']);
		}
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
            
    }
    public function add(){
        $this->load->language('api/product');
        $this->load->model('catalog/admin');
        $json = array();
        if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$postdata = file_get_contents("php://input");
			$prod=json_decode($postdata,true);
			$product=$this->model_catalog_admin->addProduct($prod);
			if($product>0){
				$json['id']=$product;
			}
		}
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
        
    }
    public function edit(){
        $this->load->language('api/product');
        $this->load->model('catalog/admin');
        $this->load->model('tool/image');
		$json = array();
        if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$postdata = file_get_contents("php://input");
			$prod=json_decode($postdata,true);
			$product=$this->model_catalog_admin->editProduct($prod['product_id'], $prod);
			$json=array('status'=>'0');
			if($product>0){
                $json['status']=1;
			}
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
?>