<?php
set_time_limit(0);
ini_set("memory_limit","999M");
error_reporting(-1);
class run{
	var $folderLog;
	var $fileName;
	var $path;
	var $folder;
	var $folderread;
	var $folderafterread;
	
	function __construct(){
		include_once("configG.php");

		$mysqli = new mysqli($hostDb,$userDb,$passDb,$db);
		if (mysqli_connect_errno()) {
			    printf("Connect failed: %s\n", mysqli_connect_error());
			    exit();
		}else{
			$this->path = $path;
			$this->db = $mysqli;
			$this->folderLog = $folderLog;
			$this->folderread = $folderread;
			$this->folderafterread = $folderafterread;
			$this->folderresult = $folderresult;
			$this->fileNameLog = $fileName;
			$this->list_file = array();
			$this->array_isi = array();
			$this->hr_pens = array();
			$this->hr_host = array();
			$this->band_posisi = array();
			$this->tanggungan = array();
			$this->golongan = array();
			$this->jenis_peserta = array();
			$this->diagnosa = array();
			$this->error = array();
		}
	}

	function writeLog($message){
		$handle = fopen($this->folderLog.$this->path.$this->fileNameLog,"a");
		fwrite($handle,date("Y-m-d H:i:s")." : ".$message."\r\n\n");
		fclose($handle);
	}

	function readFolder()
	{
		if (is_dir($this->folderread)){
		  $i = 0;
		  if ($dh = opendir($this->folderread))
		  	while (false !== ($file = readdir($dh))) {
		  		if ($file != "." && $file != ".."  && substr_count($file, ".reading") == 0 && $file != '_backup' && $file != 'temp' && $file !='_tidakboledimakan'&& $file !='LOG_') {
					rename($this->folderread.$this->path.$file, $this->folderread.$this->path.$file.'.reading');

					try{
						$query = "UPDATE tbl_import_batch SET tib_status='1' WHERE tib_filename='$file'";
						$result = $this->db->query($query);
						if($result){
							$this->writeLog("update success : ".$query);
						}else{
							$this->writeLog("update failed : ".$query);
						}
					}catch(Exception $e){
						$this->writeLog("Exception : ".$e);
					}

			    	$this->list_file[] = $file.'.reading';
					if($i == 200)break;
					$i++;
				}
		  	}
		    closedir($dh);
		  }
	}

	function proccessReadFile()
	{
		if(count($this->list_file) > 0){
			foreach($this->list_file as $idx => $value){
				$content = file($this->folderread.$this->path.$value);
				if($content !== false){
					foreach($content as $kunci=>$row){
						if (strlen($row)>17) {
							$this->array_isi[] = $row;
						}
					}
					$valuenew = str_replace('.reading', '', $value);
					rename($this->folderread.$this->path.$value, $this->folderafterread.$this->path.$valuenew);
					$this->writeLog("Move file to : ".$this->folderafterread);
				}
				else{
					$valuenew = str_replace('.reading', '', $value);
					$this->writeLog("read file ".$this->folderread.$this->path.$value." failed");
					rename($this->folderread.$this->path.$value, $this->folderafterread.$this->path.$valuenew);
					$this->writeLog("Move file to : ".$this->folderafterread);

					$valuenew = str_replace('.csv', '.txt', $valuenew);
					$array_result = ["File yg dikirimkan Tidak Sesuai"];
					$this->writeResult($this->folderresult.$this->path.$valuenew,$array_result);
				}
			}
		}
		else{
			$this->writeLog("No File");
		}
	}

	function writeResult($file,$array_result=[]){
		$myfile = fopen($file, "w");
		foreach ($array_result as $key => $value) {
        	fwrite($myfile, $value);
        	fwrite($myfile, PHP_EOL);
		}
        fclose($myfile);
	}

