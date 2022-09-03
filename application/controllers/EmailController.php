<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmailController extends CI_Controller
{   

     public function index(){
        echo "asdasdasd";
     }

   

    public function send_mail($to,$subject,$content){
        //Load email library
        $this->load->library('email');

        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://srv162.niagahoster.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@marpth5.com',
            'smtp_pass' => 'sheilaon7',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        //Email content

        $this->email->to($to);
        $this->email->from('admin@marpth5.com','Konfirmasi Pendaftaran');
        $this->email->subject($subject);
        $this->email->message($content);

        //Send email
        if($this->email->send()){
            return true;
        }
        else{
            return false;
            // echo "email_not_sent";
            // echo $this->email->print_debugger();  // If any error come, its run
        }
    }


    public function sendmail(){
        //Load email library
        $this->load->library('email');

        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://srv162.niagahoster.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@marpth5.com',
            'smtp_pass' => 'sheilaon7',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        //Email content

        $this->email->to('andeztea@gmail.com');
        $this->email->from('admin@marpth5.com','Konfirmasi Pendaftaran');
        $this->email->subject('Konfirmasi  ');
        $this->email->message('Silahkan klik Link Pendaftaran anda sebagai berikut http://localhost/projecttesis/aktivasi/676767676');

        //Send email
        if($this->email->send()){
           echo true;
        }
        else{
            return false;
            // echo "email_not_sent";
            echo $this->email->print_debugger();  // If any error come, its run
        }
    }

  



}