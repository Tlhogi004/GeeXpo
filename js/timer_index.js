var milliseconds = null;
var seconds = null;
var minutes = null;
var hours = null;
var days = null;

function getRemainingTime(endtime) {
  milliseconds = Date.parse(endtime) - Date.parse(new Date());
  seconds = Math.floor(milliseconds / 1000 % 60);
  minutes = Math.floor(milliseconds / 1000 / 60 % 60);
  hours = Math.floor(milliseconds / (1000 * 60 * 60) % 24);
  days = Math.floor(milliseconds / (1000 * 60 * 60 * 24));

  return {
    'milliseconds' : milliseconds,
    'seconds' : seconds,
    'minutes' : minutes,
    'hours' : hours,
    'days' : days
  }
}

function initClock(receive_orderexpected) {
  var counter = document.getElementById('js-countdown');
  var daysItem = counter.querySelector('.js-countdown-days');
  var hoursItem = counter.querySelector('.js-countdown-hours');
  var minutesItem = counter.querySelector('.js-countdown-minutes');
  var secondsItem = counter.querySelector('.js-countdown-seconds');

  function updateClock() {
    var time = getRemainingTime(receive_orderexpected);

    if (days < 0) {
      daysItem.innerHTML = 0;
      hoursItem.innerHTML = 0;
      minutesItem.innerHTML = 0;
      secondsItem.innerHTML = 0;
    } else {
      daysItem.innerHTML = time.days;
      hoursItem.innerHTML = ('0' + time.hours).slice(-2);
      minutesItem.innerHTML = ('0' + time.minutes).slice(-2);
      secondsItem.innerHTML = ('0' + time.seconds).slice(-2);
    }

    if (time.milliseconds <= 0) {
      clearInterval(timeinterval);
    }
  }

  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}
initClock(document.getElementById('test').value);