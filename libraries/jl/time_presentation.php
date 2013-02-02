<?php    
/*
A selection of translations from SQL date-time 
to nicer formats - used by various views/templates 
*/
class timePresentation {

	/* 
	Only the first 2 methods are really intended for public use:
	
	- listTimeFormatsAvailable()
	- selectedTime($current_selection, $ref_time_string)
	
	Making the later methods public is really just for future options,
	for example, maybe an alternative view will explicitly output 
	a particular nice time format
	*/
	
	/* 
	list the various time displays available
	*/
	public function listTimeFormatsAvailable(){	
		$dtInfo = array ( 'Casual','Contextual','Formal','Friendly','Human','Relative 1','Relative 2','Relative 3','Unformatted');
		sort ($dtInfo);
		return $dtInfo;
		}

	/* 
	swicthing dispatcher - return the selected format of time
	*/
	public function selectedTime($ref_time_string, $current_selection = 'Formal' ){

	switch ($current_selection) {
		case 'Unformatted':
			return $ref_time_string;
			break;
		case 'Formal':
			return $this->formalTime($ref_time_string);
			break;
		case 'Casual':
			return $this->casualTime($ref_time_string);
			break;
		case 'Friendly':
			return $this->friendlyTime($ref_time_string);
			break;
		case 'Contextual':
			return $this->contextualTime($ref_time_string);
			break;		
		case 'Human':
			return $this->humanRelativeTime($ref_time_string);
			break;		
		case 'Relative 1':
			return $this->niceTime($ref_time_string, 1);
			break;		
		case 'Relative 2':
			return $this->niceTime($ref_time_string, 2);
			break;		
		case 'Relative 3':
			return $this->niceTime($ref_time_string, 3);
			break;		

		default:
			return $this->formalTime($ref_time_string);
			break;
		}	
	
	return $ref_time_string;
	}


	/*
	A very formal 'date, time' presentation
	*/

	public function formalTime ($ref_time_string) {
		$date = Loader::helper("date");
		return  $date->getLocalDateTime($ref_time_string,$mask = DATE_APP_GENERIC_MDY_FULL) .
				', '.
				$date->getLocalDateTime($ref_time_string,$mask = DATE_APP_GENERIC_TS);

	}

	/*
	A casual conversion of the time string, returning either the full date/time
	or 'today' with the time
	*/
	public function casualTime ($ref_time_string) {

		$th = Loader::helper('text');
		$date = Loader::helper("date");

		// Was it today?
		if (date(DATE_APP_GENERIC_MDY) == $date->getLocalDateTime($ref_time_string,$mask = DATE_APP_GENERIC_MDY) ) {
			return t('today at ').$date->getLocalDateTime($ref_time_string,$mask = DATE_APP_GENERIC_TS);
		}
		// Or a previous day
		else {
			return t('on ').$date->getLocalDateTime($ref_time_string,$mask = DATE_APP_GENERIC_MDY_FULL);
		} 
	}



	/*
	A friendly time difference display, derived from 
	http://www.ferdychristant.com/blog//archive/DOMM-7QEFK4
	
	(though it had quite a few hacks to get it working here, 
	it is essentially the same logic)
	
	His disclaimer/copyright statement:
	"This web site reflects the thoughts or opinions of myself, 
	not my employer. you may distribute this posting and all its 
	associated parts freely but you may not make a profit from it 
	or include the posting in commercial publications without 
	written permission. Further redistributions of this document 
	or its parts are allowed."
	*/

	public function friendlyTime ($ref_time_string) {

		/* 
		Necessary constants, but php won't let me assign them 
		with calculations, so they are variables here.
		*/
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;
		$month = $day * 30;
		$year = $day * 365;
		
		$ref_time = strtotime($ref_time_string);
		if(empty($ref_time)) {
			return $ref_time_string;
			}
		$cur_time = time();
		$delta =  $cur_time - $ref_time;

		if ($delta < $minute){
			return $delta <= 1 ? t('a second ago') : $delta . t(' seconds ago'); 
		}
		if ($delta < 2 * $minute){
			return t('a minute ago');
		}
		if ($delta < 45 * $minute){
			$minutes = floor($delta / $minute) . t(' hours ago');
			return $minutes <= 1 ? t('a minute ago') : $minutes . t(' minutes ago');
		}
		if ($delta < 90 * $minute){
			return t('an hour ago');
		}
		if ($delta < 24 * $hour){
			$hours = floor($delta / $hour);
			return $hours <= 1 ? t('an hour ago') : $hours . t(' hours ago');
		}
		// Not sure if this is a good approximation?
		if ($delta < 48 * $hour){
			return t('yesterday');
		}
		if ($delta < 30 * $day){
			return floor($delta / $day) . t(' days ago');
		}
		if ($delta < 12 * $month){
			$months = floor($delta / $month);
			return $months <= 1 ? t('one month ago') : $months . t(' months ago');
		}
		else{
			$years = floor($delta / $year);
			return $years <= 1 ? t('one year ago') : $years . t(' years ago');
		}

		// catch all
		return $ref_time_string;

	}


