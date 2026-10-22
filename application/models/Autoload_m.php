<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Autoload_m extends CI_Model {
//----------------------------------------------------------------------------------------
	//desh(2023-10-19)
    public function checkDuplicates($table, $checkColumn, $checkText) {
		$this->db->select($checkColumn);
		$this->db->where($checkColumn, $checkText);
		$this->db->where('status', 'active');

		$query = $this->db->get($table);

		return $query->num_rows() > 0;
	}
//----------------------------------------------------------------------------------------	
	//desh(2023-10-30)
	public function commonGetAll($table, $fields, $joins = [], $where = [], $exceptDel = false, $connections = [], $groupBy = null, $orderBy = null) {
		$ut_type = $this->session->userdata('ut_type');
		$com_id = $this->session->userdata('com_id');
		$this->db->select("$fields, $table.status status")->from($table);

		foreach($joins as $joinTable => $on){
			$this->db->join($joinTable, $on, 'left');
		}

		foreach ($where as $condition) {
			if ($condition == 'com_check' && $ut_type !== 'admin') {
				$field = ($ut_type == 'vendor') ? $table.'.vendor_com_id' : $table.'.drop_com_id';
				$this->db->where($field, $com_id);
			} else {
				$this->db->where($condition);
			}
		}

		if ($exceptDel != 'all') {
			$statusCondition = $exceptDel ? "$table.status != 'delete'" : "$table.status = 'active'";
			$this->db->where($statusCondition);
		}
		
		if($groupBy){
			$this->db->group_by($groupBy);
		}
		
		if($orderBy){
			$this->db->order_by($orderBy);
		}

		$results = $this->db->get()->result();
		
		foreach($results as $i => $res){
			foreach($connections as $table => $val){
				$this->db->select($val['con_fields']);
				if(isset($val['except_deleted']) && $val['except_deleted']){
					if(val['except_deleted'] !== 'all'){
						$this->db->where($table.'.status !=', 'delete');
					}
				}else{
					$this->db->where($table.'.status', 'active');
				}
				if($val['con_joins'] != []){
					foreach ($val['con_joins'] as $conJoinTable => $conJoinOn) {
						$this->db->join($conJoinTable, $conJoinOn, 'left');
					}
				}
				if($val['con_where'] != []){
					foreach ($val['con_where'] as $joinCol => $tableCol) {
						$this->db->where($joinCol, $res->$tableCol);
					}
				}
				$con_name = $val['con_name'];
				$res->$con_name = $this->db->get($table)->result();
			}
		}
		
		return $results;
	}
//----------------------------------------------------------------------------------------
	//desh(2023-10-30)
	public function commonGetById($id, $idColumn, $table, $fields, $joins = [], $where = [], $exceptDel = false, $connections = [], $groupBy = null, $orderBy = null){
		$ut_type = $this->session->userdata('ut_type');
		$com_id = $this->session->userdata('com_id');	
		$this->db->select("$fields, $table.status status")->from($table)->where($idColumn, $id);
		
		foreach($joins as $joinTable => $on){
			$this->db->join($joinTable, $on, 'left');
		}

		foreach ($where as $condition) {
			if ($condition == 'com_check' && $ut_type !== 'admin') {
				$field = ($ut_type == 'vendor') ? $table.'.vendor_com_id' : $table.'.drop_com_id';
				$this->db->where($field, $com_id);
			} else {
				$this->db->where($condition);
			}
		}
		
		if ($exceptDel != 'all') {
			$statusCondition = $exceptDel ? "$table.status != 'delete'" : "$table.status = 'active'";
			$this->db->where($statusCondition);
		}

		if($groupBy){
			$this->db->group_by($groupBy);
		}
		
		if($orderBy){
			$this->db->order_by($orderBy);
		}

		$results = $this->db->get()->result();
		
		foreach($results as $i => $res){
			foreach($connections as $table => $val){
				$this->db->select($val['con_fields']);
				if(isset($val['except_deleted']) && $val['except_deleted']){
					if(val['except_deleted'] !== 'all'){
						$this->db->where($table.'.status !=', 'delete');
					}
				}else{
					$this->db->where($table.'.status', 'active');
				}
				if($val['con_joins'] != []){
					foreach ($val['con_joins'] as $conJoinTable => $conJoinOn) {
						$this->db->join($conJoinTable, $conJoinOn, 'left');
					}
				}
				if($val['con_where'] != []){
					foreach ($val['con_where'] as $joinCol => $tableCol) {
						$this->db->where($joinCol, $res->$tableCol);
					}
				}
				$con_name = $val['con_name'];
				$res->$con_name = $this->db->get($table)->result();
			}
		}
		
		return $results;
	}
//----------------------------------------------------------------------------------------
	//desh(2023-10-31)
	public function commonDelete($id, $whereArr, $title, $table, $handledBy = false, $recordLog = true){ 
		if($handledBy){
			$arr = array('status' => 'delete', 'handled_by' => $this->session->userdata('user_id'));
		}else{
			$arr = array('status' => 'delete');
		}
		
		foreach($whereArr as $whereCol => $whereVal){
			$this->db->where($whereCol, $whereVal);
		}
		
		$re = $this->db->update($table, $arr);
		
		if($recordLog){
			$this->Activity_log_m->saveLog($title, $title.' deleted', $table, $id);
		}
		
		$status = $re ? 'ok' : 'error';
		$action = 'Deleted';
		$message = $re ? "$title $action Successfully!!!" : "$title $action Failed!!!";

		echo json_encode(['stt' => $status, 'msg' => $message, 'data' => $id]);
		
	}
//----------------------------------------------------------------------------------------	
	//desh(2023-10-31)
	public function commonChangeStatus($id, $idColumn, $title, $table, $status, $handledBy = false, $recordLog = true){ 
		if($handledBy){
			$arr = array('status' => $status, 'handled_by' => $this->session->userdata('user_id'));
		}else{
			$arr = array('status' => $status);
		}
		
		$re = $this->db->where($idColumn, $id)->update($table, $arr);
		
		if($recordLog){			
			$this->Activity_log_m->saveLog($title, $title.' '.$status, $table, $id);
		}
		
		$stt = $re ? 'ok' : 'error';
		$action = $stt;
		$message = $re ? "$title $action Successful!!!" : "$title $action Failed!!!";

		echo json_encode(['stt' => $stt, 'msg' => $message, 'data' => $id]);
		
	}
//----------------------------------------------------------------------------------------	
	//desh(2023-10-30)
	public function commonSave($table, $inputArr, $title, $id = null, $idColumn = null, $inputType = null, $recordLog = true) {
		$type = $id ? 'updated' : 'added';
		
		if ($type === 'updated') {
			$re = $this->db->update($table, $inputArr, [$idColumn => $id]);
			$id = $re ? $id : -1;
		} else {
			if($inputType == 'batch'){
				$re = $this->db->insert_batch($table, $inputArr);
				$id = -1;
			}else{
				$re = $this->db->insert($table, $inputArr);
				$id = $re ? $this->db->insert_id() : -1;
			}
		}
		
		if($recordLog){
			$this->Activity_log_m->saveLog($title, $title.' '.$type, $table, $id);	
		}
		
		return $id;
	
	}
//----------------------------------------------------------------------------------------
	// to check the edit/delete permission - Nadun 2024-01-11
	public function RW_Permissions($type = 'both'){// types can be edit, delete or both
		$checking_url = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'])['path'] : "no";
		
		$permission = $this->search_permission_array($checking_url);
		
		if($permission){
			if($type == 'edit'){
				if($permission->edit_permissions != 1){
					die(json_encode(array("status" => "error", "msg" => "You do not have permission to take this action.")));
				}
			}else if($type == 'delete'){
				if($permission->delete_permissions != 1){
					die(json_encode(array("status" => "error", "msg" => "You do not have permission to take this action.")));
				}
			}else{
				if($permission->edit_permissions != 1 || $permission->delete_permissions != 1){
					die(json_encode(array("status" => "error", "msg" => "You do not have permission to take this action.")));
				}
			}
		}else{
			die(json_encode(array("status" => "error", "msg" => "You do not have permission to take this action.")));
		}
	}
//----------------------------------------------------------------------------------------
	// to search the permission array using urldecode - Nadun 2024-01-11
	public function search_permission_array($urlToFind){
		$array = $this->session->userdata('permissions');
		$matchingPermission = array_reduce($array, function ($carry, $mainObject) use ($urlToFind) {
			$matchingSubPermissions = array_filter($mainObject->sub_permissions, function ($subPermission) use ($urlToFind) {
				return $subPermission->ps_url === $urlToFind;
			});

			return $carry ?: reset($matchingSubPermissions);
		});
		
		return $matchingPermission;
	}
//----------------------------------------------------------------------------------------
	// desh(2024-01-22)
	public function checkStock($proId, $newQty) {
		$re = $this->db
			->join('st_stock', "st_stock.pro_id = product.pro_id AND st_stock.status = 'active'", 'left')
			->select("(IFNULL(SUM(st_stock.st_in), 0) - (IFNULL(SUM(st_stock.st_out), 0) + $newQty)) as stock_balance, product.pro_name")
			->where('product.pro_id', $proId)
			->group_by('product.pro_id')
			->get('product')
			->row();
			
		return ['pro_name' => $re->pro_name, 'pro_qty' => $re->stock_balance];	
	}
//----------------------------------------------------------------------------------------
	// desh(2024-01-24) - upload one image
	public function uploadImage($imageId, $imageFile, $uploadPath, $thumbPath, $thumbWidth = 300, $thumbHeight = 300, $saveName = null){
		$_FILES['img'] = array(
			'name' => $imageFile['name'],
			'type' => $imageFile['type'],
			'tmp_name' => $imageFile['tmp_name'],
			'error' => $imageFile['error'],
			'size' => $imageFile['size']
		);
		
		$tempFile = $_FILES['img']['tmp_name'];
		
		if (!is_uploaded_file($tempFile)) {
			echo json_encode(['stt' => 'error', 'msg' => 'File not uploaded!!!', 'data' => '']);
			return;
		}
		
		// Generate new file name
		if($saveName == null){            
			$randomNumber = rand(100, 999);
			$saveName = $imageId . $randomNumber . date('Ymdhis');
		}
		
		// Get file extension
		$fileParts = pathinfo($imageFile['name']);
		$fileExt = strtolower($fileParts['extension']);
		
		// Set upload path and allowed types
		$uploadConfig = [
			'upload_path' => $uploadPath,
			'allowed_types' => 'jpg|jpeg|png',
			'max_size' => 5000,
			'file_name' => $saveName . '.' . $fileExt,
		];
		
		// Load upload library
		$this->load->library('upload');
		$this->upload->initialize($uploadConfig);

		if (!$this->upload->do_upload('img')) {
			$error = $this->upload->display_errors();
			return ['error' => $error];
		} else {
			// Reset upload library for the next iteration
			$this->upload->initialize($uploadConfig);
			
			// Create thumbnail
			$newFileName = $saveName; // Fix variable name
			$thumbnailConfig = [
				'image_library' => 'gd2',
				'source_image' => $uploadPath . $newFileName . '.' . $fileExt,
				'new_image' => $thumbPath . $newFileName . '_t.' . $fileExt,
				'maintain_ratio' => TRUE,
				'width' => $thumbWidth,
				'height' => $thumbHeight,
			];

			$this->load->library('image_lib');
			$this->image_lib->initialize($thumbnailConfig);
			$this->image_lib->resize();
			$this->image_lib->clear();
			
			$imageData = [
				'imageId' => $imageId,
				'imageName' => $saveName,
				'imageExtension' => '.' . $fileExt,
				'imageOrgPath' => $uploadPath,
				'imageThumbPath' => $thumbPath
			];
			
			return $imageData;
		}
	}
//----------------------------------------------------------------------------------------
	
//----------------------------------------------------------------------------------------

	

}
?>