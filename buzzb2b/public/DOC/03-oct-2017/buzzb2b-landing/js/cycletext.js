// Uses CommonJS, AMD or browser globals to create a jQuery plugin.
(function (factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    // Node/CommonJS
    module.exports = function( root, jQuery ) {
      if ( jQuery === undefined ) {
        // require('jQuery') returns a factory that requires window to
        // build a jQuery instance, we normalize how we use modules
        // that require this pattern but the window provided is a noop
        // if it's defined (how jquery works)
        if ( typeof window !== 'undefined' ) {
          jQuery = require('jquery');
        }
        else {
          jQuery = require('jquery')(root);
        }
      }
      factory(jQuery);
      return jQuery;
    };
  } else {
    // Browser globals
    factory(jQuery);
  }
}(function ($) {
  $.fn.cycleText = function (selector, quotes, options){
    var self = this;
    if (typeof selector === "object"){
      options = quotes;
      quotes = selector;
    }
    if (typeof selector === "string"){
      selector = document.querySelector(selector);
    }

    // browsers change setIntervals and requestAnimationFrames when the tab isn't active; this section will help us deal with that
    var hidden, visibilityChange;
    if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support
      hidden = "hidden";
      visibilityChange = "visibilitychange";
    } else if (typeof document.mozHidden !== "undefined") {
      hidden = "mozHidden";
      visibilityChange = "mozvisibilitychange";
    } else if (typeof document.msHidden !== "undefined") {
      hidden = "msHidden";
      visibilityChange = "msvisibilitychange";
    } else if (typeof document.webkitHidden !== "undefined") {
      hidden = "webkitHidden";
      visibilityChange = "webkitvisibilitychange";
    }

    function handleVisibilityChange() {
      if (document[hidden]) {
        return;
      }
      else {
        displayQuote();
      }
    }

    document.addEventListener(visibilityChange, handleVisibilityChange, false);

    // default settings
    var settings = {
      fadeInSpeed: 2000,
      displayDuration: 7000,
      fadeOutSpeed: 2000,
      delay: 0,
      element: "p"
    };
    // adopts user-defined settings
    if (typeof options === "object"){
      for (var option in options){
        settings[option] = options[option];
      }
    }

    // creates elements for the quote to reside in
    quotes.forEach(function(quote, i){
      var el = document.createElement(settings.element);
      el.innerHTML = quote;
      el.style.display = "none";
      el.id = "cycletext" + i;
      self[0].appendChild(el);
    });

    // non-jQuery fadeIn
    function fadeIn(el, time) {
      el.style.display = "block";
      el.style.opacity = 0;
      var last = Date.now();
      var tick = function() {
        el.style.opacity = +el.style.opacity + (Date.now() - last) / time;
        last = Date.now();
        if (+el.style.opacity <= 1) {
          (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
        }
      };
      tick();
    }

    // non-jQuery fadeOut
    function fadeOut(el, time) {
      var last = Date.now();
      var tick = function() {
        el.style.opacity = +el.style.opacity - (Date.now() - last) / time;
        last = Date.now();
        if (+el.style.opacity > 0) {
          (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
        }
        if (el.style.opacity <= 0){
          el.style.display = "none";
        }
      };
      tick();
    }

    // displays each quote in sequence
    var i = 0;
    function displayQuote(){
      var el = document.getElementById("cycletext" + i);
      fadeIn(el, settings.fadeInSpeed);
      // sets duration of fadeout AND duration to display quote
      var fadeOutTimer = setTimeout(function(){
        fadeOut(el, settings.fadeOutSpeed);
        i++;
        // resets counter
        if (i === quotes.length){
          i = 0;
        }
      }, settings.displayDuration);
      // sets duration between initiating the display of a quote and the next initiation of displaying a quote
      var fadeInTimer = setTimeout(function(){
        clearTimeout(fadeOutTimer);
        // recursively calls the displayQuote function
        if (document[hidden]) {
          el.style.display = "none";
          return;
        }
        else {
          displayQuote();
        }
      }, settings.fadeOutSpeed + settings.displayDuration + settings.delay);
    }
    displayQuote();
  };
  return this;
}));

