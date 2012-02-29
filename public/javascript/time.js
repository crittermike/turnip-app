$(document).ready(function(){

  //// Make the Add Time form into a modal dialog.
  //$('#addtime-form').dialog({
  //  minWidth: 351,
  //  modal: true,
  //  autoOpen: false,
  //  title: 'Add Time',
  //  resizable: false
  //});
  //
  //// Open the Add Time dialog whenever the clock is clicked.
  //$('#header-clock').click(function(){
  //  $('#addtime-form').dialog('open');
  //  return false;
  //});


  // Add class when input focused, and remove when input not focused.
  // Note that we filter only inside #container so that inputs in the dialog
  // box are ignored.
  $('input, textarea').live('focus', function(){
    $('body').addClass('inputfocused');
  });
  $('input, textarea').live('blur', function(){
    $('body').removeClass('inputfocused');
  });

  // Open the Add Time dialog whenever the button "t" is pressed, but not when inside an input.
  $(document).keypress(function(e){
    if (e.which == 116 || e.keyCode == 116 || window.event.keyCode == 116) {
      if (!$('body').hasClass('inputfocused')) {
        e.preventDefault(); // Necessary to prevent the 't' from going in the first input.
        $('#addtime-form').dialog('open');
      }
    };
  });

  // AJAX-ify the Add Comment form and make the "Submit And Close" button work
  var options = {
    beforeSubmit : validateTimeForm,
    resetForm    : true
  };
  $('#addtime-form').ajaxForm(options);

  $('#addtime-form #timeform-time').timeConvert();
  $('#addtime-form #timeform-project').blur(function(){
    if ($(this).val() == '') {
      $(this).addClass('error');
    } else {
      $(this).removeClass('error');
    }
  });


	// Make all sections of the time table editable
  $('.timetable-date').editable('/time/update/', {
		type      : 'datepicker',
    indicator : 'Saving...',
		submit    : 'Save',
    tooltip   : 'Click to edit the date...',
    onblur    : 'submit'
  });
  $('.timetable-time').editable('/time/update/', {
    indicator : 'Saving...',
    tooltip   : 'Click to edit the time...',
    onblur    : 'submit'
  });
  $('.timetable-project').editable('/time/update/', {
    indicator : 'Saving...',
    tooltip   : 'Click to edit the project...',
    onblur    : 'submit'
  });
  $('.timetable-description').editable('/time/update/', {
    indicator : 'Saving...',
    tooltip   : 'Click to edit the description...',
    onblur    : 'submit'
  });

	$('#time-start, #time-end').datepicker({ dateFormat: 'yy-mm-dd' });

	$('#time-filter').accordion({ collapsible: true, animated: false, active: false });
});




function validateTimeForm(arr, $form, options) {
  if ($form.find('#timeform-time').hasClass('error') || $form.find('#timeform-project').hasClass('error') || $form.find('#timeform-time').val() == '' || $form.find('#timeform-project').val() == '') {
    $.gritter.add({
	    title: 'Whoops!',
	    image: '/public/images/error48.png',
	    text: 'Make sure you have filled out the Time and Project fields correctly.'
    });
    return false;
  }

  $.gritter.add({
	  title: 'Time added!',
	  image: '/public/images/clock48.png',
	  text: $form.find('#timeform-time').val() + ' has been added to ' + $form.find('#timeform-project').val() + '.'
  });
}
