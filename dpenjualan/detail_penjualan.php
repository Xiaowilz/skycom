<?php
	require_once("../conn.php");

    if(isset($_GET["notrans"]) && isset($_GET["customer"]) && isset($_GET["tgltrans"]))
    {
        $notrans = $_GET["notrans"];
        $customer = $_GET["customer"];
        $tgltrans = $_GET["tgltrans"];
        // $jthtempo = $_GET["jthtempo"];
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/datepicker.css">
    <script src="../javascript/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../javascript/bootstrap.min.js"></script>
    <script src="../javascript/bootstrap-datepicker.js"></script>
	
	<style type="text/css">
		.jamtgl {
            float : right;
        }

        #clock {
            margin-right: 60px;
        }

        #date {
            margin-right: 35px;
        }		

        #tampil th{
            text-align: center;
        }     

        #tampil {
        	padding-left: 30px;
        	padding-right: 30px;
        }
	</style>
</head>

<script>
    function functionTampilkanJam()
    {
        var waktu = new Date();
        var jam = waktu.getHours() + "";
        var menit = waktu.getMinutes() + "";
        var detik = waktu.getSeconds() + "";
        document.getElementById("clock").innerHTML = (jam.length==1?"0"+jam:jam) + ":" + (menit.length==1?"0"+menit:menit) + ":" + (detik.length==1?"0"+detik:detik);
    }
</script>
<?php
    function functionTanggal()
    {
        session_start();
        $hari = date("l");
        $tanggal = date("d");
        $bulan = date("m");
        $tahun = date("Y");
        echo "$hari".", "."$tanggal"."-"."$bulan"."-"."$tahun";
    }
?>

<body  onload="functionTampilkanJam();setInterval('functionTampilkanJam()', 1000);">
	<div id="topnav">
        <div class="menuicon" onclick="geser()">
            <div class="garis"></div>
            <div class="garis"></div>
            <div class="garis"></div>
        </div>

        <div class="jamtgl">
            Jam : <span id="clock"></span>
            <span id="date">
                <?php
                    functionTanggal();
                ?>
            </span>
        </div>
    </div>

    <div class="all-box">
    	<br>
    	<br>
    	<center><h3>Detail Penjualan</h3></center>
    	<div class="all-content">
			<div class="header">	
				<div class="kiri">
					<div class="form row">
					    <label for="staticEmail" class="col-sm-3 col-form-label">No. Transaksi</label>
					    <div class="col-sm-6">
					      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $notrans; ?>">
					    </div>
					 </div>

					 <div class="form row">
					    <label for="staticEmail" class="col-sm-3 col-form-label">Customer</label>
					    <div class="col-sm-6">
					      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $customer; ?>">
					    </div>
					 </div>
				</div>

				<div class="kanan">
					<div class="form row">
					    <label for="staticEmail" class="col-sm-4 col-form-label">Tanggal Transaksi</label>
					    <div class="col-sm-6">
					      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $tgltrans; ?>">
					    </div>
					 </div>

					 <div class="form row">
					    <label for="staticEmail" class="col-sm-4 col-form-label">Jatuh Tempo (14 hari)</label>
					    <div class="col-sm-6">
					      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $jthtempo; ?>">
					    </div>
					 </div>
				</div>
				<div class="spacer" style="clear: both;"></div>
			</div>	

				<div id="tampil">
					<div class="table-responsive">
	                    <table class="table table-hover table-sm table-bordered">
	                        <thead class="thead-dark">    
	                            <tr>
	                                <th>Kode Barang</th>
	                                <th>Nama Barang</th>
	                                <th width="7%">Quantity</th>
	                                <th>Harga</th>
	                                <th width="20%">Subtotal</th>
	                            </tr>
	                        </thead>
							<tbody>
								<?php
									$totalPenjualan = 0;
									$sql = "SELECT kd_barang,nm_barang,qty,harga,jumlah FROM tb_hd_penjualan WHERE no_trans = '$notrans'";
									$q = mysqli_query($conn, $sql);
		    						while ($r = mysqli_fetch_assoc($q)) 
		    						{
			    						$harga = number_format($r['harga'], 0, ',', '.');
							    		$jumlah = number_format($r['jumlah'], 0, ',', '.');
							    		echo "
											<tr>
												<td>$r[kd_barang]</td>
												<td>$r[nm_barang]</td>
												<td align='center'>$r[qty]</td>
												<td align='right'>$harga</td>
												<td align='right'>$jumlah</td>
											</tr>
							    		";
							    		$totalPenjualan += $r['jumlah'];
						    		}
								?>

								<tr>
									<td colspan="5"></td>
								</tr>

								<tr>
									<td colspan="4" align="center"><strong>Total</strong></td>
									<td align="right"><?php echo "Rp " .number_format($totalPenjualan, 0, ',', '.'); ?></td>
								</tr>
	                        </tbody>
	                    </table>
	                </div>
				</div>
    	</div>
    </div>
	
</body>
</html>