/**
 * Zabuto Calendar customized by fro_oo
 *
 * Dependencies
 * - jQuery (2.0.3)
 * - Twitter Bootstrap (3.0.2)
 */

// begin of plugin
;(function($, window, undefined) {
 'use strict';
 
 $.ZabutoCalendar = function(options, element) {
   this.$calendarElement = $(element);
   this.$tableObj = null;
   this.$legendObj = null;
   this.$eventsArray = null;
   this._init(options);
 };
 
 $.fn.zabuto_calendar_defaults = function() {
   var now = new Date();
   var year = now.getFullYear();
   var month = now.getMonth() + 1;
   var settings = {
     language: false,
     year: year,
     month: month,
     show_reminder: false,
     show_previous: true,
     show_next: true,
     show_today: true,
     show_days: true,
     weekstartson: 1,
     nav_icon: false,
     events: {
       local: false,
       ajax: false
     },
     legend: false,
     callbacks: {
       on_cell_double_clicked: false,
       on_cell_clicked: false,
       on_nav_clicked: false,
       on_event_clicked: false
     }
   };
   return settings;
 };
 
 $.fn.zabuto_calendar_language = function(lang) {
   if (typeof(lang) == 'undefined' || lang === false)
     lang = 'fr';
   switch (lang.toLowerCase()) {
   case 'en':
     return {
     month_labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
     dow_labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
     };
     break;
   case 'fr':
     return {
     month_labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
     dow_labels: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"]
     };
     break;
   }
 };
 
 // ------------------------------------------------------------------------------------------------------
 // helper functions -------------------------------------------------------------------------------------
 
 function isToday(year, month, day) {
   var todayObj = new Date();
   var dateObj = new Date(year, month, day);
   return (dateObj.toDateString() == todayObj.toDateString());
 }
 
 function dateAsString(year, month, day) {
   var d = (day < 10) ? '0' + day : day;
   var m = month + 1;
   m = (m < 10) ? '0' + m : m;
   return year + '-' + m + '-' + d;
 }
 
 function calcDayOfWeek(year, month, day) {
   var dateObj = new Date(year, month, day, 0, 0, 0, 0);
   var dow = dateObj.getDay();
   if (dow == 0) {
     dow = 6;
   } else {
     dow--;
   }
   return dow;
 }
 
 function calcLastDayInMonth(year, month) {
   var day = 28;
   while (checkValidDate(year, month + 1, day + 1)) {
     day++;
   }
   return day;
 }
 
 function calcWeeksInMonth(year, month) {
   var daysInMonth = calcLastDayInMonth(year, month);
   var firstDow = calcDayOfWeek(year, month, 1);
   var lastDow = calcDayOfWeek(year, month, daysInMonth);
   var days = daysInMonth;
   var correct = (firstDow - lastDow);
   if (correct > 0) {
     days += correct;
   }
   return Math.ceil(days / 7);
 }
 
 function checkValidDate(y, m, d) {
   return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
 }
 
 function checkMonthLimit(_this, count, invert) {
   if (count === false) {
     count = 0;
   }
   var d1 = _this.$calendarElement.data('currDate');
   var d2 = _this.$calendarElement.data('initDate');
   
   var months;
   months = (d2.getFullYear() - d1.getFullYear()) * 12;
   months -= d1.getMonth() + 1;
   months += d2.getMonth();
   
   if (invert === true) {
     if (months < (parseInt(count) - 1)) {
       return true;
     }
   } else {
     if (months >= (0 - parseInt(count))) {
       return true;
     }
   }
   return false;
 }
 
 // ------------------------------------------------------------------------------------------------------
 // plugin prototype -------------------------------------------------------------------------------------
 
 $.ZabutoCalendar.prototype = {
   
   _init: function(options) {
     var opts = $.extend({}, $.fn.zabuto_calendar_defaults(), options);
     var languageSettings = $.fn.zabuto_calendar_language(opts.language);
     this.options = $.extend({}, opts, languageSettings);
     
     // this.$calendarElement.attr('id', "zabuto_calendar_" + (Date.now() / 1000 | 0));
     this.$calendarElement.data('initYear', this.options.year);
     this.$calendarElement.data('initMonth', this.options.month);
     this.$calendarElement.data('monthLabels', this.options.month_labels);
     this.$calendarElement.data('weekStartsOn', this.options.weekstartson);
     this.$calendarElement.data('navIcons', this.options.nav_icon);
     this.$calendarElement.data('dowLabels', this.options.dow_labels);
     this.$calendarElement.data('showReminder', this.options.show_reminder);
     this.$calendarElement.data('showToday', this.options.show_today);
     this.$calendarElement.data('showDays', this.options.show_days);
     this.$calendarElement.data('showPrevious', this.options.show_previous);
     this.$calendarElement.data('showNext', this.options.show_next);
     this.$calendarElement.data('localJsonData', this.options.events.local);
     this.$calendarElement.data('ajaxSettings', this.options.events.ajax);
     this.$calendarElement.data('legendList', this.options.legend);
     this.$calendarElement.data('doubleClickOnCellCallback', this.options.callbacks.on_cell_double_clicked);
     this.$calendarElement.data('clickOnCellCallback', this.options.callbacks.on_cell_clicked);
     this.$calendarElement.data('clickOnNavCallback', this.options.callbacks.on_nav_clicked);
     this.$calendarElement.data('clickOnEventCallback', this.options.callbacks.on_event_clicked);
     
     this._renderCalendar();
   },
   
   _renderCalendar: function() {
     var dateInitYear = parseInt(this.$calendarElement.data('initYear'));
     var dateInitMonth = parseInt(this.$calendarElement.data('initMonth')) - 1;
     var dateInitObj = new Date(dateInitYear, dateInitMonth, 1, 0, 0, 0, 0);
     this.$calendarElement.data('initDate', dateInitObj);
     var year = dateInitObj.getFullYear();
     var month = dateInitObj.getMonth();
     
     this.$tableObj = $('<table class="table"></table>');
     this.$tableObj = this._renderTable(year, month);
     this.$legendObj = this._renderLegend();
     var $containerHtml = $('<div class="zabuto_calendar"></div>');
     $containerHtml.append(this.$tableObj);
     $containerHtml.append(this.$legendObj);
     this.$calendarElement.append($containerHtml);
     
     this._parseEvents(year, month);
   },
   
   // ------------------------------------------------------------------------------------------------------
   // render the empty table functions ---------------------------------------------------------------------
   
   _renderTable: function(year, month) {
     var dateCurrObj = new Date(year, month, 1, 0, 0, 0, 0);
     this.$calendarElement.data('currDate', dateCurrObj);
     this.$tableObj.empty();
     this.$tableObj = this._renderMonthHeader(year, month);
     this.$tableObj = this._renderDayOfWeekHeader();
     this.$tableObj = this._renderDaysOfMonth(year, month);
     return this.$tableObj;
   },
   
   _renderLegend: function() {
     this.$legendObj = $('<div class="legend" id="' + this.$calendarElement.attr('id') + '_legend"></div>');
     var legend = this.$calendarElement.data('legendList');
     if (typeof(legend) == 'object' && legend.length > 0) {
       $(legend).each($.proxy(function (index, item) {
         if (typeof(item) == 'object') {
           if (!this.$calendarElement.data('showReminder') && item.type == 'reminder') return false;
           var itemLabel = '';
           if ('label' in item) {
             var $labelObj = '<span class="label event ' + item.type + '-event">' + item.label + '</span> ';
           }
           this.$legendObj.append('<span class="legend-' + item.type + '">' + $labelObj + '</span>');
         }
       }, this));
     }
     return  this.$legendObj;
   },
   
   _renderMonthHeader: function(year, month) {
     var navIcons = this.$calendarElement.data('navIcons');
     var $prevMonthNavIcon = $('<span><span class="glyphicon glyphicon-chevron-left"></span></span>');
     var $nextMonthNavIcon = $('<span><span class="glyphicon glyphicon-chevron-right"></span></span>');
     if (typeof(navIcons) === 'object') {
       if ('prev' in navIcons) {
         $prevMonthNavIcon.html(navIcons.prev);
       }
       if ('next' in navIcons) {
         $nextMonthNavIcon.html(navIcons.next);
       }
     }

     var prevIsValid = this.$calendarElement.data('showPrevious');
     if (typeof(prevIsValid) === 'number' || prevIsValid === false) {
       prevIsValid = checkMonthLimit(this, this.$calendarElement.data('showPrevious'), true);
     }

     var $prevMonthNav = $('<div class="calendar-month-navigation"></div>');
     $prevMonthNav.attr('id', this.$calendarElement.attr('id') + '_nav-prev');
     $prevMonthNav.data('navigation', 'prev');
     if (prevIsValid !== false) {
       var prevMonth = (month - 1);
       var prevYear = year;
       if (prevMonth == -1) {
         prevYear = (prevYear - 1);
         prevMonth = 11;
       }
       $prevMonthNav.data('to', {year: prevYear, month: (prevMonth + 1)});
       $prevMonthNav.append($prevMonthNavIcon);
       if (typeof(this.$calendarElement.data('clickOnNavCallback')) === 'function') {
         $prevMonthNav.click(this.$calendarElement.data('clickOnNavCallback'));
       }
       $prevMonthNav.click($.proxy(function (e) {
         this._renderTable(prevYear, prevMonth);
         this._parseEvents(prevYear, prevMonth);
       }, this));
     }

     var nextIsValid = this.$calendarElement.data('showNext');
     if (typeof(nextIsValid) === 'number' || nextIsValid === false) {
       nextIsValid = checkMonthLimit(this, this.$calendarElement.data('showNext'), false);
     }

     var $nextMonthNav = $('<div class="calendar-month-navigation"></div>');
     $nextMonthNav.attr('id', this.$calendarElement.attr('id') + '_nav-next');
     $nextMonthNav.data('navigation', 'next');
     if (nextIsValid !== false) {
       var nextMonth = (month + 1);
       var nextYear = year;
       if (nextMonth == 12) {
         nextYear = (nextYear + 1);
         nextMonth = 0;
       }
       $nextMonthNav.data('to', {year: nextYear, month: (nextMonth + 1)});
       $nextMonthNav.append($nextMonthNavIcon);
       if (typeof(this.$calendarElement.data('clickOnNavCallback')) === 'function') {
         $nextMonthNav.click(this.$calendarElement.data('clickOnNavCallback'));
       }
       $nextMonthNav.click($.proxy(function (e) {
         this._renderTable(nextYear, nextMonth);
         this._parseEvents(nextYear, nextMonth);
       }, this));
     }

     var monthLabels = this.$calendarElement.data('monthLabels');

     var $prevMonthCell = $('<th></th>').append($prevMonthNav);
     var $nextMonthCell = $('<th></th>').append($nextMonthNav);

     var $currMonthLabel = $('<span>' + monthLabels[month] + ' ' + year + '</span>');
     
     $currMonthLabel.dblclick($.proxy(function () {
       var dateInitObj = this.$calendarElement.data('initDate');
       this._renderTable(dateInitObj.getFullYear(), dateInitObj.getMonth());
       this._parseEvents(dateInitObj.getFullYear(), dateInitObj.getMonth());
     }, this));

     var $currMonthCell = $('<th colspan="5"></th>');
     $currMonthCell.append($currMonthLabel);

     var $monthHeaderRow = $('<tr class="calendar-month-header"></tr>');
     $monthHeaderRow.append($prevMonthCell, $currMonthCell, $nextMonthCell);

     this.$tableObj.append($monthHeaderRow);
     return this.$tableObj;
   },
   
   _renderDayOfWeekHeader: function() {
     if (this.$calendarElement.data('showDays') === true) {
       var weekStartsOn = this.$calendarElement.data('weekStartsOn');
       var dowLabels = this.$calendarElement.data('dowLabels');
       if (weekStartsOn === 0) {
         var dowFull = $.extend([], dowLabels);
         var sunArray = new Array(dowFull.pop());
         dowLabels = sunArray.concat(dowFull);
       }

       var $dowHeaderRow = $('<tr class="calendar-week-header"></tr>');
       $(dowLabels).each(function (index, value) {
         $dowHeaderRow.append('<th>' + value + '</th>');
       });
       this.$tableObj.append($dowHeaderRow);
     }
     return this.$tableObj;
   },
   
   _renderDaysOfMonth: function(year, month) {
     var ajaxSettings = this.$calendarElement.data('ajaxSettings');
     var weeksInMonth = calcWeeksInMonth(year, month);
     var lastDayinMonth = calcLastDayInMonth(year, month);
     var firstDow = calcDayOfWeek(year, month, 1);
     var lastDow = calcDayOfWeek(year, month, lastDayinMonth);
     var currDayOfMonth = 1;

     var weekStartsOn = this.$calendarElement.data('weekStartsOn');
     if (weekStartsOn === 0) {
       if (lastDow == 6) {
         weeksInMonth++;
       }
       if (firstDow == 6 && (lastDow == 0 || lastDow == 1 || lastDow == 5)) {
         weeksInMonth--;
       }
       firstDow++;
       if (firstDow == 7) {
         firstDow = 0;
       }
     }

     for (var wk = 0; wk < weeksInMonth; wk++) {
       var $dowRow = $('<tr class="calendar-week"></tr>');
       for (var dow = 0; dow < 7; dow++) {
         if (dow < firstDow || currDayOfMonth > lastDayinMonth) {
           $dowRow.append('<td></td>');
         } else {
           var dateId = this.$calendarElement.attr('id') + '-' + dateAsString(year, month, currDayOfMonth);
           var dayId = dateId + '-events';

           var $dayNumberElement = $('<i class="day-number" >' + currDayOfMonth + '</i>');
       
           var $dayEventsElement = $('<div id="' + dayId + '" class="events" ></div>');
           $dayEventsElement.data('day', currDayOfMonth);

           var $dayCellElement = $('<td id="' + dateId + '" class="" title="Click on the day to do something"></td>');
           
           if (this.$calendarElement.data('showToday') === true) {
             if (isToday(year, month, currDayOfMonth)) {
               $dayCellElement.addClass('today-cell');
             }
           }

           $dayCellElement.append($dayNumberElement).append($dayEventsElement);

           $dayCellElement.data('date', dateAsString(year, month, currDayOfMonth));
           $dayCellElement.data('hasEvent', false);

           if (typeof(this.$calendarElement.data('doubleClickOnCellCallback')) === 'function') {
             if (!$dayCellElement.hasClass('clickable-cell'))
              $dayCellElement.addClass('clickable-cell');
             $dayCellElement.dblclick(this.$calendarElement.data('doubleClickOnCellCallback'));
           }

           if (typeof(this.$calendarElement.data('clickOnCellCallback')) === 'function') {
             $dayCellElement.addClass('clickable-cell');
             $dayCellElement.click(this.$calendarElement.data('clickOnCellCallback'));
           }


           $dowRow.append($dayCellElement);

           currDayOfMonth++;
         }
         if (dow == 6) {
           firstDow = 0;
         }
       }

       this.$tableObj.append($dowRow);
     }
     return this.$tableObj;
   },
   
   // ------------------------------------------------------------------------------------------------------
   // parsing event functions ------------------------------------------------------------------------------
   
   _parseEvents: function(year, month) {
     this.$eventsArray = [];
     if (false !== this.$calendarElement.data('localJsonData'))
       this._parseJsonEvents();
     if (false !== this.$calendarElement.data('ajaxSettings'))
       this._parseAjaxEvents(year, month);
   },
   
   _parseJsonEvents: function() {
     var localJsonData = this.$calendarElement.data('localJsonData');
     this.addEvents(localJsonData);
   },
   
   _parseAjaxEvents: function(year, month) {
     var ajaxSettings = this.$calendarElement.data('ajaxSettings');
     if (typeof(ajaxSettings) != 'object' || typeof(ajaxSettings.url) == 'undefined') {
       alert('Invalid calendar event settings');
       return;
     }
     $.ajax({
       type: 'GET',
       url: ajaxSettings.url,
       data: { 
         year: year, 
         month: (month + 1)
       },
       dataType: 'json'
     }).done($.proxy(function(response) {
       this.addEvents(response);
     }, this));
   },
   
   // ------------------------------------------------------------------------------------------------------
   // draw the events functions ----------------------------------------------------------------------------
   
   _drawAllCalendarEvents: function() {
     var events = this.$eventsArray;
     if (events !== false) {
       $(events).each($.proxy(function (index, event) {
         _drawCalendarEvent(event);
       }, this));
     }
   },
   
   _drawCalendarEvent: function(event_object) {
     if (!this.$calendarElement.data('showReminder') && event_object.type == 'reminder') return;
     var id = this.$calendarElement.attr('id') + '-' + event_object.date;
     var $dayCellElement = $('#' + id);
     var $dayEventsElement = $('#' + id + '-events');
     $dayCellElement.data('hasEvent', true);
     
     var msg = (event_object.disabled == true) ? 'You cannot edit this event' : 'Click to edit this event';
     var $dayEventElement = $('<span id="'+event_object.id+'" class="badge" title="'+msg+' : ' + event_object.title + '">' + event_object.title + '</span>');
     $dayEventElement.data('event_object', event_object);
     if (event_object.disabled == true) {
       $dayEventElement.addClass('disabled-event');
       $dayEventElement.click(function(evt) { evt.stopPropagation(); });
     } else {
       if (typeof(this.$calendarElement.data('clickOnEventCallback')) === 'function') {
         $dayEventElement.addClass('clickable-event');
         $dayEventElement.click($.proxy(function(evt) {
           this.$calendarElement.data('clickOnEventCallback').apply($dayEventElement);
           evt.stopPropagation();
         }, this));
       }
     }
     
     $dayEventElement.addClass('event');
     if (typeof(event_object.type) !== 'undefined')
       $dayEventElement.addClass(event_object.type+'-event');
     
     $dayEventsElement.append($dayEventElement);
   },
   
   _eraseCalendarEventById: function(id) {
     var $dayEventElement = $('#' + id);
     $dayEventElement.remove();
     $dayEventElement = null;
   },
   
   _eraseAllCalendarEvents: function() {
     $.each(this.$eventsArray, $.proxy(function(k, event_object) {
       this._eraseCalendarEventById(event_object.id);
     }, this));
   },
   
   // ------------------------------------------------------------------------------------------------------
   // public methods (controlers) --------------------------------------------------------------------------
   
   // create an event (object & element)
   addEvent: function(event_object) {
     if (typeof(event_object) != 'object' || event_object.id === undefined || event_object.date === undefined || event_object.title === undefined) return;
     var dateArray = event_object.date.split('-');
     if (!checkValidDate(dateArray[0], dateArray[1], dateArray[2])) return;
     var currentDateObject = this.$calendarElement.data('currDate');
     if ((currentDateObject.getMonth()+1) != dateArray[1] || currentDateObject.getFullYear() != dateArray[0]) return;
     this.removeEventById(event_object.id); // ensure no double entries
     this.$eventsArray.push(event_object);
     this._drawCalendarEvent(event_object);
   },
   
   // create events from the array
   addEvents: function(events_array) {
     $.each(events_array, $.proxy(function(k, event_object) {
       this.addEvent(event_object);
     }, this));
   },
   
   // return event object matching the id
   getEventById: function(id) {
     var events_array = this.$eventsArray;
     var r = null;
     $.each(events_array, function(k, event_object) {
       if (event_object.id === id) {
         r = event_object;
         return false;
       }
     });
     return r;
   },
   
   // return array of events matching the date
   getEventsAt: function(date) {
     var events_array = this.$eventsArray;
     var arr = jQuery.grep(events_array, function(event_object, i) {
       return (event_object.date === date);
     });
     return arr;
   },
   
   // delete event object & element
   removeEventById: function(id) {
     var index = null;
     $.each(this.$eventsArray, function(k, event_object) {
       if (event_object.id === id) {
         index = k;
         return false;
       }
     });
     if (index !== null) {
       this._eraseCalendarEventById(id);
       this.$eventsArray.splice(index, 1);
     }
   },
   
   // delete all events objects & elements
   removeAllEvents: function() {
     this._eraseAllCalendarEvents();
     this.$eventsArray = [];
   }
   
 }; // end $.ZabutoCalendar.prototype
 
 var logError = function(message) {
   if(window.console)
     window.console.error(message);
 };
 
 // ------------------------------------------------------------------------------------------------------
 // nice pattern to expose some functions ----------------------------------------------------------------
 
 $.fn.zabuto_calendar = function(options) {
   var args = Array.prototype.slice.call(arguments, 1);
   var results;
   this.each(function() {
     var self = $.data(this, 'zabuto_calendar');
     if(typeof options === 'string') {
       if(!self) {
         logError('cannot call methods on zabuto_calendar prior to initialization; ' + 
         'attempted to call method ' + options);
         return;
       }
       if(!$.isFunction(self[options]) || options.charAt(0) === '_') {
         logError('no such method ' + options + ' for zabuto_calendar self');
         return;
       }
       results = self[options].apply(self, args);       
     } else {
       if(self) {
         self._init();
       } else {
         self = $.data(this, 'zabuto_calendar', new $.ZabutoCalendar(options, this));
       }
     }
   });
   return results || this;
 };
 
})(jQuery, window); // end of plugin

