<?php

namespace App\Controllers;

use App\Models\Modelpaket;
use CodeIgniter\RESTful\ResourceController;

class Paket extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
        $modelPaket = new Modelpaket();
        $data = $modelPaket->findAll();
        $response = [
            'status' => 200,
            'error' => "false",
            'message' => '',
            'totaldata' => count($data),
            'data' => $data,
        ];

        return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
        $modelPaket = new modelPaket();

        $data = $modelPaket->orLike('id', $id)
            ->get()->getResult();

        if (count($data) > 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];

            return $this->respond($response, 200);
        } elseif (count($data) == 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];

            return $this->respond($response, 200);
        } else {
            return $this->failNotFound('maaf daa ' . $id . ' tidak ditemukan');
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
        $modelPaket = new modelPaket();
        $id = $this->request->getPost("id");
        $daerah_asal = $this->request->getPost("daerah_asal");
        $daerah_tujuan = $this->request->getPost("daerah_tujuan");
        $berat_paket = $this->request->getPost("berat_paket");
        $kecepatan = $this->request->getPost("kecepatan");

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'id' => [
                'rules' => 'is_unique[user.id]',
                'label' => 'Id User',
                'errors' => [
                    'is_unique' => "{field} sudah ada"
                ]
            ]
        ]);

        if (!$valid) {
            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getError("id"),
            ];
            return $this->respond($response, 404);
        } else {
            $modelPaket->insert([
                'id' => $id,
                'daerah_asal' => $daerah_asal,
                'daerah_tujuan' => $daerah_tujuan,
                'berat_paket' => $berat_paket,
                'kecepatan' => $kecepatan,
            ]);
            $response = [
                'status' => 201,
                'error' => "false",
                'message' => "Data berhasil disimpan"
            ];
            return $this->respond($response, 201);
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
        $model = new modelPaket();
        $data = [
            'daerah_asal' => $this->request->getVar("daerah_asal"),
            'daerah_tujuan' => $this->request->getVar("daerah_tujuan"),
            'berat_paket' => $this->request->getVar("berat_paket"),
            'kecepatan' => $this->request->getVar("kecepatan"),
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Data Anda dengan Id Paket $id berhasil dibaharukan"
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
        $modelPaket = new modelPaket();
        $cekData = $modelPaket->find($id);
        if ($cekData) {
            $modelPaket->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Selamat data sudah berhasil dihapus maksimal"
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan kembali');
        }
    }
}
