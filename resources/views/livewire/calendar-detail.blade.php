<div>
    <div wire:ignore id="calendar"></div>



    @push('style')
        <style>
            .fc-toolbar-title{
                font-size: 16px !important;
                font-weight: bold;

            }
            .fc-event{
                font-size: 12px;
            }
        </style>
    @endpush

    @push('script')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script>
            document.addEventListener('DOMContentLoaded', function() {

                const calendarEl = document.getElementById('calendar');
                if (!calendarEl) return;

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    timeZone: 'local',
                    initialView: 'dayGridMonth',
                    contentHeight: 'auto',
                    expandRows: true,
                    events: function(fetchInfo, successCallback, failureCallback) {
                        fetch(`/calendar-events?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log('Event data from server:', data); // ✅ Console log di sini
                                successCallback(data);
                            })
                            .catch(error => {
                                console.error('Error fetching events:', error); // ✅ Untuk error juga
                                failureCallback(error);
                            });
                    },
                    dayCellDidMount: function(info) {
                        if (info.date.getDay() === 0) {
                            info.el.style.backgroundColor = "#ffe5e5";
                        }

                        info.el.addEventListener('click', function () {
                            const date = info.date.toISOString().split('T')[0];
                            window.location.href = `/link/harian?tanggal=${date}`;
                        });
                    },
                    eventClick: function(info) {
                        info.jsEvent.preventDefault(); // hindari reload
                        if (info.event.url) {
                            window.location.href = info.event.url;
                        }
                    },
                });

                calendar.render();

                // var calendarEl = document.getElementById('calendar');
                // if (!calendarEl) return;

                // var events = @json($events);

                // var calendar = new FullCalendar.Calendar(calendarEl, {
                //     timeZone: 'local',
                //     initialView: 'dayGridMonth',
                //     events: function(fetchInfo, successCallback, failureCallback) {
                //         fetch(`/calendar-events?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`)
                //             .then(response => response.json())
                //             .then(data => successCallback(data))
                //             .catch(error => failureCallback(error));
                //     },
                //     contentHeight: 'auto',
                //     expandRows: true,
                //     dayCellDidMount: function(info) {
                //         if (info.date.getDay() === 0) {
                //             info.el.style.backgroundColor = "#ffe5e5";
                //         }
                //     },
                //     eventClick: function(info) {
                //         var eventType = info.event.extendedProps.type;  // misal: 'setor' atau 'tarik'
                //         var eventDate = info.event.startStr;  // tanggal event dalam format 'YYYY-MM-DD'

                //         if (eventType === 'setor') {

                //             console.log('setor')
                //             // window.location.href = `/linkA?date=${eventDate}&id=${info.event.id}`;
                //         } else {
                //             console.log('tarik')
                //             // window.location.href = `/linkB?date=${eventDate}&id=${info.event.id}`;
                //         }
                //     },

                //     dateClick: function(info) {
                //         var clickedDate = info.dateStr; // tanggal yang diklik, format 'YYYY-MM-DD'
                //         console.log('tanggal')

                //         // window.location.href = `/linkC?date=${clickedDate}`;
                //     },
                // });

                // calendar.render();
            });

        </script>

    @endpush

</div>