// ===========================================================================================
// ===========================================================================================
// ===========================================================================================

// custom zabuto calendar


//if ($("#my-calendar").length > 0) {
//  $("#my-calendar").zabuto_calendar({
//    language: "fr",
//    year: 2015,
//    month: 1,
//    show_previous: 1,
//    show_next: 2,
//    // show_reminder: true,
//    // show_today: false,
//    // show_days: true,
//    // weekstartson: 0,
//    // nav_icon: {
//    //   prev: '<i class="fa fa-chevron-circle-left"></i>',
//    //   next: '<i class="fa fa-chevron-circle-right"></i>'
//    // },
//    callbacks: {
//      on_cell_double_clicked: function() {
//        return cellDoubleClicked(this);
//      },
//      on_cell_clicked: function() {
//        return cellClicked(this);
//      },
//      on_nav_clicked: function() {
//        return navClicked(this);
//      },
//      on_event_clicked: function() {
//        return eventClicked(this);
//      }
//    },
//    events: {
//      local: events_array,
//      ajax: {
//        url: "show_data.php" // load ajax json events here...
//      }
//    },
//    legend: [
//      {label: "Rendez-vous", type: "appointment"},
//      {label: "Journal Event", type: "journal"},
//      {label: "Evenement B", type: "eventtype3"},
//      {label: "<span class='fa fa-bell-o'></span> Rappel", type: "reminder"}
//    ]
//  });
//}

