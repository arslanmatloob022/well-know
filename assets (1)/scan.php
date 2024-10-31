<?php
session_start();
require_once 'config.php';
require 'vendor/autoload.php'; // Ensure you have Guzzle installed via Composer

use GuzzleHttp\Client;

if (isset($_GET['id'])) {
    $eid = $_GET['id'];



    // Step 2: Decode the URL-encoded ID
    $decodedId = urldecode($eid);
    

  
    // Step 3: Decode the base64-encoded ID
    $base64DecodedId = base64_decode($decodedId);

    
    
    // Step 4: Sanitize the decoded ID to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $base64DecodedId);

  

    // Check if the ID exists in the database
    $check = mysqli_query($conn, "SELECT * FROM form WHERE id='$id'");
    if (mysqli_num_rows($check) == 0) {
        echo "<script>
                window.location.href='list';
              </script>";
        exit;
    } else {
        $data = mysqli_fetch_assoc($check);

// Prepare parameters for the QR code generation
        $params = array(
           "data" => "https://mfs.moh.gov.om.allcreative.info/scan?id=" . $eid,
            "config" => array(
                "body" => "pointed-in",
                "eye" => "frame13",
                "eyeBall" => "ball14",
                "erf1" => array(
                    "color" => "#ef7992",
                    "type" => "frame13"
                ),
                "erf2" => array(
                    "color" => "#ef7992",
                    "type" => "frame13"
                ),
                "erf3" => array(
                    "color" => "#ef7992",
                    "type" => "frame13"
                ),
                "brf1" => array(
                    "color" => "#000000",
                    "type" => "ball14"
                ),
                "brf2" => array(
                    "color" => "#000000",
                    "type" => "ball14"
                ),
                "brf3" => array(
                    "color" => "#000000",
                    "type" => "ball14"
                ),
                "bodyColor" => "#000000",
                "bgColor" => "#FFFFFF",
                "eye1Color" => "#ef7992",
                "eye2Color" => "#ef7992",
                "eye3Color" => "#ef7992",
                "eyeBall1Color" => "#000000",
                "eyeBall2Color" => "#000000",
                "eyeBall3Color" => "#000000",
                "logo" => "https://mfs.moh.gov.om.allcreative.info/logo2.png",
                "logoMode" => "default",
                "gradientColor1" => "#ef7992",
                "gradientColor2" => "#000000",
                "gradientType" => "linear",
                "gradientRotation" => 90,
                "gradientOnEyes" => false
            ),
            "size" => 100,
            "download" => false,
            "file" => "svg"
        );

        // Using Guzzle HTTP client
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request('POST', 'https://qrcode-monkey.p.rapidapi.com/qr/custom', [
                'json' => $params,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'qrcode-monkey.p.rapidapi.com',
                    'x-rapidapi-key' => 'be858ad2c7msha8925bef79d04f1p18a776jsn58cc9efdf7d2',
                ],
            ]);

            // Save the SVG file
            $result = $response->getBody();
            file_put_contents('qr_code.svg', $result);

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            echo 'Error: ' . $e->getMessage();
        }
}
    
} else {
    echo "ID parameter is missing.";
    echo "<script>
            window.location.href='list';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        font-family: promo-regular !important;
    }

    @font-face {
        font-family: Blacker;
        src: url(assets/font/Blacker/Blacker-Text-Medium-trial.ttf);
    }

    .Zetafonts-font{
        font-family: Blacker !important;
    }

    .arabic{
        font-family: arab;
    }

    @font-face {
        font-family: promo-medium;
        src: url(./assets/font/promo-font/PromoTest-Medium-BF63b78802b0fd1.otf);
    }

    @font-face {
        font-family: promo-light;
        src: url(./assets/font/promo-font/PromoTest-Light-BF63b788031b552.otf);
    }

    @font-face {
        font-family: promo-regular;
        src: url(./assets/font/promo-font/PromoTest-Regular-BF63b7880272a33.otf);
    }

    @font-face {
        font-family: promo-bold;
        src: url(./assets/font/promo-font/PromoTest-Bold-BF63b788015fdbf.otf);
    }

    .qr-code {
        position: relative;
        width: 145px;
        height: 145px;
        margin: 26px 0px 5px 0px;
    }

    .qr-code img {
        height: 100%;
        mix-blend-mode: screen;
    }

    .font-light {
        font-family: promo-light !important;
    }

    @media print {
        #generatePDF {
            display: none;
        }
    }

    .borders {
        border-bottom: 3px solid #1AD1D1;
        margin: 0px 10px 10px 10px;
        padding-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .scan-me {
        font-size: 14px;
        margin: 0px;
    }

    .registration,
    .info,
    .status {
        border: 2px solid #5c5c5b;
        border-radius: 10px;
        padding: 5px 10px;
    }

    th,
    td {
        padding: 3.8px 5px;
        text-align: left;
    }

    th:first-child,
    th:nth-child(3) {
        width: 28%;
        font-weight: 600;
    }

    th:nth-child(3) {
        text-align: end;
    }

    td {
        width: 50%;
        text-align: center;
        font-size: 12px;
    }

    th {
        font-size: 13px;
    }

    .scan {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .scan {
        border: 2px solid #cc181c;
        border-radius: 10px;
        padding: 5px;
        margin-right: 10px;
    }

    .box {
        background-color: aqua;
        height: 200px;
        width: 200px;
    }

    .name {
        font-size: 14px;
        text-align: center;
        margin: 0px 0px 35px 0px;
    }

    .fit {
        font-size: 16px;
        width: 90%;
        margin: 10px 0px 10px 0px;
        padding: 15px !important;
        border: 2px dashed #000000;
        color: #37b24d;
        text-align: center;
        border-radius: 10px;
        font-weight: bold;
    }

    .qr-con {
        margin-bottom: 20px;
    }

    .aprove-img {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .aprove-img img {
        width: 200px;
        margin: 20px;
        height: 200px;
    }

    .cus-size {
        font-size: 25px;
        text-align: center;
        color: #000000;
    }

    .cus-size1 {
        font-size: 20px;
        text-align: center;
        color: #000000;
        width:150%;
    }

    .custom-sz {
        font-size: 14px;
        text-align: center;
        color: #000000;
        font-family: promo-regular;
    }

    .medical-status {
        display: flex;
        justify-content: space-around;
        width: 100%;
    }

    .medical-status div {
        font-size: 13px;
        padding:0;
        color: #000000;
        margin: 0;
    }

    @media (max-width: 730px) {
        th:first-child,
        th:nth-child(3) {
            width: 30%;
            font-weight: 600;
        }

        td {
            width: 50%;
        }

        .qr-con {
            margin-bottom: 12px;
        }

        .fit {
            font-size: 15px;
            width: 90%;
            margin: 10px 0px 10px 0px;
            padding: 20px !important;
        }

        .name {
            font-size: 14px;
        }

        .medical-status span {
            font-size: 13px;
        }

        .aprove-img img {
            width: 190px;
            margin: 30px;
            height: 190px;
        }

        .scan-me {
            font-size: 14px;
        }

        .cus-size {
            font-size: 25px;
            text-align: center;
        }

        .cus-size1 {
            font-size: 18px;
        }

        td {
            font-size: 12px;
        }

        th {
            font-size: 13px;
        }

        .custom-sz {
            font-size: 16px;
            text-align: center;
        }
    }

    @media (max-width: 590px) {
        th,
        td {
            font-size: 9px;
        }

        .cus-size {
            font-size: 14px;
            text-align: center;
        }

        .custom-sz {
            font-size: 11px;
            text-align: center;
        }

        .aprove-img img {
            width: 70px;
            height: 70px;
        }
    }

    @media (max-width: 320px) {
        th,
        td {
            font-size: 9px;
        }

        .cus-size {
            font-size: 12px;
            text-align: center;
        }

        .custom-sz {
            font-size: 11px;
            text-align: center;
        }

        .aprove-img img {
            width: 50%;
        }
    }

    .fotn-12 {
        font-size: 21px;
    }

    h1 {
        margin-bottom: 0.29rem !important;
    }

    .text-gray {
        color: #000000 !important;
    }

    .logo {
        margin-top: -25px;
    }

    #download_section {
        max-width: 768px;
        width: 100%;
        margin-top:36px;
    }

    .center {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .font-20 {
        font-size: 20px;
    }

    .ps-1 {
        padding-left: .1rem !important;
    }

    @media only screen and (max-width: 730px) {
        #download_section {
            max-width: 100%;
            width: 100%;
        }
    }
    
    @media only screen and (max-width: 500px) {
    .width-100{
        width: 98% !important;
    }
    .fotn-12 {
    font-size: 15px;
}
.cus-size {
        font-size: 20px;
        width: 250%;
}
.cus-size1 {
    width:250%;
}
    .borders {
        width: 95%;
    }
    .mar-left-27{
        margin-left: 27px;
    }
    .width-95{
        width: 92.5% !important;
    }
    .width-29{
        width: 29% !important;
    }
    .width-46{
        width: 46% !important;
    }
    .display-direction{
        flex-direction: column;
    }
    .mar-20{
        margin: 20px;
    }
    .display-none-500{
       display:none; 
    }
    .display-block-500{
        display:block !important;
    }
        .aprove-img img {
        width: 210px;
        height: 210px;
    }
    .mar-top-60{
        margin-top:120px;
        margin-bottom:15px;
    }
        .fit {
       
        padding: 13px !important;
    }
    .medical-status {
    display: flex;
    justify-content: space-between;
    width: 90%;
}
.logo img{
    height:80px !important;
}
.qr-con{
    display:none;
}
.midea-marign{
   margin:20px 0px 0px 0px!important; 
}
.med-mar-top{
    padding-top:7px;
}
}
 .display-block-500{
        display:none;
    }
    .div-font-padding{
        font-size:12px;
            font-weight: 600;
        padding: 3.5px 5px;
    }
    .fnt-bold{
        font-weight:600;
    }
</style>

<div class="center">
    <div class=" py-md-5 " id="download_section">
        <div class="row borders">
            <div class="col-3 width-29 p-0 d-flex align-items-start flex-column">
                <h5 class="custom-sz med-mar-top"><strong>Sultanate Of Oman</strong></h5>
                <h5 class="custom-sz"><strong>Ministry Of Health</strong></h5>
            </div>
            <div class="col-6 width-46">
                <div class="logo d-flex align-items-center justify-content-center flex-column">
                    <img src="assets/images/logo.png" height="90" alt="Logo">
                    <h1 class="cus-size arabic">شهادة الفحص الطبي للوافدين</h1>
                    <h1 class="cus-size1 Zetafonts-font">Expatriates Medical Exam Certificate</h1>
                </div>
            </div>
            <div class="col-3 p-0 d-flex align-items-end flex-column">
                <h5 class="m-0"><span class="text-gray fotn-12 m-0 arabic">سلطنة عُمــان</span></h5>
                <h5 class="m-0"><span class="text-gray fotn-12 m-0 arabic">وزارة الصحــة</span></h5>
            </div>
        </div>

        <div class="row mt-1 display-direction display-none-500">
            <div class="col-8 pe-1 width-100">
                <div class="registration m-2 ms-3">
                    <table>
                        <tbody>
                            <tr>
                                <th>Application Type:</th>
                                <td data-label="Registration No" class="font-light"><?php echo ucwords($data['reg_type']) ?></td>
                                <th class="arabic"> :نوع الطلب</th>
                            </tr>
                            <tr>
                                <th>Application Number:</th>
                                <td data-label="Registration Type" class="font-light"><?php echo ucwords($data['reg_no']) ?></td>
                                <th> :رقم الطلب</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="info m-2 mt-3 ms-3">
                    <table>
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Name:</th>
                                <td class="font-light"><?php echo strtoupper($data['name']) ?></td>
                                <th>:الاسم</th>
                            </tr>
                            <tr>
                                <th>Date of Birth:</th>
                                <td class="font-light"><?php echo (new DateTime($data['dob']))->format('d-m-Y'); ?></td>
                                <th> :تاريخ الميلاد</th>
                            </tr>
                            <tr>
                                <th>Nationality:</th>
                                <td class="font-light"><?php echo strtoupper($data['nationality']) ?></td>
                                <th> :الجنسية</th>
                            </tr>
                            <tr>
                                <th> Gender:</th>
                                <td class="font-light"><?php echo strtoupper($data['sex']) ?></td>
                                <th> :الجنس</th>
                            </tr>
                            <tr>
                                <th>Passport No.:</th>
                                <td class="font-light"><?php echo strtoupper($data['passport']) ?></td>
                                <th> :رقم جواز السفر</th>
                            </tr>
                            <tr>
                                <th>Civil No.:</th>
                                <td class="font-light"><?php echo strtoupper($data['civilid']) ?></td>
                                <th> :الرقم المدني</th>
                            </tr>
                            <tr>
                                <th>Sponsor:</th>
                                <td class="font-light"> <?php echo strtoupper($data['sponsor']) ?></td>
                                <th> :اسم الكفيل</th>
                            </tr>
                            <tr>
                                <th>Category:</th>
                                <td class="font-light"><?php echo strtoupper($data['category']) ?></td>
                                <th> :الفئـة</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="status m-2 mt-3 ms-3">
                    <table>
                        <thead>
                        <tbody>
                            <tr>
                                <th>Validity of the Medical:</th>
                                <td class="font-light"><?php echo (new DateTime($data['validity']))->format('d-m-Y'); ?></td>
                                <th> :صلاحية الفحص الطبي</th>
                            </tr>
                            <tr>
                                <th>To:</th>
                                <td class="font-light"><?php echo (new DateTime($data['toDate']))->format('d-m-Y'); ?></td>
                                <th> :إلى</th>
                            </tr>
                            <tr>
                                <th>Medical Center:</th>
                                <td><?php echo $data['medicalcentre'] ?></td>
                                <th> :المركز الطبي</th>
                            </tr>
                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="col-4 ps-1 mar-left-27 width-95">
                <div class="scan mt-2 text-center">
                    <div class="qr-con">
                        <div class="qr-code">
                            <?= $result ?>
                        </div>
                        <p class="text-center scan-me text-gray">Scan Me / امسح الرمز</p>
                    </div>
                    <p class="p-0 m-0 font-20 text-gray "><?php echo $data['arbicname'] ?></p>
                    <div class="name mt-1">
                        <span class="text-gray"><?php echo strtoupper($data['name']) ?></span>
                    </div>
                    <div class="medical-status">
                        <div class="">Medical Status</div>
                        <div class="">الحالة الطبية</div>
                    </div>
                    <div class="fit">
                        <span> FIT / لائق صحياً </span>
                    </div>
                    <div class="aprove-img">
                        <img src="assets/images/aprove.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
        
        
        
         <div class="row mt-1 display-direction display-block-500">
            <div class="col-8 pe-1 width-100">
                <div class="registration m-2 ms-3">
                   <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Application Type:</div>
                           <div class="div-font-padding fnt-bold">:نوع الطلب</div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div data-label="Registration No" class="font-light div-font-padding"> <?php echo ucwords($data['reg_type']) ?> </div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Application Number:</div>
                           <div class="div-font-padding fnt-bold"> :رقم الطلب </div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div data-label="Registration Type" class="font-light div-font-padding"> <?php echo ucwords($data['reg_no']) ?> </div>
                       </div>
                   </div>
                </div>
                <div class="info m-2 mt-3 ms-3">
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Name:</div>
                           <div class="div-font-padding fnt-bold">:الاسم</div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div class="font-light div-font-padding"> <?php echo strtoupper($data['name']) ?> </div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Date of Birth:</div>
                           <div class="div-font-padding fnt-bold"> :تاريخ الميلاد </div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div  class="font-light div-font-padding"> <?php echo (new DateTime($data['dob']))->format('d-m-Y'); ?> </div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Nationality:</div>
                           <div class="div-font-padding fnt-bold">:الجنسية</div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div class="font-light div-font-padding"> <?php echo strtoupper($data['nationality']) ?> </div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Gender:</div>
                           <div class="div-font-padding fnt-bold"> :الجنس </div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div  class="font-light div-font-padding"> <?php echo strtoupper($data['sex']) ?> </div>
                       </div>
                   </div>
                   <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Passport No.:</div>
                           <div class="div-font-padding fnt-bold">:رقم جواز السفر</div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div class="font-light div-font-padding"> <?php echo strtoupper($data['passport']) ?> </div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Civil No.:</div>
                           <div class="div-font-padding fnt-bold"> :الرقم المدني </div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div  class="font-light div-font-padding"><?php echo strtoupper($data['civilid']) ?> </div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Sponsor:</div>
                           <div class="div-font-padding fnt-bold">:اسم الكفيل</div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div class="font-light div-font-padding">  <?php echo strtoupper($data['sponsor']) ?> </div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Category:</div>
                           <div class="div-font-padding fnt-bold"> :الفئـة </div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div  class="font-light div-font-padding"> <?php echo strtoupper($data['category']) ?> </div>
                       </div>
                   </div>
                </div>
                <div class="status m-2 mt-3 ms-3">
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Validity of the Medical:</div>
                           <div class="div-font-padding fnt-bold">:صلاحية الفحص الطبي</div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div class="font-light div-font-padding"> <?php echo (new DateTime($data['validity']))->format('d-m-Y'); ?> </div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">To:</div>
                           <div class="div-font-padding fnt-bold"> :إلى </div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div  class="font-light div-font-padding"> <?php echo (new DateTime($data['toDate']))->format('d-m-Y'); ?></div>
                       </div>
                   </div>
                    <div >
                       <div class="d-flex justify-content-between">
                           <div class="div-font-padding fnt-bold">Medical Center:</div>
                           <div class="div-font-padding fnt-bold">:المركز الطبي</div>
                       </div>
                       <div class="text-center d-flex justify-content-center">
                           <div class="font-light div-font-padding fnt-bold text-black"><?php echo $data['medicalcentre'] ?></div>
                       </div>
                   </div>
                </div>
            </div>
            <div class="col-4 ps-1 mar-left-27 width-95">
                  <div class="stamp mx-2 mar-top-60 display-block-500">
                    <strong class="text-gray">Signature / Stamp</strong>
                </div>
                <div class="scan mt-2 text-center">
                    <div class="qr-con">
                        <div class="qr-code">
                            <?= $result ?>
                        </div>
                        <p class="text-center scan-me text-gray">Scan Me / امسح الرمز</p>
                    </div>
                    <p class="p-0 m-0 font-20 text-gray midea-marign"><?php echo $data['arbicname'] ?></p>
                    <div class="name mt-1">
                        <span class="text-gray"><?php echo strtoupper($data['name']) ?></span>
                    </div>
                    <div class="medical-status">
                        <div class="">Medical Status</div>
                        <div class="">الحالة الطبية</div>
                    </div>
                    <div class="fit">
                        <span> FIT / لائق صحياً </span>
                    </div>
                    <div class="aprove-img">
                        <img src="assets/images/aprove.png" alt="">
                    </div>
                </div>
               
            </div>
        </div>
        
        
        
        
        
        
        
        
        
        
        
        <div class="stamp mx-2 mar-20 display-none-500">
            <strong class="text-gray mar-20">Signature / Stamp</strong>
        </div>
    </div>
</div>
<?php if (!isset($_GET["view"])): ?>
    <div class="container d-flex justify-content-center mb-3">
        <a class="btn btn-danger" id="generatePDF" data-name="<?php echo strtoupper($data['name']) ?>">
            <span class="inter-700 medium-font">Download</span>
        </a>
    </div>
<?php endif; ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jspdf.min.js"></script>
<script src="assets/js/html2canvas.min.js"></script>
<script src="assets/js/custom.js"></script>

<script>
    window.onload = function () {
        var shouldHide = true;

        if (shouldHide) {
            document.getElementById("generatePDF").style.display = "none";
            document.getElementById("generatePDF").remove();
        }
    };
</script>
</body>
</html>
