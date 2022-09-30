"use strict";

window.KC = {};

window.KC.enhanceCouponTokens = function() {
	$('.kc-coupon-token').each(function() {
		let cont = $(this);
//		let conf = cont.attr('data-config');
		conf = {length:10}; 
		let name = cont.find('input').hide().attr('name');
		for (let i = conf.length; i >= 0; i--)  {
			cont.prepend('<input name="'+name+'_'+i+'" />');
		}
	});
};

$(function() {
	window.KC.enhanceCouponTokens();
})

