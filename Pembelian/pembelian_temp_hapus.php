<?php 
	session_start();
	require_once("../conn.php");
	$qty = $_SESSION["qty"];
	$kodeHapus = $_POST['kodeHapus'];

	$sqlQuantity = $conn->query("SELECT qty AS quantity FROM tb_inventory WHERE  kd_barang = '$kodeHapus'");
	$data = mysqli_fetch_array($sqlQuantity);
	$quantity = $data['quantity'];

	$quantityInventory = $quantity - $qty;

	$sqlUpdateIventory = $conn->query("UPDATE tb_inventory SET qty = '$quantityInventory' WHERE kd_barang = '$kodeHapus'");

	
	$sql = "DELETE FROM tb_temp_pembelian WHERE kd_barang = '$kodeHapus'";
	$q = mysqli_query($conn, $sql);

	$sqlCekTemp = "SELECT * FROM tb_temp_pembelian";
	$cekTemp = mysqli_query($conn, $sqlCekTemp);
	if(mysqli_num_rows($cekTemp) > 0){
		echo"1";
	}
	else if(mysqli_num_rows($cekTemp) <= 0){
		echo "0";
	}	
 ?>