<?php
session_start();

	if (isset($_SESSION['username'])) {


		if (($_SESSION['u_type'] == 'Admin')) {

			echo '<div id="header_top"> 
							<h1>Master Controller</h1>
							<div id= "top_action_bar"> 
							<div class="gaylord_name"> 
								<h3> <span> The </span> Gaylord  </h3> 
							</div>
							<div class="logout_button">							
								<a href="logout.php"> Logout </a>

							</div>
					</div> 
						</div>';

		}

		else {

			echo '<div id="header_top"> 
					<h1>User Controller</h1>
					<div id= "top_action_bar"> 
							<div class="gaylord_name"> 
								<h3> <span> The </span> Gaylord </h3> 
							</div>
							<div class="logout_button">
								<a href="logout.php"> Logout </a>
							</div>
					</div> 
				</div>';
		}

	}
	else {

				echo '<div id="header_top"> 
								<h1>The Gaylord</h1>
							</div>';
	}
?>
