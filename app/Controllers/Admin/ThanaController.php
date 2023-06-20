<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ThanaController extends BaseController
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
        $builder = $this->db->table('thana');

        $data = $builder->get()->getResultArray();
        // dd($data);
        $districts = $this->db
            ->table('districts')
            ->select('id, name')
            ->get()->getResultArray();
        $query = $this->db->table('thana')
            ->select('thana.id, thana.district_id, thana.name, thana.bn_name, thana.url, districts.name AS d_name')
            ->join('districts', 'districts.id = thana.district_id', 'inner')
            ->orderBy('thana.id', 'ASC')
            ->get();
        $result = $query->getResultArray();
        return view("admin/thana", [
            'subcats' => $result,
            'dst' => $districts,
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
        $builder = $this->db->table('thana');
        $data = $builder->get()->getResultArray();
        // dd($data);
        $query = $this->db->table('thana')
            ->select('thana.id, thana.district_id, thana.name, thana.bn_name, thana.url, districts.name AS d_name')
            ->join('districts', 'districts.id = thana.district_id', 'inner')
            ->orderBy('thana.id', 'ASC')
            ->get();
        $result = $query->getResultArray();
        return $this->respond($result, 200);
    }

    public function create()
    {
        $request = request();
        //return $this->respond($_POST,200);
        $data = [
            'district_id' => $request->getPost('district_id'),
            'name' => $request->getPost('name'),
            'bn_name' => $request->getPost('bn_name'),
            'url' => $request->getPost('url'),
        ];
        if ($request->getPost('id') != "") {
            $data['id'] = $request->getPost('id');
        }

        $builder = $this->db->table('thana');
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
        $builder = $this->db->table('thana');
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
