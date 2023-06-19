<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class InstitutesController extends BaseController
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
        $builder = $this->db->table('institutes');

        $data = $builder->get()->getResultArray();
        // dd($data);

        return view("admin/institutes", [
            'subcats' => $data,
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
        $builder = $this->db->table('institutes');
        $data = $builder->get()->getResultArray();
        // dd($data);
        return $this->respond($data, 200);
    }

    public function create()
    {
        $request = request();
        //return $this->respond($_POST,200);
        $data = [
            'thana_id' => $request->getPost('thana_id'),
            'name' => $request->getPost('name'),
            'url' => $request->getPost('url'),
        ];
        if ($request->getPost('id') != "") {
            $data['id'] = $request->getPost('id');
        }

        $builder = $this->db->table('institutes');
        $builder->upsert($data);
        // $this->db
        // ->table('subjects')
        // ->insert($data);
        return $this->respond([
            'success' => true,
            'message' => "Data Inserted Successfully"
        ], 200);
    }

    public function delete()
    {
        $request = request();
        $id = $request->getPost('id');
        $builder = $this->db->table('institutes');
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
