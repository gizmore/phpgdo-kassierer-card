<?php
namespace GDO\KassiererCard\tpl\page;

use GDO\UI\GDT_Link;

?>
<h2>Welcome to <?=sitename()?></h2>

<p>You know <a href="https://www.payback.de/" rel="nofollow">Payback Card</a>.</p>
<p>You know <a href="https://www.deutschlandcard.de/" rel="nofollow">Deutschland Card</a>.</p>
<p>And many more...</p>

<p>So, what do these systems have in common?</p>
<p>Right, they are about the customer.
    No one ever thinks of the workers.
    The cashiers, the drivers, the cleaning personal,
    and maybe even some managers.</p>

<p>This is were <a href="https://kassierercard.org">KassiererCard.org</a> steps in.
    Our bonus program is focused to aid the people who keep the business running,
    often for the minimum wage.</p>

<p>If you wanna help your local employees,
	<?=GDT_Link::anchor(href('Register', 'Form'), 'register')?>
    and give them credit, where credit is due.</p>

<p>On the left sidebar you find public resources,
    the right sidebar holds private functions.<br/>
    To register as a cashier or a companym you need a special Signup-Code.<br/>
    If you
	<?=GDT_Link::anchor(href('Register', 'Form'), 'register as a customer')?>,
    you can print a coupon all 2 days,
    and hand them to your cashiers.
</p>

<br/>

<hr/>

<br/>

<p>Please note that this project is at the very beginning.</p>
<p>The site will erase and start over a lot, until Nov, 9th 2022.<br/>
    Then we will start Phase 2.</p>
<p>This project is open source, but not free.<br/>
    The <a href="https://github.com/gizmore/phpgdo-kassierer-card">sourcecode of <?=sitename()?></a>
    is visible but it is all our property.<br/>
    However, maybe you are welcome to contribute something.
<p>We are looking for partners!</p>

<em>&copy;2022-23 - KassiererCard.org</em>
