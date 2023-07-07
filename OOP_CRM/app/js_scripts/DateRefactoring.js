document.addEventListener("DOMContentLoaded", function(){
    flatpickr("#finish_date",{
        enableTime: true,
        noCalendar: false,
        dateFormat: "Y-m-d H:00:00", // Дата и время без минут и секунд
        time_24hr: true,
        minuteIncrement: 60 // Интервал времени 1 час
    });
});