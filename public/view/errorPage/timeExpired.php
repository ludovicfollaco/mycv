<?php
	use Model\Utilities\Utilities;
	$siteName = Utilities::checkAndReturnValueInUrl();
	$siteName = $siteName === 'mycv' ? 'index' : $siteName;
	$url = $siteName . '.php?page=connexion';
?>

<section class="article__section">
	<H2 class="text-center article__section--sousTitre">Time of connexion is expired!</H2>
	<article class="text-center">
		<p class="article__paragraphe" style="color: red; font-size:20px;">
			</br>
			The delay JWT of connexion is expired. Please log in again.
			</br>
			Le délai JWT de connexion est expiré. Veuillez vous reconnecter.
			</br>
			<a class="btn-primary" type="button" href=<?php echo $url; ?>>Connexion</a>
			<hr>
		</p>
	</article>
</section>

<?php
	Utilities::redirectToPageTimeOut('connexion');
?>