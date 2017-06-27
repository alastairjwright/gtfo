(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var $holder = $(".holder");
var $scroll = $holder.find(".scroll");

var listWidth = $(window).outerWidth();
var endPos = $holder.width() - listWidth;

//TimelineMax
var infinite = new TimelineMax({repeat: -1, paused: false});
var time = 20;

infinite.fromTo($scroll, time, {left:0}, {left: -listWidth, ease: Linear.easeNone}, 0);
infinite.set($scroll, {left: listWidth});
infinite.to($scroll, time, {left: 0, ease: Linear.easeNone}, time);

//Pause/Play

$holder.on("mouseenter", function(){
	infinite.pause();
}).on("mouseleave", function(){
	infinite.play();
});

var $email = $('#mce-EMAIL');
var emailPlaceholder = $email.val();
inputInput();

function inputInput() {
	var size = $email.val().length;
	size = size < 1 ? 1 : size;

	$email.attr('size', size);
}

function inputFocus() {
	$email.val('');
	inputInput();
}

var lastValue = '';
function inputChange() {
	var val = $email.val();
	if (val.length < 1) {
		$email.val(emailPlaceholder)
	};
	lastValue = val;
	inputInput();
}


setInterval(function() {
    if ($email.val() != lastValue) {
        lastValue = $email.val();
    }
}, 500);

$email.on('input', inputInput)
	.on('focus', inputFocus)
	.on('change focusout', inputChange);

$('#infoButton').on('click', function () {
	$('#infoBackground').addClass('show');
});

$('#infoBackground').on('click', function () {
	$('#infoBackground').removeClass('show');
});
},{}]},{},[1])

//# sourceMappingURL=bundle.js.map
