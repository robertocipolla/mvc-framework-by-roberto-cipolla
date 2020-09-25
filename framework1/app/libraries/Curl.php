<?php
	class Curl {
		public $curl;
		public function __construct(){
			
		}
		
		public function load($url){
			$this->curl = curl_init();
			filter_var($url, FILTER_SANITIZE_URL);
			$options = [
				CURLOPT_URL => $url,
				CURLOPT_SSL_VERIFYPEER => FALSE,
			];
			curl_setopt_array($this->curl, $options);
			
			curl_exec($this->curl);
			curl_close ($this->curl);
		}
		
		public function get($url){
			$this->curl = curl_init();
			$options = [
				CURLOPT_URL => $url,
				CURLOPT_SSL_VERIFYPEER => FALSE,
				CURLOPT_RETURNTRANSFER => TRUE,
			];
			curl_setopt_array($this->curl, $options);
			
			$result = curl_exec($this->curl);
			curl_close ($this->curl);
			return $result;
		}
		
		public function post($url, $data = [], $headers = "'Content-type': 'application/json; charset=UTF-8'"){
			$this->curl = curl_init();
			$options = [
				CURLOPT_URL => $url,
				CURLOPT_SSL_VERIFYPEER => FALSE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_POST => TRUE,
				CURLOPT_POSTFIELDS => http_build_query($data),
				CURLOPT_HTTPHEADER => $headers
			];
			curl_setopt_array($this->curl, $options);
			
			$result = curl_exec($this->curl);
			curl_close ($this->curl);
			return $result;
		}
		
		public function update($url, $data = [], $headers = "'Content-type': 'application/json; charset=UTF-8'"){
			$this->curl = curl_init();
			$options = [
				CURLOPT_URL => $url,
				CURLOPT_SSL_VERIFYPEER => FALSE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_CUSTOMREQUEST => "PUT",
				CURLOPT_POSTFIELDS => http_build_query($data),
				CURLOPT_HTTPHEADER => $headers
			];
			
			curl_setopt_array($this->curl, $options);
			
			$result = curl_exec($this->curl);
			curl_close ($this->curl);
			return $result;
		}
		
		public function delete($url, $headers = "'Content-type': 'application/json; charset=UTF-8'"){
			$this->curl = curl_init();
			$options = [
				CURLOPT_URL => $url,
				CURLOPT_SSL_VERIFYPEER => FALSE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_CUSTOMREQUEST => "DELETE",
				CURLOPT_POSTFIELDS => http_build_query($data),
				CURLOPT_HTTPHEADER => $headers
			];
			
			curl_setopt_array($this->curl, $options);
			
			$result = curl_exec($this->curl);
			curl_close ($this->curl);
			return $result;
		}
		
	}
?>