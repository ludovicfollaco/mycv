<?php
	require_once('../controller/garageparrot/home.controller.php');
	use Model\Utilities\Utilities;
?>

<form action="" method="post">

	<!-- input hidden csrf -->
	<input type="hidden" name="csrf" value="<?php echo $_SESSION['token']['csrf'];?>">

	<div class="container pt-3">

		<div class="col-12 bg-dark d-flex justify-content-center text-light mx-auto mb-3 rounded-3">

			<h2 class="px-0 py-3 m-0 w-100">

				<input
					class="text-center <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'text-light bg-transparent';} ?> "
					type="text"
					id="txt_titre1"
					name="txt_home_titre1"
					<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';}?>
					value="<?php echo Utilities::escapeInput($Home['titre1']); ?>"
				>

			</h2>

		</div>

	</div>

	<div class="container">

		<div class="row">

			<div class="col-12">

				<p>

					<textarea
						class="text-left <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>"
						name="txt_intro_chapter1"
						id="txt_intro_chapter1"
						rows="4"
						<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
						style="text-align: justify;"
					><?php echo Utilities::escapeInput($Home['intro_chapter1']); ?></textarea>

				</p>

				<hr>

				<p>

					<textarea
						class="text-left <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>" 
						name="txt_intro_chapter2"
						id="txt_intro_chapter2"
						rows="4"
						<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
						style="text-align: justify;"
					><?php echo Utilities::escapeInput($Home['intro_chapter2']); ?></textarea>

				</p>

			</div>

		</div>

	</div>
	
	<?php
	if($_SESSION['dataConnect']['type'] === 'Administrator'){
	?>
		<div class="container text-center">

			<button
				class="btn btn-lg btn-primary fs-4"
				id="bt_home"
				name="bt_home"
				type="submit">Enregistrer la page d'accueil
			</button>

		</div>
	<?php
	}
	?>

	<div class="container pt-3">

		<div class="col-12 bg-dark d-flex justify-content-center text-light mx-auto mb-3 rounded-3">

			<h2 class="px-0 py-3 m-0 w-100">

				<input
					class="text-center <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'text-light bg-transparent';} ?>" 
					type="text"
					id="txt_home_titre2"
					name="txt_home_titre2"
					value="<?php echo Utilities::escapeInput($Home['titre2']); ?>"
					<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
				>

			</h2>

		</div>

	</div>

	<div class="container pb-0 pb-lg-3">

		<div class="row">

			<div class="d-flex flex-column flex-lg-row justify-content-center p-0 p-lg-5 m-0">
				
				<div class="col-12 col-lg-8 d-flex flex-column justify-content-center bg-light m-0 pe-0 pe-lg-5">

					<h2 class="text-center <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>">

						<input
							class="text-center fw-bold"
							id="txt_article1_titre"
							name="txt_article1_titre"
							type="text"
							value="<?php echo Utilities::escapeInput($Home['article1_titre']); ?>"
							<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
						>

					</h2>

					<textarea
						class="text-left m-0 pe-0 pe-lg-5 <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>" 
						name="txt_article1_chapter1"
						id="txt_article1_chapter1"
						rows="6"
						<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
						style="text-align: justify;"
					><?php echo Utilities::escapeInput($Home['article1_chapter1']); ?></textarea>

				</div>

				<img
					class="m-0 ps-0 pb-3 pb-lg-0 ps-lg-5"
					src="../img/garageparrot/photo/<?php echo Utilities::escapeInput($Home['article1_image1']); ?>"
					alt="photo mécanique"
				>

			</div>

			<hr>

		</div>

	</div>

	<div class="container pb-0 pb-lg-3">

		<div class="row">

			<div class="d-flex flex-column flex-lg-row justify-content-center p-0 p-lg-5 m-0">

				<img
					class="m-0 ps-0 pb-3 pb-lg-0"
					src="../img/garageparrot/photo/<?php echo Utilities::escapeInput($Home['article1_image2']); ?>"
					alt="photo mécanique"
				>

				<div class="col-12 col-lg-8 d-flex flex-column justify-content-center bg-light m-0 ps-0 ps-lg-5">

					<h2 class="text-center <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>">

						<input
							class="text-center fw-bold"
							id="txt_article1_titre2"
							name="txt_article1_titre2"
							type="text"
							<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
							value="<?php echo Utilities::escapeInput($Home['article1_titre2']); ?>"
						>

					</h2>

					<textarea
						class="text-left m-0 pe-0 pb-3 pb-lg-0 pe-lg-5 <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>"
						name="txt_article1_chapter2"
						id="txt_article1_chapter2"
						rows="6"
						<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
						style="text-align: justify;"
					><?php echo Utilities::escapeInput($Home['article1_chapter2']); ?></textarea>

				</div>

			</div>

			<hr>

		</div>

	</div>

	<div class="container pb-0 pb-lg-3">

		<div class="row">

			<div class="d-flex flex-column flex-lg-row justify-content-center p-0 p-lg-5 m-0">

				<div class="col-12 col-lg-8 d-flex flex-column justify-content-center bg-light m-0 pe-0 pe-lg-5">

					<h2 class="text-center pt-3 pt-lg-0 <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>">

						<input
							class="text-center fw-bold"
							id="txt_article2_titre"
							name="txt_article2_titre"
							type="text"
							<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
							value="<?php echo Utilities::escapeInput($Home['article2_titre']); ?>"
						>

					</h2>

					<textarea
						class="text-left m-0 pe-0 pe-lg-5 <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>" 
						name="txt_article2_chapter1"
						id="txt_article2_chapter1"
						rows="6"
						<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
						style="text-align: justify;"
					><?php echo Utilities::escapeInput($Home['article2_chapter1']); ?></textarea>

				</div>

				<img
					class="m-0 ps-0 pb-3 pb-lg-0 ps-lg-5"
					src="../img/garageparrot/photo/<?php echo Utilities::escapeInput($Home['article2_image1']); ?>"
					alt="photo mécanique"
				>

			</div>

			<hr>

		</div>

	</div>

	<div class="container pb-0 pb-lg-3">

		<div class="row">

			<div class="d-flex flex-column flex-lg-row justify-content-center p-0 p-lg-5 ps-lg-0 m-0">
				
				<img
					class="m-0 ps-0 pb-3 pb-lg-0"
					src="../img/garageparrot/photo/<?php echo Utilities::escapeInput($Home['article2_image2']); ?>"
					alt="photo mécanique"
				>

				<div class="col-12 col-lg-8 d-flex flex-column justify-content-center bg-light m-0 ps-0 ps-lg-5">
					
					<h2 class="text-center <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>">

						<input
							class="text-center fw-bold"
							id="txt_article2_titre2"
							name="txt_article2_titre2"
							type="text"
							<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
							value="<?php echo Utilities::escapeInput($Home['article2_titre2']); ?>"
						>

					</h2>

					<textarea
						class="text-left m-0 pe-0 pb-3 pb-lg-0 pe-lg-5 <?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'bg-transparent';} ?>"
						name="txt_article2_chapter2"
						id="txt_article2_chapter2"
						rows="6"
						<?php if($_SESSION['dataConnect']['type'] != 'Administrator'){echo 'readonly disabled';} ?>
						style="text-align: justify;"
					><?php echo Utilities::escapeInput($Home['article2_chapter2']); ?></textarea>

				</div>

			</div>

		</div>

	</div>

	<?php
	if($_SESSION['dataConnect']['type'] === 'Administrator'){
	?>

		<div class="container text-center">

			<button
				class="btn btn-lg btn-primary fs-4"
				id="bt_home"
				name="bt_home"
				type="submit">
				Enregistrer la page d'accueil
			</button>

		</div>

	<?php
	}
	?>

</form>

<div class="col-12 bg-dark d-flex justify-content-center text-light mx-auto mb-3 rounded-3">
    <h2 class="px-0 py-3 m-0">Partagez votre expérience, laissez un commentaire!</h2>
</div>

<div class="container d-flex flex-column flex-lg-row justify-content-center">

	<div class="col-12 col-lg-5 mx-0 px-0 mb-md-3">

		<div class="col-12 bg-dark d-flex justify-content-center text-light py-3 mx-0 px-0 rounded-3">
			Commentez votre expérience
		</div>

		<?php include "../module/common/commentForm.php"; ?>

	</div>

	<div class="col-12 col-lg-5 ms-auto me-0 px-0 pt-3 pt-sm-0">

		<div class="col-12 bg-dark d-flex justify-content-center text-light py-3 mx-0 px-0 rounded-3">
			Commentaires de nos clients
		</div>

		<div class="overflow-auto p-0 m-0" style="max-height: 280px;">

			<?php include "../module/common/comment.php"; ?>

		</div>

	</div>

</div>

<!--
<script src="../js/common/function.js"></script>
<script src="../js/common/fetch.js"></script>
-->