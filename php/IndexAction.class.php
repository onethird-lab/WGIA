<?php

class IndexAction extends Action{
	//index
	public function index(){
		header('Content-Type:text/html; charset=utf-8');
		//echo THINK_VERSION;
		//phpinfo();
		$this->display('index');
	}



	public function sendMail($to, $name, $title, $content) {
		header('Content-Type:text/html; charset=utf-8');
		$Email=M('email');
		$the_email=$Email->where('email_now=1')->find();
		//dump($the_email);
		Vendor('PHPMailer.PHPMailerAutoload');
		$mail = new PHPMailer(); 

		$mail->IsSMTP(); 
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		$mail->Host=$the_email['smtp_host']; 
		$mail->SMTPAuth = true; 
		$mail->Username = $the_email['email']; 
		$mail->Password = $the_email['email_pwd'] ; 
		$mail->From = $the_email['email']; 
		$mail->FromName = "Onethird-lab";
		if(is_array($to)){
			for($i=0;$i<count($to);$i++){
				if($to[$i]) $mail->AddAddress($to[$i], $name[$i]);
			}

		}else{
			$mail->AddAddress($to, $name);
		}

		$mail->WordWrap = 50; 
		$mail->IsHTML(true);
		$mail->CharSet="UTF-8"; 
		$mail->Subject = $title;
		$mail->Body = $content;
		$mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端";
		return $mail->Send() ? true : $mail->ErrorInfo;

	}
	public function email(){
		header('Content-Type:text/html; charset=utf-8');
		$this->display('email');
	}


	public function email_ok(){
		header('Content-Type:text/html; charset=utf-8');

		$email=$_POST['email'];
		$code=mt_rand(100000, 999999);


		$User=M('user');
		$the_user = $User->where("email= '%s'", $email)->find();

		if($the_user){
			$revise['code']=$code;
			$revise['register_time']=date("Y-m-d H:i:s");
			$User->where("email= '%s'", $email)->save($revise);
		}else{
			$data['email']=$email;
			$data['code']=$code;
			$data['register_time']=date("Y-m-d H:i:s");
			$User->create($data);
			$User->add();
		}

		$this->assign('email', $email);
		$this->display('register');

		$this->sendMail($email, '', 'Onethird-lab', "Hey!<br><br>You're just steps away from registering for Genome Interaction Analysis Cloud Platform. To complete your registration, we need to verify your email address.<br><br>Verification code: ".$code."<br><br>Have a great day!<br>--One-third Lab");
	}


	public function register_ok(){
		header('Content-Type:text/html; charset=utf-8');

		$User=M('user');
		$data['email']=$_POST['email'];
		$data['code']=$_POST['code'];
		

		$code_ok =0;
		$password_ok = 0;
		
		$code_ok = 1;

		$password=$_POST['password'];
		$password_confirm=$_POST['password_confirm'];
		if($password_confirm!=$password){
			echo '<script language="JavaScript">alert("The two passwords you typed do not match.");location.href=history.back(-1);</script>';
		}else{
			$password_ok = 1;
		}

		if($code_ok == 1 && $password_ok == 1){
			$revise['password']=$password;
			$revise['email']=$_POST['email'];
			$revise['username']=$_POST['username'];
			$userid=$User->add($revise);

			session_start();
			session('user_id',$userid);
			session('email',$_POST['email']);

			if($_POST['index_page']){
			echo '<script language="JavaScript">alert("Registration success！");location.href="login";</script>';
			}

			if($_POST['AnalysisId']){
			$AnalysisId=$_POST['AnalysisId'];
			echo '<script language="JavaScript">alert("Registration success！");location.href="job_center?AnalysisId='.$AnalysisId.'";</script>';
			}
		}
	}


	public function login(){
		header('Content-Type:text/html; charset=utf-8');

		$this->display('login');
	}


