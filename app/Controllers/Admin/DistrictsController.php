<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class DistrictsController extends BaseController
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
        $builder = $this->db->table('districts');

        $data = $builder->get()->getResultArray();
        // dd($data);
        $boards = $this->db
            ->table('boards')
            ->select('id, name')
            ->get()->getResultArray();
        $query = $this->db->table('districts')
            ->select('districts.id, districts.board_id, districts.name, districts.bn_name, districts.lat, districts.lon, districts.url, boards.name AS board_name')
            ->join('boards', 'boards.id = districts.board_id', 'inner')
            ->orderBy('districts.id', 'ASC')
            ->get();
        $result = $query->getResultArray();
        return view("admin/districts", [
            'subcats' => $result,
            'boards' => $boards,
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
        $builder = $this->db->table('districts');
        $data = $builder->get()->getResultArray();
        // dd($data);
        $query = $this->db->table('districts')
            ->select('districts.id, districts.board_id, districts.name, districts.bn_name, districts.lat, districts.lon, districts.url, boards.name AS board_name')
            ->join('boards', 'boards.id = districts.board_id', 'inner')
            ->orderBy('districts.id', 'ASC')->get();
        $result = $query->getResultArray();
        return $this->respond($result, 200);
    }

    public function create()
    {
        $request = request();
        //return $this->respond($_POST,200);
        $data = [
            'board_id' => $request->getPost('board_id'),
            'name' => $request->getPost('name'),
            'bn_name' => $request->getPost('bn_name'),
            'lat' => $request->getPost('lat'),
            'lon' => $request->getPost('lon'),
            'url' => $request->getPost('url'),
        ];
        if ($request->getPost('id') != "") {
            $data['id'] = $request->getPost('id');
        }

        $builder = $this->db->table('districts');
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
        $builder = $this->db->table('districts');
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
