<?php
	add_action( 'wp_ajax_getmonthcalendar', 'getMonthCalendar');
	add_action( 'wp_ajax_nopriv_getmonthcalendar', 'getMonthCalendar');

	function getMonthCalendar() {
		$args = array(
			'posts_per_page'   => -1,
			'category'         => '',
			'category_name'    => '',
			'post_type'        => 'l-event',
		);
		$monthCalendar = array();
		$eventData = array();
		//date initial
		if(isset($_POST['month'])){
			$month = $_POST['month'];
		}else{
			$month = date('m');
		}
		if(isset($_POST['year'])){
			$year = $_POST['year'];
		}else{
			$year = date('Y');
		}
		
		$firstdayofmonth = (int)(date("Ym", strtotime($month."/01/". $year)) . "01");
		$lastdayofmonth = (int)(date("Ymt", strtotime($month."/01/". $year)));
		//l-event initial
		$lEvents = get_posts( $args );
		foreach ($lEvents as $event) {
			//initial event data
			$startDate = (int)(date ("Ymd" , strtotime(get_post_meta( $event->ID, 'start_date', true ) )));
			$endDate = (int)(date ("Ymd" , strtotime(get_post_meta( $event->ID, 'end_date', true ) )));
			$event -> startTime =  get_post_meta( $event->ID, 'start_time', true );
			$event -> endTime =  get_post_meta( $event->ID, 'end_time', true );
			$event -> location =  get_post_meta( $event->ID, 'location', true );
			$event -> startDate = $startDate;
			$event -> endDate = $endDate;
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $event->ID ), 'large' ); 
			$event -> thumbnail = $thumbnail[0];
			//condition 1
			//the startdate within the month
			if($startDate >= $firstdayofmonth && $startDate <= $lastdayofmonth){
				//validate endate if enddate is smaller than startdate then this is invalid endate
				if($startDate <= $endDate){
					//okay now we will see where enddate at, is it in the month or outside of the month
					if($endDate <= $lastdayofmonth){
						$monthCalendar = push_date($event->ID, $startDate%100, $endDate%100, $monthCalendar);
						$eventData[$event->ID] = $event;
					}else{
						$monthCalendar = push_date($event->ID, $startDate%100, 31, $monthCalendar);	
						$eventData[$event->ID] = $event;
					}
				}
				else{
					$monthCalendar = push_date($event->ID, $startDate%100, $startDate%100, $monthCalendar);
					$eventData[$event->ID] = $event;
				}
			}
			//condition 2
			//this is when startdate is not within the month, it should be less than the month
			else if($startDate <= $endDate && $startDate < $firstdayofmonth && $endDate >= $firstdayofmonth){
				if($endDate <= $lastdayofmonth){
					$monthCalendar = push_date($event->ID, 1, $endDate%100, $monthCalendar);
					$eventData[$event->ID] = $event;
				}else{
					$monthCalendar = push_date($event->ID, 1, 31, $monthCalendar);
					$eventData[$event->ID] = $event;
				}
			}

		}

		$result;
		$result['eventData'] = $eventData;
		$result['calendarEvents'] = $monthCalendar;
		echo json_encode($result);
		wp_die(); // this is required to terminate immediately and return a proper response

	}
	/*
	// @desc push the date into $monthCalendar array
	// @para $id = $post_id
	// @para $dateStartPush = push from what date
	// @para $dateEndPush = push til what date
	// @para $monthCalendar = update this array
	// @return monthCalendar array
	*/
	function push_date($id, $dateStartPush, $dateEndPush, $monthCalendar){
		for ($i=$dateStartPush; $i < $dateEndPush+1; $i++) {
			if(isset($monthCalendar[$i])){ 
				$monthCalendar[$i] =  $monthCalendar[$i] . "," . $id;
			}
			else{
				$monthCalendar[$i] = $id;
			}
		}
		return $monthCalendar;
	};




?>