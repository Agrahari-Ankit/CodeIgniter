<?php

namespace App\Models;

use CodeIgniter\Model;

class EducationModel extends Model
{
    protected $table      = 'education_details';  
    protected $primaryKey = 'id'; 

    protected $allowedFields = [
        'user_id',
        'highest_education',
        'university',
        'college',
        'percentage',
        'year_of_passing',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true; 
}
