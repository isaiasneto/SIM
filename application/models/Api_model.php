<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
	public function add_queue_crop($data) {
		$data_insert = array(
			'id_user' => $data['id_user'],
			'source' => $data['source'],
			'filename' => $data['filename'],
			'crop_start' => $data['crop_start'],
			'crop_end' => $data['crop_end'],
			'ts_add' => strtotime('now'),
		);
		$this->db->insert('queue_crop', $data_insert);
		return $this->db->insert_id();
	}

	public function get_queue_crop() {
		$this->db->order_by('ts_add','desc');
		return $this->db->get('queue_crop')->result_array();
	}
}