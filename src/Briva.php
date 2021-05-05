<?php
// created by Aditya Nanda Utama, S.Kom at 20210316 11:44.
// 
// have any project? you can contact me at https://aditnanda.com
// instagram : @adit.nanda
// PLEASE DO NOT DELETE THIS COPYRIGHT IF YOU ARE A HUMAN.

namespace idmahbub\briva;

class Briva{

    public $cons_key, $cons_sec; 
    public $institution_code, $briva_no; 
    public $base_url = ''; 
    public function __construct()
    {
        $this->cons_key = env('BRIVA_CONSUMER_KEY','NAND');    
        $this->cons_sec = env('BRIVA_CONSUMER_SECRET','NAND');    
        $this->institution_code = env('BRIVA_INSTITUTION_CODE','NAND');    
        $this->briva_no = env('BRIVA_NO','NAND');    
        $BRIVA_PRODUCTION = env('BRIVA_PRODUCTION','NAND'); 
        if (!$BRIVA_PRODUCTION) {
            $this->base_url = 'https://sandbox.partner.api.bri.co.id/';
        }   else{
            $this->base_url = 'https://partner.api.bri.co.id/';

        }
    }

    public function BRIVAgenerateToken($client_id, $secret_id) {
        $url =$this->base_url."oauth/client_credential/accesstoken?grant_type=client_credentials";
        $data = "client_id=".$client_id."&client_secret=".$secret_id;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        $json = json_decode($result, true);
        $accesstoken = $json['access_token'];
    
        return $accesstoken;
    }
    
