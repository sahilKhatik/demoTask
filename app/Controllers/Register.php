<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use CodeIgniter\API\ResponseTrait;

use App\Models\UsersModel;
use Exception;

class Register extends BaseController
{
    use ResponseTrait;
    public function registrationPage()
    {
        return view('registrationPage');
    }

    public function userRegisteredSuccessfull()
    {
        return view('userCreatedSuccessfull');
    }

    public function newUserRegister()
    {
        try {
            $usersModel = new UsersModel();

            $frontendToBackendAttrs = [
                'name' => 'name',
                'email' => 'email',
                'mobileNo' => 'mobile_no',
                'password' => 'password'
            ];

            $data = array();
            foreach ($frontendToBackendAttrs as $frontendAttr => $backendAttr) {
                $data[$backendAttr] = $this->request->getVar($frontendAttr);
            }
            //print_r($data);

            $usersModel->insert($data);
            if ($usersModel->db->error()['code']) throw new Exception($usersModel->db->error()['message'], 500);
            if (!empty($usersModel->errors())) {
                throw new Exception('Validation', 409);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => $e->getCode() === 0 ? 500 : $e->getCode(),
                'error' => $e->getCode() === 409 ? $usersModel->errors() : $e->getMessage()
            ];

            return $this->respond($response, $response['status']);
        }

        if($usersModel->db->affectedRows() == 1)
        {
            unset($data['password']);
            $response = [
                'status' => 200,
                'data' => $data
            ];
        }
        else
        {
            $response = [
                'status' => 500,
                'error' => 'Something went wrong!',
            ];
        }
        //header('Content-Type: application/json');
        //return $this->response->setJSON($response);
        //echo json_encode($response);
        return $this->respond($response, 200);

    }
}
