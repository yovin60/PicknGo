<?php 
session_start();
$mail = $_SESSION['mail'];
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
$result = mysqli_query($db, "SELECT * FROM employee 
	INNER JOIN operational_centers ON employee.center_id = operational_centers.center_id 
	where email='{$mail}'");

    while($row = mysqli_fetch_array($result))
    
    {
        $_SESSION['center'] = $row['center_id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['cname'] = $row['name'];
    }
?>
<!DOCTYPE HTML>

<head>
		<h1><title>Pick & Go | Delivery</title></h1>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>

		<!-- Header -->
			<header id="header" class="alt">
				<div class="logo"><a href="" target="">Pick & Go | Manager Dashboard <span></span></a></div>
				<a href="#menu"> Menu </a>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="../index.html">Log out</a></li>
					<li><a href="../edit_employee_account/editdetails.php" target="">Account Settings</a></li>
					<li><a href="../crud_cities/index.php" target="">Cities</a></li>
                    <li><a href="../crud_vehicles/index.php" target="">Vehicles</a></li>					
                    <li><a href="../crud_routes/index.php" target="">Routes</a></li>
					<li><a href="../pending_orders/index.php" target="">Pending orders</a></li>
					<li><a href="../approved_orders/index.php" target="">Approved orders</a></li>
                    <li><a href="../pickedup_items/index.php" target="">Picked up orders</a></li>
                    <li><a href="../loaded_items/index.php" target="">Loaded orders</a></li>
                    <li><a href="../items_to_be_arrived/index.php" target="">Orders to be arrived</a></li>
                    <li><a href="../arrived_items/index.php" target="">Arrived orders</a></li>
                    <li><a href="" target="">Completed Deliveries</a></li>
					
                    
				</ul>
			</nav>

		<!-- Banner -->
			<section class="banner full">
				<article>
					<img src="images/1stimg.jpg" alt="" />
					<div class="inner">
						<header>
							<p><b>Welcome to Pick & Go Delivery Services!</b></p>
							<h2><i>Pick & Go</i></h2>
						</header>
					</div>
				</article>
				<article>
					<img src="images/2ndimg.jpg"  alt="" />
					<div class="inner">
						<header>
							<p><b>Island wide Deliveries available !</b></p>
							<h2><i>Pick & Go</i></h2>
						</header>
					</div>
				</article>
			</section>

		<!-- Two -->
			<section id="two" class="wrapper style3">
				<div class="inner">
					<header class="align-center">
						<p>This is the Official website of Pick & Go Delivery services.</p>
						<h2>Thank You!</h2>
					</header>
				</div>
			</section>

		<!-- Three -->
			<section id="three" class="wrapper style2">
				<div class="inner">
					<header class="align-center">
						<p class="special">ALways ensure customers' safety and privacy</p>
						<h2>Our MIssion</h2>
					</header>
					
						
						</div>
					</div>
				</div>
			</section>


		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="https://www.twitter.com" class="icon fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>
						<li><a href="https://www.facebook.com" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
						<li><a href="https://www.instagram.com" class="icon fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>
						<li><a href="https://www.gmail.com" class="icon fa-envelope-o" target="_blank"><span class="label">Email</span></a></li>
					</ul>
				</div>
				<div class="copyright">
					&copy; PicknGo. All rights reserved.
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

</body>
</html>