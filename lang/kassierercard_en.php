<?php
namespace GDO\KassiererCard\lang;
return [
	### Nav
	'link_kk_home' => 'KassiererCard.org',
	'link_kk_offers' => 'Cashier Offers',
	'link_kk_businesses' => 'Participating Stores',
	'link_kk_employees' => 'Store Employees',
	'link_kk_help' => 'Help / FaQ',
	'link_kk_partners' => 'Partners',
	
	### Buttons
	'btn_send_coupons' => 'Send Coupons',
	'btn_stopped_there' => 'I quit there!',
	'btn_working_there' => 'I am working there!',
	
	### Config
	'cfg_free_stars_period' => 'Free Stars per period.',
	
	### Admin
	'generate_signup_code' => 'Create Signup-Code',
	'signup_codes' => 'Signup-Codes',
	'mt_kassierercard_admincreatesignupcode' => 'Create Signup-Code',
	'list_kassierercard_adminsignupcodes' => '%s Signup-Codes',
	'msg_signup_code_created' => 'A signup code has been created.',
	
	### Types
	'kk_type' => 'Account Type',
	'kk_stars' => 'Bonus Points',
	'kk_cashier' => 'Cashier',
	'kk_company' => 'Company',
	'kk_customer' => 'Customer',
	'perm_kk_cashier' => 'Cashier',
	'perm_kk_company' => 'Company',
	'perm_kk_customer' => 'Customer',
	
	'coup_type' => 'Coupon Type',
	'coup_token' => 'Code',
	'tt_coup_type' => 'Choose your kashiercard coupon type<br/>.This',
	
	'lbl_choose_account_type' => 'Please choose your account type.',
	
	'num_biz' => 'Stores',
	'business' => 'Business',
	
	### Signup
	'kk_info_register' => 'We very welcome you on KassiererCard.org. Please tell us if you a customer, a cashier, or a company. Companies are our merchandize partners. Cashiers are the workers, Customers are... customers and can print coupons.',
	'lbl_choose_account_type' => 'Choos account type',
	'enum_customer' => 'Customer',
	'enum_cashier' => 'Cashier',
	'enum_partner' => 'Company',
	'lbl_kk_register_code' => 'Signup Code',
	'tt_kk_register_code' => 'A valid signup code is required if you signup as a Cashier or Company.',
	'err_kk_signup_code' => 'As a cashier, or company, you need a valid signup code.',
	
	'coupon_kind' => 'Kindness',
	'coupon_fast' => 'Quickness',
	'coupon_help' => 'Smartness',
	'tt_coupon_kind' => 'The collected badges of kindness. You can trade these for drinks.',
	'tt_coupon_fast' => 'The collected badges of quickness. You can trade these for food.',
	'tt_coupon_help' => 'The collected badges of smartness. You can trade these for auxilary products',
	
	### Methods
	'mt_kassierercard_welcome' => 'Welcome',
	'md_kassierercard_welcome' => 'Kassierercard is a bonus program for employees instead of customers.',
	
	'mt_kassierercard_partners' => 'Out Partners',
	'md_kassierercard_partners' => 'Participating partners of Kassierercard.org, the bonus system for employees.',
	
	'md_kassierercard_businesses' => 'This list is an overview of participating stores ordered by distance to you.',
	'list_kassierercard_businesses' => '%s participating stores',
	
	'md_kassierercard_rateemployee' => 'Send Coupons to an employee of your choice. You can send up to %s coupons per day.',
	
	'mt_kassierercard_workingthere' => 'Working There?',
	'md_kassierercard_workingthere' => 'Setup your store or workplace to be ranked under Kassierercard.org',
	'msg_kk_started_work' => 'You started to work at %s on %s.',
	'msg_kk_stopped_work' => 'You stopped to work at %s.',

	# Partners
	'list_kassierercard_partners' => '%s Partners',
	
	# Enter
	'enter_coupon' => 'Enter Coupon',
	
	# Offer 
	'create_offer' => 'Create Offer',
	'md_kassierercard_offers' => 'Show all available and historical coupon offers on KassiererCard.org.',
	'info_create_offer' => 'Create a new coupon type / offer.',
	'list_kassierercard_offers' => '%s Coupon Types',
	'err_kk_offer_timeout' => 'This offer did expire on %s.',
	
	# Print
	'mt_kassierercard_createcoupon' => 'Create Coupon',
	'kk_info_create_coupon' => 'In total you have created %s coupons with %s stars. In this period, you can print %s/%s more stars on coupons.',
	'generate_coupons' => 'Generate Coupons',
	'msg_coupon_created' => 'Your cashiercard coupon has been created.',
	'err_kk_create_stars' => 'You want to create %s stars, but you could only add %s more stars this period. You already created %s stars this period.',
	
	# Printed
	'printed_coupons' => 'Printed Coupons',
	'li_kk_coupon_fresh' => 'This coupon is fresh and can be printed.',
	'list_kassierercard_printedcoupons' => '%s Coupons ready',
	
	# Granted
	'granted_coupons' => 'Redeemed Coupons',

	# Employees
	'list_kassierercard_employees' => '%s Employees',
	'li_kk_working' => '%s is working at %s since %s.',
	'li_kk_working_sub' => 'They has collected %s bees, %s suns and %s stars.',

	# Biz
	'btn_biz_emplyoees' => '%s Employees',
	
	# Coupons
	'err_kk_offer_timeout' => 'This coupon\'s offer is expired and cannot be redeemed anymore.',
	'err_kk_offer_no_more_for_you' => 'You have redeemed %s of %s items for this offer. No more!',
	'kk_offer_status' => 'In total, %s of %s items have been redeemed. You may redeem this offer %s time(s).',
	
];
