$(document).ready(function(){

  // Customize the buttons.
  $('#submitclose').button("option", "icons", {primary:'ui-icon-check'});
  $('#submitopen').button("option", "icons", {primary:'ui-icon-arrowreturnthick-1-w'});
  $('.addtask').button("option", "icons", {primary:'ui-icon-plus'});
  $('#taskradios').buttonset();

  // Make the Open/Closed/All buttons on the top of the task list work as expected.
  $("#taskradios input").change(function() {
    if ($("#radioall:checked").val()) {
      $("tr.closed, tr.open").removeClass('hide');
    } else if ($("#radioclosed:checked").val()) {
      $("tr.closed").removeClass('hide');
      $("tr.open").addClass('hide');
    } else {
      $("tr.open").removeClass('hide');
      $("tr.closed").addClass('hide');
    }
  });

  // Make the entire table row on the task list clickable
  $('#task-list tr').click(function() {
    var href = $(this).find("a").attr("href");
    if (href)
      window.location = href;
  });

  // AJAX-ify the Add Comment form and make the "Submit And Close/Reopen" buttons work.
  $('#addcomment-form').ajaxForm({success: showComment, resetForm: true });
  if ($('h2#title').hasClass('closed')) {
    $('#submitopen').show();
    $('#submitclose').hide();
  }
  $('#submitclose').click(function(){
    $('h2#title').addClass('closed');
    $(this).hide();
    $('#submitopen').show();
    $.gritter.add({
      title: 'Task closed',
      image: '/public/images/tasks48.png',
      text: 'This task has been closed. To reopen, click the "Save And Reopen Task" button.'
    });
  });
  $('#submitopen').click(function(){
    $('h2#title').removeClass('closed');
    $(this).hide();
    $('#submitclose').show();
    $.gritter.add({
      title: 'Task reopened',
      image: '/public/images/tasks48.png',
      text: 'This task has been reopened and will now appear on the main Task List again.'
    });
  });

  // Initialize autocomplete on the Projects input box.
  var projects;
  $.get('/projects/clean_list', function(data){
    projects = data.split(',');
    $("#addtask-form #project, #timeform-project").autocomplete(projects, { autoFill: true, delay: 10, selectFirst: true });
  });

  // Initialize the table filter for the task list.
  initFilter();

  // Create the editable fields using the Jeditable jQuery plugin.
  $('.text-editable').editable('/tasks/update/' + $('.id').html(), {
    indicator : 'Saving...',
    width     : 748,
    tooltip   : 'Click to edit title...',
    onblur    : 'submit'
  });
  $('.tag-editable').editable('/tasks/update/' + $('.id').html(), {
    loadurl   : '/tasks/clean_tags/' + $('.id').html(),
    indicator : 'Saving...',
    width     : 748,
    tooltip   : 'Click to edit tags...',
    onblur    : 'submit'
  });
  $('.textarea-editable').editable('/tasks/update/' + $('.id').html(), {
    loadurl   : '/tasks/clean_description/' + $('.id').html(),
    type      : 'textarea',
    onblur    : 'submit',
    rows      : 10,
    width     : 748,
    indicator : 'Saving...',
    tooltip   : 'Click to edit description...'
  });
});


function showComment(responseText, statusText, xhr, $form) {
  $(responseText).hide().prependTo('#comments').slideDown('fast');
}

function initFilter() {
  $("#task-filter").val('').unbind('keyup');
  $('.hidden').removeClass('hidden');
  $("#task-filter").keyup(function () {
    var filter = $(this).val();
    if (filter.length < 1) {
      $('.hidden').removeClass('hidden');
    } else {
      $("#task-list tbody tr:not(.hide)").each(function () {
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).addClass("hidden");
        } else {
          $(this).removeClass("hidden");
        }
      });
    }
  });
}
