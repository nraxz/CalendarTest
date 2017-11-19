<?php
namespace Calendar;
use DateTime;
use DateTimeInterface;
class Calendar implements CalendarInterface
{
    protected $dateTime;
    public function __construct(DateTimeInterface $datetime)
    {
        $this->dateTime = $datetime;
    }
    public function getDay()
    {
        /* day of the month */
        return (int)$this->dateTime->format('j');
    }
    public function getWeekDay()
    {
        /* Numeric Representation of the day */
        return (int)$this->dateTime->format('N');
    }
    public function getFirstWeekDay()
    {
        return (int)$this->getMonthFirstDay($this->dateTime)->format('N');
    }
    public function getFirstWeek()
    {
        return (int)$this->getMonthLastDay($this->dateTime)->format('W');
    }
    public function getNumberOfDaysInThisMonth()
    {
        return (int)$this->dateTime->format('t');
    }
    public function getNumberOfDaysInPreviousMonth()
    {
        return (int)$this->getMonthFirstDay($this->dateTime)
            ->modify('-1 month')
            ->format('t');
    }
    public function getCalendar()
    {
        	$calenderResult = [];
			$dateStart = $this->getCalendarDateStart($this->dateTime);
			$dateLast = $this->getCalendarDateLast($this->dateTime);
			$theDate = $dateStart;


			$displayWeek = 0;
			while ($displayWeek < 6){

				  if ($theDate <= $dateLast){
					 $runningWeek = (int)$theDate->format('W');
					 $theDay = 1;
					while($theDay <= 7){
						 $theDayOfMonth = $theDate->format('j');
						 $calendarResult[$runningWeek][$theDayOfMonth] = $this->weekHighlight($runningWeek);
						 $theDate->modify('+1 day');
						 $theDay++;
					 }
				  }

					$theDate++;
				}


        return $calendarResult;
    }
     /**
     * @param DateTimeInterface $datetime
     * @param string $format
     * @return DateTime
     */
    private function dateFormatSetting(DateTimeInterface $datetime, $format)
    {
        return new DateTime($datetime->format($format));
    }

    /**
     * @param DateTimeInterface $datetime
     * @return DateTime
     */
    private function getDateTime(DateTimeInterface $datetime)
    {
        return $this->dateFormatSetting($datetime, 'd-m-Y');
    }
    /**
     * @param DateTimeInterface $datetime
     * @return DateTime
     */
    private function getMonthFirstDay(DateTimeInterface $datetime)
    {
        return $this->dateFormatSetting($datetime, '1-m-Y');
    }
     /**
     * @param DateTimeInterface $datetime
     * @return DateTime
     */

    private function getMonthLastDay(DateTimeInterface $datetime)
    {
        /* t returs number of the days in given month. */
        return $this->dateFormatSetting($datetime, 't-m-Y');

    }
     /**
     * @param $inputDate
     * @return DateTime
     */
    private function getCalendarDateStart($inputDate)
    {
        $dateStart = $this->getMonthFirstDay($inputDate);
        $dateStart->setISODate($dateStart->format('o'), $dateStart->format('W'));
        return $dateStart;
    }
     /**
     * @param $inputDate
     * @return DateTime
     */
    private function getCalendarDateLast($inputDate)
    {
        $dateLast = $this->getMonthLastDay($inputDate);
        $dateLast->setISODate($dateLast->format('o'), $dateLast->format('W'));
        return $dateLast;
    }
	/**
     * @param int $runningWeek
     * @return bool
     */

    public function weekHighlight($runningWeek)
    {
        $dt = $this->getDateTime($this->dateTime);
        return ($runningWeek == $dt->modify('-7 days')->format('W'));
    }
}
