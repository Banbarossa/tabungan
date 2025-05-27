<div>
    <div wire:ignore id="calendar" ></div>



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
        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            // Hapus isi sebelumnya jika ada (agar tidak dobel render)
            calendarEl.innerHTML = '';

            const calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'local',
                initialView: 'dayGridMonth',
                contentHeight: 'auto',
                expandRows: true,
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch(`/calendar-events?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Parsed event data:', JSON.stringify(data, null, 2));
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                dayCellDidMount: function(info) {

                    info.el.addEventListener('click', function () {
                        // const date = info.date.toISOString().split('T')[0];
                        const date = info.date.toLocaleDateString('en-CA');
                        window.location.href = `/report/common-daily-report/${date}`;
                    });
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                },
            });

            calendar.render();
        }

        document.addEventListener('livewire:initialized', initializeCalendar);

        document.addEventListener('livewire:navigated', initializeCalendar);









            // document.addEventListener('DOMContentLoaded', function() {
            // document.addEventListener('livewire:initialized', () => {

            //     const calendarEl = document.getElementById('calendar');
            //     if (!calendarEl) return;

            //     const calendar = new FullCalendar.Calendar(calendarEl, {
            //         timeZone: 'local',
            //         initialView: 'dayGridMonth',
            //         contentHeight: 'auto',
            //         expandRows: true,
            //         events: function(fetchInfo, successCallback, failureCallback) {
            //             fetch(`/calendar-events?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`)
            //                 .then(response => response.json())
            //                 .then(data => {
            //                     successCallback(data);
            //                 })
            //                 .catch(error => {
            //                     failureCallback(error);
            //                 });
            //         },
            //         dayCellDidMount: function(info) {
            //             if (info.date.getDay() === 0) {
            //                 info.el.style.backgroundColor = "#ffe5e5";
            //             }

            //             // info.el.addEventListener('click', function () {
            //             //     const date = info.date.toISOString().split('T')[0];
            //             //     window.location.href = `/link/harian?tanggal=${date}`;
            //             // });
            //         },
            //         eventClick: function(info) {
            //             info.jsEvent.preventDefault(); // hindari reload
            //             if (info.event.url) {
            //                 window.location.href = info.event.url;
            //             }
            //         },
            //     });

            //     calendar.render();

            // });

        </script>

    @endpush

</div>
