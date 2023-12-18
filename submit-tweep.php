<?php
	/*
	* CSCI 2170: ONLINE EDITION, WINTER 2021
	* STARTER CODE FOR ASSIGNMENT 3
	* 
	* This code was developed by Dr. Raghav V. Sampangi (raghav@cs.dal.ca)
	*
	* Blog page: read data from the DB and display the contents.
	*/

	require_once "includes/header.php";
    require_once "login-access-check.php";
	require_once "includes/db.php";
?>
		<main id="pg-main-content">
			<div class="py-5 text-center container">
				<div class="row">
					<div class="col-lg-6 col-md-8 mx-auto">
						<h1 class="fw-light">Jedi Tweep</h1>
						<p class="lead text-muted">Share your Jedi knowledge through tweeps!</p>
						<p class="lead text-muted">Sith, keep away!</p>
					</div>
				</div>
			</div>

			<div class="container">
				<section class="space-above-below my-4">
					<h2 class="fw-light">Post a tweep</h2>
                    <hr>

					<form method="post" action="includes/process-tweep.php">
						<div class="form-row">
							<div class="form-group">
								<label for="tweep-title">Tweep Title</label>
                                <!-- The required blog title should not be than 256 char. -->
								<input type="text" class="form-control" id="tweep-title" name="tweep-title" placeholder="Enter tweep title here..." required maxlength="256">
							</div>
						</div>
						<br>
						<div class="form-row">
							<div class="form-group">
								<label for="input-category">Tweep Category</label>
                                <!-- The required blog category should not be than 64 char. It should also be separated by semi-colons if there is more than one category -->
								<input type="text" class="form-control" id="input-category" name="tweep-category"
                                       placeholder="Enter tweep category here..."
                                       required maxlength="64"
                                       pattern="([A-Za-z0-9 ]+(; [A-Za-z0-9 ]+)*)+">
                                <small class="form-text text-muted">
                                    Multiple categories must be separated by semi-colons: abc; def; ghi
                                </small>
							</div>
						</div>
						<br>
						<div class="form-group">
							<label for="input-tweep">Tweep content (less than 240 characters)</label>
                            <!-- The required blog content should not be than 240 char.-->
                            <textarea class="form-control" id="input-tweep" name="tweep-content" placeholder="Enter tweep content here..." rows="5" required maxlength="240"></textarea>
						</div>
						<br>
						<input type="submit" name="submit-tweep" class="btn btn-primary" value="Post">
                        <!-- Ask the user to decide if they really want to go back after clicking this button -->
						<button type="button" class="btn btn-danger" onclick="checkRedirect()" >Cancel &amp; go to home page</button>
					</form>
				</section>
			</div>
		</main>

<script src="js/scripts.js"></script>

<?php
	require_once "includes/footer.php";
?>