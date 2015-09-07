/* Loi Calendar
 * http://loitruong.us/
 *
 * Copyright 2015 Loi Truong;
 * Licensed under the MIT license 
 */

//global variables
var monthNames = ["none","Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
var category;
$j = jQuery;
var allEvents;
var imagePath;
var calendarMonthImages;
var xhr; //ajax
$j(document).ready(function(){
	imagePath = $j("#loicalendar").attr("imagepath");
	category = $j("#loicalendar").attr("category");
	getMonthImages();
	//==========================================================
	//Click Events Section
	//==========================================================
	$j("#loicalendar").on("click" , ".prev-month" , function(){
		var currentMonth = parseInt($j("#loicalendar .current-month").attr("month"));
		var currentYear = parseInt($j("#loicalendar .current-month").attr("year"));
		if(currentMonth == 1){
			currentYear--;
			currentMonth = 12;
			$j("#loicalendar .current-month").text(monthNames[12] + " " + currentYear);
			$j("#loicalendar .preloader").show();
			$j('<img src="'+ calendarMonthImages[currentMonth-1] +'">').load(function() {
				$j("#loicalendar .top-calendar").css("background-image", 'url("'+ calendarMonthImages[currentMonth-1] +'")');
				$j("#loicalendar .preloader").hide();
			});
		}else{
			currentMonth--;
			$j("#loicalendar .current-month").text(monthNames[currentMonth] + " " + currentYear);
			$j("#loicalendar .preloader").show();
			$j('<img src="'+ calendarMonthImages[currentMonth-1] +'">').load(function() {
				$j("#loicalendar .top-calendar").css("background-image", 'url("'+ calendarMonthImages[currentMonth-1] +'")');
				$j("#loicalendar .preloader").hide();
			});
		}
		$j("#loicalendar .current-month").attr("month", currentMonth);
		$j("#loicalendar .current-month").attr("year", currentYear);
		
		initialMonth(currentMonth, currentYear);
		responsive();
	});
	$j("#loicalendar").on("click", ".next-month" , function(){
		var currentMonth = parseInt($j("#loicalendar .current-month").attr("month"));
		var currentYear = parseInt($j("#loicalendar .current-month").attr("year"));
		if(currentMonth == 12){
			currentYear++;
			currentMonth = 1;
			$j("#loicalendar .current-month").text(monthNames[1] + " " + currentYear);
			$j("#loicalendar .preloader").show();
			$j('<img src="'+ calendarMonthImages[currentMonth-1] +'">').load(function() {
				$j("#loicalendar .top-calendar").css("background-image", 'url("'+ calendarMonthImages[currentMonth-1] +'")');
				$j("#loicalendar .preloader").hide();
			});
		}else{
			currentMonth++;
			$j("#loicalendar .current-month").text(monthNames[currentMonth] + " " + currentYear);
			$j("#loicalendar .preloader").show();
			$j('<img src="'+ calendarMonthImages[currentMonth-1] +'">').load(function() {
				$j("#loicalendar .top-calendar").css("background-image", 'url("'+ calendarMonthImages[currentMonth-1] +'")');
				$j("#loicalendar .preloader").hide();
			});
		}
		$j("#loicalendar .current-month").attr("month", currentMonth);
		$j("#loicalendar .current-month").attr("year", currentYear);
		
		initialMonth(currentMonth, currentYear);
		responsive();
	});
	$j("#loicalendar").on("click" , ".calendar-column" , function(e){
		//if individual event is click then go to the event page
		if( $j(e.target).hasClass("individual-event") ) return;
		//if there are no event then no point to open it
		if( $j(this).attr("event-lists") == undefined) return;
		//disable window scroll
		$j("html").css("overflow","hidden");
		//disable
		var columndateformat = $j(this).attr("eventDate");
		var eventIDs = $j(this).attr("event-lists");
		var dummyImage =  calendarMonthImages[$j(this).attr("eventMonth")-1];

		$j(".loiModal .event-list .content").empty();
		$j("#loicalendar .loiModal").show().css("left", "100%").animate({
			"left" : "0px"
		},500);
		$j("#loicalendar .loiModal .header").text(columndateformat);
		try{
			eventIDs = eventIDs.split(',');
			for (var i = 0; i < eventIDs.length; i++) {
				var each_event = allEvents[eventIDs[i]];
				var event_location = '';
				if(each_event.location != null){
					event_location = "<div class='location'><b>Event Location: </b><a href='https://www.google.com/maps?q="+ each_event.location +"' target='_blank'>"+ each_event.location +"</a></div>";
				}
				var event_date = '';
				var event_time = '';
				var event_start_date_month = Math.floor((each_event.startDate%10000)/100);
				var event_start_date_day = (each_event.startDate%100);
				var event_end_date_month = Math.floor((each_event.endDate%10000)/100);
				var event_end_date_day = (each_event.endDate%100);
			
				if(each_event.startTime != each_event.endTime){
					event_time  = "<div>" + get_time_format(each_event.startTime) + ' - ' + get_time_format(each_event.endTime) + "</div>";
				}

				//check if invalid date
				
				if(each_event.startDate > each_event.endDate){
					event_date = "<div class='event_day'>"+ monthNames[event_start_date_month] + " " + event_start_date_day +"</div>";
				}else{
					event_date = "<div class='event_day'>"+ monthNames[event_start_date_month] + " " + event_start_date_day + " - " + monthNames[event_end_date_month] + " " + event_end_date_day + "</div>";
				}
				var thumbnail_image;
				if(each_event.thumbnail != null){
					thumbnail_image = each_event.thumbnail; 
				}else{
					thumbnail_image = dummyImage;
				}
				$j(".loiModal .event-list .content").append("<div class='eachEvent'><div class='thumbnail' style='background-image:url(\""+ thumbnail_image  +"\")'></div><div class='event-info'><div class='event-title'>"+ each_event.post_title  +"</div>"+ event_location +"<div class='event-description'>"+ each_event.post_excerpt +"</div><div class='event-link'><a href='"+ each_event.guid +"'>Read more</a></div></div><div class='event-date'>"+ event_date + event_time + "</div></div>");
			};
		}catch(e){
			eventIDs = eventIDs;
		}
		$j("#loicalendar .layoutbackground").css("height", ($j("#loicalendar .loiModal .event-list").height()+60));

		//console.log(allEvents);
	});
	$j("#loicalendar").on("click" , ".close" , function(){
		//enable window scroll again
		$j("html").css("overflow","auto");


		$j("#loicalendar .loiModal").animate({
			"left" : "100%"
		},500, function(){
			$j(this).css("left", "0");
			$j(this).css("display", "none");
		});

	});
	//============================================================================
	// get the format time
	// @para string $time 
	// @return formatted string time
	//============================================================================
	function get_time_format($time){
		var hour = Math.floor(parseInt($time)/100);
		var time = parseInt($time)%100;
		if(time < 10){
			time = "0" + time;
		}
		if($time >= 1200){
			if(hour == 12){
				hour  = 12;
			}else{
				hour -= 12;
			}
			return hour + ":" + time + "PM";
		}else{
			return hour + ":" + time + "AM";
		}
	}
}); //end of document ready


function loiCalendar(){
	/*
	* Initialize Calendar
	*/
	var currentMonth = new Date().getMonth() + 1;
	var currentYear = new Date().getYear() + 1900;
	$j("#loicalendar .current-month").attr("month", currentMonth);
	$j("#loicalendar .current-month").attr("year", currentYear);
	$j("#loicalendar .current-month").text(monthNames[currentMonth] + " " + currentYear);
	$j("#loicalendar .preloader").show();
	$j('<img src="'+ calendarMonthImages[currentMonth-1] +'">').load(function() {
		$j("#loicalendar .top-calendar").css("background-image", 'url("'+ calendarMonthImages[currentMonth-1] +'")');
		$j("#loicalendar .preloader").hide();
	});
	
	initialMonth(currentMonth, currentYear);

	/*
		Responsive columns
	*/
	responsive();
	$j(window).resize(function(){
		responsive();
	});






};//end of the calendar

//==========================================================
//initialize the calendar days
// @para year and month you want the calendar to be show
//==========================================================
function initialMonth(m,y){
	$j("#loicalendar .calendar-row").remove();
	var month = m;
	var year = y;
	var currentDate = new Date();

	var selectMonth = new Date(year,month-1);
	var firstDay = selectMonth.getDay();
	var daysInMonth = new Date(year,month,0).getDate();
	var lastDay = new Date(year, month-1, daysInMonth).getDay();
	// currentrow and current column, is to keep track of where's heading
	var currentRow = 0;
	var currentColumn = firstDay;
	var trackDate = 1;

	//initialize first row
	createRow();
	//asign day for each column
	for (var i = 0; i < daysInMonth; i++) {
		var day = i + 1;
		var columndateformat = monthNames[month] + " " + day + " " + year;
		$j("#loicalendar .calendar-row").eq(currentRow).find(".calendar-column").eq(currentColumn).attr("eventDate", columndateformat);
		$j("#loicalendar .calendar-row").eq(currentRow).find(".calendar-column").eq(currentColumn).attr("eventMonth", month);
		var columnDate = $j("#loicalendar .calendar-row").eq(currentRow).find(".calendar-column").eq(currentColumn).find(".column-date");
		columnDate.text(trackDate);
		if(currentDate.getMonth()+1 == month && currentDate.getDate() == trackDate && currentDate.getYear()+1900 == year){
			columnDate.addClass("currentDate");
		}
		trackDate++;
		if(currentColumn < 6){
			currentColumn++;
		}else{
			currentRow++;
			currentColumn = 0;
			createRow();
		}
	 };
	 //remove extra row when february has 28 days and start at sunday
	 if(month == 2 && daysInMonth == 28 && firstDay == 0){
	 	$j("#loicalendar .calendar-row").eq(currentRow).remove();
	 }
	 //remove extra row when 30/31 is at saturday
	 if(daysInMonth > 28 &&  lastDay == 6){
	 	$j("#loicalendar .calendar-row").eq(currentRow).remove();
	 }
	 initialEventsToMonth(firstDay,month, year);
}
//Create a row in the calendar
function createRow(){
	$j("#loicalendar .calendar-layout").append('<div class="calendar-row"> <div class="calendar-column"> <div class="column-date-cover"> <span class="column-date"></span> </div><div class="column-data"> </div><div class="view-all-events"> <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="124.81" height="124.81" viewBox="0 0 124.81 124.81" xml:space="preserve" enable-background="new 0 0 124.813 124.813"> <path d="M48.08 80.36l-1.91 11.37c-0.26 1.56 0.38 3.12 1.65 4.05 1.27 0.93 2.97 1.05 4.36 0.32l10.23-5.34L72.63 96.1c0.61 0.31 1.27 0.47 1.92 0.47 0.86 0 1.72-0.27 2.44-0.79 1.27-0.93 1.91-2.49 1.65-4.05l-1.91-11.37 8.23-8.08c1.13-1.1 1.53-2.75 1.04-4.25 -0.48-1.5-1.78-2.59-3.34-2.82l-11.41-1.69 -5.14-10.33c-0.7-1.41-2.14-2.3-3.72-2.3 -1.57 0-3.01 0.89-3.72 2.3l-5.13 10.33 -11.41 1.69c-1.56 0.23-2.85 1.33-3.34 2.82 -0.49 1.5-0.09 3.15 1.04 4.25L48.08 80.36z"/> <path d="M111.44 13.27H98.38V6.02C98.38 2.7 95.68 0 92.36 0H91.4c-3.33 0-6.02 2.7-6.02 6.02v7.25H39.28V6.02C39.28 2.7 36.59 0 33.26 0h-0.96c-3.33 0-6.02 2.7-6.02 6.02v7.25H13.37c-6.83 0-12.39 5.56-12.39 12.39v86.76c0 6.83 5.56 12.39 12.39 12.39h98.07c6.83 0 12.39-5.56 12.39-12.39V25.66C123.84 18.83 118.28 13.27 111.44 13.27zM109.83 110.8H14.99V43.27h94.84V110.8z"/> </svg> </div></div><div class="calendar-column"> <div class="column-date-cover"> <span class="column-date"></span> </div><div class="column-data"> </div><div class="view-all-events"> <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="124.81" height="124.81" viewBox="0 0 124.81 124.81" xml:space="preserve" enable-background="new 0 0 124.813 124.813"> <path d="M48.08 80.36l-1.91 11.37c-0.26 1.56 0.38 3.12 1.65 4.05 1.27 0.93 2.97 1.05 4.36 0.32l10.23-5.34L72.63 96.1c0.61 0.31 1.27 0.47 1.92 0.47 0.86 0 1.72-0.27 2.44-0.79 1.27-0.93 1.91-2.49 1.65-4.05l-1.91-11.37 8.23-8.08c1.13-1.1 1.53-2.75 1.04-4.25 -0.48-1.5-1.78-2.59-3.34-2.82l-11.41-1.69 -5.14-10.33c-0.7-1.41-2.14-2.3-3.72-2.3 -1.57 0-3.01 0.89-3.72 2.3l-5.13 10.33 -11.41 1.69c-1.56 0.23-2.85 1.33-3.34 2.82 -0.49 1.5-0.09 3.15 1.04 4.25L48.08 80.36z"/> <path d="M111.44 13.27H98.38V6.02C98.38 2.7 95.68 0 92.36 0H91.4c-3.33 0-6.02 2.7-6.02 6.02v7.25H39.28V6.02C39.28 2.7 36.59 0 33.26 0h-0.96c-3.33 0-6.02 2.7-6.02 6.02v7.25H13.37c-6.83 0-12.39 5.56-12.39 12.39v86.76c0 6.83 5.56 12.39 12.39 12.39h98.07c6.83 0 12.39-5.56 12.39-12.39V25.66C123.84 18.83 118.28 13.27 111.44 13.27zM109.83 110.8H14.99V43.27h94.84V110.8z"/> </svg> </div></div><div class="calendar-column"> <div class="column-date-cover"> <span class="column-date"></span> </div><div class="column-data"> </div><div class="view-all-events"> <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="124.81" height="124.81" viewBox="0 0 124.81 124.81" xml:space="preserve" enable-background="new 0 0 124.813 124.813"> <path d="M48.08 80.36l-1.91 11.37c-0.26 1.56 0.38 3.12 1.65 4.05 1.27 0.93 2.97 1.05 4.36 0.32l10.23-5.34L72.63 96.1c0.61 0.31 1.27 0.47 1.92 0.47 0.86 0 1.72-0.27 2.44-0.79 1.27-0.93 1.91-2.49 1.65-4.05l-1.91-11.37 8.23-8.08c1.13-1.1 1.53-2.75 1.04-4.25 -0.48-1.5-1.78-2.59-3.34-2.82l-11.41-1.69 -5.14-10.33c-0.7-1.41-2.14-2.3-3.72-2.3 -1.57 0-3.01 0.89-3.72 2.3l-5.13 10.33 -11.41 1.69c-1.56 0.23-2.85 1.33-3.34 2.82 -0.49 1.5-0.09 3.15 1.04 4.25L48.08 80.36z"/> <path d="M111.44 13.27H98.38V6.02C98.38 2.7 95.68 0 92.36 0H91.4c-3.33 0-6.02 2.7-6.02 6.02v7.25H39.28V6.02C39.28 2.7 36.59 0 33.26 0h-0.96c-3.33 0-6.02 2.7-6.02 6.02v7.25H13.37c-6.83 0-12.39 5.56-12.39 12.39v86.76c0 6.83 5.56 12.39 12.39 12.39h98.07c6.83 0 12.39-5.56 12.39-12.39V25.66C123.84 18.83 118.28 13.27 111.44 13.27zM109.83 110.8H14.99V43.27h94.84V110.8z"/> </svg> </div></div><div class="calendar-column"> <div class="column-date-cover"> <span class="column-date"></span> </div><div class="column-data"> </div><div class="view-all-events"> <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="124.81" height="124.81" viewBox="0 0 124.81 124.81" xml:space="preserve" enable-background="new 0 0 124.813 124.813"> <path d="M48.08 80.36l-1.91 11.37c-0.26 1.56 0.38 3.12 1.65 4.05 1.27 0.93 2.97 1.05 4.36 0.32l10.23-5.34L72.63 96.1c0.61 0.31 1.27 0.47 1.92 0.47 0.86 0 1.72-0.27 2.44-0.79 1.27-0.93 1.91-2.49 1.65-4.05l-1.91-11.37 8.23-8.08c1.13-1.1 1.53-2.75 1.04-4.25 -0.48-1.5-1.78-2.59-3.34-2.82l-11.41-1.69 -5.14-10.33c-0.7-1.41-2.14-2.3-3.72-2.3 -1.57 0-3.01 0.89-3.72 2.3l-5.13 10.33 -11.41 1.69c-1.56 0.23-2.85 1.33-3.34 2.82 -0.49 1.5-0.09 3.15 1.04 4.25L48.08 80.36z"/> <path d="M111.44 13.27H98.38V6.02C98.38 2.7 95.68 0 92.36 0H91.4c-3.33 0-6.02 2.7-6.02 6.02v7.25H39.28V6.02C39.28 2.7 36.59 0 33.26 0h-0.96c-3.33 0-6.02 2.7-6.02 6.02v7.25H13.37c-6.83 0-12.39 5.56-12.39 12.39v86.76c0 6.83 5.56 12.39 12.39 12.39h98.07c6.83 0 12.39-5.56 12.39-12.39V25.66C123.84 18.83 118.28 13.27 111.44 13.27zM109.83 110.8H14.99V43.27h94.84V110.8z"/> </svg> </div></div><div class="calendar-column"> <div class="column-date-cover"> <span class="column-date"></span> </div><div class="column-data"> </div><div class="view-all-events"> <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="124.81" height="124.81" viewBox="0 0 124.81 124.81" xml:space="preserve" enable-background="new 0 0 124.813 124.813"> <path d="M48.08 80.36l-1.91 11.37c-0.26 1.56 0.38 3.12 1.65 4.05 1.27 0.93 2.97 1.05 4.36 0.32l10.23-5.34L72.63 96.1c0.61 0.31 1.27 0.47 1.92 0.47 0.86 0 1.72-0.27 2.44-0.79 1.27-0.93 1.91-2.49 1.65-4.05l-1.91-11.37 8.23-8.08c1.13-1.1 1.53-2.75 1.04-4.25 -0.48-1.5-1.78-2.59-3.34-2.82l-11.41-1.69 -5.14-10.33c-0.7-1.41-2.14-2.3-3.72-2.3 -1.57 0-3.01 0.89-3.72 2.3l-5.13 10.33 -11.41 1.69c-1.56 0.23-2.85 1.33-3.34 2.82 -0.49 1.5-0.09 3.15 1.04 4.25L48.08 80.36z"/> <path d="M111.44 13.27H98.38V6.02C98.38 2.7 95.68 0 92.36 0H91.4c-3.33 0-6.02 2.7-6.02 6.02v7.25H39.28V6.02C39.28 2.7 36.59 0 33.26 0h-0.96c-3.33 0-6.02 2.7-6.02 6.02v7.25H13.37c-6.83 0-12.39 5.56-12.39 12.39v86.76c0 6.83 5.56 12.39 12.39 12.39h98.07c6.83 0 12.39-5.56 12.39-12.39V25.66C123.84 18.83 118.28 13.27 111.44 13.27zM109.83 110.8H14.99V43.27h94.84V110.8z"/> </svg> </div></div><div class="calendar-column"> <div class="column-date-cover"> <span class="column-date"></span> </div><div class="column-data"> </div><div class="view-all-events"> <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="124.81" height="124.81" viewBox="0 0 124.81 124.81" xml:space="preserve" enable-background="new 0 0 124.813 124.813"> <path d="M48.08 80.36l-1.91 11.37c-0.26 1.56 0.38 3.12 1.65 4.05 1.27 0.93 2.97 1.05 4.36 0.32l10.23-5.34L72.63 96.1c0.61 0.31 1.27 0.47 1.92 0.47 0.86 0 1.72-0.27 2.44-0.79 1.27-0.93 1.91-2.49 1.65-4.05l-1.91-11.37 8.23-8.08c1.13-1.1 1.53-2.75 1.04-4.25 -0.48-1.5-1.78-2.59-3.34-2.82l-11.41-1.69 -5.14-10.33c-0.7-1.41-2.14-2.3-3.72-2.3 -1.57 0-3.01 0.89-3.72 2.3l-5.13 10.33 -11.41 1.69c-1.56 0.23-2.85 1.33-3.34 2.82 -0.49 1.5-0.09 3.15 1.04 4.25L48.08 80.36z"/> <path d="M111.44 13.27H98.38V6.02C98.38 2.7 95.68 0 92.36 0H91.4c-3.33 0-6.02 2.7-6.02 6.02v7.25H39.28V6.02C39.28 2.7 36.59 0 33.26 0h-0.96c-3.33 0-6.02 2.7-6.02 6.02v7.25H13.37c-6.83 0-12.39 5.56-12.39 12.39v86.76c0 6.83 5.56 12.39 12.39 12.39h98.07c6.83 0 12.39-5.56 12.39-12.39V25.66C123.84 18.83 118.28 13.27 111.44 13.27zM109.83 110.8H14.99V43.27h94.84V110.8z"/> </svg> </div></div><div class="calendar-column"> <div class="column-date-cover"> <span class="column-date"></span> </div><div class="column-data"> </div><div class="view-all-events"> <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="124.81" height="124.81" viewBox="0 0 124.81 124.81" xml:space="preserve" enable-background="new 0 0 124.813 124.813"> <path d="M48.08 80.36l-1.91 11.37c-0.26 1.56 0.38 3.12 1.65 4.05 1.27 0.93 2.97 1.05 4.36 0.32l10.23-5.34L72.63 96.1c0.61 0.31 1.27 0.47 1.92 0.47 0.86 0 1.72-0.27 2.44-0.79 1.27-0.93 1.91-2.49 1.65-4.05l-1.91-11.37 8.23-8.08c1.13-1.1 1.53-2.75 1.04-4.25 -0.48-1.5-1.78-2.59-3.34-2.82l-11.41-1.69 -5.14-10.33c-0.7-1.41-2.14-2.3-3.72-2.3 -1.57 0-3.01 0.89-3.72 2.3l-5.13 10.33 -11.41 1.69c-1.56 0.23-2.85 1.33-3.34 2.82 -0.49 1.5-0.09 3.15 1.04 4.25L48.08 80.36z"/> <path d="M111.44 13.27H98.38V6.02C98.38 2.7 95.68 0 92.36 0H91.4c-3.33 0-6.02 2.7-6.02 6.02v7.25H39.28V6.02C39.28 2.7 36.59 0 33.26 0h-0.96c-3.33 0-6.02 2.7-6.02 6.02v7.25H13.37c-6.83 0-12.39 5.56-12.39 12.39v86.76c0 6.83 5.56 12.39 12.39 12.39h98.07c6.83 0 12.39-5.56 12.39-12.39V25.66C123.84 18.83 118.28 13.27 111.44 13.27zM109.83 110.8H14.99V43.27h94.84V110.8z"/> </svg> </div></div></div>');
}


//============================================================================
//	initialize the events into calendar
// @para firstColumnPosition = the column position of first day 
// @para year and month you want the calendar to be show
//============================================================================
function initialEventsToMonth($firstColumnPosition,m,y){
	var currentColumn = $firstColumnPosition;
	var currentRow = 0;
	try{
		xhr.abort();
	}catch(e){
		//no error
	}
	xhr = $j.ajax({
	  method: "POST",
	  url: "/wp-admin/admin-ajax.php",
	  data: { action: 'lec_getmonthcalendar' ,year: y, month: m, category: category }
	}).done(function(data) {
		data = JSON.parse(data);
		calendarEvents = data.calendarEvents;
		eventData = data.eventData;
		allEvents = eventData;
	  	for (var key = 1; key <= new Date(y,m,0).getDate(); key++) {
  	      if (calendarEvents.hasOwnProperty(key)){
  	      	var columnData = $j("#loicalendar .calendar-row").eq(currentRow).find(".calendar-column").eq(currentColumn).find(".column-data");
  	      	try{
	  	      	var eachEvent = calendarEvents[key].split(',');
	  	      	for (var i = 0; i < eachEvent.length; i++) {
	  	      		columnData.append("<a href="+ eventData[eachEvent[i]].guid +" class='individual-event'>"+ eventData[eachEvent[i]].post_title +"</a>");
	  	      	};
  	      	}catch(err){
  	      		columnData.append("<a href="+ eventData[calendarEvents[key]].guid +" class='individual-event'>"+ eventData[calendarEvents[key]].post_title +"</a>");
  	      	}
  	      	$j("#loicalendar .calendar-row").eq(currentRow).find(".calendar-column").eq(currentColumn).attr("event-lists", calendarEvents[key]);
  	      	$j("#loicalendar .calendar-row").eq(currentRow).find(".calendar-column").eq(currentColumn).find(".view-all-events").addClass("active");

  	      }
  	      if(currentColumn < 6){
  	      	currentColumn++;
  	      }else{
  	      	currentRow++;
  	      	currentColumn = 0;
  	      }
	  	}
	  	rearrangeColumn();
	  	responsive();
	});
}
// rearrangeColumn to looks evently
function rearrangeColumn(){
	var height = 0;
	$j("#loicalendar .calendar-column").each(function(){
		if($j(this).outerHeight() > height){
			height = $j(this).outerHeight();
		}
	});
	$j("#loicalendar .calendar-row .calendar-column").css("min-height", height);
}


//==========================================================
// all responsive code going to be in this function
//==========================================================
function responsive(){
	$j("#loicalendar .top-calendar").css('height', "500px");
	$j("#loicalendar .calendar-row .calendar-column").css({"min-height" : "150px", "border" : "1px solid #efefef"});
	$j("#loicalendar .column-date-cover").css("text-align", "right");
	$j("#loicalendar .calendar-row .individual-event").show();
	$j("#loicalendar .calendar-row .view-all-events").hide();
	if($j("#loicalendar").width() < 961){
		$j("#loicalendar .calendar-row .calendar-column").css({"min-height" : "100px", "border" : "1px solid #efefef"});
		$j("#loicalendar .column-date-cover").css("text-align", "right");
		$j("#loicalendar .calendar-row .individual-event").hide();
		$j("#loicalendar .calendar-row .view-all-events").each(function(){
			if($j(this).hasClass("active")){
				$j(this).show();
				$j(this).css({
					"position" : "absolue",
					"top"	   : "50%",
				});
			}else{
				$j(this).hide();
			}
		});
	}
	if($j("#loicalendar").width() < 737){
		$j("#loicalendar .calendar-row .calendar-column").css({"min-height" : "75px", "border" : "1px solid #efefef"});
		$j("#loicalendar .top-calendar").css('height', "300px");
		$j("#loicalendar .column-date-cover").css("text-align", "right");
		$j("#loicalendar .calendar-row .individual-event").hide();
		$j("#loicalendar .calendar-row .view-all-events").each(function(){
			if($j(this).hasClass("active")){
				$j(this).show();
				$j(this).css({
					"position" : "absolue",
					"top"	   : "50%",
				});
			}else{
				$j(this).hide();
			}
		});
	}
	if($j("#loicalendar").width() < 520){
		$j("#loicalendar .calendar-row .calendar-column").css({"min-height" : "45px", "border" : "none"});
		$j("#loicalendar .column-date-cover").css("text-align", "center");
		$j("#loicalendar .calendar-row .individual-event").hide();
		$j("#loicalendar .calendar-row .view-all-events").each(function(){
			if($j(this).hasClass("active")){
				$j(this).show();
				$j(this).css({
					"position" : "relative",
					"display" : "inline-block",
					"top"	   : "0",
				});
			}else{
				$j(this).hide();
			}
		});
	}
	if($j("#loicalendar").width() < 400){
		$j("#loicalendar .top-calendar").css('height', "200px");
		$j("#loicalendar .column-date-cover").css("text-align", "center");
		$j("#loicalendar .calendar-row .individual-event").hide();
		$j("#loicalendar .calendar-row .view-all-events").each(function(){
			if($j(this).hasClass("active")){
				$j(this).show();
				$j(this).css({
					"position" : "relative",
					"display" : "inline-block",
					"top"	   : "0",
				})
			}else{
				$j(this).hide();
			}
		});
	}
};
//==========================================================
// Get Month Images From Option
//==========================================================
function getMonthImages(){
	$j.ajax({
		  method: "POST",
		  url: "/wp-admin/admin-ajax.php",
		  data: { action: 'lec_getMonthImages' }
		}).done(function(data) {
			data = JSON.parse(data);
			calendarMonthImages = data;
			loiCalendar();
		});
}


