<?php
include('../../library/smtp/PHPMailerAutoload.php');
require "../../vendor/autoload.php";
require "../../vendor/dompdf/dompdf/src/Dompdf.php";
require "../../vendor/dompdf/dompdf/src/Options.php";

use Dompdf\Dompdf;
use Dompdf\Options;



try {
    function folder_exist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        return ($path !== false and is_dir($path)) ? $path : false;
    }

    function send_email($to, $html, $subject, $attachment = "")
    {

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Username = "mason@dkclending.com";
        $mail->Password = "dfhtiradumjqehcw";
        $mail->SetFrom("mason@dkclending.com");
        $mail->Subject = $subject;
        $mail->Body = $html;
        $mail->AddAddress($to);
        $mail->SMTPOptions = array('ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => false
        ));
        if ($attachment != "") {
            // $mail->addAttachment($attachment, 'invoice.pdf');
            $enc = file_get_contents($attachment);
            $mail->addStringAttachment(base64_decode(base64_encode($enc)), "invoices.pdf");
        }
        if ($mail->Send()) {
            return true;
        } else {
            return false;
        }
    }

    if (isset($_POST['sid'])) {

        $sid = $_POST['sid'];
        $borrower = $_POST['borrower'];
        $address = $_POST['collateral'];
        $odate = $_POST['odate'];
        $mdate = $_POST['mdate'];
        $lamount = $_POST['lamount'];
        $rate = $_POST['rate'];
        $interest = $_POST['interest'];
        $table_tr = $_POST['table_tr'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $keys_arr = ["{{ borrower }}", "{{ collateral }}", "{{ odate }}", "{{ mdate }}", "{{ loan }}", "{{ rate }}", "{{ interest }}", "{{ restdata }"];

        $value_arr = [$borrower, $address, $odate, $mdate, $lamount, $rate, $interest, $table_tr];

        // /**
        //  * Set the Dompdf options
        //  */
        $options = new Options;
        $options->setChroot(__DIR__);
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);

        // /**
        //  * Set the paper size and orientation
        //  */
        $dompdf->setPaper("letter", "potrait");


        // /**
        //  * Load the HTML and replace placeholders with values from the form
        //  */
        $html = file_get_contents("template/template.html");
        // echo $html;
        $html = str_replace($keys_arr, $value_arr, $html);
      
        $dompdf->setBasePath('template/');
        $dompdf->loadHtml($html);

        // /**
        //  * Create the PDF and set attributes
        //  */


        $dompdf->render();


        $dompdf->addInfo("Title", "Invoice");

        // /**
        //  * Send the PDF to the browser
        //  */

        // $dompdf->stream("invoice.pdf", ["Attachment" => 0]);

        // /**
        //  * Save the PDF file locally
        //  */
        $dompdf->setBasePath($_SERVER['DOCUMENT_ROOT']);
        $base_path =  $dompdf->getBasePath();
        $output = $dompdf->output();
        $file_ = "$base_path/pdf/$sid/" . date("d.m.Y..h.i.s") . ".pdf";

        if (folder_exist("$base_path/pdf/$sid")) {
            file_put_contents($file_, $output);
        } else {
            mkdir("$base_path/pdf/$sid");
            file_put_contents($file_, $output);
        }
        if (send_email($email, "Invoice of this month", $subject, $file_)) {
            echo "success";
        } else {
            echo "error";
        }
    }
} catch (Exception $e) {
    echo $e;
}
