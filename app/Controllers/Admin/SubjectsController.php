<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class SubjectsController extends BaseController
{
    use ResponseTrait;
    protected $db;
    protected $security;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->security = \Config\Services::security();
    }
    public function index()
    {

        //echo BASESEURL . "<hr>";
        $builder = $this->db->table('subjects');

        $data = $builder->get()->getResultArray();
        // dd($data);

        return view("admin/subjects", [
            'subcats' => $data,
            'security' => $this->security
        ]);
    }
    public function store()
    {

        //echo BASESEURL . "<hr>";
        $builder = $this->db->table('subjects');

        $data = $builder->get()->getResultArray();
        // dd($data);

        return view("store", [
            'sub' => $data,
            'security' => $this->security
        ]);
    }

    //paginated link
    public function getPaginatedData($id)
    {
    }
    //paginated link end

    public function all()
    {

        //echo BASESEURL . "<hr>";
        $builder = $this->db->table('subjects');
        $data = $builder->get()->getResultArray();
        // dd($data);
        return $this->respond($data, 200);
    }

    public function create1()
    {
        $request = request();
        //return $this->respond($_POST,200);
        $data = [
            'subject' => $request->getPost('subject'),
            'class' => $request->getPost('class'),
            'images' => $request->getPost('image'),
            'quantity' => $request->getPost('q'),
            'price' => $request->getPost('p'),
            'discount' => $request->getPost('d'),
        ];
        //`quantity`, `price`, `discount`
        if ($request->getPost('id') != "") {
            $data['id'] = $request->getPost('id');
        }

        $builder = $this->db->table('subjects');
        $builder->upsert($data);
        // $this->db
        // ->table('subjects')
        // ->insert($data);
        return $this->respond([
            'success' => true,
            'message' => "Data Inserted Successfully"
        ], 200);
    }

    public function create()
    {
        $request = $this->request;

        // // Handle file upload

        if ($request->getFile('image') != "") {
            $uploadedFile = $request->getFile('image');
            $imgname = $request->getPost('i');
            $extension = $uploadedFile->getExtension();
            $newName = $imgname . '.' . $extension;
            // $filePath = FCPATH . 'assets/HSC/' . $newName;

            // if (file_exists($filePath)) {
            //     unlink($filePath);
            //     return true;
            // } else {
            //     // File does not exist
            //     return false;
            // }
            $uploadedFile->move('assets/HSC', $newName);
            $data['images'] = $newName;
        }

        // Get other form data
        $data['subject'] = $request->getPost('subject');
        $data['class'] = $request->getPost('class');
        $data['quantity'] = $request->getPost('q');
        $data['price'] = $request->getPost('p');
        $data['discount'] = $request->getPost('d');

        // Insert data into the database
        // $this->db->table('subjects')->insert($data);
        if ($request->getPost('id') != "") {
            $data['id'] = $request->getPost('id');
        }

        $builder = $this->db->table('subjects');
        $builder->upsert($data);
        // Return the response
        return $this->respond([
            'success' => true,
            'message' => 'Data Inserted Successfully'
        ], 200);
    }

    public function delete()
    {
        $request = request();
        $id = $request->getPost('id');
        $builder = $this->db->table('subjects');
        if ($builder->delete(['id' => $id])) {
            return $this->respond([
                'success' => true,
                'message' => "Data Deleted Successfully"
            ], 200);
        } else {
            return $this->respond([
                'success' => false,
                'message' => "Error deleting Subcategory!!"
            ], 200);
        }
    }
}
