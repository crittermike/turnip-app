/*
 * timeConvert jQuery plugin, by Mike Crittenden <mikethecoder.com>
 *
 * On blur, tests an input to see if its value is a valid time or decimal number and:
 * - If valid time, do nothing
 * - If valid decimal number, convert to valid time
 * - If neither, add class="error" to the input
 */

(function($){
  $.fn.timeConvert = function(type) {
    var input = $(this);
    input.blur(function(){
      var val = jQuery.trim(input.val());
      if (!isTime(val) && !isNumber(val)) {
        input.addClass('error');
      } else {
        input.removeClass('error');
        if (isNumber(val)) {
          input.val(decimalToTime(val));
        }
      }
    })

    // Converts a decimal number of hours to H:MM time format.
    function decimalToTime(num) {
      var nums = num.split('.');
      if (!nums[1]) {
        nums[1] = "00";
      } else {
        nums[1] = parseFloat("0." + nums[1]) * 60;
        nums[1] = Math.ceil(nums[1]);
        if (nums[1] < 10)
          nums[1] = "0" + nums[1];
      }
      return nums[0] + ":" + nums[1];
    }

    // Helper function to tell if input is a valid decimal number.
    function isNumber(num) {
      return !isNaN(parseFloat(num)) && isFinite(num);
    }

    // Helper function to tell if time is in H:MM format or not.
    function isTime(time) {
      return time.match(/(^([0-9]|[0-1][0-9]|[2][0-3]):([0-5][0-9])$)|(^([0-9]|[1][0-9]|[2][0-3])$)/);
    }
  };
})(jQuery);
