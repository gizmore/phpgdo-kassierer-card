"use strict";

window.KC = {};

window.KC.tokenPress = function(event) {
	console.log('window.KC.tokenPress()', event);
//	debugger;
	var input = $(event.target);
	if (event.originalEvent.keyCode ===  13) {
		input.closest('input[type=submit]').click();
	}
	else {
		var next = input.next();
//		debugger;
		let tag = next.prop("tagName");
		if (tag === 'SPAN') {
			next = next.next();
		}
		if (!next.length) {
			setTimeout(function(){
				let text = input.val();
				text = text.slice(-1).toUpperCase();
				input.val(text);
//				input.closest('input[type=submit]').click();
			}, 10);
		}
		else {
			setTimeout(function(){
				next.focus();
				let text = event.originalEvent.key?.toUpperCase() || '';
				input.val(text);
			}, 10);
		}
	}
};

window.KC.enhanceCouponTokens = function() {
	$('.kc-coupon-token').each(function() {
		let cont = $(this);
		var hidden = cont.find('input');
		let config = hidden.hide().attr('data-config');
		let conf = JSON.parse(config);
		let code = conf.var||'                   '; 
		var len = conf.max;
//		let name = cont.find('input').hide().attr('name');
		for (let i = 0; i < len;) {
			for (let j = 0; j < 2; j++) {
				let input = $('<input gdo-focus-required autocomplete="off" class="kk-split-token" value=\"'+(code[i].trim())+'\" />');
				input.keypress(window.KC.tokenPress.bind(input));
				cont.append(input);
				i++;
			}
			if (i < len) {
				cont.append('<span class="dash">-</span>');
			}
		}
		cont.closest('form').submit(function() {
			debugger;
			var tok = '';
			$('.kk-split-token').each(function(){
				tok += this.value;
			});
			hidden.val(tok);
			return hidden.val().length === len;
		});
	});
	setTimeout(window.GDO.autofocusForm, 10);
};

$(function() {
	setTimeout(window.KC.enhanceCouponTokens, 10);
});
