<?php
namespace GDO\KassiererCard\lang;
return [
	'module_kassierercard' => 'KassiererCard',
### Nav
	'sitename' => 'KassiererCard.org',
	'kk_link_todo' => 'ToDo',
##############
	
### Config ###
	
##############
	'cfg_free_stars_period' => 'Kostenlose Sterne pro Tag',
# Global Site Stats
	'cfg_diamonds_created' => 'Erstellte Diamanten',
# Tooltips Stats
	'tt_cfg_diamonds_created' => 'Unternehmen schaffen Diamanten, indem sie Angebote erfüllen.',
	'tt_cfg_coupons_printed' => 'Kunden drucken Coupons für die Kassierer aus.',
# Tooltips Config
	'tt_cfg_token_request_time' => 'Dauer: wie viel Zeit zum Sperren von Coupon-Token?',
### AdminGrantStars
	'grant_stars' => 'Sterne gewähren',
	'mail_subj_kk_grant_stars' => '%s: %s Sterne vergeben',

Der Admin %s hat Ihnen %s Sterne für %s gewährt.

Gründe dafür.

Mit freundlichen Grüße,
Das %4$s-Team',

	
### Buttons
	
// 	'btn_send_coupons' => 'Send Coupons',
	'btn_stopped_there' => 'Da habe ich aufgehört!',
### Admin Signup Codes
	'generate_signup_code' => 'Anmeldecode erstellen',
	'kc_info' => 'Einladungsnotiz',
# Signup
	'msg_signup_customer_no_token' => 'Sie haben keinen Registrierungscode eingegeben und sind somit als Kunde registriert.<br/>Wenn Sie ein Arbeitnehmer oder ein Unternehmen sind, kontaktieren Sie uns bitte.<br/>Wenn Sie sich erneut anmelden, werden Sie möglicherweise gesperrt. ',
	'err_kk_signup_code_required' => 'Sie benötigen einen Registrierungscode, es sei denn, Sie sind Kunde.',
### Types
	'kk_type' => 'Kontotyp',
// 	'kk_team' => 'Team Member',
	'kk_coupon' => 'Gutschein',
### Signup
	'kk_info_register' => 'Wir heißen Sie herzlich willkommen auf KassiererCard.org. Bitte teilen Sie uns mit, ob Sie ein Kunde, ein Kassierer oder ein Unternehmen sind. Unternehmen sind unsere Handelspartner. Kassierer sind die Arbeiter, Kunden sind... Kunden und können Coupons ausdrucken.',
	'lbl_choose_account_type' => 'Kontotyp auswählen',

	
### Settings
	'salary_gross' => 'Bruttogehalt',
// 	'qrcode_size' => 'QR-Code Size',

	
### Methods
	'mt_kassierercard_welcome' => 'Willkommen',

	'mt_kassierercard_workingthere' => 'Arbeiten Sie dort?',
# Partners
	'kc_partner' => 'Partner',
# Partner Page
	'info_kk_company_admin' => 'Hier erfahren Sie, wie Sie Partner von %s werden<br/>
Ihre Aufgabe ist es, Angebote für die Mitarbeiter und Kunden einzulösen.<br/>
Sie tun dies, indem Sie entweder QR-Codes scannen, eine Taste auf dem Mobiltelefon des Mitarbeiters drücken oder einen Code eingeben.<br/>
<br/>
Wir danken Ihnen sehr, dass Sie an diesem kleinen Projekt teilnehmen!<br/>
 - gizmore',

# Partner Card
	'kk_partner_estab' => '%s hat dieses Geschäft am %s eröffnet.',
	
# Partner Edit
	'mt_kassierercard_partneredit' => 'Ihren Auftritt hier bearbeiten',
Drücken Sie dazu im rechten Menü auf "Konto".<br/>
Die Einstellungen sind manchmal etwas mühsam zu finden, z.B. findet sich Ihr Name unter Adresse-Eigenen-Adressen.<br/>
Wenn Sie Fragen oder Bedenken haben, <a href="%s">kontaktieren Sie uns bitte</a>.',
	
# Partner Offers
	'list_kassierercard_partneroffers' => '%s Angebote',
# PartnerScansOffer
	'err_kk_customer_cannot_afford_offer' => 'Der Kunde %s kann Ihr Angebot nicht einlösen: %s',
# Enter
	'enter_coupon' => 'Gutschein eingeben',

	
# Entered
	'entered_coupons' => 'Eingegebene Gutscheine',
# Offer
	'kk_info_offers' => 'Hier finden Sie die verfügbaren Angebote in Ihrer Nähe.<br/>Angebote werden von unseren Partnern erstellt, Kunden drucken die Coupons aus und Mitarbeiter lösen sie ein.<br/>Für jeweils 5 eingelöste Coupons bekommt der Kunde auch einen Gutschein.',
	'create_offer' => 'Angebot erstellen',
	'err_kk_offer_no_more_for_you' => 'Du hast %s/%s von %s/%s Artikeln für dieses Angebot eingelöst. Nicht mehr für Sie verfügbar.',
	'kk_offer_status' => 'Insgesamt wurden %s von %s Artikeln eingelöst. Sie können dieses Angebot %s Mal bis %s einlösen. Dieses Angebot kostet %s Sterne/Diamanten.',

	
	# Create Coupon
	'create_coupon' => 'Gutschein erstellen',
	'sel_coupon_offer' => 'Angebot auswählen',

	
	# Print
	'back_side' => 'Rückseite',
oder zeigen Sie Ihrem Mitarbeiter den QR-Code.',
	'err_unknown_coupon' => 'Dieser Gutschein existiert nicht oder gehört nicht Ihnen.',
	'err_print_sundays' => 'Sonntags können Sie keine Coupons drucken.<br/>
	'your_ad_here' => 'Rückseite 100 % für Partner',
# Printed
	'printed_coupons' => 'Gedruckte Gutscheine',
# Redeem
	'redeem_offer' => 'Angebot einlösen',
Bitte beachten Sie, dass Sie den Einlösevorgang nicht abbrechen können,
nachdem Sie hier auf die Schaltfläche gedrückt haben!',
	'err_kk_offer_totaled' => 'Dieses Angebot ist abgeschlossen, da es %s/%s Mal eingelöst wurde.',
# Redeem Now
	'msg_redeem_started' => 'Sie fordern das Angebot jetzt an!',
oder Sie drücken den QR-Code-Button und lassen ihn vom Mitarbeiter scannen.<br/>
So oder so, es gibt keinen Weg zurück,
wenn Sie das Angebot in Anspruch nehmen!',
	'msg_redeem aborted' => 'Sie haben den Vorgang abgebrochen.',
# Partner Redeem
	'mt_kassierercard_partnerredeemqrcode' => 'Einlösecode scannen',
# Redeem O.K.
	'kk_info_redeem_offer_ok' => 'Lassen Sie den Arbeiter bei %s jetzt den Knopf drücken!',
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
	'the_managers' => 'Die Manager',
# Invite
	'invite_users' => 'Personen einladen',
Wählen Sie außerdem die Anzahl der Sterne für Ihre Einladung,
und wenn die eingeladene Person aktiviert,
Sie erhalten Diamanten als Belohnung.
Sonst gehen deine Sterne verloren und werden zu Staub im Wind!<br/>
Derzeit sind Diamanten wertlos, außer für unsere Wettbewerbe.',
	'msg_kk_sent_invitation' => 'Sie haben %s Sterne ausgegeben, um eine Einladung an %s zu senden. Außerdem sind %s Sterne Ihr Geschenk an sie, die in Diamanten umgewandelt werden, sobald sie sich bei uns anmelden.',
	'mailsubj_kk_invite' => '%s: Einladung als %s',

Wir sind ein Prämiensystem (mehr) für Arbeitnehmer statt nur für die Kunden,
und sind unabhängig, bieten echte Waren an, wie einen Kaffee oder einen Döner.

Unsere Wechselkurse sind 1 Euro == %s Stern(e),

und %1$s (%s) schickt Ihnen %s Sterne als Willkommensgeschenk.

Wir haben derzeit %s attraktive lokale Angebote wie Kebab, einen Haarschnitt, CBD-Weed und mehr.

Besuchen Sie uns unter: %s

Mit freundlichen Grüße,
Das %3$s-System',

	'mail_subj_kk_invited_diamonds' => '%s: %s hat sich uns angeschlossen!',
Ihre Investition von %s Sternen wird in %s Diamanten umgewandelt,
von denen Sie jetzt %s haben.

Ihr Benutzerlevel ist um %s Punkte auf %s gestiegen.

Mit freundlichen Grüße,
Das %4$s-Team',

	
# Impressum
	'responsible_is' => 'Verantwortlich dafür ist:',
# Privacy
	'kk_info_privacy_div' => 'KassiererCard.org speichert Ihre IP für einige Zeit.',
# Welcome PM
	'pm_welcome_title' => 'Willkommen bei %s',
Willkommen bei %s,<br/>
das umgekehrte Bonussystem,<br/>
Kopfüber und Hals über Kopf!<br/>
<br/>
Die Seite ist ganz neu,
und wir können Funktionen schnell implementieren und ändern.<br/>
Bitte helfen Sie uns, den Menschen und der Natur mehr Bedeutung zu geben,
statt Geld.<br/>
<br/>
 - gizmore!',

	
# Redeem Mails
	'mailsubj_redeemed_staff' => '%s: Angebot eingelöst',

%s - %s

Dieses Angebot wurde jetzt %s/%s Mal eingelöst.

Wir lassen es Sie wissen
Das %s-System',

	'mailsubj_redeemed_user' => '%s: Angebot eingelöst',

%s - %s

Sie haben jetzt noch %s Sterne übrig.

Mit freundlichen Grüßen
Das %s-System',

	'mailsubj_redeemed_partner' => '%s: Angebot eingelöst',

%s - %s

Dieses Angebot wurde jetzt %s/%s Mal eingelöst.

Mit freundlichen Grüßen
Das %s-System',

	
# Entered stars
	'mail_subj_customer_stars' => '%s: %s Sterne verdient',
Das hat dir auch %s Sterne eingebracht.

Gut erledigt!
Das %s-System',

	
# Competitions
	'enum_cashier_of_the_week' => 'Kassierer der Woche',

	
# Favorites
	'mt_kk_favorites' => 'Favorit %s',


	
];