<?php 

if (!function_exists('send_email')) {
   function send_email($to,$subject,$content) {
        $CI =& get_instance();
        $CI->load->library('email');

        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://srv162.niagahoster.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@marpth5.com',
            'smtp_pass' => 'sheilaon7',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );

        $CI->email->initialize($config);
        $CI->email->set_mailtype("html");
        $CI->email->set_newline("\r\n");

        //Email content

        $CI->email->to($to);
        $CI->email->from('admin@marpth5.com','Konfirmasi Pendaftaran');
        $CI->email->subject($subject);
        $CI->email->message($content);




        //Send email
        if($CI->email->send()){
            return true;
        }
        else{
            echo $CI->email->print_debugger();
            return false;
            //echo "email_not_sent";
            //echo $CI->email->print_debugger();  // If any error come, its run
        }


    }
}

?>