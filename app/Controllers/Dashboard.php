<?php

namespace App\Controllers;

use App\Models\FilesModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use Exception;

class Dashboard extends BaseController
{
    use ResponseTrait;

    public function home()
    {
        $session = session();
        if ($session->get('is_logged_in'))
            return view('dashboardHome');
        else
            return redirect()->to('/login');
    }

    public function uploadFileForm()
    {
        try {
            $session = session();
            $filesModel = new FilesModel();
            helper('form', 'url');

            $file = $this->request->getFile('file');
            //$userID = $this->request->getVar('user_id');
            $userID = $session->get('id');

            if ($file->isValid() && !$file->hasMoved()) {
                $file->move(WRITEPATH . 'uploads/');
                $data = [
                    'user_id' => $userID,
                    'file' => WRITEPATH . 'uploads/' . $file->getName()
                ];
                $filesModel->insert($data);
                if ($filesModel->db->error()['code']) throw new Exception($filesModel->db->error()['message'], 500);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => $e->getCode() === 0 ? 500 : $e->getCode(),
                'error' => $e->getCode() === 409 ? $filesModel->errors() : $e->getMessage()
            ];
            return $this->respond($response, 200);
        }

        if ($filesModel->db->affectedRows() == 1) {
            $response = [
                'status' => 200,
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 500,
                'error' => "Something went wrong!",
            ];
        }

        return $this->respond($response, 200);
    }
}
