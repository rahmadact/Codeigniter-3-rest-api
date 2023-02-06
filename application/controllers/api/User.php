<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController
{
    public function __construct()
    {
        parent::__construct();

        //load model crud
        $this->load->model('User_model');

        $this->methods['index_get']['limit'] = 100;
    }

    public function index_get()
    {
        $id= $this->get('id_user');
        if ($id==NULL) {
            $user = $this->User_model->getUser();
        }else {
            $user = $this->User_model->getUser($id);
        }
        
        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user
            ], RestController::HTTP_OK);
        }else {
            $this->response([
                'status' => false,
                'message' => 'data tidak ditemukan'
            ], 404);
        }
    }

    public function index_post()
    {
        $data = [
            'nama' => $this->post('nama'),
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'key' => $this->post('key')
            
        ];

        $insert = $this->User_model->createUser($data);
        if ($insert) {
            $this->response([
                'status' => true,
                'message' => 'data berhasil ditambahkan'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data gagal ditambahkan'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id_user');

        if ($id === NULL) {
            $this->response([
                'status' => false,
                'message' => 'Provied ID'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            if ($this->User_model->deleteUser($id) > 0) {
                $this->response([
                    'status' => true,
                    'id_user' => $id,
                    'message' => 'deleted'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data tidak ditemukan'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_put()
    {
        $id = $this->put('id_user');
        $data = [
            'nama' => $this->put('nama'),
            'username' => $this->put('username'),
            'password' => $this->put('password'),
            
        ];

        $update = $this->User_model->updateUser($data, $id);
        if ($update) {
            $this->response([
                'status' => true,
                'message' => 'data berhasil diupdate'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data gagal diupdate'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}