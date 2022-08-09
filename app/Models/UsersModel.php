<?php
namespace App\Models;
use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'email', 'mobile_no', 'password'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'name' => 'required|alpha_numeric_space',
        'email' => 'required|valid_email|is_unique[users.email]',
        'mobile_no' => 'required|numeric|is_unique[users.mobile_no]',
        'password' => 'required'
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Name is mandatory!',
            'alpha_numeric_space' => 'Special characters not allowed!',
        ],
        'email' => [
            'required' => 'Email is mandatory!',
            'valid_email' => 'Enter valid email!',
            'is_unique' => 'This email has already been taken!'
        ],
        'mobile_no' => [
            'required' => 'Mobile no is required!',
            'numeric' => 'Enter correct mobile number!',
            'is_unique' => 'This mobile number has already been taken!'
        ],
        'password' => [
            'required' => 'Password is mandatory!'
        ]
    ];
    protected $skipValidation     = false;
}
?>