	function insertIntoDB()
	{
		if(count($this->list_file) > 0){
		// if(count($this->array_isi) > 0){
			// foreach ($this->array_isi as $key => $value) {
			foreach($this->list_file as $idx => $value){
				$this->error = array();
				$content = file($this->folderread.$this->path.$value);
				$line = 1;
				if($content !== false){
					$total = 0;
					$sukses = 0;
					foreach($content as $kunci=>$row){
						if (strlen($row)>17) {
							try{
								$explode = explode(',', $row);
								if (count($explode)>18) {
									if (isset($this->hr_pens[trim($explode[5])]) && isset($this->hr_host[trim($explode[6])]) && isset($this->band_posisi[trim($explode[8])]) && isset($this->jenis_peserta[trim($explode[11])]) && isset($this->golongan[trim($explode[13])])) {
										$nik = trim($explode[0]);
										$nama_kk = trim($explode[1]);
										$nikes = trim($explode[2]);
										$status = trim($explode[3]);
										$nama_kel = trim($explode[4]);
										$hr_pens = $this->hr_pens[trim($explode[5])];
										$hr_host = $this->hr_host[trim($explode[6])];
										$kategori_host = (trim($explode[7])=='PENSIUN')?'1':'2';
										$band_posisi = $this->band_posisi[trim($explode[8])];
										$tgl_lahir = date('Y-m-d', strtotime(trim($explode[9])));
										$umur = trim($explode[10]);
										$tp_jenis_peserta = $this->jenis_peserta[trim($explode[11])];
										$alamat = trim($explode[12]);
										$gol = $this->golongan[trim($explode[13])];
										// $tanggungan = trim($explode[14]);
										$tgl_pensiun = date('Y-m-d', strtotime(trim($explode[15])));
										$jenis_kelamin = (trim($explode[16])=='L')?'0':'1';
										$no_bpjs = trim($explode[17]);
										$exist = $this->cekPeserta($nik,$nikes);
										if ($exist) {
											try{
												$query = "UPDATE tbl_peserta SET tp_nik='$nik', tp_nama_kk='$nama_kk', tp_nikes='$nikes', tp_status_kel='$status', tp_nama_kel='$nama_kel', tp_hr_pens='$hr_pens', tp_hr_host='$hr_host', kategori_host='$kategori_host', tp_band_posisi='$band_posisi', tp_tgl_lahir='$tgl_lahir', tp_umur='$umur', tp_jenis_peserta='$tp_jenis_peserta', tp_alamat= '$alamat', tp_gol='$gol', tp_tgl_pens='$tgl_pensiun', tp_jenis_kelamin='$jenis_kelamin', tp_no_bpjs='$no_bpjs', last_user='Import', flag_deleted=0 WHERE tp_nik='$nik' AND tp_nikes='$nikes'";
												$result = $this->db->query($query);
												if($result){
													$this->writeLog("update success : ".$query);
													$sukses++;
												}else{
													$this->error[] =  "Line : ".$line.". Error insert, hubungi admin.";
													$this->writeLog("update failed : ".$query);
												}
											}catch(Exception $e){
												$this->error[] =  "Line : ".$line.". Error insert, hubungi admin.";
												$this->writeLog("Exception : ".$e);
											}
										}else{
											try{
												$query = "INSERT INTO tbl_peserta (tp_nik, tp_nama_kk, tp_nikes, tp_status_kel, tp_nama_kel, tp_hr_pens, tp_hr_host, kategori_host, tp_band_posisi, tp_tgl_lahir, tp_umur, tp_jenis_peserta, tp_alamat, tp_gol, tp_tgl_pens, tp_jenis_kelamin, tp_no_bpjs, last_user, flag_deleted)VALUES ('$nik','$nama_kk', '$nikes', '$status', '$nama_kel', '$hr_pens', '$hr_host', '$kategori_host', '$band_posisi', '$tgl_lahir', '$umur', '$tp_jenis_peserta', '$alamat', '$gol', '$tgl_pensiun', '$jenis_kelamin', '$no_bpjs', 'Import', '0')";
												$result = $this->db->query($query);
												if($result){
													$this->writeLog("insert success : ".$query);
													$sukses++;
												}else{
													$this->error[] =  "Line : ".$line.". Error insert (code: 119), hubungi admin.";
													$this->writeLog("insert failed : ".$query);
												}
											}catch(Exception $e){
												$this->error[] =  "Line : ".$line.". Error insert (code: 120), hubungi admin.";
												$this->writeLog("Exception : ".$e);
											}
										}
									}else{
										$this->error[] =  "Line : ".$line.". Format data tidak sesuai.";

									}
								}else{
									$this->error[] = "Line : ".$line.". Format data tidak sesuai.";
								}
							}catch(Exception $e){
								$this->error[] =  "Line : ".$line.". Error insert (code: 121), hubungi admin.";								
								$this->writeLog("Exception : ".$e);
							}
							$total++;
						}
						$line++;
					}
				}
				$valuenew = str_replace('.reading', '', $value);
				rename($this->folderread.$this->path.$value, $this->folderafterread.$this->path.$valuenew);
				$this->writeLog("Move file to : ".$this->folderafterread);

				if (count($this->error)>0) {
					$valuenew1 = str_replace('.csv', '.txt', $valuenew);
					$this->writeResult($this->folderresult.$this->path.$valuenew1,$this->error);
				}
				$total = $total;
				$sukses = $sukses;
				$failed = count($this->error);
				try{
					$query = "UPDATE tbl_import_batch SET tib_status='2', tib_total='$total', tib_success='$sukses', tib_failed='$failed' WHERE tib_filename='$valuenew'";
					$result = $this->db->query($query);
					if($result){
						$this->writeLog("update success : ".$query);
					}else{
						$this->writeLog("update failed : ".$query);
					}
				}catch(Exception $e){
					$this->writeLog("Exception : ".$e);
				}
			}
		}else{
			$this->writeLog("No File");
		}
	}