	public function login_ok(){
		header('Content-Type:text/html; charset=utf-8');
		$User=M('user');
		$data['email']=$_POST['email'];
		$data['password']=$_POST['password'];

		$email_ok =0;
		$password_ok = 0;

		$the_user = $User->where("email= '%s'", $data['email'])->find();


		if(!$the_user){
			echo '<script language="JavaScript">alert("Account does not exist！");location.href=history.back(-1);</script>';
		}else $email_ok=1;


		if($data['password']!=$the_user['password']){
			echo '<script language="JavaScript">alert("Password error!");location.href=history.back(-1);</script>';
		}else $password_ok=1;

		if($email_ok==1 && $password_ok==1){
			session_start();
			session('user_id',$the_user['user_id']);
			session('email',$the_user['email']);
			//$this->redirect('index');
			
			if($_POST['index_page']){
			$this->redirect('index');
			}

			if($_POST['AnalysisId']){
			$AnalysisId=$_POST['AnalysisId'];
			echo '<script language="JavaScript">alert("Success！");location.href="job_center?AnalysisId='.$AnalysisId.'";</script>';
		}
		}
	}


	public function logout(){
		header('Content-Type:text/html; charset=utf-8');
		cookie(NULL);
		session(NULL);
		$returnstatus=array('status' => 'success', 'message' => 'You have logged out. It is recommended that you log in to show your analysis job.');
		echo json_encode($returnstatus);
		//$this->display('index');
	}



	public function center(){
		header('Content-Type:text/html; charset=utf-8');
		$Analysis = M('analysisinfo');
		
		$types=array('SNP','CNV','DNAm','mRNA','lncRNA','microRNA','Protein');
		foreach($types as $type){
			$map['_logic'] = 'or';
			$map['Omics1']  = array('eq', $type);
			$map['Omics2'] = array('eq', $type);
			$result[$type]=$Analysis->where($map)->select();
			
		}
		$this->assign('result',$result);

		$this->display('center');
	}

	public function job_linear(){
		header('Content-Type:text/html; charset=utf-8');
		$this->display('job_linear');
	}

	public function job_center(){
		header('Content-Type:text/html; charset=utf-8');
		$AnalysisId=$_GET['AnalysisId'];
		
		$display_value=array();
		if($_SESSION['user_id']){
			$display_value['suggestion']='none';
			$display_value['welcome']='block';
		}else{
			$display_value['suggestion']='block';
			$display_value['welcome']='none';
		}
		$this->assign('display_value',$display_value);
		
		$Analysis = M('analysisinfo');
		$this_analysis = $Analysis->where(array("AnalysisId" => $AnalysisId))->find();

		$Omics1 = $this_analysis['Omics1'];
		$Omics2 = $this_analysis['Omics2'];
		$withPheno = $this_analysis['withPheno'];
		$withCovariant = $this_analysis['withCovariant'];
		$FullName = $this_analysis['FullName'];
		$methodType = $this_analysis['methodType'];
		$Introduction = $this_analysis['Introduction'];
		$MainText = $this_analysis['MainText'];
		$schemaFileName = $this_analysis['schemaFileName'];
		$AnalysisType = $this_analysis['AnalysisType'];


		$this->assign('AnalysisId', $AnalysisId);
		$this->assign('AnalysisType', $AnalysisType);
		$this->assign('Omics1', $Omics1);
		$this->assign('Omics2', $Omics2);
		$this->assign('FullName', $FullName);
		$this->assign('Introduction', $Introduction);
		$this->assign('MainText', $MainText);
		$this->assign('schemaFileName', $schemaFileName);
		$this->assign('withPheno', $withPheno);
		$this->assign('withCovariant', $withCovariant);
		$this->assign('methodType', $methodType);
		$this->assign('Threshold',$this_analysis['cutoff']);

		$this->display('job_center');
	}

	public function job(){
		header('Content-Type:text/html; charset=utf-8');
		$this->display('job');
	}
	public function get_real_ip(){
		header('Content-Type:text/html; charset=utf-8');
		$ip = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		return $ip;
	}

