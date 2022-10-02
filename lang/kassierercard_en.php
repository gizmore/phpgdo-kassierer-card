<?php
namespace GDO\KassiererCard\lang;
return [
	### Nav
	'sitename' => 'KassiererCard.org',
	'link_kk_home' => 'KassiererCard.org',
	'link_kk_offers' => '%s Offers',
	'link_kk_partners' => '%s Partners',
	'link_kk_businesses' => '%s Employers',
	'link_kk_employees' => '%s Employees',
	'link_kk_team' => '%s Team Members',
	'link_kk_help' => 'Help / FaQ',
	'kk_admin' => 'KC-Staff',
	
	### Buttons
	'btn_send_coupons' => 'Send Coupons',
	'btn_stopped_there' => 'I quit there!',
	'btn_working_there' => 'I am working there!',
	
	### Config
	'cfg_free_stars_period' => 'Free Stars per period.',
	
	### Admin Signup Codes
	'generate_signup_code' => 'Create Signup-Code',
	'signup_codes' => 'Signup-Codes',
	'mt_kassierercard_admincreatesignupcode' => 'Create Signup-Code',
	'list_kassierercard_adminsignupcodes' => '%s Signup-Codes',
	'msg_signup_code_created' => 'A signup code for a %s has been created.',
	'err_kk_no_coupon' => 'You cannot create coupons this way!',
	'kk_invite_slogan' => 'Invitation as a %s',
	
	### Types
	'kk_type' => 'Account Type',
	'kk_stars' => 'Bonus Points',
	'kk_coupon' => 'Coupon',
	'kk_cashier' => 'Cashier',
	'kk_company' => 'Company',
	'kk_customer' => 'Customer',
	'perm_kk_cashier' => 'Cashier',
	'perm_kk_company' => 'Company',
	'perm_kk_customer' => 'Customer',
	'perm_kk_distributor' => 'Distributor',
	'perm_kk_manager' => 'Manager',
	
	'lbl_choose_account_type' => 'Please choose your account type.',
	
	'business' => 'Business',
	'partner' => 'Partner',
	'slogan' => 'Slogan',
	'kc_token' => 'Code',
	'kc_offer' => 'Coupon Offer',
	'offers' => 'Offers',
	'coupons_available' => 'Coupons available',
	'coupons_created' => 'Coupons created',
	'coupons_entered' => 'Coupons entered',
	'coupons_redeemed' => 'Coupons redeemed',
	'favorite_meal' => 'Favorite Meal',
	'favorite_movie' => 'Favorite Movie',
	'favorite_song' => 'Favorite Song',
	'favorite_website' => 'Favorite Website',
	'num_biz' => 'Stores',
	'offers_taken' => 'Offers taken',
	'profession' => 'Profession',
	'personal_website' => 'Own Website',
	'tt_coupons_created' => 'Only customers can create coupons.',
	'tt_coupons_available' => 'You can spend these coupons on offers.',
	
	### Signup
	'kk_info_register' => 'We very welcome you on KassiererCard.org. Please tell us if you a customer, a cashier, or a company. Companies are our merchandize partners. Cashiers are the workers, Customers are... customers and can print coupons.',
	'lbl_choose_account_type' => 'Choos account type',
	'enum_customer' => 'Customer',
	'enum_cashier' => 'Cashier',
	'enum_partner' => 'Company',
	'lbl_kk_register_code' => 'Signup Code',
	'tt_kk_register_code' => 'A valid signup code is required if you signup as a Cashier or Company.',
	'err_kk_signup_code' => 'As a cashier, or company, you need a valid signup code.',

	### Settings
	'stars_purchased' => 'Extra Stars',
	'stars_purchased_total' => 'Stars Purchased',
	'stars_created' => 'Coupon-Stars Created',
	'stars_entered' => 'Stars Earned',
	'stars_available' => 'Stars Available',
	'stars_redeemed' => 'Stars Redeemed',
	'offers_redeemed' => 'Offers Redeemed',
	'offers_created' => 'Offers Created',
	'your_dream' => 'Your Dream',
	'qrcode_size' => 'QR-Code Size',
	
	### Methods
	'mt_kassierercard_welcome' => 'Welcome',
	'md_kassierercard_welcome' => 'KassiererCard is a bonus program for employees instead of customers.',
	
	'mt_kassierercard_partners' => 'Our Partners',
	'md_kassierercard_partners' => 'Partners of KassiererCard.org, the bonus system for employees.',
	
	'md_kassierercard_businesses' => 'This list is an overview of participating businesses ordered by distance to you.',
	'list_kassierercard_businesses' => '%s Businesses',
	
	'md_kassierercard_rateemployee' => 'Send Coupons to an employee of your choice. You can send up to %s coupons per day.',
	
	'mt_kassierercard_workingthere' => 'Working There?',
	'md_kassierercard_workingthere' => 'Setup your store or workplace to be ranked under KassiererCard.org',
	'msg_kk_started_work' => 'You started to work at %s on %s.',
	'msg_kk_stopped_work' => 'You stopped to work at %s.',

	# Partners
	'list_kassierercard_partners' => '%s Partners',
	'kk_info_partners_table' => 'Merchandize partners offer their goods in exchange for coupons.',
	'footer_partner' => 'You can contact this partner via %s.',
	'footer_partner_offers' => 'This partner has <a href="%s">%s offers</a>.',
	
	# Enter
	'enter_coupon' => 'Enter Coupon',
	'err_kk_coupon_unknown' => 'This coupon is unknown or has been entered already.',
	
	# Entered
	'entered_coupons' => 'Entered Coupons',
	
	# Offer
	'kk_info_offers' => 'Here you can find the available offers in your area.<br/>Offers are created by our partners, customers print the coupons and employees redeem them.<br/>For every 5 redeemed coupons, the customer gets a coupon as well.',
	'create_offer' => 'Create Offer',
	'md_kassierercard_offers' => 'Show all available and historical coupon offers on KassiererCard.org.',
	'info_create_offer' => 'Create a new coupon type / offer.',
	'list_kassierercard_offers' => '%s Coupon Types',
	'err_kk_offer_timeout' => 'This coupon\'s offer expired on %s and cannot be redeemed anymore.',
	'err_kk_offer_no_more_for_you' => 'You have redeemed %s of %s items for this offer. No more available for you.',
	'kk_offer_status' => 'In total, %s of %s items have been redeemed. You may redeem this offer %s time(s) until %s. This offer cost %s coupon stars.',
	
	# Create Coupon
	'create_coupon' => 'Create Coupon',
	'generate_coupons' => 'Generate Coupons',
	'kk_info_create_coupon' => 'Select your %s and the number of stars for your coupon.<br/>In total you have created %s coupons with %s stars. In this period, you can print %s/%s more stars on coupons in this period. This period goes from %s to %s.',
	'sel_coupon_offer' => 'Select Offer',
	'tt_create_offer' => 'Create a Coupon for this Offer to share with your local workers.',
	'msg_coupon_created' => 'Your cashiercard coupon has been created. You gained %s experience and levelup to level %s.',
	'err_kk_create_stars' => 'You want to create %s stars, but you could only add %s more stars this period. You already created %s stars this period.',
	
	# Redeem Coupon
	'redeem_coupon' => 'Redeem Coupon',
	'kk_info_redeem_offer' => 'Here you can claim an offer. Make sure you have earned enough stars and follow the instructions.',
	
	# Print
	'mt_kassierercard_printcoupon' => 'Print Coupon',
	'btn_qrcode' => 'QR-Code',
	'kk_info_print_coupon' => 'Print one of your coupons.<br/>Either send it to your printer, write the code down manually, or show your worker the QR code.',
	'err_unknown_coupon' => 'This Coupon does not exist or is not yours.',
	'msg_kk_enter_auth' => 'You are not authenticated. Please login and try again.',
	'err_print_sundays' => 'You cannot print coupons on sunday. You can try again tommorow.',
	'your_ad_here' => 'Backside 100% for Partners',
	
	# Printed
	'printed_coupons' => 'Printed Coupons',
	'li_kk_coupon_fresh' => 'This coupon is fresh and can be printed.',
	'list_kassierercard_printedcoupons' => '%s Coupons ready',
	
	'redeem_offer' => 'Redeem Offer',
	
	# Granted
	'granted_coupons' => 'Redeemed Coupons',

	# Employees
	'list_kassierercard_employees' => '%s Employees',
	'li_kk_working' => '%s is working at %s since %s.',
	'li_kk_working_sub' => 'They has collected %s stars and redeemed %s offers.',

	# Biz
	'btn_biz_emplyoees' => '%s Employees',
	
	# Coupons

	# The Team
	'the_team' => 'The Team',
	'the_team_paragraph' => 'This page is dedicated to the %s Team Members.<br/>Hello!',
	'the_admins' => 'The Admins',
	'the_admins_paragraph' => '%s Admins have access to everything. Do not trust them!',
	'the_staff' => 'The Staff',
	'the_staff_paragraph' => '%s Staff members have access to almost everything. They censor the spam and get lots of email. Do not trust them!',
	
];
