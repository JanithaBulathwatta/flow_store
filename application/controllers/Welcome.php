 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('groups_model');  
		$this->load->model('message_model');
		$this->load->model('campaign_model');
    }
    
    public function index()
    {
         
        $data['groups'] = $this->groups_model->get_all_groups();
		
		 $this->load->model('contacts_model');
		 foreach ($data['groups'] as &$group) {
			 $group['participant_count'] = $this->contacts_model->get_contact_count($group['group_id']);
         }
		 
        $this->load->view('header');
        $this->load->view('groups_view', $data);
        $this->load->view('footer');
    }
    
     
    
    public function message_screen()
    {
        $this->load->view('header');
        $this->load->view('send_message');
        $this->load->view('footer');
    }
    
     
    
     
    public function create_group() {
         
        $this->output->set_content_type('application/json');
        
         
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
         
        $groupName = trim($this->input->post('group_name'));
        
         
        if (empty($groupName)) {
            echo json_encode(['success' => false, 'message' => 'Group name is required']);
            return;
        }
        
        if (strlen($groupName) < 2) {
            echo json_encode(['success' => false, 'message' => 'Group name must be at least 2 characters']);
            return;
        }
        
        if (strlen($groupName) > 45) {
            echo json_encode(['success' => false, 'message' => 'Group name must be less than 45 characters']);
            return;
        }
        
         
        if ($this->groups_model->group_exists($groupName)) {
            echo json_encode(['success' => false, 'message' => 'Group already exists']);
            return;
        }
        
         
        $groupId = $this->groups_model->create_group($groupName);
        
        if ($groupId) {
			$this->db->where('fk_group_id', $groupId);
            $this->db->where('contact_status', 'Active');
            $participant_count = $this->db->count_all_results('contact');
          
		  echo json_encode([
                'success' => true,
                'message' => 'Group created successfully!',
                'data' => [
                    'group' => [
                        'group_id' => $groupId,
						  
                        'group_name' => $groupName,
						'participant_count' => $participant_count
                    ]
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create group']);
        }
		
    }
	
	
	 
public function delete_group() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $groupId = (int) $this->input->post('group_id');
    
     
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
    // Check if group exists
    $group = $this->groups_model->get_group_by_id($groupId);
    if (!$group) {
        echo json_encode(['success' => false, 'message' => 'Group not found']);
        return;
    }
    
    // Soft delete (update group_str to 'Inactive')
    $this->db->where('group_id', $groupId);
    $deleteResult = $this->db->update('group', ['group_str' => 'Inactive']);
    
    if ($deleteResult) {
        echo json_encode([
            'success' => true,
            'message' => 'Group deleted successfully!',
            'data' => [
                'group_id' => $groupId
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete group']);
    }
}


//  method to get group data for editing
public function get_group_for_edit() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $groupId = (int) $this->input->post('group_id');
    
     
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
     
    $group = $this->groups_model->get_group_by_id($groupId);
    
    if ($group) {
        echo json_encode([
            'success' => true,
            'message' => 'Group found',
            'data' => [
                'group' => $group
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Group not found']);
    }
}

// Add this method to update group
public function update_group() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $groupId = (int) $this->input->post('group_id');
    $groupName = trim($this->input->post('group_name'));
    
     
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
     
    if (empty($groupName)) {
        echo json_encode(['success' => false, 'message' => 'Group name is required']);
        return;
    }
    
    if (strlen($groupName) < 2) {
        echo json_encode(['success' => false, 'message' => 'Group name must be at least 2 characters']);
        return;
    }
    
    if (strlen($groupName) > 45) {
        echo json_encode(['success' => false, 'message' => 'Group name must be less than 45 characters']);
        return;
    }
    
     
    if ($this->groups_model->group_exists($groupName, $groupId)) {
        echo json_encode(['success' => false, 'message' => 'Group name already exists']);
        return;
    }
    
     
    $existingGroup = $this->groups_model->get_group_by_id($groupId);
    if (!$existingGroup) {
        echo json_encode(['success' => false, 'message' => 'Group not found']);
        return;
    }
    
     
    $this->db->where('group_id', $groupId);
    $updateResult = $this->db->update('group', [
        'group_name' => $groupName,
           
    ]);
    
    if ($updateResult) {
        echo json_encode([
            'success' => true,
            'message' => 'Group updated successfully!',
            'data' => [
                'group' => [
                    'group_id' => $groupId,
                    'group_name' => $groupName
                ]
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update group']);
    }
}


 /**************************************************/
public function group_screen() {
    // Get group_id from URL
    $group_id = $this->input->get('group_id');
    
    if (!$group_id) {
        redirect('welcome/index');
        return;
    }
    
    // Load the Contacts model
    $this->load->model('contacts_model');
    
    // Get data using TWO queries from model
    $data['group'] = $this->contacts_model->get_group_details($group_id); // Single row
    $data['contacts'] = $this->contacts_model->get_contacts_by_group($group_id); // Multiple rows array
    
     
    $data['contact_count'] = $this->contacts_model->get_contact_count($group_id);
    
    $this->load->view('header');
    $this->load->view('group', $data);  
    $this->load->view('footer');
}

 
public function get_data() {
     
    $this->output->set_content_type('application/json');
    
     
    $group_id = $this->input->get('group_id') ?: $this->input->post('group_id');
    
    if (!$group_id) {
        echo json_encode([
            'success' => false, 
            'message' => 'Group ID is required'
        ]);
        return;
    }
    
     
    $this->load->model('contacts_model');
    
     
    $data = $this->contacts_model->get_data($group_id);
    
     
    $response = [
        'success' => true,
        'data' => $data  // This contains group, contacts, and contact_count
    ];
    
    echo json_encode($response);
}


// Delete contact from group
public function delete_contact() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $contactId = (int) $this->input->post('contact_id');
    $groupId = (int) $this->input->post('group_id');
    
     
    if (empty($contactId) || $contactId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
        return;
    }
    
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
     
    $this->load->model('contacts_model');
    
    // Check if contact exists and belongs to this group
    $this->db->where('contact_id', $contactId);
    $this->db->where('fk_group_id', $groupId);
    $this->db->where('contact_status', 'Active');
    $query = $this->db->get('contact');
    
    if ($query->num_rows() === 0) {
        echo json_encode(['success' => false, 'message' => 'Contact not found or already deleted']);
        return;
    }
    
    // Soft delete - update contact_status to 'Inactive'
    $this->db->where('contact_id', $contactId);
    $this->db->where('fk_group_id', $groupId);
    $updateResult = $this->db->update('contact', [
        'contact_status' => 'Inactive'
         
    ]);
    
    if ($updateResult) {
         
        $contact_count = $this->contacts_model->get_contact_count($groupId);
        
        echo json_encode([
            'success' => true,
            'message' => 'Contact deleted successfully!',
            'contact_count' => $contact_count,
            'data' => [
                'contact_id' => $contactId,
                'group_id' => $groupId
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete contact']);
    }
}
 
 
 // Get contact data for editing
public function get_contact_for_edit() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $contactId = (int) $this->input->post('contact_id');
    $groupId = (int) $this->input->post('group_id');
    
     
    if (empty($contactId) || $contactId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
        return;
    }
    
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
     
    $this->load->model('contacts_model');
    
     
    $contact = $this->contacts_model->get_contact_by_id($contactId, $groupId);
    
    if ($contact) {
        echo json_encode([
            'success' => true,
            'message' => 'Contact found',
            'data' => [
                'contact' => $contact
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Contact not found']);
    }
}

// Update contact
public function update_contact() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $contactId = (int) $this->input->post('contact_id');
    $contactName = trim($this->input->post('contact_name'));
    $contactNumber = trim($this->input->post('contact_number'));
    $groupId = (int) $this->input->post('group_id');
    
     
    if (empty($contactId) || $contactId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
        return;
    }
    
    if (empty($contactName)) {
        echo json_encode(['success' => false, 'message' => 'Contact name is required']);
        return;
    }
    
    if (strlen($contactName) < 2) {
        echo json_encode(['success' => false, 'message' => 'Contact name must be at least 2 characters']);
        return;
    }
    
    if (strlen($contactName) > 45) {
        echo json_encode(['success' => false, 'message' => 'Contact name must be less than 45 characters']);
        return;
    }
    
    if (empty($contactNumber)) {
        echo json_encode(['success' => false, 'message' => 'Contact number is required']);
        return;
    }
    
     
    $contactNumber = preg_replace('/\s+/', '', $contactNumber);
    
    if (strlen($contactNumber) < 10 || strlen($contactNumber) > 12) {
        echo json_encode(['success' => false, 'message' => 'Contact number must be 10-12 digits']);
        return;
    }
    
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
     
    $this->load->model('contacts_model');
    
     
    $existingContact = $this->contacts_model->get_contact_by_id($contactId, $groupId);
    if (!$existingContact) {
        echo json_encode(['success' => false, 'message' => 'Contact not found']);
        return;
    }
    
     
    if ($this->contacts_model->contact_exists($groupId, $contactNumber, $contactId)) {
        echo json_encode(['success' => false, 'message' => 'Contact number already exists in this group']);
        return;
    }
    
     
    $updateData = [
        'contact_name' => $contactName,
        'contact_number' => $contactNumber
        // You could add: 'updated_date' => date('Y-m-d H:i:s')
    ];
    
    $this->db->where('contact_id', $contactId);
    $this->db->where('fk_group_id', $groupId);
    $updateResult = $this->db->update('contact', $updateData);
    
    if ($updateResult) {
        echo json_encode([
            'success' => true,
            'message' => 'Contact updated successfully!',
            'data' => [
                'contact' => [
                    'contact_id' => $contactId,
                    'contact_name' => $contactName,
                    'contact_number' => $contactNumber
                ]
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update contact']);
    }
}
 
 
 
 // Add new contact to group
public function add_contact() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $contactName = trim($this->input->post('contact_name'));
    $contactNumber = trim($this->input->post('contact_number'));
    $groupId = (int) $this->input->post('group_id');
	$source = $this->input->post('source') ?: 'manual';
    
     
    if (empty($contactName)) {
        echo json_encode(['success' => false, 'message' => 'Contact name is required']);
        return;
    }
    
    if (strlen($contactName) < 2) {
        echo json_encode(['success' => false, 'message' => 'Contact name must be at least 2 characters']);
        return;
    }
    
    if (strlen($contactName) > 45) {
        echo json_encode(['success' => false, 'message' => 'Contact name must be less than 45 characters']);
        return;
    }
    
    if (empty($contactNumber)) {
        echo json_encode(['success' => false, 'message' => 'Contact number is required']);
        return;
    }
    
     
    $contactNumber = preg_replace('/\s+/', '', $contactNumber);
    
    if (strlen($contactNumber) < 10 || strlen($contactNumber) > 12) {
        echo json_encode(['success' => false, 'message' => 'Contact number must be 10-12 digits']);
        return;
    }
    
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
     
    $this->load->model('contacts_model');
    
     
    if ($this->contacts_model->contact_exists($groupId, $contactNumber)) {
        echo json_encode(['success' => false, 'message' => 'Contact number already exists in this group']);
        return;
    }
	
	$source = $this->input->post('source') ?: 'manual';
	
	if (empty($this->input->post('source'))) {
        
         
        $referrer = $this->input->server('HTTP_REFERER');
        if (strpos($referrer, 'group_screen') !== false) {
            $source = 'existing';
        }
    }
	
    
     
    $contactData = [
        'name' => $contactName,
        'phone_number' => $contactNumber,
		'source' => $source
    ];
    
     
    $insertResult = $this->contacts_model->add_contact($groupId, $contactData);
    
    if ($insertResult) {
         
        $contactId = $this->db->insert_id();
        
         
        $newContact = $this->contacts_model->get_contact_by_id($contactId, $groupId);
        
         
        $contactCount = $this->contacts_model->get_contact_count($groupId);
        
        echo json_encode([
            'success' => true,
            'message' => 'Contact added successfully!',
            'contact_count' => $contactCount,
            'data' => [
                'contact' => $newContact
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add contact']);
    }
	
	  
}



// Import contacts from Excel
public function import_contacts() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $groupId = (int) $this->input->post('group_id');
    $note = trim($this->input->post('note'));
    $contactsJson = $this->input->post('contacts');
    
     
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
    if (empty($contactsJson)) {
        echo json_encode(['success' => false, 'message' => 'No contacts data received']);
        return;
    }
    
    $contacts = json_decode($contactsJson, true);
    
    if (!is_array($contacts) || empty($contacts)) {
        echo json_encode(['success' => false, 'message' => 'Invalid contacts data']);
        return;
    }
    
     
    $this->load->model('contacts_model');
    
     
    $importResult = $this->import_contacts_batch($groupId, $contacts, $note);
    
    if ($importResult['success']) {
         
        $contactCount = $this->contacts_model->get_contact_count($groupId);
        
        echo json_encode([
            'success' => true,
            'message' => 'Contacts imported successfully!',
            'contact_count' => $contactCount,
            'data' => [
                'imported_contacts' => $importResult['imported_contacts'],
                'summary' => [
                    'total' => count($contacts),
                    'imported' => $importResult['imported_count'],
                    'skipped' => $importResult['skipped_count']
                ]
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => $importResult['message']]);
    }
	
	$contactData['source'] = 'excel';
}

 
private function import_contacts_batch($groupId, $contacts, $note = '') {
    $imported = [];
    $importedCount = 0;
    $skippedCount = 0;
    
     
    $this->db->trans_start();
    
    foreach ($contacts as $contact) {
        $name = trim($contact['name']);
        $phone = preg_replace('/\s+/', '', $contact['phone']);
        
        // Validate again (server-side)
        if (empty($name) || strlen($name) < 2 || strlen($name) > 45) {
            $skippedCount++;
            continue;
        }
        
        if (!preg_match('/^0[0-9]{9}$/', $phone)) {
            $skippedCount++;
            continue;
        }
        
         
        $this->db->where('fk_group_id', $groupId);
        $this->db->where('contact_number', $phone);
        $this->db->where('contact_status', 'Active');
        $exists = $this->db->get('contact')->num_rows() > 0;
        
        if ($exists) {
            $skippedCount++;
            continue;
        }
        
         
        $contactData = [
            'fk_group_id' => $groupId,
            'contact_name' => $name,
            'contact_number' => $phone,
			 'source' => 'excel',
            'contact_status' => 'Active',
            'created_date' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('contact', $contactData);
        
        if ($this->db->affected_rows() > 0) {
            $contactId = $this->db->insert_id();
            $imported[] = [
                'contact_id' => $contactId,
                'contact_name' => $name,
                'contact_number' => $phone,
                'created_date' => $contactData['created_date']
            ];
            $importedCount++;
        } else {
            $skippedCount++;
        }
    }
    
    $this->db->trans_complete();
    
    if ($this->db->trans_status() === FALSE) {
        return [
            'success' => false,
            'message' => 'Database error during import'
        ];
    }
    
    return [
        'success' => true,
        'imported_count' => $importedCount,
        'skipped_count' => $skippedCount,
        'imported_contacts' => $imported,
        'message' => "Imported {$importedCount} contacts, skipped {$skippedCount} duplicates/invalid"
    ];
}

// Download Excel template
public function download_template() {
    // Load PHPExcel library
    $this->load->library('phpexcel');
    
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $sheet = $objPHPExcel->getActiveSheet();
    
    // Set headers
    $sheet->setCellValue('A1', 'Name');
    $sheet->setCellValue('B1', 'Phone Number');
    
    // Set sample data
    $sheet->setCellValue('A2', 'John Doe');
    $sheet->setCellValueExplicit('B2', '0711234567', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValue('A3', 'Jane Smith');
    $sheet->setCellValueExplicit('B3', '0789876543', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValue('A4', 'Robert Johnson');
    $sheet->setCellValueExplicit('B4', '0765551234', PHPExcel_Cell_DataType::TYPE_STRING);
    
    // Add notes
    $sheet->setCellValue('A6', 'IMPORTANT NOTES:');
    $sheet->setCellValue('A7', '1. Keep headers in first row');
    $sheet->setCellValue('A8', '2. Name column is required');
    $sheet->setCellValue('A9', '3. Phone must be 10 digits starting with 0');
    $sheet->setCellValue('A10', '4. Do not change column order');
    $sheet->setCellValue('A11', '5. Maximum 1000 contacts per file');
    
     
    $sheet->getStyle('A1:B1')->getFont()->setBold(true);
    $sheet->getStyle('A1:B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('E8E8E8');
    
     
    $sheet->getStyle('A6')->getFont()->setBold(true)->setColor(new PHPExcel_Style_Color('FF0000'));
    
	
	$sheet->getStyle('B')
          ->getNumberFormat()
          ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		  
     
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    
     
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Contacts_Template.xlsx"');
    header('Cache-Control: max-age=0');
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}



 
public function filter_contacts() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $groupId = (int) $this->input->post('group_id');
    $search = trim($this->input->post('search'));
    $dateFilter = $this->input->post('date_filter');
    $sortBy = $this->input->post('sort_by');
    
     
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
     
    $this->load->model('contacts_model');
    
     
    $filters = [];
    if (!empty($search)) {
        $filters['search'] = $search;
    }
    
     
    $contacts = $this->contacts_model->get_contacts_by_group($groupId, $filters);
    
     
    if (!empty($dateFilter)) {
        $contacts = $this->apply_date_filter($contacts, $dateFilter);
    }
    
     
    $contacts = $this->apply_sorting($contacts, $sortBy);
    
     
    $totalCount = $this->contacts_model->get_contact_count($groupId);
    
    echo json_encode([
        'success' => true,
        'message' => 'Filter applied',
        'data' => [
            'contacts' => $contacts,
            'filtered_count' => count($contacts),
            'total_count' => $totalCount
        ]
    ]);
}

// Helper: Apply date filtering
private function apply_date_filter($contacts, $dateFilter) {
    $filtered = [];
    $today = date('Y-m-d');
    
    foreach ($contacts as $contact) {
        $contactDate = date('Y-m-d', strtotime($contact['created_date']));
        $include = false;
        
        switch($dateFilter) {
            case 'today':
                $include = ($contactDate == $today);
                break;
            case 'yesterday':
                $yesterday = date('Y-m-d', strtotime('-1 day'));
                $include = ($contactDate == $yesterday);
                break;
            case 'week':
                $weekAgo = date('Y-m-d', strtotime('-7 days'));
                $include = ($contactDate >= $weekAgo);
                break;
            case 'month':
                $monthAgo = date('Y-m-d', strtotime('-30 days'));
                $include = ($contactDate >= $monthAgo);
                break;
            default:
                $include = true;
        }
        
        if ($include) {
            $filtered[] = $contact;
        }
    }
    
    return $filtered;
}

 
private function apply_sorting($contacts, $sortBy) {
    usort($contacts, function($a, $b) use ($sortBy) {
        switch($sortBy) {
            case 'oldest':
                return strtotime($a['created_date']) - strtotime($b['created_date']);
            case 'name_asc':
                return strcasecmp($a['contact_name'], $b['contact_name']);
            case 'name_desc':
                return strcasecmp($b['contact_name'], $a['contact_name']);
            case 'newest':
            default:
                return strtotime($b['created_date']) - strtotime($a['created_date']);
        }
    });
    
    return $contacts;
}  

public function get_group_contacts() {
     
    $this->output->set_content_type('application/json');
    
     
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $groupId = (int) $this->input->post('group_id');
    
     
    if (empty($groupId) || $groupId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group ID']);
        return;
    }
    
     
    $this->load->model('contacts_model');
    
     
    $contacts = $this->contacts_model->get_contacts_by_group($groupId, []);
    $totalCount = $this->contacts_model->get_contact_count($groupId);
    
    echo json_encode([
        'success' => true,
        'message' => 'Contacts loaded',
        'data' => [
            'contacts' => $contacts,
            'total_count' => $totalCount
        ]
    ]);
}


 /******************/
  
// Get contacts for a specific group (for AJAX)
public function get_group_contacts_ajax() {
     
    $this->output->set_content_type('application/json');
    
     
    $group_id = $this->input->post('group_id');
    
     
    if (empty($group_id) || $group_id <= 0) {
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid group ID'
        ]);
        return;
    }
    
     
    $group_data = $this->message_model->get_group_data($group_id);
    
     
    if (empty($group_data['group'])) {
        echo json_encode([
            'success' => false, 
            'message' => 'Group not found'
        ]);
        return;
    }
    
     
    $response = [
        'success' => true,
        'group_id' => $group_id,
        'group_name' => $group_data['group']['group_name'],
        'contact_count' => $group_data['contact_count'],
        'contacts' => $group_data['contacts']
    ];
    
    echo json_encode($response);
}

 
  
public function get_all_groups_ajax() {
    $this->output->set_content_type('application/json');
    
    try {
        $this->db->where('group_str', 'Active');
        $this->db->order_by('group_id', 'DESC');  
        $query = $this->db->get('group');
        $groups = $query->result_array();
		
        if ($groups) {
             
            foreach ($groups as &$group) {
                $group['participant_count'] = $this->message_model->get_contact_count($group['group_id']);
            }
            
            echo json_encode([
                'success' => true,
                'groups' => $groups
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'groups' => [],
                'message' => 'No groups found'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error loading groups: ' . $e->getMessage()
        ]);
    }
}
/*****************/

public function campaigns_screen() {
     
    $data['campaigns'] = $this->campaign_model->get_all_campaigns();
    
    // For each campaign, calculate the percentage
    foreach ($data['campaigns'] as &$campaign) {
        // Get total contacts for this campaign
        $this->db->where('fk_campaign_id', $campaign['campaign_id']);
        $total_contacts = $this->db->count_all_results('campaign_numbers');
        
        // Exclude message chunks from total (MSG_START, MSG_CHUNK_, MSG_END)
        $this->db->where('fk_campaign_id', $campaign['campaign_id']);
        $this->db->not_like('campaign_number', 'MSG_START', 'after');
        $this->db->not_like('campaign_number', 'MSG_CHUNK_', 'after');
        $this->db->not_like('campaign_number', 'MSG_END', 'after');
        $this->db->not_like('campaign_number', 'MSG', 'after');
        $actual_contacts = $this->db->count_all_results('campaign_numbers');
        
        // Use actual contacts if available, otherwise use total_sent
        $total_recipients = max($actual_contacts, $campaign['total_sent']);
        
        // Calculate percentage
        if ($total_recipients > 0) {
            $percentage = round(($campaign['total_sent'] / $total_recipients) * 100);
        } else {
            $percentage = 0;
        }
        
        // Ensure percentage doesn't exceed 100%
        $percentage = min($percentage, 100);
        
        // Store the calculated percentage and total recipients
        $campaign['sent_percentage'] = $percentage;
        $campaign['total_recipients'] = $total_recipients;
    }
	
    $data['statistics'] = $this->campaign_model->get_campaign_statistics();
    
    $this->load->view('header');
    $this->load->view('campaigns', $data);
    $this->load->view('footer');
}

/**
 * Get campaigns data via AJAX
 */
public function get_campaigns_ajax() {
    $this->output->set_content_type('application/json');
    
    try {
        $status = $this->input->post('status');
        $search = $this->input->post('search');
        
        $filters = array();
        if (!empty($status) && $status != 'all') {
            $filters['status'] = $status;
        }
        
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        
        $campaigns = $this->campaign_model->get_all_campaigns($filters);
        
         
        $formatted_campaigns = array();
        foreach ($campaigns as $campaign) {
            $formatted_campaigns[] = array(
                'campaign_id' => $campaign['campaign_id'],
                'campaign_title' => $campaign['campaign_title'],
                'campaign_date' => date('Y-m-d', strtotime($campaign['campaign_date'])),
                'total_sent' => $campaign['total_sent'],
                'recipients' => $campaign['recipients'],
                'status' => $campaign['campaign_status']
            );
        }
        
        echo json_encode([
            'success' => true,
            'campaigns' => $formatted_campaigns
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error loading campaigns: ' . $e->getMessage()
        ]);
    }
}

/**
 * Get campaign details for edit
 */
public function get_campaign_for_edit() {
    $this->output->set_content_type('application/json');
    
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
    $campaign_id = (int) $this->input->post('campaign_id');
    
    if (empty($campaign_id) || $campaign_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid campaign ID']);
        return;
    }
    
    $campaign = $this->campaign_model->get_campaign_by_id($campaign_id);
    
    if ($campaign) {
        echo json_encode([
            'success' => true,
            'message' => 'Campaign found',
            'data' => [
                'campaign' => $campaign
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Campaign not found']);
    }
}

/**
 * Create new campaign
 */
public function create_campaign() {
    $this->output->set_content_type('application/json');
    
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $campaign_title = trim($this->input->post('campaign_title'));
    $campaign_date = $this->input->post('campaign_date');
    $total_sent = (int) $this->input->post('total_sent');
    $recipients = trim($this->input->post('recipients'));
    $campaign_status = trim($this->input->post('campaign_status'));
    
     
    if (empty($campaign_title)) {
        echo json_encode(['success' => false, 'message' => 'Campaign title is required']);
        return;
    }
    
    if (strlen($campaign_title) < 2) {
        echo json_encode(['success' => false, 'message' => 'Campaign title must be at least 2 characters']);
        return;
    }
    
    if (strlen($campaign_title) > 45) {
        echo json_encode(['success' => false, 'message' => 'Campaign title must be less than 45 characters']);
        return;
    }
    
     
    if ($total_sent < 0) {
        echo json_encode(['success' => false, 'message' => 'Total sent cannot be negative']);
        return;
    }
    
     
    if (empty($recipients)) {
        $recipients = 'All Contacts';
    }
    
    if (strlen($recipients) > 20) {
        echo json_encode(['success' => false, 'message' => 'Recipients must be less than 20 characters']);
        return;
    }
    
     
    $valid_statuses = array('Active', 'Completed', 'Pending', 'Draft', 'Cancelled');
    if (!empty($campaign_status) && !in_array($campaign_status, $valid_statuses)) {
        $campaign_status = 'Active';
    } elseif (empty($campaign_status)) {
        $campaign_status = 'Active';
    }
    
     
    if ($this->campaign_model->campaign_exists($campaign_title)) {
        echo json_encode(['success' => false, 'message' => 'Campaign title already exists']);
        return;
    }
    
     
    $campaign_data = array(
        'campaign_title' => $campaign_title,
        'campaign_date' => !empty($campaign_date) ? date('Y-m-d H:i:s', strtotime($campaign_date)) : date('Y-m-d H:i:s'),
        'total_sent' => $total_sent,
        'recipients' => $recipients,
        'campaign_status' => $campaign_status
    );
    
     
    $campaign_id = $this->campaign_model->create_campaign($campaign_data);
    
    if ($campaign_id) {
         
        $new_campaign = $this->campaign_model->get_campaign_by_id($campaign_id);
        
        echo json_encode([
            'success' => true,
            'message' => 'Campaign created successfully!',
            'data' => [
                'campaign' => $new_campaign
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create campaign']);
    }
}

/**
 * Update campaign
 */
public function update_campaign() {
    $this->output->set_content_type('application/json');
    
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $campaign_id = (int) $this->input->post('campaign_id');
    $campaign_title = trim($this->input->post('campaign_title'));
    $campaign_date = $this->input->post('campaign_date');
    $total_sent = (int) $this->input->post('total_sent');
    $recipients = trim($this->input->post('recipients'));
    $campaign_status = trim($this->input->post('campaign_status'));
    
     
    if (empty($campaign_id) || $campaign_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid campaign ID']);
        return;
    }
    
     
    $existing_campaign = $this->campaign_model->get_campaign_by_id($campaign_id);
    if (!$existing_campaign) {
        echo json_encode(['success' => false, 'message' => 'Campaign not found']);
        return;
    }
    
     
    if (!empty($campaign_title)) {
        if (strlen($campaign_title) < 2) {
            echo json_encode(['success' => false, 'message' => 'Campaign title must be at least 2 characters']);
            return;
        }
        
        if (strlen($campaign_title) > 45) {
            echo json_encode(['success' => false, 'message' => 'Campaign title must be less than 45 characters']);
            return;
        }
        
         
        if ($this->campaign_model->campaign_exists($campaign_title, $campaign_id)) {
            echo json_encode(['success' => false, 'message' => 'Campaign title already exists']);
            return;
        }
    }
    
     
    $update_data = array();
    
    if (!empty($campaign_title)) {
        $update_data['campaign_title'] = $campaign_title;
    }
    
    if (!empty($campaign_date)) {
        $update_data['campaign_date'] = date('Y-m-d H:i:s', strtotime($campaign_date));
    }
    
    if ($total_sent >= 0) {
        $update_data['total_sent'] = $total_sent;
    }
    
    if (!empty($recipients)) {
        if (strlen($recipients) > 20) {
            echo json_encode(['success' => false, 'message' => 'Recipients must be less than 20 characters']);
            return;
        }
        $update_data['recipients'] = $recipients;
    }
    
    if (!empty($campaign_status)) {
        $valid_statuses = array('Active', 'Completed', 'Pending', 'Draft', 'Cancelled');
        if (in_array($campaign_status, $valid_statuses)) {
            $update_data['campaign_status'] = $campaign_status;
        }
    }
    
     
    $result = $this->campaign_model->update_campaign($campaign_id, $update_data);
    
    if ($result) {
         
        $updated_campaign = $this->campaign_model->get_campaign_by_id($campaign_id);
        
        echo json_encode([
            'success' => true,
            'message' => 'Campaign updated successfully!',
            'data' => [
                'campaign' => $updated_campaign
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update campaign']);
    }
}

/**
 * Delete campaign
 */
public function delete_campaign() {
    $this->output->set_content_type('application/json');
    
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
    $campaign_id = (int) $this->input->post('campaign_id');
    
    if (empty($campaign_id) || $campaign_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid campaign ID']);
        return;
    }
    
     
    $campaign = $this->campaign_model->get_campaign_by_id($campaign_id);
    if (!$campaign) {
        echo json_encode(['success' => false, 'message' => 'Campaign not found']);
        return;
    }
    
     
    $result = $this->campaign_model->delete_campaign($campaign_id);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Campaign deleted successfully!',
            'data' => [
                'campaign_id' => $campaign_id
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete campaign']);
    }
}

/**
 * Update campaign status
 */
public function update_campaign_status() {
    $this->output->set_content_type('application/json');
    
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
    $campaign_id = (int) $this->input->post('campaign_id');
    $status = trim($this->input->post('status'));
    
     
    if (empty($campaign_id) || $campaign_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid campaign ID']);
        return;
    }
    
    $valid_statuses = array('Active', 'Completed', 'Pending', 'Draft', 'Cancelled');
    if (empty($status) || !in_array($status, $valid_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        return;
    }
    
     
    $result = $this->campaign_model->update_campaign_status($campaign_id, $status);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Campaign status updated successfully!',
            'data' => [
                'campaign_id' => $campaign_id,
                'status' => $status
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update campaign status']);
    }
}

/**
 * Get campaign statistics via AJAX
 */
public function get_campaign_statistics_ajax() {
    $this->output->set_content_type('application/json');
    
    try {
        $statistics = $this->campaign_model->get_campaign_statistics();
        
        echo json_encode([
            'success' => true,
            'statistics' => $statistics
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error loading statistics: ' . $e->getMessage()
        ]);
    }
}

/*****************************hdghgfhf*/

/**
 * Save SMS campaign with ALL contacts from group
 */
public function save_sms_campaign() {
    $this->output->set_content_type('application/json');
    
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
     
    $campaign_title = trim($this->input->post('campaign_title'));
    $message_content = trim($this->input->post('message_content'));
    $group_id = (int) $this->input->post('group_id');
    $group_name = trim($this->input->post('group_name'));
    
     
    if (empty($campaign_title)) {
        echo json_encode(['success' => false, 'message' => 'Campaign title is required']);
        return;
    }
    
    if (empty($message_content)) {
        echo json_encode(['success' => false, 'message' => 'Message content is required']);
        return;
    }
    
    if (empty($group_id) || $group_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid group selected']);
        return;
    }
    
     
    $this->db->select('contact_id, contact_name, contact_number, source');
    $this->db->where('fk_group_id', $group_id);
    $this->db->where('contact_status', 'Active');
    $query = $this->db->get('contact');
    $all_contacts = $query->result_array();
    
    $contact_count = count($all_contacts);
    
    if ($contact_count === 0) {
        echo json_encode(['success' => false, 'message' => 'No contacts found in the selected group']);
        return;
    }
    
     
    $this->db->trans_start();
    
     
    $compact_contacts = [];
    foreach ($all_contacts as $contact) {
        $compact_contacts[] = $contact['contact_id'] . ':' . 
                             substr($contact['contact_name'], 0, 3) . '|' . 
                             $contact['contact_number'];
    }
    $serialized_contacts = implode(';', $compact_contacts);
    
     
    if (strlen($serialized_contacts) > 20) {
        $serialized_contacts = substr($serialized_contacts, 0, 20);
    }
    
     
    $campaign_data = array(
        'campaign_title' => $campaign_title,
        'campaign_date' => date('Y-m-d H:i:s'),
        'total_sent' => $contact_count,
        'recipients' => $serialized_contacts,
        'campaign_status' => 'Pending'
    );
    
    $this->db->insert('campaign', $campaign_data);
    $campaign_id = $this->db->insert_id();
    
    if (!$campaign_id) {
        $this->db->trans_rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to create campaign']);
        return;
    }
	
	// 2. Store the FULL message in campaign_numbers table
    //  split long messages into chunks
    $full_message = $message_content;
    $message_chunks = str_split($full_message, 7); // 7 chars per chunk (leaving room for index)
    
    // Store message metadata  
    $message_meta = array(
        'fk_campaign_id' => $campaign_id,
        'campaign_number' => 'MSG_START', // Special marker for message start
        'send_status' => 'CHUNKS:' . count($message_chunks) // Store number of chunks
    );
    $this->db->insert('campaign_numbers', $message_meta);
	
	// Store each message chunk
    foreach ($message_chunks as $index => $chunk) {
        $chunk_index = str_pad($index, 3, '0', STR_PAD_LEFT); // 001, 002, etc
        $chunk_data = array(
            'fk_campaign_id' => $campaign_id,
            'campaign_number' => 'MSG_CHUNK_' . $chunk_index,
            'send_status' => $chunk // Store the actual message chunk
        );
        $this->db->insert('campaign_numbers', $chunk_data);
    }
    
     
    $message_end = array(
        'fk_campaign_id' => $campaign_id,
        'campaign_number' => 'MSG_END',
        'send_status' => 'END'
    );
    $this->db->insert('campaign_numbers', $message_end);
	
	
    
     
    foreach ($all_contacts as $contact) {
         
        $phone = substr($contact['contact_number'], 0, 12);
        
         
        $contact_id_str = substr((string)$contact['contact_id'], 0, 8);
        
        $campaign_number_data = array(
            'fk_campaign_id' => $campaign_id,
            'campaign_number' => $phone,
            'send_status' => $contact_id_str  
        );
        
        $this->db->insert('campaign_numbers', $campaign_number_data);
    }
    
    $this->db->trans_complete();
    
    if ($this->db->trans_status() === FALSE) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
        return;
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Campaign created successfully with ' . $contact_count . ' contacts!',
        'data' => [
            'campaign_id' => $campaign_id,
            'total_contacts' => $contact_count,
            'campaign_title' => $campaign_title,
			'message_length' => strlen($message_content),
            'chunks_stored' => count($message_chunks)
        ]
    ]);
}
 
 
/**
 * Get campaign contacts from actual contact table
 */
  public function get_campaign_contacts_ajax() {
    $this->output->set_content_type('application/json');
    
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
    $campaign_id = (int) $this->input->post('campaign_id');
    
    if (empty($campaign_id) || $campaign_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid campaign ID']);
        return;
    }
	
	 
    $this->load->model('campaign_model');
    //$message_content = $this->campaign_model->get_campaign_message($campaign_id);
    // Get message chunks from campaign_numbers table
$this->db->select('send_status');
$this->db->where('fk_campaign_id', $campaign_id);
$this->db->like('campaign_number', 'MSG_CHUNK_', 'after'); // Get only message chunks
$this->db->order_by('cn_id', 'ASC'); // Important: keep chunks in correct order
$message_chunks = $this->db->get('campaign_numbers')->result_array();

 
$message_content = '';
foreach ($message_chunks as $chunk) {
    $message_content .= $chunk['send_status'];
}

 
if (empty($message_content)) {
    $message_content = 'No message found for this campaign';
}


     
    $this->db->select('send_status');  
    $this->db->where('fk_campaign_id', $campaign_id);
	  
	$this->db->not_like('campaign_number', 'MSG_CHUNK_', 'after');  
    $this->db->not_like('campaign_number', 'MSG');  
    
	
$campaign_contacts = $this->db->get('campaign_numbers')->result_array();
    
	
    $contact_ids = [];
    foreach ($campaign_contacts as $cn) {
        // send_status contains contact_id as string
        if (is_numeric($cn['send_status'])) {
            $contact_ids[] = (int)$cn['send_status'];
        }
    }
    
    if (empty($contact_ids)) {
        echo json_encode([
            'success' => true,
            'contacts' => [],
            'total' => 0,
            'message' => 'No contacts found for this campaign'
        ]);
        return;
    }
    
     
    $this->db->select('contact_id, contact_name, contact_number,source');
    $this->db->where_in('contact_id', $contact_ids);
    $this->db->where('contact_status', 'Active');
    $query = $this->db->get('contact');
    $contacts = $query->result_array();
    
     
    $formatted_contacts = [];
    foreach ($contacts as $contact) {
        $formatted_contacts[] = [
            'contact_id' => $contact['contact_id'],
            'contact_name' => $contact['contact_name'],
            'contact_number' => $contact['contact_number'],
            'status' => 'Saved',  
			'source' => isset($contact['source']) ? $contact['source'] : 'existing'
        ];
    }
    
    echo json_encode([
        'success' => true,
        'contacts' => $formatted_contacts,
		'message_content' => $message_content,
        'total' => count($formatted_contacts),
        'debug' => [
            'campaign_id' => $campaign_id,
            'contact_ids_found' => $contact_ids,
            'contacts_retrieved' => count($formatted_contacts),
			'message_retrieved' => true
        ]
    ]);
}

 /*
public function debug_campaign_message($campaign_id) {
    $this->output->set_content_type('application/json');
    
    // 1. Check campaign table
    $this->db->where('campaign_id', $campaign_id);
    $campaign = $this->db->get('campaign')->row_array();
    
    // 2. Check what's in campaign_numbers for this campaign
    $this->db->where('fk_campaign_id', $campaign_id);
    $this->db->order_by('cn_id', 'ASC');
    $all_rows = $this->db->get('campaign_numbers')->result_array();
    
    // 3. Try to reconstruct message
    $message_chunks = [];
    foreach ($all_rows as $row) {
        if (strpos($row['campaign_number'], 'MSG_') === 0 || 
            $row['campaign_number'] === 'MSG_START' ||
            $row['campaign_number'] === 'MSG' ||
            $row['campaign_number'] === 'MSG_END') {
            $message_chunks[] = $row;
        }
    }
    
    echo json_encode([
        'campaign_data' => $campaign,
        'all_rows_count' => count($all_rows),
        'message_rows' => $message_chunks,
        'sample_rows' => array_slice($all_rows, 0, 10)
    ]);
}
*/

 
}