	function generateRandomString() {
		$length = 20;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function test1(){
		header('Content-Type:text/html; charset=utf-8');

		$root='./Public/test/';
		$info= $this->upload($root);
		//$data['matrix']=$info[0]['savename'];
		$file = new SplFileInfo($root.$_FILES['matrix1']['name']);
		$extension  = $file->getExtension();
		dump("The extension is: $extension.");
		rename($root.$_FILES['matrix1']['name'],$root.'matrix_phenotype'.'.'.$extension);
		dump($_FILES['key']);
	}

	public function test2(){

		$cmd = 'D:/job.bat';
		exec($cmd);
	}

	public function job_submit(){
		header('Content-Type:text/html; charset=utf-8');
		$Job = M('job');
		$data['email']=$_POST['email'];
		$data['AnalysisId']=$_POST['AnalysisId'];
		$data['AnalysisType']=$_POST['AnalysisType'];
		$data['method_type']=$_POST['method_type'];
		$data['covariant_correction']=$_POST['covariant_correction'];
		$data['include_pheno']=$_POST['include_pheno'];
		
		if($_POST['threshold']){
			$data['threshold']=$_POST['threshold'];
		}else{
			$data['threshold']=1e-5;
		}

		$data['ip'] = $this->get_real_ip();
		$data['submit_date']=date("Y-m-d H:i:s");
		$data['key']=$this->generateRandomString();
		//matrix
		$root='./Public/job/'.$data['key'].'/';
		
		$info= $this->upload($root);
		
		
		$data['matrix']=$info[0]['savename'];
		$unzip_info=$this->unzipAndRename($root);
		

		$Job->create($data);
		try {
			$job_id = $Job->add();
			$out = 'add secsessed '.$job_id."\n";
		} catch (Exception $e) {
			$out = 'Caught exception: '.getMessage()."\n";
		}


		$the_last_job = $Job->where('job_id = %d', $job_id-1)->find();
		$out = $out."_".($job_id-1);

		$AnalysisCode = M('analysiscode');
		$this_analysiscode = $AnalysisCode->where(array(
			"AnalysisId" => $data['AnalysisId'],
			"methodType" => $data['method_type'],
			"withCovariant" => $data['covariant_correction'],
			"withPheno" => $data['include_pheno']
		))->find();

		$exeFileName = $this_analysiscode['exeFileName'];
		$preProcessName = $this_analysiscode['preProcessName'];
		$analysisRmdName = $this_analysiscode['analysisRmdName'];
		$cmdCode = $this_analysiscode['cmdCode'];

		$dir_bat = $_SERVER['DOCUMENT_ROOT']."/wgia/Public/job/common_jobfile/job_test.bat";
		$param1 = $data['key'];
		$param2 = $_SERVER['DOCUMENT_ROOT'];
		$param3 = $data['AnalysisId'];
		$param4 = $data['method_type'];
		$param5 = $data['covariant_correction'];
		$param6 = $data['include_pheno'];
		$cmd = $dir_bat.
			" ".$param1." ".$param2.
			" ".$exeFileName." ".$preProcessName." ".$analysisRmdName." "."\"".$cmdCode." "."-cutoff ".$data['threshold']."\"";
		$out= $param1." ".$param2.
			" ".$exeFileName." ".$preProcessName." ".$analysisRmdName." "."\"".$cmdCode."\"";
		$info = $param3."_and_".$param4."_and_".$param5."_and_".$param6."_and_".$data['threshold'];
		

		$cmd = $cmd." "."\"".$info."\"";
		$out = $out." "."\"".$info."\"";
		
		$condition_cmd['key']=$data['key'];
		$data_cmd['cmd_code'] = $cmd;
		$data_cmd['user_id']=$_SESSION['user_id'];
		///////////////
		$Job->where($condition_cmd)->save($data_cmd);
		
		if($the_last_job['status']!= 4){
			//$out=$job_id;
			$file = $_SERVER['DOCUMENT_ROOT'].'/wgia/Public/job/queue.txt';
			$handle = fopen($file, 'a');
			/*fwrite($handle, $data['key']."\n");*/
			fwrite($handle, $out."\n");
			fclose($handle);
			echo $data['key']."__".$cmd;
		}else{
			
			echo $data['key']."__".$cmd."__status=4";
		}
		
	}
 
	public function batcode(){
		$key=$_GET['key'];
		$cmd=$_GET['cmd'];
		//$cmd="E:/test.bat";
		
		$handle = popen("start /B ".$cmd, "r");
		$read = fread($handle, 2096);
		pclose($handle);
		$this->ajaxReturn(array('status' => "success", 'message' => $cmd));
	}


	public function status(){
		header('Content-Type:text/html; charset=utf-8');

		$start_text='Your job has started running...';
		$pro_log1 = 'success';
		$pro_log2 = 'dark';
		$pro_log3 = 'dark';
		$key=$_GET['key'];

		$Job = M('job');
		$condition_key['key']=$key;
		$record=$Job->where($condition_key)->find();
		$cmd=$record['cmd_code'];
		
		if($_GET['run']=="no"){
			$current_status =  0;
		}else{
			$current_status = 1;
		} 

		$log_pre_path = './Public/job/' . $key . '/logfile_pre.txt';
		$log_content_pre = '';
		if (file_exists($log_pre_path)) {
			$log_content_pre = file_get_contents($log_pre_path);
			$current_status = 2;
		} else {
			$log_content_pre = '!!!!!!===Data preprocessing has not yet been initiated... Please be patient for a while.';
		}

		$log_cuda_path = './Public/job/' . $key . '/logfile_cuda.txt';
		$log_content_cuda = '';
		if (file_exists($log_cuda_path)) {
			$log_content_cuda = file_get_contents($log_cuda_path);
			$current_status = 3;
		} else {
			$log_content_cuda = '!!!!!!===Interaction calculation has not yet been initiated... Please be patient for a while.';
		}

		$log_res_path = './Public/job/' . $key . '/logfile_res.txt';
		$log_content_res = '';
		if (file_exists($log_res_path)) {
			$log_content_res = file_get_contents($log_res_path);
			$current_status = 4;
		} else {
			$log_content_res = '!!!!!!===Result summary analysis has not yet been initiated... Please be patient for a while.';
		}
		

		$log_res_path = './Public/job/' . $key . '/report.html';
		if (file_exists($log_res_path)) {
			$Job=M('job');
			$condition['key']=$key;
			$current_record=$Job->where($condition)->find();
			$current_record['report']='1';
			$result = $Job->save($current_record);
			$current_report = 'yes';
		} else {
			$current_report = 'no';
		}

		$this->assign('start_text', $start_text);
		$this->assign('pro_log1', $pro_log1);
		$this->assign('pro_log2', $pro_log2);
		$this->assign('pro_log3', $pro_log3);
		$this->assign('key', $key);
		$this->assign('cmd', $cmd);
		$this->assign('log_content_pre', $log_content_pre);
		$this->assign('log_content_cuda', $log_content_cuda);
		$this->assign('log_content_res', $log_content_res);
		$this->assign('current_status', $current_status);
		$this->assign('current_report', $current_report);

		$this->display('status');
	}


	public function report(){
		header('Content-Type:text/html; charset=utf-8');
		$key = $_GET['key'];
		$status = $_GET['status'];

		$Job = M('job');
		$condition['key'] = $key;
		$the_job = $Job->where($condition)->find();
		$report_status =$the_job['report'];
		
		if (!$the_job) {
			$this->redirect('error');
		} else {
			$queuedJobs = $Job->where('status != 4')->count();
			$this->assign('key', $key);
			$this->assign('status', $status);
			$this->assign('report_status',$report_status);
			$this->assign('queuedJobs', $queuedJobs);
			$this->display();
		}
	}

	public function query_report(){
		header('Content-Type:text/html; charset=utf-8');
		$found=$_GET['found'];
		
		$Job=M('job');
		$jobs=$Job->order('job_id desc')->select();
		foreach($jobs as $k=>$v){
			if($v['status']==0) $jobs[$k]['status']='Wait';
			elseif($v['status']==4) $jobs[$k]['status']='Done';
			else $jobs[$k]['status']='Running';
		}

		import('ORG.Util.Page');
		$count=count($jobs);
		$Page= new Page($count,10);
		$show= $Page->show();
		$jobs = array_slice($jobs,$Page->firstRow,$Page->listRows);


		$this->assign('record_count', $count);
		$this->assign('found',$found);
		$this->assign('vo', $jobs);
		$this->assign('page', $show);
	$this->display();
	}

	public function query_report_ok(){
		header('Content-Type:text/html; charset=utf-8');
		$key=$_GET['key'];
		$Job = M('job');
		$condition['key']=$key;
		$the_job = $Job->where($condition)->find();

		if(!$the_job){
			$this->redirect('query_report?found=error');
			}
		else{
			/*$this->redirect('report?key='.$key);*/
			$status = $the_job['status'];
			$this->redirect('report?key=' . $key . '&status=' . $status);
		}
	}





	function error(){
		header('Content-Type:text/html; charset=utf-8');
		$this->display('404');
	}


	public function upload($root){
		header('Content-Type:text/html; charset=utf-8');
		import('ORG.Net.UploadFile');
		$upload=new UploadFile();

		$upload->maxSize=20971520000;
		
		//$upload->saveRule = 'uniqid';

		$upload->saveRule = '';

		$upload->savePath=$root;
		if(!$upload->upload()){
			$info=$this->error($upload->getErrorMsg());
			
		}
		else{
			$info=$upload->getUploadFileInfo();
		}
		return $info;
	}
	
	public function test_unzip(){
		$ip = $this->get_real_ip();
		$dir='./Public/job/me2ljprzhprkla1i79uz/';
		$info=$this->unzipAndRename($dir);
		echo($info);
	}
	 public function unzipAndRename($dir) {
        //$sevenZipPath = "D:/software/7-Zip/7Z/7z.exe";
       $sevenZipPath = "D:/application/7-Zip/7z.exe";
        //$dir = "./Public/job/bf2pe6bb6hapbmcitone/";

        $archiveFiles = glob($dir . '*.{zip,rar,tar,7z}', GLOB_BRACE);

        foreach ($archiveFiles as $filePath) {
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);
            
            $tempDir = $dir . 'temp/';
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0777, true);
            }
            