function cellDoubleClicked(cell_element) {
  // console.log($(cell_element).data("hasEvent"));
  var day_date = $(cell_element).data("date");
  var url = "/my-nice-modal.php";
  var modal = openModal(url, {date:day_date}, true);
}

function cellClicked(cell_element) {
  // console.log($(cell_element).data("hasEvent"));
  if ($(cell_element).data("hasEvent")) {
    var day_date = $(cell_element).data("date");
    var day_events = $('#my-calendar').zabuto_calendar('getEventsAt', day_date);
    $("#list-container").load( "/my-nice-events-list.php", { date:day_date, events:day_events, show_reminder:false }, function( response, status, xhr ) {
      if ( status == "error" ) {
        alert("cellClicked ERROR !");
      }
    });
  }
}

function navClicked(nav_element) {
  // console.log('navClicked');
  // console.log(nav_element);
  // console.log($(nav_element).data("navigation") + ' > ' + $(nav_element).data("to").month + '/' + $(nav_element).data("to").year);
}

function eventClicked(event_element) {
  var event_object = $(event_element).data("event_object");
  var url = "/my-nice-modal.php";
  var modal = openModal(url, {
      date: event_object.date, 
      id: event_object.id, 
      title: event_object.title, 
      type: event_object.type, 
      reminder: event_object.reminder, 
    }, true );
  $('#list-container').empty();
}

function openModal(url, data_options, focus_on_first_field) {
  $("#modal-container").load(url, data_options, function(response, status, xhr) {
    if (status == "error") {
      alert("openModal ERROR !");
      return false;
    } else {
      var modal = $("#modal-container").find(".modal");
      modal.modal('toggle');
      return modal;
    }
  });
}
