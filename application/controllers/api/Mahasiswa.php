<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Mahasiswa extends RestController
{
    public function __construct()
    {
        parent::__construct();

        //load model crud
        $this->load->model('Mahasiswa_model');

        $this->methods['index_get']['limit'] = 100;
    }
    
    public function index_get()
    {
        $id= $this->get('id');
        if ($id==NULL) {
            $mahasiswa = $this->Mahasiswa_model->getMahasiswa();
        }else {
            $mahasiswa = $this->Mahasiswa_model->getMahasiswa($id);
        }
        
        if ($mahasiswa) {
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], RestController::HTTP_OK);
        }else {
            $this->response([
                'status' => false,
                'message' => 'data tidak ditemukan'
            ], 404);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id===NULL) {
            $this->response([
                'status' => false,
                'message' => 'Provied ID'
            ], RestController::HTTP_BAD_REQUEST);
        }else {
            if ($this->Mahasiswa_model->deleteMahasiswa($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'
                ], RestController::HTTP_OK);
            }else {
                $this->response([
                    'status' => false,
                    'message' => 'data tidak ditemukan'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data= [
            'nrp'=>$this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan'),
        ];

        $insert = $this->Mahasiswa_model->createMahasiswa($data);
        if ($insert) {
            $this->response([
                'status' => true,
                'message' => 'data berhasil ditambahkan'
            ], RestController::HTTP_CREATED);
        }else {
            $this->response([
                'status' => false,
                'message' => 'data gagal ditambahkan'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan'),
        ];

        $update = $this->Mahasiswa_model->updateMahasiswa($data,$id);
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