	/*
	Different friendly algorithm -contextual, derived from
	http://pkarl.com/articles/contextual-user-friendly-time-and-dates-php/

	(again it had quite a few hacks to get it working here, 
	it is essentially the same logic)
	
	He posted no associated disclaimer or copyright statement.

	*/

	public function contextualTime ($ref_time_string) {

		/* 
		Necessary constants, but php won't let me assign them 
		with calculations, so they are variables here.
		*/
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;
		$month = $day * 30;
		$year = $day * 365;

  		$ref_time = strtotime($ref_time_string);
		if(empty($ref_time)) {
			return $ref_time_string;
			}
		$cur_time = time();
		$delta =  $cur_time - $ref_time;

		if($delta <= 1) {
			return t('less than 1 second ago');
		}
		if($delta < $minute) {
			return $delta . t(' seconds ago');
		}
		if($delta < $hour) { 
			$minutes = round($delta/60); 
			return t('about ') . $minutes . ($minutes > 1 ? t(' minutes ago') : t(' minute ago')); 
		}
		if($delta < ($hour*16)) { 
			$hours = round($delta/(60*60)); 
			return t('about ') . $hours . ($hours > 1 ? t(' hours ago') : t('hour ago')); 
		}
		if($delta < (time() - strtotime('yesterday'))) {
			return t('yesterday');
			}
		if($delta < $day) { 
			$hours = round($delta/$hour); 
			return t('about ') . $hours . ($hours > 1 ? t(' hours ago') : t('hour ago')); 
		}
		if($delta < ($day*6.5)) {
			return t('about ') . round($delta/$day) . t(' days ago');
		}
		if($delta < (time() - strtotime('last week'))) {
			return t('last week');
		}
		if(round($delta/$week)  == 1) {
			return 'about a week ago';
		}
		if($delta < ($week*3.5)) {
			return t('about ') . round($delta/$week) . t(' weeks ago');
		}
		if($delta < (time() - strtotime('last month'))) {
			return t('last month');
		}
		if(round($delta/$month)  == 1) {
			return t('about a month ago');
		}
		if($delta < ($month*11.5)) {
			return t('about ') . round($delta/$month) . t(' months ago');
		}
		if($delta < (time() - strtotime('last year'))) {
			return t('last year');
		}
		if(round($delta/$year) == 1) {
			return t('about a year ago');
		}
		if($delta >= $year) {
			return t('about ') . round($delta/$year) . t(' years ago'); 
		}

		// catch all
		return $ref_time_string;
	}


	/* 
	Another approach using the class from
	http://www.inventpartners.com/content/free-php-class-friendly-relative-time
	
	They attched:
	"Legalese: 	Whilst we've made every effort to make this script both bomb and 
	idiot proof, the usual disclaimers apply: Invent Partners accepts no liability 
	for any loss or damages incurred by the use or misuse of this script. Sorry."
	
	Then, within the library:
	"Human Friendly dates by Invent Partners
	We hope you enjoy using this free class.
	Remember us next time you need some software expertise!
	http://www.inventpartners.com"
	
	*/
	public function humanRelativeTime ($ref_time_string) {
		Loader::library('3rdparty/humanRelativeDate.class','jl_last_updated');
		$humanRelativeDate = new HumanRelativeDate();
		return $humanRelativeDate->getTextForSQLDate($ref_time_string);
	}

	/*
	Derived from 
	
	http://www.ankur.com/blog/100/php/relative-time-php-flexible-detail-level/
	
	(It had some minor hacks to get it working here, but remains the same logic)
	
	He posted no associated disclaimer or copyright statement.
	
	Detail is the number of significant units to go into. As the code is only 
	approximate, detail>2 is both anal and likely to be slightly innacurate over 
	longer periods.
	 */
	function niceTime($ref_time_string, $detailLevel = 1) {

		$periods = array(t('second'), t('minute'), t('hour'), t('day'), t('week'), t('month'), t('year'), t('decade') );
		$lengths = array('60', '60', '24', '7', '4.35', '12', '10');

		$now = time();

  		$ref_time = strtotime($ref_time_string);
		if(empty($ref_time)) {
			return $ref_time_string;
			}

		$cur_time = time();

		// is it future date or past date
		if($cur_time > $ref_time) {
			$delta = $now - $ref_time;
			$tense = t('ago');

		} else {
			$delta = $ref_time - $now;
			$tense = t('from now');
		}

		if ($delta == 0) {
			return t('1 second ago');
		}

		$remainders = array();

		for($j = 0; $j < count($lengths); $j++) {
			$remainders[$j] = floor(fmod($delta, $lengths[$j]));
			$delta = floor($delta / $lengths[$j]);
		}

		$delta = round($delta);

		$remainders[] = $delta;

		$op_string = '';

		for ($i = count($remainders) - 1; $i >= 0; $i--) {
			if ($remainders[$i]) {
				$op_string .= $remainders[$i] . ' ' . $periods[$i];

				if($remainders[$i] != 1) {
					$op_string .= t('s');
				}

				$op_string .= ' ';

				$detailLevel--;

				if ($detailLevel <= 0) {
					break;
				}
			}
		}
		return $op_string . $tense;
	}


}
?>