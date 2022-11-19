<?php

namespace App\Controllers;

use App\Models\Modeluser;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
        $modelUser = new Modeluser();
        $data = $modelUser->findAll();
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
        $modelUser = new Modeluser();

        $data = $modelUser->orLike('id', $id)
            ->orLike('username', $id)->get()->getResult();

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
        $modelUser = new Modeluser();
        $id = $this->request->getPost("id");
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $email = $this->request->getPost("email");
        $phonenumber = $this->request->getPost("phonenumber");
        $birthdate = $this->request->getPost("birthdate");

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
            $modelUser->insert([
                'id' => $id,
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'phonenumber' => $phonenumber,
                'birthdate' => $birthdate,
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
        $model = new Modeluser();

        $data = [
            'username' => $this->request->getVar("username"),
            'password' => $this->request->getVar("password"),
            'email' => $this->request->getVar("email"),
            'phonenumber' => $this->request->getVar("phonenumber"),
            'birthdate' => $this->request->getVar("birthdate"),
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Data Anda dengan NIM $id berhasil dibaharukan"
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
        $modelUser = new Modeluser();
        $cekData = $modelUser->find($id);
        if ($cekData) {
            $modelUser->delete($id);
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
