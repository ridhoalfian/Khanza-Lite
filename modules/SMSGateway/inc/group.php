<?php
include "send.php";
$op = isset($_GET['op'])?$_GET['op']:null;
?>
<?php
if(num_rows(query("SHOW TABLES LIKE 'sms_inbox'")) !== 1) {
	echo '<div style="min-height:70vh; min-width:70vw;">';
	echo '<div class="alert bg-pink alert-dismissible text-center" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">';
	echo '<p class="lead">Belum terinstall SMS Gateway</p>';
	echo '<a href="'.URL.'/?module=SMSGateway&page=index&op=install" class="btn btn-lg btn-primary m-t-20">Install Sekarang</a>';
	echo '</div>';
	echo '</div>';
} else {
?>

				<h2 class="title">Atur Group Phonebook</h2>
				<p class="lead"><a href="<?php echo URL; ?>/?module=SMSGateway&page=group&op=add">Tambah</a></p>
				<div class="entry">
					<p>
<?php
		if (!$op)
		{
		// menampilkan seluruh data group

		$query = "SELECT * FROM sms_group";
		$hasil = query($query);
		echo "<br>";
		echo "<table border='1' width='100%'>";
		echo "<tr><th>ID Group</th><th>Nama Group</th><th>Atur</th></tr>";
		while ($data = fetch_array($hasil))
		{
		   echo "<tr><td>".$data['idgroup']."</td><td>".$data['group']."</td><td><a href='".URL."/?module=SMSGateway&page=group&op=edit&id=".$data['idgroup']."'>Edit</a> | <a href='".URL."/?module=SMSGateway&page=group&op=hapus&id=".$data['idgroup']."'>Hapus</a></td></tr>";
		}
		echo "</table>";
		}
		else if ($op == "update")
		{
		// proses update data
		?>
		<h3>Edit Group</h3>
		<?php

			$idgroup = $_POST['id'];
			$group = $_POST['group'];

			$query = "UPDATE sms_group SET sms_group.group = '$group' WHERE idgroup = '$idgroup'";
			query($query);
			echo "<p>&nbsp;</p><p>Nama group sudah diupdate</p>";


		}

		if ($op == "add")
		{
		// proses tambah data group
		?>
		<h3>Tambah Group</h3>
		<p>&nbsp;</p>
		<form name="formku" method="post" action="<?php echo URL; ?>/?module=SMSGateway&page=group&op=simpan">
		Nama Group (tanpa spasi) : <input type="text" name="group">
		<input type="submit" name="submit" value="Simpan">
		</form>


		<?php
		}

		if ($op == "simpan")
		{
		// proses penyimpanan data group yang baru
		   $group = $_POST['group'];
		   $query = "INSERT INTO sms_group(sms_group.group) VALUES ('$group')";
		   $hasil = query($query);
		   if ($hasil) echo "<p>Data sudah disimpan</p>";
		   else echo "<p>Data gagal disimpan</p>";
		}

		if ($op == "hapus")
		{
		// proses menghapus data group
		    $id = $_GET['id'];
			$query = "DELETE FROM sms_group WHERE idgroup = '$id'";
			query($query);
			echo "<p>Data group sudah dihapus</p>";
		}

		if ($op == "edit")
		{
		// proses edit data group
		    $id = $_GET['id'];
		    $query = "SELECT * FROM sms_group WHERE idgroup = '$id'";
			$hasil = query($query);
			$data = fetch_array($hasil);
		?>

		<h3>Edit Group</h3>
		<p>&nbsp;</p>
		<form name="formku" method="post" action="<?php echo URL; ?>/?module=SMSGateway&page=group&op=update">
		Nama Group : <input type="text" name="group" value="<?php echo $data['group']; ?>">
		<input type="submit" name="submit" value="Simpan">
		<input type="hidden" name="id" value="<?php echo $data['idgroup'];?>">
		</form>


		<?php
		}
}
				?>
					</p>
				</div>
			</div>
			</div>
			</div>

		</div>
