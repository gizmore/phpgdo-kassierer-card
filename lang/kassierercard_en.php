<?php
namespace GDO\KassiererCard\lang;

return [
	'module_kassierercard' => 'Cashier-Card',
	### Nav
	'sitename' => 'KassiererCard.org',
	'link_kk_home' => 'KassiererCard.org',
	'link_kk_offers' => '%s Offers',
	'link_kk_companys' => '%s Partners',
	'link_kk_statistics' => '%s Statistics',
	'link_kk_favorites' => '%s Favorites',
	'link_kk_competitions' => '%s Competitions',
	'link_kk_businesses' => '%s Employers',
	'link_kk_employees' => '%s Employees',
	'link_kk_team' => '%s Team Members',
	'link_kk_help' => 'Help / FaQ',
	'link_kk_company_page' => 'Partner Pages',
	'link_kk_company_edit' => 'Edit',
	'link_kk_company_enter' => 'Enter Offer Code',
	'link_kk_company_scans' => 'Scan Offer Code',
	'link_kk_company_offers' => 'Your Offers',
	'kk_admin' => 'KC-Staff',

	##############
	### Config ###
	##############
	'cfg_free_stars_period' => 'Free Stars per period',
	'cfg_token_request_amt' => 'Coupons Entering: Tries',
	'cfg_token_request_time' => 'Coupons Entering: Timeout',
	# Global Site Stats
	'cfg_diamonds_created' => 'Diamonds Created',
	'cfg_diamonds_earned' => 'Diamonds Earned',
	'cfg_coupons_created' => 'Coupons Created',
	'cfg_coupons_entered' => 'Coupons Entered',
	'cfg_coupons_printed' => 'Coupons Printed',
	'cfg_coupons_redeemed' => 'Coupons Redeemed',
	'cfg_stars_available' => 'Stars Available',
	'cfg_stars_created' => 'Stars Created',
	'cfg_stars_earned' => 'Stars Earned',
	'cfg_stars_entered' => 'Stars Entered',
	'cfg_stars_invited' => 'Stars Invited',
	'cfg_stars_purchased' => 'Stars Purchased',
	'cfg_stars_redeemed' => 'Stars Redeemed',
	'cfg_offers_created' => 'Offers Created',
	'cfg_offers_redeemed' => 'Offers Redeemed',
	'cfg_offers_fullfilled' => 'Offers Fullfilled',
	'cfg_euros_invested' => 'Euros Invested',
	'cfg_euros_generated' => 'Euros Generated',
	'cfg_euros_earned' => 'Euros Gathered',
	'cfg_euros_donated' => 'Euros Donated',
	'cfg_euros_revenue' => 'Euros Revenue',
	'cfg_users_invited' => 'Users Invited',
	# Profile settings
	'cfg_your_dream' => '',
	# Tooltips Stats
	'tt_cfg_diamonds_created' => 'Companies create Diamonds by fulfilling Offers.',
	'tt_cfg_diamonds_earned' => 'Customers and Cashiers earn Diamonds by Invitations.',
	'tt_cfg_coupons_created' => 'Customers create Coupons for the Cashiers.',
	'tt_cfg_coupons_entered' => 'Cashiers enter Coupons to earn stars. Customers gain Diamonds and Stars for that.',
	'tt_cfg_coupons_printed' => 'Customers print Coupons for the Cashiers.',
	'tt_cfg_coupons_redeemed' => 'Customers and Cashiers redeem Coupons.',
	'tt_cfg_stars_available' => 'Stars can be used to redeem Offers.',
	'tt_cfg_stars_created' => 'Customers can create Coupons with Stars.',
	'tt_cfg_stars_purchased' => 'Customers can purchase Stars with real money.',
	'tt_cfg_stars_redeemed' => 'Stars Redeemed',
	'tt_cfg_offers_created' => 'Offers Created',
	'tt_cfg_offers_redeemed' => 'Offers Redeemed',
	'tt_cfg_offers_fullfilled' => 'Offers Fullfilled',
	'tt_cfg_euros_invested' => 'Total Euro Invested',
	'tt_cfg_euros_fullfilled' => 'Total Euro wealth generated',
	'tt_cfg_euros_donated' => 'Total amount of Euro donated, from Members to KC.org.',
	'tt_cfg_euros_earned' => 'Total worth of Euros gathered.',
	'tt_cfg_euros_revenue' => 'Total Euro revenue for the KassiererCard.org.',
	# Tooltips Config
	'tt_cfg_token_request_time' => 'Duration: how much time for blocking coupon tokens?',

	### AdminGrantStars
	'grant_stars' => 'Grant Stars',
	'msg_stars_granted' => 'You granted %s stars to %s. An email has been sent to them.',
	'mail_subj_kk_grant_stars' => '%s: %s Stars Granted',
	'mail_body_kk_grant_stars' => '
Dear %s

The Admin %s has granted you %s stars on %s.

Reason: %s.

Kind Regards,
The %4$s Team',

	### Buttons
// 	'btn_send_coupons' => 'Send Coupons',
	'btn_stopped_there' => 'I quit there!',
	'btn_working_there' => 'I am working there!',

	### Admin Signup Codes
	'generate_signup_code' => 'Create Signup-Code',
	'signup_codes' => 'Signup-Codes',
	'register_as_customer' => 'registrieren as a customer',
	'mt_kassierercard_admincreatesignupcode' => 'Create Signup-Code',
	'list_kassierercard_adminsignupcodes' => '%s Signup-Codes',
	'msg_signup_code_created' => 'A signup code for a %s has been created.',
	'err_kk_no_coupon' => 'You cannot create coupons this way!',
	'kk_invite_slogan' => 'Invitation as a %s',
	'msg_signup_stars' => 'Welcome on %s. You have earned %s stars with your invitation and now have %s.',
	'kc_info' => 'Invitation Note',
	'kc_entered' => 'Entered at',

	# Signup
	'msg_signup_customer_no_token' => 'You did not enter a Signup-Code and thus are registered as customer.<br/>If you are a worker or company, please contact us.<br/>If you signup again you might get banned.',
	'err_kk_signup_code_required' => 'You need a Signup-Code unless you are a customer.',

	# Free
	'msg_kk_free_customer_stars' => 'You received %s Stars for today.',

	### Types
	'kk_type' => 'Account Type',
	'kk_stars' => 'KC Stars',
// 	'kk_team' => 'Team Member',
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
	'kc_enterer' => 'Entered',
	'offers' => 'Offers',
	'offers_available' => 'Offers available',
	'favorite_meal' => 'Favorite Meal',
	'favorite_movie' => 'Favorite Movie',
	'favorite_song' => 'Favorite Song',
	'favorite_website' => 'Favorite Website',
	'num_biz' => 'Stores',
	'profession' => 'Profession',
	'personal_website' => 'Own Website',
	'tt_offers_available' => 'The amount of offers available for you.',

	### Signup
	'kk_info_register' => 'We very welcome you on KassiererCard.org. Please tell us if you a customer, a cashier, or a company. Companies are our merchandize partners. Cashiers are the workers, Customers are... customers and can print coupons.',
	'lbl_choose_account_type' => 'Choos account type',
	'enum_customer' => 'Customer',
	'enum_cashier' => 'Cashier',
	'enum_partner' => 'Company',
	'lbl_kk_register_code' => 'Signup Code',
	'tt_kk_register_code' => 'A valid signup code is required if you signup as a Cashier or Company.',
	'err_kk_signup_code' => 'As a cashier, or company, you need a valid signup code.',
	'err_kk_signup_code_unknown' => 'The signup-code you entered is unknown.',
	'err_kk_signup_code_type' => 'Wrong Account Type!. Your Signup-Code is only for a %s.',

	### Settings
	'salary_gross' => 'Gross Salary',
	'salary_hourly' => 'Hourly Rate',
	'favorite_artist' => 'Favorite Artist',
	'favorite_book' => 'Favorite Book',
	'your_dream' => 'Your Dream',
	'favorite_religion' => 'Favorite Religion',
// 	'qrcode_size' => 'QR-Code Size',

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
	'kc_partner' => 'Partner',
	'create_company' => 'Create Partner',
	'list_kassierercard_partners' => '%s Partners',
	'kk_info_partners_table' => 'Merchandize partners offer their goods in exchange for coupons.',
	'footer_partner' => 'You can contact this partner via %s.',
	'footer_partner_offers' => 'This partner has <a href="%s">%s offers</a>.',

	# Partner Page
	'info_kk_company_admin' => 'Here you can learn about being a Partner of %s<br/>
You can setup your own little web-page, like on myspace.<br/>
Your job is to redeem offers for the workers and customers.<br/>
You do so by either scanning QR-Codes, press a button on the worker\'s mobile phone, or entering a code.<br/>
<br/>
We thank you very much for joining this little project!<br/>
 - gizmore',

	# Partner Edit
	'mt_kassierercard_partneredit' => 'Edit Your Presence Here',
	'kk_info_partner_edit' => 'Here you can edit your partner details on %s.<br/>
You can also <a href="%s">edit your profile</a>.
To do so, press &quot;Account&quot; in the right menu.<br/>
If you have questions or concerns, please <a href="%s">contact us</a>.',

	# Partner Offers
	'list_kassierercard_partneroffers' => '%s Offers',

	# PartnerScansOffer
	'err_kk_customer_cannot_afford_offer' => 'The customer %s cannot redeem your offer: %s',
	'err_kk_redeem_hashcode' => 'The hashcode is invalid.<br/>Read the GDOv7 Documentation for how to crack hashcodes.',

	# Enter
	'enter_coupon' => 'Enter Coupon',
	'err_kk_coupon_unknown' => 'This coupon is unknown or has been entered already.',
	'msg_entered_stars' => 'Your entered code is valid and you earned %s stars.',
	'err_kk_coupon_used' => 'The code you entered was already entered.',
	'err_kc_token_tries' => 'You enter too much codes too quickly. Please wait %s.',

	# Entered
	'entered_coupons' => 'Entered Coupons',
	'list_kassierercard_enteredcoupons' => '%s Entered Coupons',

	# Offer
	'kk_info_offers' => 'Here you can find the available offers in your area.<br/>Offers are created by our partners, customers print the coupons and employees redeem them.<br/>For every 5 redeemed coupons, the customer gets a coupon as well.',
	'create_offer' => 'Create Offer',
	'md_kassierercard_offers' => 'Show all available and historical coupon offers on KassiererCard.org.',
	'info_create_offer' => 'Create a new coupon type / offer.',
	'list_kassierercard_offers' => '%s Coupon Types',
	'err_kk_offer_timeout' => 'This coupon\'s offer expired on %s and cannot be redeemed anymore.',
	'err_kk_offer_afford' => 'You cannot afford to redeem this. The offer needs %s stars and you have only %s available.',
	'err_kk_offer_no_more_for_you' => 'You have redeemed %s/%s of %s/%s items for this offer. No more available for you.',
	'kk_offer_status' => 'In total, %s of %s items have been redeemed. You may redeem this offer %s time(s) until %s. This offer cost %s coupon stars.',

	# Create Coupon
	'create_coupon' => 'Create Coupon',
	'generate_coupons' => 'Generate Coupons',
	'kk_info_create_coupon' => 'Select the amount of stars, you have %s, for your coupon.<br/>Optionally, select an offer for the backside.',
	'sel_coupon_offer' => 'Select Offer',
	'tt_create_offer' => 'Create a Coupon for this Offer to share with your local workers.',
	'msg_coupon_created' => 'Your cashiercard coupon has been created.',
	'err_kk_create_stars' => 'You want to create %s stars, but you could only add %s more stars this period. You already created %s stars this period.',

	# Print
	'back_side' => 'Back-Side',
	'front_side' => 'Front-Side',
	'mt_kassierercard_printcoupon' => 'Print Coupon',
	'btn_qrcode' => 'QR-Code',
	'kk_info_print_coupon' => 'Print one of your coupons.<br/>
Either send it to your printer, write the code down manually,
or show your worker the QR code.',
	'err_unknown_coupon' => 'This Coupon does not exist or is not yours.',
	'msg_kk_enter_auth' => 'You are not authenticated.<br/>
Please login and try again.',
	'err_print_sundays' => 'You cannot print coupons on sunday.<br/>
You can try again tommorow.',
	'your_ad_here' => 'Backside 100% for Partners',
	'link_preview_enter_coupon' => 'Coupon URL',

	# Printed
	'printed_coupons' => 'Printed Coupons',
	'li_kk_coupon_fresh' => 'This coupon is fresh and can be printed.',
	'li_kk_coupon_printed' => 'This coupon was printed on %s.',
	'list_kassierercard_printedcoupons' => '%s Coupons ready',

	# Redeem
	'redeem_offer' => 'Redeem Offer',
	'all_offers' => 'all offers',
	'kk_info_redeem_offer' => 'Here you can redeem an Offer.<br/>
You can find %s on the left menu.<br/>
Please note, that you cannot abort the redeem process,
after you press the button here!',
	'err_kk_offer_totaled' => 'This offer is completed as it got redeemed %s/%s times.',

	# Redeem Now
	'msg_redeem_started' => 'You are claiming the offer now!',
	'kk_info_redeem_offer_now' => 'You <b>either</b>
let the worker at %s press the OK button,
or you press the QR-Code button and let the worker scan it.<br/>
Either way, there is no way back,
when you are claiming the offer!',
	'msg_redeem aborted' => 'You have aborted the process.',

	# Partner Redeem
	'mt_kassierercard_partnerredeemqrcode' => 'Scan Redeem Code',
	'kk_info_redeem_qr' => 'As a partner, scan a customers QR-Code here.',

	# Redeem O.K.
	'kk_info_redeem_offer_ok' => 'Let the worker at %s press the button now!',
	'msg_offer_redeemed_ok' => 'You have officially redeemed this offer: %s.<br/>If this is an error: bad luck!',

	# Granted
	'granted_coupons' => 'Redeemed Coupons',

	# Employees
	'list_kassierercard_employees' => '%s Employees',
	'li_kk_working' => '%s is working at %s since %s.',
	'li_kk_working_sub' => 'They has collected %s stars and redeemed %s offers.',

	# Biz
	'owner' => 'Owner',
	'create_business' => 'Create Employer',
	'kk_info_crud_business' => 'Here you can add a new business with cashiers.<br/>You maybe want to %s first.',
	'biz_participating' => 'Official Employer since',
	'biz_declining' => 'Declined us at',
	'btn_biz_emplyoees' => '%s Employees',

	# Coupons
	'li_kk_coupon_entered' => 'Entered on %s by %s.',

	# The Team
	'the_team' => 'The Team',
	'the_team_paragraph' => 'This page is dedicated to the %s Team Members.<br/>Hello!',
	'the_admins' => 'The Admins',
	'the_admins_paragraph' => '%s Admins have access to everything. Do not trust them!',
	'the_staff' => 'The Staff',
	'the_staff_paragraph' => '%s Staff members have access to almost everything. They censor the spam and get lots of email. Do not trust them!',
	'the_kk_manager' => 'The Managers',
	'the_kk_manager_paragraph' => '%s Managers supply the distributors with printed cards and flyers.',
	'the_kk_distributor' => 'The Managers',
	'the_kk_distributor_paragraph' => '%s Distributords do merchandize work and play test customer.',

	# Invite
	'invite_users' => 'Invite People',
	'kk_info_invite_stars' => 'Here you can invite more people to %s.
It cost %s/%s stars to send an invitation.<br/>
Additionally, select the number of stars for your invitation,
and when the invited person activates,
you get diamonds as reward.
Else your stars are lost and become dust in the wind!',
	'msg_kk_sent_invitation' => 'You have spent %s stars to send an invitation to %s. Additionally, %s stars are your gift to them, which will get converted to diamonds as soon as they sign up with us.',
	'mailsubj_kk_invite' => '%s: Invitation as %s',
	'mailbody_kk_invite' => 'Hello Dear future User,

%s has invited you as a %s on %s.

We are a bonus system (more) for workers instead only the customers,
and are indipendant, offer real goods, like a coffee or a kebab.

Our exchange rates are 1 Euro == %s Star(s),

and %1$s (%s) sends you %s stars as a welcome gift.

We currently have %s attractive local offers, like kebab, a haircut, CBD weed and more.

Check us out at: %s

Kind Regards,
The %3$s System',

	'mail_subj_kk_invited_diamonds' => '%s: %s joined us!',
	'mail_body_kk_invited_diamonds' => 'Dear %s,

%s (%s) has followed your invitation towards %s and just got activated.
You get your investment of %s stars turned into %s diamonds,
from which you have %s now.

Your userlevel increased by %s points to %s.

Kind Regards,
The %4$s Team',

	# Impressum
	'responsible_is' => 'Responsible for this is:',

	# Privacy
	'kk_info_privacy_div' => 'KassiererCard.org saves your IP for some time.',

	# Welcome PM
	'pm_welcome_title' => 'Welcome to %s',
	'pm_welcome_message' => 'Hello %s,
<br/>
Welcome to %s,<br/>
the bonus system that goes the other way round,<br/>
upside down, and head over heels!<br/>
<br/>
The site is brand new,
and we can quickly implement and change features.<br/>
Please help us to give more meaning to the people and nature,
instead of money.<br/>
<br/>
 - gizmore!',

	# Redeem Mails
	'mailsubj_redeemed_staff' => '%s: Offer redeemed',
	'mailbody_redeemed_staff' => 'Hello %s,
	
The user %s just redeemed the following offer:
	
%s - %s

This offer has been redeemed %s/%s times now.
	
We just let you know
The %s System',

	'mailsubj_redeemed_user' => '%s: Offer redeemed',
	'mailbody_redeemed_user' => 'Hello %s,
	
You just redeemed %s stars for the following offer:

%s - %s

You now have %s stars left.

Sincerly,
The %s System',

	'mailsubj_redeemed_partner' => '%s: Offer redeemed',
	'mailbody_redeemed_partner' => 'Hello %s,
	
The user %s just redeemed one of your offers:

%s - %s

This offer has been redeemed %s/%s times now.
	
Sincerly,
The %s System',

	# Entered stars
	'mail_subj_customer_stars' => '%s: %s stars earned',
	'mail_body_customer_stars' => 'Hello %s,

The user %s has just entered your coupon of %s stars.
This earned you %s stars as well.

Well Done!
The %s System',

	# Competitions
	'enum_cashier-of-the-week' => 'Cashier of the Week',
	'enum_cashier-of-the-month' => 'Cashier of the Month',
	'enum_cashier-of-the-year' => 'Cashier of the Year',
	'enum_customer-of-the-week' => 'Customer of the Week',
	'enum_customer-of-the-month' => 'Customer of the Month',
	'enum_customer-of-the-year' => 'Customer of the Year',
	'enum_company-of-the-week' => 'Company of the Week',
	'enum_company-of-the-month' => 'Company of the Month',
	'enum_company-of-the-year' => 'Company of the Year',
	'enum_business-of-the-week' => 'Business of the Week',
	'enum_business-of-the-month' => 'Business of the Month',
	'enum_business-of-the-year' => 'Business of the Year',
	'enum_offer-of-the-week' => 'Offer of the Week',
	'enum_offer-of-the-month' => 'Offer of the Month',
	'enum_offer-of-the-year' => 'Offer of the Year',

	'competition_table' => '%s; %s entries; Page %s/%s',

	# Favorites
	'mt_kk_favorites' => 'Favorite %s',
	'tt_kk_favorites' => '%s favorite &quot;%s&quot; setings',
	'md_kk_favorites' => 'The %s favorite %s on %s. Real user content, Real opinions on your favorite %2$s.',

	# Granted Coupons
	'list_kassierercard_grantedcoupons' => '%s Eingegebene Coupons',
	'md_kassierercard_grantedcoupons' => 'Übersicht ihrer erstellten Coupons, welche eingegben wurden.',

	# ToDo
	'mt_kassierercard_todo' => 'ToDo',

	# Team
	'mt_kassierercard_team' => 'Team',

	# Statistics
	'kk_info_statistics' => 'stats',
];
