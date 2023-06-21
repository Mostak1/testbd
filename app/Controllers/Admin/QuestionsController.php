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
        $subject = $this->db
            ->table('subjects')
            ->select('id, subject')
            ->get()->getResultArray();
        $board = $this->db
            ->table('boards')
            ->select('id, name')
            ->get()->getResultArray();
        $query = $this->db->table('questions')
            ->select('questions.id, questions.subject_id, questions.board_id, questions.zilla_id, questions.thana_id, questions.institute_id, questions.year, questions.q_image, questions.hot, questions.created_at, subjects.subject AS sbn,boards.name AS boardnm,districts.name AS districtnm, thana.name AS thananm,institutes.name AS instnm')
            ->join('subjects', 'subjects.id = questions.subject_id', 'inner')
            ->join('boards', 'boards.id=questions.board_id', 'inner')
            ->join('districts', 'districts.id=questions.zilla_id', 'inner')
            ->join('thana', 'thana.id=questions.thana_id', 'inner')
            ->join('institutes', 'institutes.id=questions.institute_id', 'inner')
            ->orderBy('questions.id', 'ASC')
            ->get();
        $result = $query->getResultArray();
        return view("admin/questions", [
            'subcats' => $result,
            'subject' => $subject,
            'board' => $board,
            'security' => $this->security
        ]);
    }
    //create method for change thana,district,board according to ...
    public function districts($id)
    {
        $districts = $this->db
            ->table('districts')
            ->select('id, name')
            ->where('board_id', $id)
            ->get()->getResultArray();
        return $this->response->setJSON($districts);
    }
    public function thana($id)
    {
        $thana = $this->db
            ->table('thana')
            ->select('id, name')
            ->where('district_id', $id)
            ->get()->getResultArray();
        return $this->response->setJSON($thana);
    }
    public function institutes($id)
    {
        $institutes = $this->db
            ->table('institutes')
            ->select('id, name')
            ->where('thana_id', $id)
            ->get()->getResultArray();
        return $this->response->setJSON($institutes);
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

        $query = $this->db->table('questions')
            ->select('questions.id, questions.subject_id, questions.board_id, questions.zilla_id, questions.thana_id, questions.institute_id, questions.year, questions.q_image, questions.hot, questions.created_at, subjects.subject AS sbn,boards.name AS boardnm,districts.name AS districtnm, thana.name AS thananm,institutes.name AS instnm')
            ->join('subjects', 'subjects.id = questions.subject_id', 'inner')
            ->join('boards', 'boards.id=questions.board_id', 'inner')
            ->join('districts', 'districts.id=questions.zilla_id', 'inner')
            ->join('thana', 'thana.id=questions.thana_id', 'inner')
            ->join('institutes', 'institutes.id=questions.institute_id', 'inner')
            ->orderBy('questions.id', 'ASC')
            ->get();
        $result = $query->getResultArray();
        return $this->respond($result, 200);
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
