/* ------------------------------------------------------------------------------
 *
 *  # Fullcalendar basic options
 *
 *  Demo JS code for extra_fullcalendar_views.html and extra_fullcalendar_styling.html pages
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const FullCalendarBasic = function() {


    //
    // Setup module components
    //

    // Basic calendar
    const _componentFullCalendarBasic = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }

        // Add demo events
        // ------------------------------

        // Default events
        const events = [];


        // Initialization
        // ------------------------------

        //
        // Basic view
        //

        // Define element
        const calendarBasicViewElement = document.querySelector('.fullcalendar-basic');
        
        const initialLocaleCode = 'id';

        // Initialize
        let currentMonth ='';
        if(calendarBasicViewElement) {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0]; // Format to YYYY-MM-DD
            const calendarBasicViewInit = new FullCalendar.Calendar(calendarBasicViewElement, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    // right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    right: ''
                },
                // locale: initialLocaleCode,
                initialDate: formattedDate,
                navLinks: true, // can click day/week names to navigate views
                nowIndicator: true,
                weekNumberCalculation: 'ISO',
                editable: false,
                selectable: true,
                direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                dayMaxEvents: false, // allow "more" link when too many events
                // events: events,
                 // Define currentMonth variable at a higher scope

                // const calendarFunctions = {
                //     datesSet: function(dateInfo) {
                //         currentMonth = dateInfo.view.title; // Set the currentMonth variable
                //     },
                datesSet: function(dateInfo) {
                    // const startMonth = dateInfo.start.getMonth() + 1; // getMonth() is 0-indexed
                    // const endMonth = dateInfo.end.getMonth() + 1;
                    currentMonth = dateInfo.view.title;
                    calendarBasicViewInit.refetchEvents(); 
                    // const currentYear = dateInfo.start.getFullYear();
                    // console.log(dateInfo.view.title,startMonth,endMonth, currentMonth);
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                // Extract the month from the current view title
                // const currentMonth = dateInfo.view.title;

                // Assuming `currentMonth` is in a format like "September 2023", 
                // you may need to parse it into a format usable as a parameter.
                // For example, you can convert it to a month index or a more usable string.// Check if currentMonth is not defined
                if (!currentMonth) {
                    console.error('currentMonth is not defined.');
                    return; // Exit the function if currentMonth is not set
                }
                const [monthName, year] = currentMonth.split(' ');
                const monthIndex = new Date(Date.parse(monthName + " 1, 2021")).getMonth() + 1; // Get month as a number (1-12)

                // Construct the URL with query parameters
                const url = `/api/ulo-calendar-all?month=${monthIndex}&year=${year}`;
                fetch(url) // Your API endpoint 
                    .then(response => response.json())
                    .then(data => successCallback(data))
                    .catch(error => failureCallback(error));
                }, 
                eventMouseEnter: function (info) {
                    let tooltip = document.createElement('div');
                    tooltip.id = 'calendar-tooltip';
                    tooltip.classList.add('calendar-tooltip');
                    tooltip.style.position = 'absolute';
                    tooltip.style.backgroundColor = '#333';
                    tooltip.style.color = '#fff';
                    tooltip.style.padding = '5px';
                    tooltip.style.borderRadius = '4px';
                    tooltip.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
                    tooltip.style.zIndex = '1000';
                    tooltip.innerHTML = info.event.title; // or other custom details

                    document.body.appendChild(tooltip);

                    // Position the tooltip
                    tooltip.style.left = info.jsEvent.pageX + 10 + 'px';
                    tooltip.style.top = info.jsEvent.pageY + 10 + 'px';
                    info.el.tooltip = tooltip;
                },
                eventMouseLeave: function(info) {
                    const tooltip = info.el.tooltip;
                    if (tooltip) {
                        setTimeout(() => {
                            tooltip.remove();
                        }, 50); // Short delay to ensure no overlap with tooltip itself
                    }
                }
            });

            // Init
            calendarBasicViewInit.render();

            // Resize calendar when sidebar toggler is clicked
            $('.sidebar-control').on('click', function() {
                calendarBasicViewInit.updateSize();
            });
        }


        //
        // Agenda view
        //

        // Define element
        // const calendarAgendaViewElement = document.querySelector('.fullcalendar-agenda');

        // // Initialize
        // if(calendarAgendaViewElement) {
        //     const calendarAgendaViewInit = new FullCalendar.Calendar(calendarAgendaViewElement, {
        //         initialDate: '2020-09-12',
        //         initialView: 'timeGridWeek',
        //         nowIndicator: true,
        //         headerToolbar: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'timeGridWeek,timeGridDay'
        //         },
        //         navLinks: true, // can click day/week names to navigate views
        //         editable: true,
        //         selectable: true,
        //         selectMirror: true,
        //         dayMaxEvents: true, // allow "more" link when too many events
        //         direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
        //         events: events
        //     });

        //     // Init
        //     calendarAgendaViewInit.render();

        //     // Resize calendar when sidebar toggler is clicked
        //     $('.sidebar-control').on('click', function() {
        //         calendarAgendaViewInit.updateSize();
        //     });
        // }


        //
        // List view
        //

        // Define element
        // const calendarListViewElement = document.querySelector('.fullcalendar-list');

        // // Initialize
        // if(calendarListViewElement) {
        //     const calendarListViewInit = new FullCalendar.Calendar(calendarListViewElement, {
        //         headerToolbar: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'listDay,listWeek,listMonth'
        //         },

        //         // Customize the button names,
        //         // otherwise they'd all just say "list"
        //         views: {
        //             listDay: {
        //                 buttonText: 'Day'
        //             },
        //             listWeek: {
        //                 buttonText: 'Week'
        //             },
        //             listMonth: {
        //                 buttonText: 'Month'
        //             }
        //         },
        //         initialView: 'listWeek',
        //         initialDate: '2020-09-12',
        //         navLinks: true, // can click day/week names to navigate views
        //         editable: true,
        //         height: 'auto',
        //         dayMaxEvents: true, // allow "more" link when too many events
        //         direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
        //         events: events
        //     });

        //     // Init
        //     calendarListViewInit.render();

        //     // Resize calendar when sidebar toggler is clicked
        //     $('.sidebar-control').on('click', function() {
        //         calendarListViewInit.updateSize();
        //     });
        // }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentFullCalendarBasic();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FullCalendarBasic.init();
});
