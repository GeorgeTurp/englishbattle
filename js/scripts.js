// Register form - City autocompletion (jquery)
$(document).ready(function() {
  $('#search-box').keyup(function() {
    $.ajax({
      type: 'POST',
      url: 'includes/search-city.php',
      data: 'keyword=' + $(this).val(),
      success: function(data) {
        $('#suggestion-box').show()
        $('#suggestion-box').html(data)
      }
    })
  })
})

function selectCity(val, cityId) {
  var citySearchBox = $('#search-box')
  var cityIdSearchBox = $('#search-box-city-id')
  citySearchBox.val(val)
  cityIdSearchBox.val(cityId)
  $('#suggestion-box').hide()
}

if ($('.user-id-container')) {
  var userIdContainer = $('.user-id-container')
  var gameIdContainer = $('.game-id-container')
  var userId = userIdContainer.val()
  var gameId = gameIdContainer.val()
  setTimeout(function() {
    userIdContainer.remove()
    gameIdContainer.remove()
  }, 500)
}

// Start a new game
$(document).on('click', '.new-game', function() {
  var userId = userIdContainer.val()
  $.ajax({
    method: 'POST',
    url: 'includes/start-game.php',
    data: {
      userId: userId
    }
  }).done(function(data) {
    location.href = 'game.php?partie=' + data
  })
})

// Game countdown
function radialTimer() {
  var self = this

  this.seconds = 0
  this.count = 0
  this.degrees = 0
  this.interval = null
  this.timerHTML =
    "<div class='n'></div><div class='slice'><div class='q'></div><div class='pie r'></div><div class='pie l'></div></div>"
  this.timerContainer = null
  this.number = null
  this.slice = null
  this.pie = null
  this.pieRight = null
  this.pieLeft = null
  this.quarter = null

  this.init = function(e, s) {
    self.timerContainer = $('#' + e)
    self.timerContainer.html(self.timerHTML)

    self.number = self.timerContainer.find('.n')
    self.slice = self.timerContainer.find('.slice')
    self.pie = self.timerContainer.find('.pie')
    self.pieRight = self.timerContainer.find('.pie.r')
    self.pieLeft = self.timerContainer.find('.pie.l')
    self.quarter = self.timerContainer.find('.q')

    // start timer
    self.start(s)
  }

  this.start = function(s) {
    self.seconds = s
    self.interval = window.setInterval(function() {
      self.number.html(self.seconds - self.count)
      self.count++

      if (self.count > self.seconds - 1) clearInterval(self.interval)

      self.degrees = self.degrees + 360 / self.seconds
      if (self.count >= self.seconds / 2) {
        self.slice.addClass('nc')
        if (!self.slice.hasClass('mth'))
          self.pieRight.css({ transform: 'rotate(180deg)' })
        self.pieLeft.css({
          transform: 'rotate(' + self.degrees + 'deg)'
        })
        self.slice.addClass('mth')
        if (self.count >= self.seconds * 0.75) self.quarter.remove()
      } else {
        self.pie.css({
          transform: 'rotate(' + self.degrees + 'deg)'
        })
      }
    }, 1000)
  }
}

$(document).keypress(function(e) {
  if (e.which == 13 && $('body').hasClass('game-page')) {
    $('.validation-btn')
      .focus()
      .click()
    setTimeout(function() {
      $('#preterit').focus()
    }, 50)
  }
})

