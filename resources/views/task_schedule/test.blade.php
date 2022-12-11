<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>



<input type="text" id="Txt_Date" name="jadwal" placeholder="Choose Date" style="cursor: pointer;">
<button type="submit">Submit</button>
<script>
$("#Txt_Date").datepicker({
    format: '"d-M-yyyy"',
    inline: false,
    lang: 'en',
    step: 5,
    multidate: 5,
    closeOnDateSelect: true,
    startDate: '0d',
    endDate: '+1M'
});
</script>