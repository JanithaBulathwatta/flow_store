<?php
class Permission_model extends CI_Model {

    /*public function get_user_types()
    {
        return $this->db->where('status','active')->get('sys_user_type')->result();
    }*/

    /*public function get_modules()
    {
        $this->db->select('m.pm_id,m.pm_name,s.ps_id,s.ps_name');
        $this->db->from('sys_permission_main m');
        $this->db->join('sys_permission_sub s','m.pm_id=s.pm_id','left');
        $this->db->where('m.status','active');
        $this->db->where('s.status','active');
        $this->db->order_by('m.pm_order,s.ps_order');

        $res = $this->db->get()->result();

        $data = [];
        foreach($res as $r){
            $data[$r->pm_id]['name'] = $r->pm_name;
            $data[$r->pm_id]['subs'][] = [
                'ps_id'=>$r->ps_id,
                'ps_name'=>$r->ps_name
            ];
        }
        return $data;
    }*/
	/*public function get_modules($ut_id)
		{
			$this->db->select('m.pm_id,m.pm_name,s.ps_id,s.ps_name');
			$this->db->from('sys_permission_user_main um');
			$this->db->join('sys_permission_main m','m.pm_id=um.pm_id');
			$this->db->join('sys_permission_sub s','m.pm_id=s.pm_id','left');

			$this->db->where('um.ut_id',$ut_id);
			//$this->db->group_by('s.ut_id');
			//$this->db->where('um.status','active');
			$this->db->where('m.status','active');

			// ✅ IMPORTANT: hide skip_menu = 1
			$this->db->where('show_settings',0);
			$this->db->where('s.status','active');

			$this->db->order_by('m.pm_order,s.ps_order');

			$res = $this->db->get()->result();

			$data = [];
			foreach($res as $r){

				// Skip if no sub permission exists
				if(empty($r->ps_id)) continue;

				$data[$r->pm_id]['pm_id'] = $r->pm_id;
				$data[$r->pm_id]['name']  = $r->pm_name;
				$data[$r->pm_id]['subs'][] = [
					'ps_id'   => $r->ps_id,
					'ps_name' => $r->ps_name
				];
			}

			return $data;
		}
		
	*/
	

    /*public function get_permissions()
    {
        $rows = $this->db->get('sys_user_permission')->result();
        $perm=[];
        foreach($rows as $r){
            $perm[$r->ut_id][]=$r->ps_id;
        }
        return $perm;
    }*/
	
	/*public function get_permissions()
	{
		$rows = $this->db->where('status','active')
						 ->get('sys_permission_user_sub')
						 ->result();

		$perm=[];
		foreach($rows as $r){
			$perm[$r->ut_id][$r->pm_id][] = $r->ps_id;
		}
		return $perm;
	}*/
	

    /*public function save_permissions($ut_id,$ps_ids)
    {
        $this->db->where('ut_id',$ut_id)->delete('sys_user_permission');

        if(!empty($ps_ids)){
            foreach($ps_ids as $ps){
                $this->db->insert('sys_user_permission',['ut_id'=>$ut_id,'ps_id'=>$ps]);
            }
        }
    }
	
	public function save_permissions($ut_id,$ps_ids,$stt)
    {
		if($stt=='0'){
			$stt = 'delete';
		}else{
			$stt = 'active';
		}
		
        $this->db->where('ut_id',$ut_id)->delete('sys_permission_user_sub');

        if(!empty($ps_ids)){
            foreach($ps_ids as $ps){
                $this->db->insert('sys_user_permission',['ut_id'=>$ut_id,'ps_id'=>$ps,'status'=>$stt]);
            }
        }
    }*/
	
/*		public function getUserTypes()
		{
			return $this->db
				->where('status','active')
				->order_by('ut_id','ASC')
				->get('sys_user_type')
				->result();
		}
*/


		/* GET ALL MAIN MODULES 
		public function getMainModules()
		{
			return $this->db
				->where('status','active')
				->order_by('pm_order','ASC')
				->get('sys_permission_main')
				->result();
		}*/



		/* GET ALL SUB MODULES 
		public function getSubModules()
		{
			return $this->db
				->where('status','active')
				->where('skip_menu',1)
				->order_by('ps_order','ASC')
				->get('sys_permission_sub')
				->result();
		}*/


	public function getUserTypes()
    {
        return $this->db->where('status','active')->get('sys_user_type')->result();
    }


		/*public function getModules()
    {

        $this->db->where('status','active');
        $this->db->order_by('pm_order','ASC');

        $main = $this->db->get('sys_permission_main')->result();

        foreach($main as $m){

            $this->db->where('pm_id',$m->pm_id);
            $this->db->where('status','active');

            $this->db->order_by('ps_order','ASC');

            $m->subs = $this->db->get('sys_permission_sub')->result();

        }

        return $main;

    }*/

	public function getModules()
	{

		$this->db->where('status','active');
		$this->db->order_by('pm_order','ASC');

		$main = $this->db->get('sys_permission_main')->result();

		foreach($main as $m){

			// 🔹 Add this line
			$m->name = $m->pm_name;

			$this->db->where('pm_id',$m->pm_id);
			//$this->db->where('skip_menu',0);
			$this->db->where('show_settings',1);
			$this->db->where('status','active');
			$this->db->order_by('ps_order','ASC');

			$m->subs = $this->db->get('sys_permission_sub')->result();

		}

		return $main;

	}

    public function getUserPermissions($ut_id)
    {

        $this->db->select('pm_id,ps_id');
        $this->db->from('sys_permission_user_sub');

        $this->db->where('ut_id',$ut_id);
        $this->db->where('status','active');

        return $this->db->get()->result();

    }

	/* USER MAIN PERMISSIONS */
	public function getUserMainPermissions($ut_id)
	{
		return $this->db->where('ut_id',$ut_id)->get('sys_permission_user_main')->result();
	}



	public function getUserSubPermissions($ut_id)
	{
		return $this->db->where('ut_id',$ut_id)->get('sys_permission_user_sub')->result();
	}



	public function updateSubPermission($ut_id,$ps_id,$status){
			$this->db->where('ut_id',$ut_id);
			$this->db->where('ps_id',$ps_id);
			$this->db->where('skip','0');

			return $this->db->update('sys_permission_user_sub',['status'=>$status]);
	}



	public function insertSubPermission($data)
	{
		return $this->db->insert('sys_permission_user_sub',$data);
	}



	public function checkUserSubPermission($ut_id,$ps_id)
	{
		return $this->db->where('ut_id',$ut_id)->where('ps_id',$ps_id)->get('sys_permission_user_sub')->row();
	}



	public function getMainModules()
	{
		return $this->db->where('status','active')->get('sys_permission_main')->result();
	}



	public function countActiveSubPermissions($ut_id,$pm_id){
		$this->db->from('sys_permission_user_sub');

		$this->db->where('ut_id',$ut_id);
		$this->db->where('pm_id',$pm_id);
		$this->db->where('status','active');

		return $this->db->count_all_results();
	}



	public function updateMainPermission($ut_id,$pm_id,$status){
		$exists = $this->db->where('ut_id',$ut_id)->where('pm_id',$pm_id)->get('sys_permission_user_main')->row();

		if($exists){

			$this->db->where('ut_id',$ut_id);
			$this->db->where('pm_id',$pm_id);

			return $this->db->update(
				'sys_permission_user_main',
				['status'=>$status]
			);

		}else{

			return $this->db->insert(
				'sys_permission_user_main',
				[
					'ut_id'=>$ut_id,
					'pm_id'=>$pm_id,
					'status'=>$status
				]
			);

		}
	}

	
	
}