    /* Generate signature */
    public function BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret) {
        $payloads = "path=$path&verb=$verb&token=Bearer $token&timestamp=$timestamp&body=$payload";
        $signPayload = hash_hmac('sha256', $payloads, $secret, true);
        return base64_encode($signPayload);
    }

    public function BrivaRead($data) {
        $client_id = $this->cons_key;
        $secret_id = $this->cons_sec;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $secret = $secret_id;
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
    
        $institutionCode = $this->institution_code;
        $brivaNo = $this->briva_no;
        $custCode = $data['custCode'];
    
        $payload = null;
        $path = "/v1/briva/".$institutionCode."/".$brivaNo."/".$custCode;
        $verb = "GET";
        $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );
    
        $urlPost =$this->base_url."v1/briva/".$institutionCode."/".$brivaNo."/".$custCode;
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "GET"); 
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
        
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);

        return json_decode($resultPost, true);
    }

    public function BrivaReadStatus($data) {
        $client_id = $this->cons_key;
        $secret_id = $this->cons_sec;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $secret = $secret_id;
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
    
        $institutionCode = $this->institution_code;
        $brivaNo = $this->briva_no;
        $custCode = $data['custCode'];
    
        $payload = null;
        $path = "/v1/briva/status/".$institutionCode."/".$brivaNo."/".$custCode;
        $verb = "GET";
        $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );
    
        $urlPost =$this->base_url."v1/briva/status/".$institutionCode."/".$brivaNo."/".$custCode;
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "GET"); 
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
        
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);

        return json_decode($resultPost, true);
    }

    public function BrivaUpdateStatus($data) {
        $client_id = $this->cons_key;
        $secret_id = $this->cons_sec;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $secret = $secret_id;
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
    
        $institutionCode = $this->institution_code;
        $brivaNo = $this->briva_no;
        $custCode = $data['custCode'];
        $statusBayar = $data['statusBayar'];
    
        $datas = array(
            'institutionCode' => $institutionCode ,
            'brivaNo' => $brivaNo,
            'custCode' => $custCode,
            'statusBayar'=> $statusBayar
        );
    
        $payload = json_encode($datas, true);
        $path = "/v1/briva/status";
        $verb = "PUT";
        $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    
        $request_headers = array(
            "Content-Type:"."application/json",
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );
    
        $urlPost =$this->base_url."v1/briva/status";
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "PUT"); 
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
    
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);

        return json_decode($resultPost, true);
    
    }
    
    public function BrivaCreate($data) {
        $client_id = $this->cons_key;
        $secret_id = $this->cons_sec;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $secret = $secret_id;
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
    
        $institutionCode = $this->institution_code;
        $brivaNo = $this->briva_no;
        $custCode = $data['custCode'];
        $nama = $data['nama'];
        $amount=$data['ammount'];
        $keterangan=$data['keterangan'];
        $expiredDate=$data['expiredDate'];
    
        $datas = array(
            'institutionCode' => $institutionCode ,
            'brivaNo' => $brivaNo,
            'custCode' => $custCode,
            'nama' => $nama,
            'amount' => $amount,
            'keterangan' => $keterangan,
            'expiredDate' => $expiredDate
        );
    
        $payload = json_encode($datas, true);
        $path = "/v1/briva";
        $verb = "POST";
        $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    
        $request_headers = array(
            "Content-Type:"."application/json",
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );
    
        $urlPost =$this->base_url."v1/briva";
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
    
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);
    
        return json_decode($resultPost, true);
    }

    public function BrivaUpdate($data) {
        $client_id = $this->cons_key;
        $secret_id = $this->cons_sec;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $secret = $secret_id;
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
    
        $institutionCode = $this->institution_code;
        $brivaNo = $this->briva_no;
        $custCode = $data['custCode'];
        $nama = $data['nama'];
        $amount=$data['ammount'];
        $keterangan=$data['keterangan'];
        $expiredDate=$data['expiredDate'];
    
        $datas = array(
            'institutionCode' => $institutionCode ,
            'brivaNo' => $brivaNo,
            'custCode' => $custCode,
            'nama' => $nama,
            'amount' => $amount,
            'keterangan' => $keterangan,
            'expiredDate' => $expiredDate
        );
    
        $payload = json_encode($datas, true);
        $path = "/v1/briva";
        $verb = "PUT";
        $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    
        $request_headers = array(
            "Content-Type:"."application/json",
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );
    
        $urlPost =$this->base_url."v1/briva";
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "PUT"); 
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
    
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);

        return json_decode($resultPost, true);
    }

    public function BrivaDelete($data) {
        $client_id = $this->cons_key;
        $secret_id = $this->cons_sec;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $secret = $secret_id;
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
    
        $institutionCode = $this->institution_code;
        $brivaNo = $this->briva_no;
        $custCode = $data['custCode'];
    
        $datas = array(
            'institutionCode' => $institutionCode ,
            'brivaNo' => $brivaNo,
            'custCode' => $custCode
        );
    
        $payload = "institutionCode=".$institutionCode."&brivaNo=".$brivaNo."&custCode=".$custCode;
        $path = "/v1/briva";
        $verb = "DELETE";
        $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );
    
        $urlPost =$this->base_url."v1/briva";
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
        
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);

        return json_decode($resultPost, true);
    }

    public function BrivaGetReport($data) {
        $client_id = $this->cons_key;
        $secret_id = $this->cons_sec;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $secret = $secret_id;
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
    
        $institutionCode = $this->institution_code;
        $brivaNo = $this->briva_no;
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
    
        $payload = null;
        $path = "/v1/briva/report/".$institutionCode."/".$brivaNo."/".$startDate."/".$endDate;
        $verb = "GET";
        $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );
    
        $urlPost =$this->base_url."v1/briva/report/".$institutionCode."/".$brivaNo."/".$startDate."/".$endDate;
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "GET"); 
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
    
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);

        return json_decode($resultPost, true);
    }
    
    public function BrivaGetReportTime($data) {
        $client_id = $this->cons_key;
        $secret_id = $this->cons_sec;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $secret = $secret_id;
        $token = $this->BRIVAgenerateToken($client_id, $secret_id);
    
        $institutionCode = $this->institution_code;
        $brivaNo = $this->briva_no;
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $startTime = $data['start_time'];
        $endTime = $data['end_time'];
    
        $payload = null;
        $path = "/v1/briva/report_time/".$institutionCode."/".$brivaNo."/".$startDate."/".$startTime."/".$endDate."/".$endTime;
        $verb = "GET";
        $base64sign = $this->BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);
    
        $request_headers = array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $base64sign,
        );
    
        $urlPost =$this->base_url."v1/briva/report_time/".$institutionCode."/".$brivaNo."/".$startDate."/".$startTime."/".$endDate."/".$endTime;
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL, $urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "GET"); 
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
    
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);

    
        return json_decode($resultPost, true);
    }
}
?>