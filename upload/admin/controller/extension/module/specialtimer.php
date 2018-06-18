<?php

class ControllerExtensionModuleSpecialtimer extends Controller {

	private $error = array();

	public function install() {
			/* Start Email Function on Installation */
			$query = $this->db->query("SELECT count(*) as total FROM `" . DB_PREFIX . "setting` WHERE `key` = 'special_timer_status'");
			$countforumstatus = $query->row['total'];
			if($countforumstatus<1 && (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())){
				$store_name = $this->config->get('config_name');
				
				$store_url = HTTP_CATALOG ;	

				$message  = "It is default email. Sender has installed Deal Timer extension on the below store.";
				$message .= "\n\n";
				$message .= 'Store URL- '.$store_url . "\n\n";
				$message .= 'Store Email- '.$this->config->get('config_email') . "\n\n";
				$message .= 'Store Name- '.html_entity_decode($store_name, ENT_QUOTES, 'UTF-8');

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo('bdm@synapseindia.com');
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
				$mail->setSubject('Deal Timer extension installed');
				$mail->setText($message);
				$mail->send();
			}
			/* End Email Function on Installation */		
    }

	public function index() {
		
		$this->install();
		
		$this->load->language('extension/module/specialtimer');



		$this->document->setTitle($this->language->get('heading_title'));



		$this->load->model('setting/setting');



		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
        
			$this->model_setting_setting->editSetting('special_time', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));

		}



		$data['heading_title'] = $this->language->get('heading_title');



		$data['text_edit'] = $this->language->get('text_edit');

		$data['text_enabled'] = $this->language->get('text_enabled');

		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['text_yes'] = $this->language->get('text_yes');

		$data['text_no'] = $this->language->get('text_no');


		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['entry_special_product_page'] = $this->language->get('entry_special_product_page');
		
		$data['entry_special_product_module'] = $this->language->get('entry_special_product_module');
		
		$data['entry_product_page'] = $this->language->get('entry_product_page');
		
		$data['entry_featured_product_page'] = $this->language->get('entry_featured_product_page');
		
		$data['entry_latest_product_page'] = $this->language->get('entry_latest_product_page');
		
		$data['entry_special_product_category_page'] = $this->language->get('entry_special_product_category_page');
		
		$data['entry_search_product_page'] = $this->language->get('entry_search_product_page');
		
		$data['button_save'] = $this->language->get('button_save');

		$data['button_cancel'] = $this->language->get('button_cancel');



		if (isset($this->error['warning'])) {

			$data['error_warning'] = $this->error['warning'];

		} else {

			$data['error_warning'] = '';

		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(

			'text' => $this->language->get('text_home'),

			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)

		);



		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true)
		);


		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/specialtimer', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);


		$data['action'] = $this->url->link('extension/module/specialtimer', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);
	

		if (isset($this->request->post['special_timer_status'])) {
			$data['special_timer_status'] = $this->request->post['special_timer_status'];
		} else {
			$data['special_timer_status'] = $this->config->get('special_timer_status');
		}
		
		
		if (isset($this->request->post['special_time_config_special_product_page'])) {
			$data['special_time_config_special_product_page'] = $this->request->post['special_time_config_special_product_page'];
		} else {
			$data['special_time_config_special_product_page'] = $this->config->get('special_time_config_special_product_page');
		}
		
		if (isset($this->request->post['special_time_config_special_product_module'])) {
			$data['special_time_config_special_product_module'] = $this->request->post['special_time_config_special_product_module'];
		} else {
			$data['special_time_config_special_product_module'] = $this->config->get('special_time_config_special_product_module');
		}
		
		if (isset($this->request->post['special_time_config_product_page'])) {
			$data['special_time_config_product_page'] = $this->request->post['special_time_config_product_page'];
		} else {
			$data['special_time_config_product_page'] = $this->config->get('special_time_config_product_page');
		}
		
		if (isset($this->request->post['special_time_config_featured_product_page'])) {
			$data['special_time_config_featured_product_page'] = $this->request->post['special_time_config_featured_product_page'];
		} else {
			$data['special_time_config_featured_product_page'] = $this->config->get('special_time_config_featured_product_page');
		}
		
		if (isset($this->request->post['special_time_config_latest_product_page'])) {
			$data['special_time_config_latest_product_page'] = $this->request->post['special_time_config_latest_product_page'];
		} else {
			$data['special_time_config_latest_product_page'] = $this->config->get('special_time_config_latest_product_page');
		}
		
		if (isset($this->request->post['special_time_config_special_product_category_page'])) {
			$data['special_time_config_special_product_category_page'] = $this->request->post['special_time_config_special_product_category_page'];
		} else {
			$data['special_time_config_special_product_category_page'] = $this->config->get('special_time_config_special_product_category_page');
		}

       if (isset($this->request->post['special_time_config_search_product_page'])) {
			$data['special_time_config_search_product_page'] = $this->request->post['special_time_config_search_product_page'];
		} else {
			$data['special_time_config_search_product_page'] = $this->config->get('special_time_config_search_product_page');
		}


		$data['user_token'] = $this->session->data['user_token'];



		$data['header'] = $this->load->controller('common/header');

		$data['column_left'] = $this->load->controller('common/column_left');

		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/specialtimer', $data));

	}



	protected function validate() {

		if (!$this->user->hasPermission('modify', 'extension/module/specialtimer')) {

			$this->error['warning'] = $this->language->get('error_permission');

		}	


		return !$this->error;

	}

}