var Timer
// Get game id & user  idea
$(document).ready(function() {
  Timer = new radialTimer()
  Timer.init('timer', 120)
  var dateEnvoi = Date.now()
  var dateReponse
  if ($('body').hasClass('game-page')) {
    // Load first verb
    var result
    var verbFRContainer = $('.loaded-verb-trad-container')
    var verbBVContainer = $('#baseVerbale')
    var verbPContainer = $('#preterit')
    var verbPPContainer = $('#participe-passe')
    var currentVerbId
    var currentVerbBV
    var currentVerbP
    var currentVerbPP
    var currentVerbT
    var newVerbId
    var newVerbBV
    var newVerbP
    var newVerbPP
    var newVerbT
    var questionCount = 1
    var questionCountContainer = $('.question-count')
    var scoreCount = 0
    var scoreCountContainer = $('.score-count')
    $.ajax({
      method: 'POST',
      url: 'includes/get-question.php',
      dataType: 'text'
    }).done(function(res) {
      result = $.parseJSON(res)
      var randId = Math.floor(Math.random() * (countProperties(result) - 0) + 0)
      currentVerbId = randId
      currentVerbBV = result[currentVerbId].baseVerbale
      currentVerbP = result[currentVerbId].preterit
      currentVerbPP = result[currentVerbId].participePasse
      currentVerbT = result[currentVerbId].traduction
      verbFRContainer.html(currentVerbT)
      verbBVContainer.val(currentVerbBV)
    })

    $('.validation-btn').on('click', function() {
      if ($(this).hasClass('clicked') || $('.pass-btn').hasClass('clicked')) {
        if (
          verbPContainer.val().toLowerCase() == newVerbP.toLowerCase() &&
          verbPPContainer.val().toLowerCase() == newVerbPP.toLowerCase()
        ) {
          delete result[newVerbId]
          var newRandId = Math.floor(
            Math.random() * (countProperties(result) - 0) + 0
          )
          newVerbId = newRandId
          newVerbBV = result[newVerbId].baseVerbale
          newVerbP = result[newVerbId].preterit
          newVerbPP = result[newVerbId].participePasse
          newVerbT = result[newVerbId].traduction
          verbFRContainer.html(newVerbT)
          verbBVContainer.val(newVerbBV)
          if (verbPContainer.hasClass('input-error')) {
            verbPContainer.removeClass('input-error')
          }
          if (verbPPContainer.hasClass('input-error')) {
            verbPPContainer.removeClass('input-error')
          }
          questionCount++
          scoreCount = scoreCount + 100
          questionCountContainer.html(questionCount)
          scoreCountContainer.html(scoreCount)
          dateReponse = Date.now()
          $.ajax({
            url: 'includes/save-question.php',
            method: 'POST',
            async: true,
            data: {
              idPartie: gameId,
              idVerbe: newVerbId,
              reponsePreterit: verbPContainer.val(),
              reponseParticipePasse: verbPPContainer.val(),
              dateEnvoi: dateEnvoi,
              dateReponse: dateReponse
            }
          }).done(function() {
            verbPContainer.val('')
            verbPPContainer.val('')
          })
        } else {
          if (verbPContainer.val().toLowerCase() != newVerbP.toLowerCase()) {
            verbPContainer.addClass('input-error')
          } else {
            if (verbPContainer.hasClass('input-error')) {
              verbPContainer.removeClass('input-error')
            }
          }
          if (verbPPContainer.val().toLowerCase() != newVerbPP.toLowerCase()) {
            verbPPContainer.addClass('input-error')
          } else {
            if (verbPPContainer.hasClass('input-error')) {
              verbPPContainer.removeClass('input-error')
            }
          }
        }
      } else {
        if (
          verbPContainer.val().toLowerCase() == currentVerbP.toLowerCase() &&
          verbPPContainer.val().toLowerCase() == currentVerbPP.toLowerCase()
        ) {
          delete result[currentVerbId]
          var newRandId = Math.floor(
            Math.random() * (countProperties(result) - 0) + 0
          )
          newVerbId = newRandId
          newVerbBV = result[newVerbId].baseVerbale
          newVerbP = result[newVerbId].preterit
          newVerbPP = result[newVerbId].participePasse
          newVerbT = result[newVerbId].traduction
          verbFRContainer.html(newVerbT)
          verbBVContainer.val(newVerbBV)
          $('.validation-btn').addClass('clicked')
          if (verbPContainer.hasClass('input-error')) {
            verbPContainer.removeClass('input-error')
          }
          if (verbPPContainer.hasClass('input-error')) {
            verbPPContainer.removeClass('input-error')
          }
          questionCount++
          scoreCount = scoreCount + 100
          questionCountContainer.html(questionCount)
          scoreCountContainer.html(scoreCount)
          dateReponse = Date.now()
          $.ajax({
            url: 'includes/save-question.php',
            method: 'POST',
            async: true,
            data: {
              idPartie: gameId,
              idVerbe: currentVerbId,
              reponsePreterit: verbPContainer.val(),
              reponseParticipePasse: verbPPContainer.val(),
              dateEnvoi: dateEnvoi,
              dateReponse: dateReponse
            }
          }).done(function() {
            verbPContainer.val('')
            verbPPContainer.val('')
          })
        } else {
          if (
            verbPContainer.val().toLowerCase() != currentVerbP.toLowerCase()
          ) {
            verbPContainer.addClass('input-error')
          } else {
            if (verbPContainer.hasClass('input-error')) {
              verbPContainer.removeClass('input-error')
            }
          }
          if (
            verbPPContainer.val().toLowerCase() != currentVerbPP.toLowerCase()
          ) {
            verbPPContainer.addClass('input-error')
          } else {
            if (verbPPContainer.hasClass('input-error')) {
              verbPPContainer.removeClass('input-error')
            }
          }
        }
      }
    })
    $('.pass-btn').on('click', function() {
      if (
        $(this).hasClass('clicked') ||
        $('.validation-btn').hasClass('clicked')
      ) {
        delete result[newVerbId]
        var newRandId = Math.floor(
          Math.random() * (countProperties(result) - 0) + 0
        )
        newVerbId = newRandId
        newVerbBV = result[newVerbId].baseVerbale
        newVerbP = result[newVerbId].preterit
        newVerbPP = result[newVerbId].participePasse
        newVerbT = result[newVerbId].traduction
        verbFRContainer.html(newVerbT)
        verbBVContainer.val(newVerbBV)
        if (verbPContainer.hasClass('input-error')) {
          verbPContainer.removeClass('input-error')
        }
        if (verbPPContainer.hasClass('input-error')) {
          verbPPContainer.removeClass('input-error')
        }
        questionCount++
        scoreCount = scoreCount - 50
        questionCountContainer.html(questionCount)
        scoreCountContainer.html(scoreCount)
        dateReponse = Date.now()
        verbPContainer.val('')
        verbPPContainer.val('')
      } else {
        delete result[currentVerbId]
        var newRandId = Math.floor(
          Math.random() * (countProperties(result) - 0) + 0
        )
        newVerbId = newRandId
        newVerbBV = result[newVerbId].baseVerbale
        newVerbP = result[newVerbId].preterit
        newVerbPP = result[newVerbId].participePasse
        newVerbT = result[newVerbId].traduction
        verbFRContainer.html(newVerbT)
        verbBVContainer.val(newVerbBV)
        $('.validation-btn').addClass('clicked')
        if (verbPContainer.hasClass('input-error')) {
          verbPContainer.removeClass('input-error')
        }
        if (verbPPContainer.hasClass('input-error')) {
          verbPPContainer.removeClass('input-error')
        }
        questionCount++
        scoreCount = scoreCount - 50
        questionCountContainer.html(questionCount)
        scoreCountContainer.html(scoreCount)
        verbPContainer.val('')
        verbPPContainer.val('')
      }
    })
    setInterval(function() {
      if ($('#timer>.n').html() == '1') {
        location.href = 'end.php?partie=' + gameId
        $.ajax({
          url: 'includes/save-score.php',
          method: 'POST',
          async: true,
          data: {
            idPartie: gameId,
            score: scoreCount
          }
        })
      }
    }, 1000)
  }
})

