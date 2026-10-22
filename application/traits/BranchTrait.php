<?php
trait BranchTrait {
    
    protected function getCurrentBranchId() {
        $CI =& get_instance();
        
        // Try both possible keys (branch or branch_id)
        $branch_id = $CI->session->userdata('branch_id');
        
        // If not found, try 'branch' key (your session uses this)
        if (!$branch_id) {
            $branch_id = $CI->session->userdata('branch');
        }
        
        // Debug log (remove after testing)
        log_message('debug', 'BranchTrait::getCurrentBranchId() - Branch ID: ' . ($branch_id ? $branch_id : 'NULL'));
        
        return $branch_id;
    }
    
    protected function addBranch($data) {
        $branch_id = $this->getCurrentBranchId();
        
        if ($branch_id && !isset($data['branch_id'])) {
            $data['branch_id'] = $branch_id;
            log_message('debug', 'BranchTrait::addBranch() - Added branch_id ' . $branch_id);
        }
        
        return $data;
    }
    
    protected function filterByBranch($table_alias = null) {
        $branch_id = $this->getCurrentBranchId();
        
        if ($branch_id) {
            if ($table_alias) {
                $this->db->where($table_alias . '.branch_id', $branch_id);
            } else {
                $this->db->where('branch_id', $branch_id);
            }
            log_message('debug', 'BranchTrait::filterByBranch() - Applied filter for branch_id = ' . $branch_id);
        } else {
            log_message('debug', 'BranchTrait::filterByBranch() - No branch_id found in session!');
        }
        
        return $this;
    }
    
    protected function verifyBranch($table, $id, $id_field = 'id') {
        $branch_id = $this->getCurrentBranchId();
        
        if (!$branch_id) return true;
        
        $CI =& get_instance();
        $count = $CI->db->where($id_field, $id)
                        ->where('branch_id', $branch_id)
                        ->get($table)
                        ->num_rows();
        
        return $count > 0;
    }
}