<?php
namespace GDO\KassiererCard\lang;
return [
### Nav
'sitename' => 'KassiererCard.org',
### Config ###
##############
'cfg_free_stars_period' => 'Kostenlose Sterne pro Zeitraum.',
'grant_stars' => 'Sterne gewähren',
'mail_subj_kk_grant_stars' => '%s: %s Sterne vergeben',

Der Admin %s hat Ihnen %s Sterne für %s gewährt.

Gründe dafür.

Mit freundlichen Grüße,
Das %4$s-Team',

### Buttons
// 	'btn_send_coupons' => 'Send Coupons',
'btn_stopped_there' => 'Da habe ich aufgehört!',
'generate_signup_code' => 'Anmeldecode erstellen',
'register_as_customer' => 'als Kunde registrieren',
'kc_info' => 'Einladungsnotiz',
'msg_signup_customer_no_token' => 'Sie haben keinen Registrierungscode eingegeben und sind somit als Kunde registriert.<br/>Wenn Sie ein Arbeitnehmer oder ein Unternehmen sind, kontaktieren Sie uns bitte.<br/>Wenn Sie sich erneut anmelden, werden Sie möglicherweise gesperrt. ',
'err_kk_signup_code_required' => 'Sie benötigen einen Registrierungscode, es sei denn, Sie sind Kunde.',
'kk_type' => 'Kontotyp',
'kk_info_register' => 'Wir heißen Sie herzlich willkommen auf KassiererCard.org. Bitte teilen Sie uns mit, ob Sie ein Kunde, ein Kassierer oder ein Unternehmen sind. Unternehmen sind unsere Handelspartner. Kassierer sind die Arbeiter, Kunden sind... Kunden und können Coupons ausdrucken.',
'lbl_choose_account_type' => 'Kontotyp auswählen',

### Settings
'salary_gross' => 'Bruttogehalt',
'' => '',
'' => '',
'' => '',
'' => '',
// 	'stars_purchased' => 'Extra Stars',
// 	'stars_created' => 'Coupon-Stars Created',
// 	'tt_stars_created' => 'Number of star coupons printed and entered.Auch als Geschenk erstellte Sterne als Teammitglied.',
// 	'stars_entered' => 'Stars Entererd',
// 	'stars_available' => 'Stars Available',
// 	'stars_redeemed' => 'Stars Redeemed',
// 	'offers_redeemed' => 'Offers Redeemed',
// 	'offers_created' => 'Offers Created',
// 	'diamonds_earned' => 'Diamonds',
// 	'your_dream' => 'Your Dream',
// 	'qrcode_size' => 'QR-Code Size',

### Methods
'mt_kassierercard_welcome' => 'Willkommen',

'mt_kassierercard_workingthere' => 'Arbeiten Sie dort?',
'kc_partner' => 'Partner',
'info_kk_company_admin' => 'Hier erfahren Sie, wie Sie Partner von %s werden<br/>
Ihre Aufgabe ist es, Angebote für die Mitarbeiter und Kunden einzulösen.<br/>
Sie tun dies, indem Sie entweder QR-Codes scannen, eine Taste auf dem Mobiltelefon des Mitarbeiters drücken oder einen Code eingeben.<br/>
<br/>
Wir danken Ihnen sehr, dass Sie an diesem kleinen Projekt teilnehmen!<br/>
 - gizmore',

# Partner Edit
'mt_kassierercard_partneredit' => 'Ihre Anwesenheit hier bearbeiten',
Drücken Sie dazu im rechten Menü auf "Konto".<br/>
Wenn Sie Fragen oder Bedenken haben, <a href="%s">kontaktieren Sie uns bitte</a>.',

# Partner Offers
'list_kassierercard_partneroffers' => '%s Angebote',
'err_kk_customer_cannot_afford_offer' => 'Der Kunde %s kann Ihr Angebot nicht einlösen: %s',
'enter_coupon' => 'Gutschein eingeben',
'entered_coupons' => 'Eingegebene Gutscheine',
'kk_info_offers' => 'Hier finden Sie die verfügbaren Angebote in Ihrer Nähe.<br/>Angebote werden von unseren Partnern erstellt, Kunden drucken die Coupons aus und Mitarbeiter lösen sie ein.<br/>Für jeweils 5 eingelöste Coupons bekommt der Kunde auch einen Gutschein.',
'create_offer' => 'Angebot erstellen',
'err_kk_offer_no_more_for_you' => 'Du hast %s/%s von %s/%s Artikeln für dieses Angebot eingelöst. Nicht mehr für Sie verfügbar.',
'kk_offer_status' => 'Insgesamt wurden %s von %s Artikeln eingelöst. Sie können dieses Angebot %s Mal bis %s einlösen. Dieses Angebot kostet %s Gutscheinsterne.',

# Create Coupon
'create_coupon' => 'Gutschein erstellen',
'sel_coupon_offer' => 'Angebot auswählen',

# Print
'mt_kassierercard_printcoupon' => 'Gutschein drucken',
oder zeigen Sie Ihrem Mitarbeiter den QR-Code.',
'err_unknown_coupon' => 'Dieser Gutschein existiert nicht oder gehört nicht Ihnen.',
'err_print_sundays' => 'Sonntags können Sie keine Coupons drucken.<br/>
'your_ad_here' => 'Rückseite 100 % für Partner',
'printed_coupons' => 'Gedruckte Gutscheine',
'redeem_offer' => 'Angebot einlösen',
Bitte beachten Sie, dass Sie den Einlösevorgang nicht abbrechen können,
nachdem Sie hier auf die Schaltfläche gedrückt haben!',
'err_kk_offer_totaled' => 'Dieses Angebot ist abgeschlossen, da es %s/%s Mal eingelöst wurde.',
# Redeem Now
'msg_redeem_started' => 'Sie fordern das Angebot jetzt an!',

# Granted
'granted_coupons' => 'Eingelöste Gutscheine',
# Employees
'list_kassierercard_employees' => '%s Mitarbeiter',
# Biz
'owner' => 'Eigentümer',
# Coupons
'li_kk_coupon_entered' => 'Eingetragen am %s von %s.',
# The Team
'the_team' => 'Das Team',
'the_staff' => 'Das Personal',
'the_kk_manager' => 'Die Manager',
# Invite
'invite_users' => 'Personen einladen',
Wählen Sie außerdem die Anzahl der Sterne für Ihre Einladung,
und wenn die eingeladene Person aktiviert,
Sie erhalten den gleichen Betrag wie Diamanten zurück.
Sonst gehen deine Sterne verloren und werden zu Staub im Wind!<br/>
Derzeit sind Diamanten wertlos, außer für unsere Wettbewerbe.',
'msg_kk_sent_invitation' => 'Sie haben %s ausgegeben, um eine Einladung an %s zu senden. Außerdem sind %s Sterne Ihr Geschenk an sie, die in Diamanten umgewandelt werden, sobald sie sich anmelden.',

	# Mail Invite
	
	'mailsubj_kk_invite' => '%s: Einladung als %s',

Wir sind ein Prämiensystem (mehr) für Arbeitnehmer statt nur für die Kunden,
und sind unabhängig, bieten echte Waren an, wie einen Kaffee oder einen Döner.

Unsere Wechselkurse sind 1 Euro == %s Stern(e),

und %1$s (%s) schickt Ihnen %s Sterne als Willkommensgeschenk.

Wir haben derzeit %s attraktive lokale Angebote wie Kebab, einen Haarschnitt, CBD-Weed und mehr.

Besuchen Sie uns unter: %s

Mit freundlichen Grüße,
Das %3$s-System',
	
	# Mail Invite Diamonds
	
'mail_subj_kk_invited_diamonds' => '%s: %s hat sich uns angeschlossen!',
Ihre Investition von %s Sternen wird in %s Diamanten umgewandelt,
von denen Sie jetzt %s haben.

Ihr Benutzerlevel ist um %s Punkte auf %s gestiegen.

Mit freundlichen Grüßen,
Das %4$s Team',

	# Impressum
	'responsible_is' => 'Verantwortlich hierfür ist:',
	
];