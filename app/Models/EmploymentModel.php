<?php
 

namespace App\Models;
use CodeIgniter\Model;

class EmploymentModel extends Model {
    protected $table = 'employment_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'company_name', 'designation', 'years_experience', 'location'];
}