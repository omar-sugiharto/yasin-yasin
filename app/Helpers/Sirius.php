<?php 
namespace App\Helpers;

/**
 * All this helper created by Fathul Husnan under Sirius Pelita Abadi.
 * www.fathulhusnan.com
 * www.siriuspelitaabadi.com
 * @ 2020
 */

class Sirius
{
	/**
	*	Convert date to just Indonesian month,
	*   ex: 06, 'short' => Jun.
	*   ex: 11, 'long' => November.
	*   @param $date = the date being converted.
	*   @param $format = choose 'short', 'long'.
	**/
	public static function toIdMonth($date, $format = 'long')
	{
		$shortMonth = [
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Mar',
			4 => 'Apr',
			5 => 'Mei',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Agu',
			9 => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Des'
		];

		$longMonth = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		];

		$converted = date('m', strtotime($date));
		$month = ($format == "long") ? $longMonth[intval($converted)] : $shortMonth[intval($converted)];

		return $month;
	}

	/**
	*	Convert date to Indonesian Long Date Format with day, ex: 2020-01-22 => Kamis, 22 Januari 2020.
	*   @param $date = the date being converted.
	**/
	public static function toIdLongDateDay($date)
	{
		$longDay = [
			0 => 'Minggu',
			1 => 'Senin',
			2 => 'Selasa',
			3 => 'Rabu',
			4 => 'Kamis',
			5 => 'Jumat',
			6 => 'Sabtu'
		];

		$longMonth = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		];

		$splited = str_split("0".date('wdmy', strtotime($date)), 2);
		$dayText = $longDay[intval($splited[0])];
		$day = $splited[1];
		$month = $longMonth[intval($splited[2])];
		$year = date('Y', strtotime($date));

		return "$dayText, $day $month $year";
	}

	/**
	*	Convert date to Indonesian Long Date Format, ex: 2020-01-22 => 22 Januari 2020.
	*   @param $date = the date being converted. 
	**/
	public static function toIdLongDate($date)
	{
		$longMonth = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		];

		$splited = str_split(date('dmy', strtotime($date)), 2);
		
		$day = $splited[0];
		$month = $longMonth[intval($splited[1])];
		$year = date('Y', strtotime($date));

		return "$day $month $year";
	}

	/**
	*	Convert date to Indonesian Short Date Format with day, ex: 2020-01-22 => Kam, 22 Jan 2020.
	*   @param $date = the date being converted.
	**/
	public static function toIdShortDateDay($date)
	{
		$shortDay = [
			0 => 'Min',
			1 => 'Sen',
			2 => 'Sel',
			3 => 'Rab',
			4 => 'Kam',
			5 => 'Jum',
			6 => 'Sab'
		];

		$shortMonth = [
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Mar',
			4 => 'Apr',
			5 => 'Mei',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Agu',
			9 => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Des'
		];

		$splited = str_split("0".date('wdmy', strtotime($date)), 2);
		
		$dayText = $shortDay[intval($splited[0])];
		$day = $splited[1];
		$month = $shortMonth[intval($splited[2])];
		$year = date('Y', strtotime($date));

		return "$dayText, $day $month $year";
	}

	/**
	*	Convert date to Indonesian Short Date Format, ex: 2020-01-22 => 22 Jan 2020.
	*   @param $date = the date being converted.
	**/
	public static function toIdShortDate($date)
	{
		$shortMonth = [
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Mar',
			4 => 'Apr',
			5 => 'Mei',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Agu',
			9 => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Des'
		];

		$splited = str_split(date('dmy', strtotime($date)), 2);
		
		$day = $splited[0];
		$month = $shortMonth[intval($splited[1])];
		$year = date('Y', strtotime($date));

		return "$day $month $year";
	}

	/**
	*	Convert number to Indonesian Rupiah, ex: 10000 => Rp10.000,-
	*	@param $nominal = the number being converted.
	*	@param $decimal = sets the number of decimal points (default 0).
	**/
	public static function toRupiah($nominal, $decimal = 0)
	{
		return "Rp".number_format(intval($nominal), intval($decimal), ',', '.').(($decimal == 0) ? ',-' : '');
	}
}
?>