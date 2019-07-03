<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pelanggan extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelanggan_model', 'pelanggan');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $data = $this->pelanggan->getPelanggan();
        } else {
            $data = $this->pelanggan->getPelanggan($id);
        }

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data tidak ditemukan.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'Membutuhkan id.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->pelanggan->deletePelanggan($id) > 0) {
                $this->response([
                    'status' => TRUE,
                    'id' => $id,
                    'message' => 'Data berhasil dihapus.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Data tidak ditemukan.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'id_kwh' => $this->post('id_kwh'),
            'nama' => $this->post('nama'),
            'alamat' => $this->post('alamat'),
            'tarif' => $this->post('tarif')
        ];

        if ($this->pelanggan->tambahPelanggan($data) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'Data berhasil ditambahkan.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data gagal ditambahkan.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'id_kwh' => $this->put('id_kwh'),
            'nama' => $this->put('nama'),
            'alamat' => $this->put('alamat'),
            'tarif' => $this->put('tarif')
        ];

        if ($this->pelanggan->updatePelanggan($data, $id) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'Data berhasil diubah.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data gagal diubah.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
