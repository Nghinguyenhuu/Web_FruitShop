<?php
	session_start();
	include "include/connect.php";
	//check admin
    $admin_ses = $_SESSION['sadmin'];
	if(!isset($admin_ses)){
		header('location:login.php');
	 };
?>
<?php include 'include/header.php'; ?>
	<body>
	<?php include 'include/navbar_admin.php'; ?>
		<div class=" manage row d-flex align-items-center justify-content-center btn-lg">
                <a href="manage_account.php"><button type="button" class="manage_a1 col-lg-10">Manage account</button></a>
                <a href="manage_product.php"><button type="button" class="manage_p1 col-lg-10">Manage product</button></a>
        </div>
	</body>
</html>
