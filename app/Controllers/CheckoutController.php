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
            'customer_name' => $request->getPost('u_name'),
            'payment' => $request->getPost('payment'),
            'tranxid' => $request->getPost('trxid'),
            'comment' => $request->getPost('comment'),
            'total' => $request->getPost('price'),
            'status' => 'Pending',
        ];
        // `customer_id`, `total`, `discount`, `quantity`, `comment`, `payment`, `tranxid`, `status`, `b_address`, `s_address`,
        // if ($request->getPost('id') != "") {
        //     $data['id'] = $request->getPost('id');
        // }

        $builder = $this->db->table('orders');
        $builder->insert($data);
        // $this->db
        // ->table('subjects')
        // ->insert($data);
        // Get the dynamic keys and values from the request
        $dynamicKeys = [];
        foreach ($request->getPost() as $key => $value) {
            if (strpos($key, 'sub_') !== false) {
                $index = substr($key, strlen('sub_'));
                $dynamicKeys[$index]['sub'] = $value;
            } elseif (strpos($key, 'id_') !== false) {
                $index = substr($key, strlen('id_'));
                $dynamicKeys[$index]['id'] = $value;
            } elseif (strpos($key, 'qu_') !== false) {
                $index = substr($key, strlen('qu_'));
                $dynamicKeys[$index]['qu'] = $value;
            }
        }

        // Insert the dynamic keys and values into the database
        if (!empty($dynamicKeys)) {
            $orderItems = [];
            $insertID = $this->db->insertID();
            foreach ($dynamicKeys as $key => $values) {
                $orderItems[] = [
                    'order_id' => $insertID, // Assuming there is an auto-incrementing primary key column 'id' in the 'orders' table
                    'subject' => $values['sub'],
                    'subject_id' => $values['id'],
                    'quantity' => $values['qu']
                ];
            }
            $builderItems = $this->db->table('order_items');
            $builderItems->insertBatch($orderItems);
        }
        return $this->respond([
            'success' => true,
            'message' => "Order Submited Successfully"
        ], 200);
    }
}
