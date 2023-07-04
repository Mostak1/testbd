<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class CheckoutController extends BaseController
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
        return view('checkout');
    }
    public function submitorder()
    {
        $request = request();
        //return $this->respond($_POST,200);
        $data = [
            'b_address' => $request->getPost('bAddress'),
            's_address' => $request->getPost('sAddress'),
            'customer_id' => $request->getPost('u_id'),
            'payment' => $request->getPost('payment'),
            'tranxid' => $request->getPost('trxid'),
            'comment' => $request->getPost('comment'),
            'total' => $request->getPost('price'),
        ];
        // `customer_id`, `total`, `discount`, `quantity`, `comment`, `payment`, `tranxid`, `status`, `b_address`, `s_address`,
        // if ($request->getPost('id') != "") {
        //     $data['id'] = $request->getPost('id');
        // }

        $builder = $this->db->table('orders');
        $builder->upsert($data);
        // $this->db
        // ->table('subjects')
        // ->insert($data);
        return $this->respond([
            'success' => true,
            'message' => "Data Inserted Successfully"
        ], 200);
    }
}
