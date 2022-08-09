<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Config\Services;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use Exception;

class Login extends BaseController
{
    use ResponseTrait;

    public function loginPage()
    {
        return view('loginPage');
    }

    public function validateUser()
    {
        try {
            $usersModel = new UsersModel();
            $validation = Services::validation();
            $validationRules = [
                'email' => [
                    'rules' => 'required|valid_email|is_not_unique[users.email]',
                    'errors' => [
                        'required' => 'Enter email id!',
                        'valid_email' => 'Enter valid email!',
                        'is_not_unique' => 'User not registered!'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Enter password!'
                    ]
                ]
            ];
            $validation->setRules($validationRules);
            $validation->withRequest($this->request)->run();
            if (!empty($validation->getErrors())) {
                throw new Exception('Validation', 409);
            }

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $userInfo = $usersModel->where('email', $email)->first();
            if ($usersModel->db->error()['code']) throw new Exception($usersModel->db->error()['message'], 500);
            if (!empty($userInfo) && $userInfo['password'] === $password) {
                $session = session();
                unset($userInfo['password']);
                $userInfo['is_logged_in'] = true;
                $session->set($userInfo);
                return redirect()->to('/Dashboard');
            } else {
                throw new Exception('Check your credintials!', 401);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => $e->getCode() === 0 ? 500 : $e->getCode(),
                'error' => $e->getCode() === 409 ? $validation->getErrors() : $e->getMessage()
            ];
            $data['response'] = $response;
            return view('loginPage', $data);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
