<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: E:\projet_php_nactive\mon-projet-nette\app\Presentation\Home/default.latte */
final class Template_2fcbe4cfed extends Latte\Runtime\Template
{
	public const Source = 'E:\\projet_php_nactive\\mon-projet-nette\\app\\Presentation\\Home/default.latte';

	public const Blocks = [
		['content' => 'blockContent', 'title' => 'blockTitle'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		$this->renderBlock('content', get_defined_vars()) /* line 3 */;
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<div id="banner">
';
		$this->renderBlock('title', get_defined_vars()) /* line 5 */;
		echo '</div>

<div id="content">
	<h2>You have successfully created your <a href="https://nette.org">Nette</a> Web project.</h2>

	<p><img src="data:image/png;base64,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" alt="">
	If you are exploring Nette for the first time, you should read the
	<a href="https://doc.nette.org/quickstart">Quick Start</a>, <a href="https://doc.nette.org">documentation</a>,
	<a href="https://blog.nette.org">blog</a> and <a href="https://forum.nette.org">forum</a>.</p>

	<h2>We hope you enjoy Nette!</h2>
</div>

<style>
	html { font: normal 18px/1.3 Georgia, "New York CE", utopia, serif; color: #666; -webkit-text-stroke: 1px rgba(0,0,0,0); overflow-y: scroll; }
	body { background: #3484d2; color: #333; margin: 2em auto; padding: 0 .5em; max-width: 600px; min-width: 320px; }

	a { color: #006aeb; padding: 3px 1px; }
	a:hover, a:active, a:focus { background-color: #006aeb; text-decoration: none; color: white; }

	#banner { border-radius: 12px 12px 0 0; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAB5CAMAAADPursXAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAGBQTFRFD1CRDkqFDTlmDkF1D06NDT1tDTNZDk2KEFWaDTZgDkiCDTtpDT5wDkZ/DTBVEFacEFOWD1KUDTRcDTFWDkV9DkR7DkN4DkByDTVeDC9TDThjDTxrDkeADkuIDTRbDC9SbsUaggAAAEdJREFUeNqkwYURgAAQA7DH3d3335LSKyxAYpf9vWCpnYbf01qcOdFVXc14w4BznNTjkQfsscAdU3b4wIh9fDVYc4zV8xZgAAYaCMI6vPgLAAAAAElFTkSuQmCC); }

	h1 { font: inherit; color: white; font-size: 50px; line-height: 121px; margin: 0; padding-left: 4%; background: url(https://files.nette.org/images/logo-nette@2.png) no-repeat 95%; background-size: 130px auto; text-shadow: 1px 1px 0 rgba(0, 0, 0, .9); }
	@media (max-width: 600px) {
		h1 { background: none; font-size: 40px; }
	}

	#content { background: white; border: 1px solid #eff4f7; border-radius: 0 0 12px 12px; padding: 10px 4%; overflow: hidden; }

	h2 { font: inherit; padding: 1.2em 0; margin: 0; }

	img { border: none; float: right; margin: 0 0 1em 3em; }
</style>
';
	}


	/** n:block="title" on line 5 */
	public function blockTitle(array $ʟ_args): void
	{
		echo '	<h1>Congratulations!</h1>
';
	}
}
