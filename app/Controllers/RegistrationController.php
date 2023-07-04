<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Controllers\BaseController;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Validation\Validation;
use Config\Services\session;

class RegistrationController extends BaseController
{
    protected $helpers = ['form'];

    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session = session();
    }

    public function index()
    {
        // helper('form');
        return  view('registration');
    }

    // log in 
    public function login()
    {
        $data = [
            'session' => $this->session,
        ];
        helper("request");
        if (!$this->request->is('post')) {
            return view('login', $data);
        }

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return view('login', $data);
        }

        $userModel = model('UsersModel');
        $email = $this->request->getPost('email');
        $pass = $this->request->getPost("password");
        $user = $userModel->where('email', $email)->first();
        // dd($user);
        if ($user) {
            if (password_verify($pass, $user['password'])) {
                $newdata = [
                    'uid' => $user['id'],
                    'username'  => $user['name'],
                    'email'     => $user['email'],
                    'mobile'     => $user['mobile'],
                    'role'     => $user['role'],
                    'logged_in' => true,
                ];

                $this->session->set($newdata);
                if ($user['role'] == 2) {
                    return redirect()->to("admin/dashboard");
                } elseif ($user['role'] == 1) {
                    return redirect()->to("/");
                } else {
                    return redirect()->to("/");
                }
            } else {
                $this->session->setFlashdata('type', 'danger');
                $this->session->setFlashdata('message', 'password invalid');
                return redirect()->to("login");
            }
        } else {
            $this->session->setFlashdata('type', 'danger');
            $this->session->setFlashdata('message', 'User Email Or password invalid');
            return redirect()->to("login");
        }
    }


    public function store()
    {
        // Validate the form data
        $validation = \Config\Services::validation();
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[10]',
            'passconf' => 'required|matches[password]',
            'email'    => 'required|valid_email',
        ];
        $validation->setRules([
            'name' => 'required|min_length[5]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'mobile' => 'required|min_length[11]',
            'password' => 'required|min_length[6]',
            'passconf' => 'required|matches[password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        if (!$validation->withRequest($this->request)->run()) {
            $this->session->setFlashdata('errors', $validation->getErrors());
            return redirect()->to('registration');
        }



        // Get the form input data
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $mobile = $this->request->getPost('mobile');
        $password = $this->request->getPost('password') ?? '';

        // Create an instance of the UserModel
        $userModel = new UsersModel();

        // Prepare the data to be inserted into the database
        $data = [
            'name' => $name,
            'email' => $email,
            // 'password' => $password, // You should hash the password for security
            'password' => password_hash($password, PASSWORD_DEFAULT), // You should hash the password for security
            'mobile' => $mobile, // You should
            'role' => 1
        ];

        // Insert the data into the database
        $userModel->insert($data);
        $this->session->setFlashdata('message', 'Registration Successful');
        // Redirect or display a success message
        return redirect()->to('registration');
    }

    // logout settings methode
    public function logout()
    {
        $session_items = ['username', 'email', 'logged_in'];
        $this->session->remove($session_items);
        $this->session->destroy();
        return redirect()->to("/");
    }
}
