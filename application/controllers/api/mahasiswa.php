<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class mahasiswa extends REST_Controller
{
    public function __construct()
        {
            parent::__construct();
            $this->load->model('mahasiswa_model', 'mahasiswa');
        }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null){
            $mahasiswa = $this->mahasiswa->getmahasiswa();
        }else{
            $mahasiswa = $this->mahasiswa->getmahasiswa($id);
        }

        if ($mahasiswa) {
            $this->response([
                'status' => TRUE,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'id yang dicari tidak ada'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if($id === null){
            $this->response([
                'status' => FALSE,
                'message' => 'id yang dihapus tidak ada'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            if($this->mahasiswa->deletemahasiswa($id) > 0)
            {$this->response([
                'status' => TRUE,
                'message' => 'terhapus'
            ], REST_Controller::HTTP_NO_CONTENT);
            }else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'gagal menghapus'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nim' => $this->post('nim'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];
        if($this->mahasiswa->createmahasiswa($data) > 0)
        {
            $this->response([
                'status' => TRUE,
                'message' => 'berhasil menambahkan mahasiswa'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'gagal menambahkan mahasiswa'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nim' => $this->put('nim'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];
        if($this->mahasiswa->updatemahasiswa($data, $id) > 0)
        {
            $this->response([
                'status' => TRUE,
                'message' => 'berhasil mengedit mahasiswa'
            ], REST_Controller::HTTP_NO_CONTENT);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'gagal mengedit mahasiswa'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}