<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class QuestionsController extends BaseController
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
        $builder = $this->db->table('questions');

        $data = $builder->get()->getResultArray();
        // dd($data);

        return view("admin/questions", [
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
        $builder = $this->db->table('questions');
        $data = $builder->get()->getResultArray();
        // dd($data);
        return $this->respond($data, 200);
    }

    public function create()
    {
        $request = request();
        //return $this->respond($_POST,200);
        $data = [
            'subject_id' => $request->getPost('sid'),
            'board_id' => $request->getPost('bid'),
            'zilla_id' => $request->getPost('zid'),
            'thana_id' => $request->getPost('tid'),
            'institute_id' => $request->getPost('iid'),
            'year' => $request->getPost('year'),
            'q_image' => $request->getPost('q'),
        ];
        if ($request->getPost('id') != "") {
            $data['id'] = $request->getPost('id');
        }

        $builder = $this->db->table('questions');
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
        $builder = $this->db->table('questions');
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
