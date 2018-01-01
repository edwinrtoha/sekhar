<?php
	date_default_timezone_set("Asia/Jakarta");
	if(!function_exists('siteinfo')){
		function siteinfo($value){
			if(empty($value)){
			}
			elseif($value=='title'){
				"Sistem Informasi Sekolah";
			}
		}
	}
	if(!function_exists('admin_url')){
		function admin_url(){
			echo base_url().'admin/';
		}
	}
	if(!function_exists('alert')){
		function alert($type,$dismiss,$icon,$title,$value){
			if($dismiss=="yes"){
				$dismiss=" alert-dismissable";
			}
			else{
				$dismiss="";
			}
			if($icon==""){
				$icon="";
			}
			else{
				$icon="<i class='icon fa fa-".$icon."'></i> ";
			}
			if($title==""){
				echo "<div class='alert alert-".$type.$dismiss."'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>".$value."</div>";
			}
			else{
				echo "<div class='alert alert-".$type.$dismiss."'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4>".$icon.$title."</h4>".$value."</div>";
			}
		}
	}
	if(!function_exists('avatar_url')){
		function avatar_url($uid=""){
			if(empty($uid) or $uid==""){
			}
			else{
				$query=$this->db->query("SELECT * FROM `user` ORDER BY `id` DESC LIMIT $offset,$limit");
				if($query->num_rows()>0){
					foreach ($query->result() as $row){
						$avatar=$row->google_uid;
						if(empty($avatar) or $avatar=="" or $avatar=="0" or $avatar=="null"){
							return base_url()."/assets/dist/img/user2-160x160.jpg";
						}
						else{
						}
					}
				}
			}
		}
	}
	if(!function_exists('concurrency')){
		function concurrency($value,$currency){
			if(empty($currency) or $currency==""){
				$value = number_format($value,2,',','.');
			}
			else{
				$value = $currency." " . number_format($value,2,',','.');
			}
			return $value;
		}
	}
	if(!function_exists('show_date')){
		function show_date($timestamp, $format){
			$timestamp=explode(" ", $timestamp);
			$timestamp=array("date"=>explode("-",$timestamp[0]),"time"=>explode(":", $timestamp[1]));
			$d=mktime($timestamp["time"][0], $timestamp["time"][1], $timestamp["time"][2], $timestamp["date"][1], $timestamp["date"][2], $timestamp["date"][0]);
			return date($format, $d);
		}
	}
?>