function countProperties(obj) {
  return Object.keys(obj).length
}

(function () {
    'use strict';
    var devtools = {
        open: false,
        orientation: null
    };
    var threshold = 160;
    var emitEvent = function (state, orientation) {
        window.dispatchEvent(new CustomEvent('devtoolschange', {
            detail: {
                open: state,
                orientation: orientation
            }
        }));
    };

    setInterval(function () {
        var widthThreshold = window.outerWidth - window.innerWidth > threshold;
        var heightThreshold = window.outerHeight - window.innerHeight > threshold;
        var orientation = widthThreshold ? 'vertical' : 'horizontal';

        if (!(heightThreshold && widthThreshold) &&
            ((window.Firebug && window.Firebug.chrome && window.Firebug.chrome.isInitialized) || widthThreshold || heightThreshold)) {
            if (!devtools.open || devtools.orientation !== orientation) {
                emitEvent(true, orientation);
            }

            devtools.open = true;
            devtools.orientation = orientation;
        } else {
            if (devtools.open) {
                emitEvent(false, null);
            }

            devtools.open = false;
            devtools.orientation = null;
        }
    }, 500);

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = devtools;
    } else {
        window.devtools = devtools;
    }
})();

setInterval(function () {
    if ($('body').hasClass('game-page') && window.devtools.open === true) {
        // location.href = 'index.php'
    }
}, 1000)