<?php
	/*
	* CSCI 2170: ONLINE EDITION, WINTER 2021
	* STARTER CODE FOR ASSIGNMENT 3
	* 
	* This code was developed by Dr. Raghav V. Sampangi (raghav@cs.dal.ca)
	*
	* Page to login to the website
	*/

	require_once "includes/header.php";
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

			<div class="py-5 text-center container">
				<div class="row">
					<div class="col-lg-6 col-md-8 mx-auto">
					<form class="form-signin" method="post" action="includes/login.php">
						<!-- Bootstrap Login form used from example on getbootstrap.com,
							available here: https://getbootstrap.com/docs/4.0/examples/sign-in/
							Date accessed: 16 Feb 2021
						-->
						<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                        <?php
                        // If the user enters the wrong password or username, print an error message.
                        if (isset($_GET['login-success'])){
                            if (!$_GET['login-success']){
                                echo "<p class='lead text-danger text-center'>Incorrect username or password</p>";
                            }
                        }

                        // If the user has been redirected after trying to access resources in the includes folder, print the error message.
                        if (isset($_GET['noaccess'])){
                            if ($_GET['noaccess']){
                                echo "<p class='lead text-danger text-center'>You do not have access to the resource that you tried to access!</p>";
                            }
                        }
                        ?>
                        <!-- The required username should not be than 128 char.-->
						<input type="text" name="jedi-uname" id="input-uname" class="form-control" placeholder="Username" required autofocus maxlength="128">
						<br>
                        <!-- The required username should not be than 256 char.-->
						<input type="password" name="jedi-pswd" id="input-password" class="form-control" placeholder="Password" required maxlength="256">
						<br>
						<input type="submit" name="submit-jedi-login" class="btn btn-lg btn-primary btn-block" value="Sign in">
					</form>
					
					</div>
				</div>
			</div>
		</main>

<?php
	require_once "includes/footer.php";
?>