            $command = "\"$sevenZipPath\" x \"$filePath\" -o\"$tempDir\" -y";
          
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                $extractedFiles = glob($tempDir . '*.{tsv,csv,txt}', GLOB_BRACE);
                if (count($extractedFiles) == 1) {
					 $extension = pathinfo($extractedFiles[0], PATHINFO_EXTENSION);
                    rename($extractedFiles[0], $dir . $fileName . '.' . $extension);
                   // rename($extractedFiles[0], $dir . $fileName . '.txt');
                } else {
                    return( "Warning: Multiple or no .txt files found in archive: $filePath");
                }
            } else {
               return( "Error: Failed to extract archive: $filePath");
            }
            
            array_map('unlink', glob("$tempDir/*.*"));
            rmdir($tempDir);
        }

        return ("All archives processed successfully!");
    }
	
    
	
/* 	public function unzipAll($dir) {
  
        $extractDir =  $dir;

        if (!is_dir($extractDir)) {
            mkdir($extractDir, 0777, true);
        }
        $zipFiles = glob($dir . '*.zip');
        $rarFiles = glob($dir . '*.rar');
        $archiveFiles = array_merge($zipFiles, $rarFiles);
        if (!empty($archiveFiles)) {
        foreach ($archiveFiles as $filePath) {
            $zip = new ZipArchive;
            if ($zip->open($filePath) === TRUE) {
                $fileName = pathinfo($filePath, PATHINFO_FILENAME);
                $extractPath = $extractDir . $fileName . '/';

                if (!is_dir($extractPath)) {
                    mkdir($extractPath, 0777, true);
                }

                $zip->extractTo($extractPath);
                $zip->close();

                $extractedFiles = glob($extractPath . '*.txt');
                if (!empty($extractedFiles)) {
                    $newFileName = $extractDir . $fileName . '.txt';
                    rename($extractedFiles[0], $newFileName);

                    rmdir($extractPath);
                } else {
                    return('No .txt file found in the zip: ' . $filePath);
                }
            } else {
               return('Failed to unzip file: ' . $filePath);
            }
        }
}
        return( $extractDir);
    }
         */


	public function upload_test(){
		header('Content-Type:text/html; charset=utf-8');
		// $root='./Public/upload_files/';
		// $info= $this->upload($root);
		// $data['task_upload']=$info[0]['savename'];
		// $data['user_id']=$_SESSION['user_id'];

		// $data['task_time']=date("Y-m-d H:i:s");
		// dump($data);

		// $Task->create($data);
		// $task_id = $Task->add();

		$this->display('upload_test2');
	}

	public function upload_test_ok(){
		header('Content-Type:text/html; charset=utf-8');
		// $upload->maxSize=20971520000;
		// $upload->saveRule = 'uniqid';

		// $upload->saveRule = '';
		// $root='./Public/job/test/';
		// $upload->savePath=$root;
		// if(!$upload->upload()){
		// $this->error($upload->getErrorMsg());
		// }
		// else{
		// $info=$upload->getUploadFileInfo();
		// $this->redirect('upload_test_success');
		// }



		$Job = M('job');
		// $data['email']=$_POST['email'];
		$data['ip'] = $this->get_real_ip();
		$data['submit_date']=date("Y-m-d H:i:s");
		$data['key']=$this->generateRandomString();
		//matrix
		$root='./Public/job/'.$data['key'].'/';
		$info= $this->upload($root);
		$data['matrix']=$info[0]['savename'];


		$Job->create($data);
		$job_id = $Job->add();


		echo $data['key'];

	}

	public function upload_test_success(){
		header('Content-Type:text/html; charset=utf-8');
		$this->display('upload_test_success');
	}

	public function enrichment(){
		header('Content-Type:text/html; charset=utf-8');
		if(!$_POST['gene'] || !$_POST['key']){$this->redirect('error');}
		else{
			$data['gene'] = $_POST['gene'];
			$data['key'] = $_POST['key'];

			exec('Rscript -e "rmarkdown::render('."'".$_SERVER['DOCUMENT_ROOT'].'/wgia/Public/job/enrichment.Rmd'."'".', output_file='."'".$_SERVER['DOCUMENT_ROOT'].'/wgia/Public/job/'.$data['key'].'/enrichment.html'."'".', params = list(args = '."'".$data['gene']."'".'))"');

			$this->assign('key', $data['key']);
			$this->display('enrichment');
		}
	}
	public function user_center(){
		header('Content-Type:text/html; charset=utf-8');
		#$User=M('user');
		$Job=M('job');
		$user_id=$_SESSION['user_id '];
		$condition['user_id']=$user_id;
		$user_jobs = $Job->where($condition)->select();
	
		$job_number=count($user_jobs);
		$this->assign('job_number',$job_number);	
		$this->display();
	}
	public function user_record(){
		header('Content-Type:text/html; charset=utf-8');
		#$User=M('user');
		$Job=M('job');
		$user_id =$_SESSION['user_id'];
		
		$condition1['user_id']=$user_id ;
		$condition1['status']=array('eq', '4');
		#$user_info = $User->where($condition)->select();
		$user_jobs_records = $Job->where($condition1)->select();
	
		echo json_encode(array("data" => $user_jobs_records));
		
	}
	public function unfinished_fun(){
		header('Content-Type:text/html; charset=utf-8');
		#$User=M('user');
		$Job=M('job');
		$user_id =$_SESSION['user_id'];
		
		$condition['user_id']=$user_id;
		$condition['status']=array('neq', '4');
		#$user_info = $User->where($condition)->select();
		$jobs_unfinish= $Job->where($condition)->select();
	
		echo json_encode(array("data" => $jobs_unfinish));
	}
	public function tutorial(){
		header('Content-Type:text/html; charset=utf-8');
		$manual=M('manual');
		$condition_1['class']="Overview";
		$manual_info_overviwe=$manual->where($condition_1)->select();
		
		$condition_2['class']="Basic Processes";
		$manual_info_Processes=$manual->where($condition_2)->select();
		
		//dump($manual_info);
		$this->assign('manual_info_overviwe',$manual_info_overviwe);
		$this->assign('manual_info_Processes',$manual_info_Processes);
		$this->display();
	}
	public function software(){
			header('Content-Type:text/html; charset=utf-8');
		$analysisinfo=M('analysisinfo');
		//$AnalysisId=$analysisinfo->getField('AnalysisId', true);
		
$result = $analysisinfo->field('AnalysisId, FullName')->select();

$AnalysisId = array_map(function($item) {
    return array($item['AnalysisId'], $item['FullName']);
}, $result);
//dump($AnalysisId );
		$this->assign('AnalysisId',$AnalysisId);
		
		$this->display();
}
}
?>
