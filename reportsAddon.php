  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#salesFrom" ).datepicker({
      defaultDate: "+0d",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#salesTo" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#salesTo" ).datepicker({
      defaultDate: "+0d",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#salesFrom" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $( "#dishFrom" ).datepicker({
      defaultDate: "+0d",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#dishTo" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#dishTo" ).datepicker({
      defaultDate: "+0d",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#dishFrom" ).datepicker( "option", "maxDate", selectedDate );
      }
    });	
  });
  </script>