<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*	type untuk success||danger||warning||
*	title untuk penamaan alert
*	bold untuk bold
*	message untuk pesannya
*	last parameter FALSE untuk json, TRUE atau biarkan kosong untuk php
*/
function alert($title, $type, $bold, $message,$php = true)
{
	$CI =& get_instance();
	if ($php) {
		$CI->session->set_flashdata($title,"
			<div class='alert alert-".$type."' alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>".$bold." </strong>".$message."</div>
			");
	}
	else{
		echo "<div class='alert alert-".$type." alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>".$bold."</strong> ".$message."</div>";
	}
}

if ( ! function_exists('limit_text')){
	function limit_text($text, $limit) {
		if (str_word_count($text, 0) > $limit) {
			$words = str_word_count($text, 2);
			$pos = array_keys($words);
			$text = substr($text, 0, $pos[$limit]) . '...';
		}
		return $text;
	}
}


if ( ! function_exists('tgl_indo'))
{
	function tgl_indo($tgl,$bulan_tiga_karakter = '')
	{
		$ubah = gmdate($tgl, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tanggal = $pecah[2];
		$bulan = bulan($pecah[1],$bulan_tiga_karakter);
		$tahun = $pecah[0];
		return $tanggal.' '.$bulan.' '.$tahun;
	}
}

if ( ! function_exists('bulan'))
{
	function bulan($bln,$bulan_tiga_karakter)
	{
		if ($bulan_tiga_karakter == FALSE) {
			switch ($bln)
			{
				case 1:
				return "Januari";
				break;
				case 2:
				return "Februari";
				break;
				case 3:
				return "Maret";
				break;
				case 4:
				return "April";
				break;
				case 5:
				return "Mei";
				break;
				case 6:
				return "Juni";
				break;
				case 7:
				return "Juli";
				break;
				case 8:
				return "Agustus";
				break;
				case 9:
				return "September";
				break;
				case 10:
				return "Oktober";
				break;
				case 11:
				return "November";
				break;
				case 12:
				return "Desember";
				break;
			}
		}else{
			switch ($bln)
			{
				case 1:
				return "Jan";
				break;
				case 2:
				return "Feb";
				break;
				case 3:
				return "Mar";
				break;
				case 4:
				return "Apr";
				break;
				case 5:
				return "Mei";
				break;
				case 6:
				return "Jun";
				break;
				case 7:
				return "Jul";
				break;
				case 8:
				return "Agu";
				break;
				case 9:
				return "Sep";
				break;
				case 10:
				return "Okt";
				break;
				case 11:
				return "Nov";
				break;
				case 12:
				return "Des";
				break;
			}
		}
	}
}

if ( ! function_exists('nama_hari'))
{
	function nama_hari($tanggal)
	{
		$ubah = gmdate($tanggal, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tgl = $pecah[2];
		$bln = $pecah[1];
		$thn = $pecah[0];

		$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari = "";
		if($nama=="Sunday") {$nama_hari="Minggu";}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		return $nama_hari;
	}
}

if ( ! function_exists('time_elapsed_string'))
{

	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'tahun',
			'm' => 'bulan',
			'w' => 'minggu',
			'd' => 'hari',
			'h' => 'jam',
			'i' => 'menit',
			's' => 'detik',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v ;
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' yang lalu' : 'baru-baru ini';
	}
}


if ( ! function_exists('int_to_word'))
{
	function int_to_words($x) {
		$nwords = array( "nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh",
			"delaan", "sembilan", "sepuluh", "sebelas", "dua belas", "tiga belas",
			"empat belas", "lima belas", "enam belas", "tujuh belas", "delapan belas",
			"sembilan belas", "dua puluh", 30 => "tiga puluh", 40 => "empat puluh",
			50 => "lima puluh", 60 => "enam puluh", 70 => "tujuh puluh", 80 => "delapan puluh",
			90 => "sembilan puluh" );

		if(!is_numeric($x))
			$w = '#';
		else if(fmod($x, 1) != 0)
			$w = '#';
		else {
			if($x < 0) {
				$w = 'minus ';
				$x = -$x;
			} else
			$w = '';
	      // ... now $x is a non-negative integer.

	      if($x < 21)   // 0 to 20
	      $w .= $nwords[$x];
	      else if($x < 100) {   // 21 to 99
	      	$w .= $nwords[10 * floor($x/10)];
	      	$r = fmod($x, 10);
	      	if($r > 0)
	      		$w .= '-'. $nwords[$r];
	      }
	  }
	  return $w;
	}
}