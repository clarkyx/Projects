<?php

class Booking
{
	// Booking status types
	const TENTATIVE = 0;
	const CONFIRMED = 1;
	const REJECTED = 2;

	// Class members
	public $id;                         // Unique booking-id
	public $userid;                     // The user-id of this booking's user
	public $roomid;                     // The room-id of this booking's location
	public $title;                      // The title of the booking event.
	public $description;
	public $date_booked;                // Date that this booking was made
	public $start_time;                 // Start datetime
	public $end_time;                   // End datetime
	public $status = self::TENTATIVE;   // Booking status is tentative by default
	public $repeat =0;
	public $repeat_freq = 0;
	public $repeat_end=NULL;

	// NOTE: dates are in the format YYYY-MM-DD
	// NOTE: datetimes are in the format YYYY-MM-DD HH:MM:SS
	// TODO: Globalize the format of the date/time so it's consistent and easy
	// to maintain.

	/*
	 * Format a date into the database's date format.
	 *
	 * Takes 3 integers: year, month, and day and returns a date string. Will
	 * fail if the year-month-day combination is invalid as per the mktime
	 * function.
	 *
	 * @param year:integer
	 * @param month:integer
	 * @param day:integer
	 */
	function format_date($year, $month, $day){
		$time = new DateTime("$year-$month-$day");
		return $time->format('Y-m-d');
	}

	// Format a time into the DB's format
	// Takes 3 integers: hour, minute, and a selector (0 for AM, 1 for PM)
	// The hour should be specified for a 12-hour clock
	// Leading zeroes are not necessary in the arguments (so 2, 0, 0 is OK) 
	// Returns true on success, false on fail
	// Failure occurs when the combination of hour, minute, and selector is invalid
	// Returns a timestamp of the form: HH:MM:SS on success, in 24-hour format, or false on fail
	// Failure occurs when the combination of hour, minute, and selector is invalid
	function format_time($hour, $minute) {
		$time = new DateTime("t $hour:$minute:00");
		return $time->format('H:i:s');
	}

	function format_datetime(DateTime $time) {
		return $time->format('Y-m-d H:i:s');
	}
    
    
    /*
	 * Set the initial booking date (today).
	 */
	function init() {
		$this->date_booked = date('Y-m-d');
	}

	function get_start_date() {
		$start = new DateTime($this->start_time);
		return $start->format('Y-m-d');
	}

	/*
	 * Set the start date of the booking.
	 */
	function set_start_date($year, $month, $day) {
		$start = new DateTime($this->start_time);
		$start->setDate($year, $month, $day);

		$this->start_time = $this->format_datetime($start);
	}

	/*
	 * Set the end date of the booking.
	 */
	function set_end_date($year, $month, $day) {
		$end = new DateTime($this->end_time);
		$end->setDate($year, $month, $day);

		$this->end_time = $this->format_datetime($end);
	}

	/*
	 * Set the start-time of this booking
	 */
	function set_start_time($hour, $minute, $second = 0) {
		$start = new DateTime($this->start_time);
		$start->setTime($hour, $minute, $second);

		$this->start_time = $this->format_datetime($start);
	}

	/*
	 * Set the end-time of this booking.
	 */
	function set_end_time($hour, $minute, $second = 0) {
		$end = new DateTime($this->end_time);
		$end->setTime($hour, $minute, $second);

		$this->end_time = $this->format_datetime($end);
	}

	/*
	 * Set the start and end of this booking when adding an event from the
	 * calendar directly.
	 */
	function set_times($start, $end, $utc = FALSE) {
		if ($utc) {
			$start = new DateTime($start, new DateTimeZone('UTC'));
			$end = new DateTime($end, new DateTimeZone('UTC'));

			$start->setTimeZone(new DateTimeZone('America/New_York'));
			$end->setTimeZone(new DateTimeZone('America/New_York'));
		} else {
			$start = new DateTime($start);
			$end = new DateTime($end);
		}

		$this->start_time = $this->format_datetime($start);
		$this->end_time = $this->format_datetime($end);
	}

	/*
	 * Moves this booking.
	 *
	 * Uses that change in days and minutes as indicators for where to move the
	 * booking. delta_days indicates the days moved and delta_minutes indicates
	 * the minutes moved.
	 *
	 * @param delta_days: integer
	 * @param delta_minutes: integer
	 */
	function move($delta_days, $delta_minutes, $room_id) {
		// Use the createFromDateString function in order to gracefully handle
		// negative days and minutes.
		$arg = $delta_days . ' days ' . $delta_minutes . ' minutes';
		$interval = DateInterval::createFromDateString($arg);

		$date = new DateTime($this->start_time);
		$date->add($interval);
		$this->start_time = $this->format_datetime($date);

		$date = new DateTime($this->end_time);
		$date->add($interval);
		$this->end_time = $this->format_datetime($date);

		$this->roomid = $room_id;

	}

	/*
	 * Resizes this booking.
	 *
	 * Uses the change in days and minutes as indicators of how much to shift
	 * the end time of this booking.
	 *
	 * @param delta_days: integer
	 * @param delta_minutes: integer
	 */
	function resize($delta_days, $delta_minutes) {
		$arg = $delta_days . ' days ' . $delta_minutes . ' minutes';
		$interval = DateInterval::createFromDateString($arg);

		$date = new DateTime($this->end_time);
		$date->add($interval);
		$this->end_time = $this->format_datetime($date);
	}

	/*
	 * TODO: Recurring event function
	 */
}

/* End of file booking.php */
/* Location: ./application/models/booking.php */
