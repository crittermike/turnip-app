$(document).ready(function(){
  // Set the input labels inside the fields all sexy-like.
  $("label").inFieldLabels();

  // Initialize jQuery UI on the buttons.
  $("button, input:submit, a.button").button();

  // Initialize tabs where needed.
  $("#tabs").tabs();

  // Initialize a table sorter on all tables.
  $('table').tablesorter({
    textExtraction: 'complex'
  });
});