	function cekPeserta($nik,$nikes)
	{
		$q = "select tp_id FROM tbl_peserta where tp_nik='".$nik."' AND tp_nikes='".$nikes."'";
		$hasilquery = $this->db->query($q);
		if ($hasilquery->num_rows > 0) {
			return true;
		}
		return false;
	}

	function mapping()
	{
		$query = 'SELECT thp_id,thp_penamaan FROM tbl_hr_pens';
		$hasilquery = $this->db->query($query);
		if ($hasilquery->num_rows > 0) {
			while($data = $hasilquery->fetch_assoc()) {
				$this->hr_pens[$data['thp_penamaan']] = $data['thp_id'];
			}
		}


        $query = 'SELECT thh_id,thh_penamaan FROM tbl_hr_host';
        $hasilquery = $this->db->query($query);
		if ($hasilquery->num_rows > 0) {
			while($data = $hasilquery->fetch_assoc()) {
				$this->hr_host[$data['thh_penamaan']] = $data['thh_id'];
			}
		}

        $query = 'SELECT tbp_id,tbp_penamaan FROM tbl_band_posisi';
        $hasilquery = $this->db->query($query);
		if ($hasilquery->num_rows > 0) {
			while($data = $hasilquery->fetch_assoc()) {
				$this->band_posisi[$data['tbp_penamaan']] = $data['tbp_id'];
			}
		}

        $query = 'SELECT tt_id,tt_penamaan FROM tbl_tanggungan';
        $hasilquery = $this->db->query($query);
		if ($hasilquery->num_rows > 0) {
			while($data = $hasilquery->fetch_assoc()) {
				$this->tanggungan[$data['tt_penamaan']] = $data['tt_id'];
			}
		}

        $query = 'SELECT tg_id,tg_penamaan FROM tbl_golongan';
        $hasilquery = $this->db->query($query);
		if ($hasilquery->num_rows > 0) {
			while($data = $hasilquery->fetch_assoc()) {
				$this->golongan[$data['tg_penamaan']] = $data['tg_id'];
			}
		}

        $query = 'SELECT tjp_id,tjp_penamaan FROM tbl_jenis_peserta';
        $hasilquery = $this->db->query($query);
		if ($hasilquery->num_rows > 0) {
			while($data = $hasilquery->fetch_assoc()) {
				$this->jenis_peserta[$data['tjp_penamaan']] = $data['tjp_id'];
			}
		}

        $query = 'SELECT tdg_id,tdg_penamaan FROM tbl_diagnosa';
        $hasilquery = $this->db->query($query);
		if ($hasilquery->num_rows > 0) {
			while($data = $hasilquery->fetch_assoc()) {
				$this->diagnosa[$data['tdg_penamaan']] = $data['tdg_id'];
			}
		}
	}

	function process(){
		try {
			$this->mapping();
			$this->readFolder();
			$this->insertIntoDB();
			// $this->proccessReadFile();
		}

		//catch exception
		catch(Exception $e) {
			$this->writeLog("Exception Log : ".$e);
		}
	}
}
		$run = new run();
		$run->process();
?>
