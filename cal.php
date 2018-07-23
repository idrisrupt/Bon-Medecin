<link href="dist/helloweek.min.css" rel="stylesheet">
<link href="dist/demo.css" rel="stylesheet">
<script src="dist/helloweek.min.js" type="text/javascript"></script>
<div class="hello-week"></div>
<p class="demo-picked"></p>	 
<script>
    const picked = document.querySelector('.demo-picked');
    var x;
    function updateInfo() {
        if (this.lastSelectedDay) {
            picked.innerHTML = '';
            for (days of this.selectedDays) {

                x = days;
                document.getElementById('date').value = x;

            }
        }
    }
    const myCalendar = new HelloWeek({
        selector: '.hello-week',
        lang: 'en',
        format: 'YYYY-MM-DD',
        monthShort: false,
        weekShort: true,
        disablePastDays: true,
        multiplePick: false,
        weekStart: 7,
        // minDate: 1520696057,
        // maxDate: 1522519829,
        onLoad: updateInfo,
        onChange: updateInfo,
        onSelect: updateInfo
    });
    prev.addEventListener('click', () => myCalendar.prev());
    next.addEventListener('click', () => myCalendar.next());
</script>
