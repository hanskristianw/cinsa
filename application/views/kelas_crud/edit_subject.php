<style>
	.grid-container {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
		grid-column-gap: 3px;
		padding: 30px;
		margin: 20px;
		box-shadow: 5px 5px 5px 5px;
		overflow: auto;
		padding-bottom: 120px;
		padding-top: 50px;
	}
</style>

<div class="grid-container">

	<div>
		<div class="text-center">
			<h4 class="h4 text-gray-900 mt-4 mb-4"><u>Mapel yang Tersedia</u></h4>
		</div>

		<table class="table table-sm table-bordered table-hover" style="font-size:12px;">
			<thead>
				<tr style="height:50px;">
					<th class="align-middle">Nama Mapel</th>
					<th class="align-middle" style="width:50px; text-align:center;">KKM</th>
					<th class="align-middle" style="width:90px; text-align:center;">Jumlah Guru</th>
					<th class="align-middle" style="width:30px; text-align:center;">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($mapel_all as $m) : ?>
					<tr>
						<td><?= $m['mapel_nama'] . ' (' . $m['mapel_sing'] . ')' ?></td>
						<td class="text-center"><?= $m['mapel_kkm'] ?></td>

						<form class="" action="<?= base_url('Kelas_CRUD/edit_subject') ?>" method="post">
							<td style="text-align:center;">
								<select name="jum_guru" id="jum_guru" style="height:23px; font-size:11px;">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
								</select>
							</td>
							<td class="text-center">
								<input type="hidden" name="mapel_id" value=<?= $m['mapel_id'] ?>>
								<input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
								<button type="submit" class="btn btn-sm btn-success" style="height:25px; font-size:10px;">
									<i class="fa fa-plus"></i>
								</button>
							</td>
						</form>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>


	<div>
		<div class="text-center">
			<h4 class="h4 text-gray-900 mt-4 mb-4"><u>Mapel di <?= $kelas_all['kelas_nama']; ?></u></h4>
			<?= $this->session->flashdata('message'); ?>
		</div>
		<table class="table table-sm table-bordered table-hover" style="font-size:12px;">
			<thead>
				<tr style="height:50px;">
					<th class="align-middle" style="width:180px;">Nama Mapel</th>
					<th class="align-middle">Guru / Jumlah Jam</th>
					<th class="align-middle" colspan="2">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($d_mpl_all as $m) :
					$count = 0;
				?>
					<tr>
						<td><?= $m['mapel_nama'] . ' (' . $m['mapel_sing'] . ')' ?></td>

						<form action="<?= base_url('Kelas_CRUD/save_teacher') ?>" method="post">
							<td>
								<input type="hidden" name="d_mpl_id" value="<?= $m['d_mpl_id'] ?>">
								<?php
								$guru_id = explode(",", $m['d_mpl_kr_id']);
								$beban = explode(",", $m['d_mpl_beban']);
								for ($i = 1; $i <= $m['jum_guru']; $i++) :
								?>
									<select name="kr_id[]" id="kr_id[]" style="width:150px;">
										<?php
										$_selected = $guru_id[$count];

										echo "<option value= '0'> Pengajar Ke: " . $i . "</option>";
										foreach ($guru_all as $n) :
											if ($_selected == $n['kr_id']) {
												$s = "selected";
											} else {
												$s = "";
											}
											echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] . " " . $n['kr_nama_belakang'] . "</option>";
										endforeach
										?>
									</select>
									<input type="number" style="height:20px;width:40px;" name="beban[]" min="0" value=<?= $beban[$count] ?>>
									<br>
									<div style="height:3px;"></div>
								<?php
									$count++;
								endfor;
								?>
							</td>
							<td style="width:40px;">
								<input type="hidden" name="mapel_id" value=<?= $m['mapel_id'] ?>>
								<input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
								<button type="submit" class="btn btn-success" style="height:25px; font-size:10px;">
									<i class="fa fa-save"></i>
								</button>
							</td>
						</form>
						<td style="width:40px;">
							<form class="" action="<?= base_url('Kelas_CRUD/delete_subject') ?>" method="post">
								<input type="hidden" name="d_mpl_id_delete" value=<?= $m['d_mpl_id'] ?>>
								<input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
								<button type="submit" class="btn btn-danger" style="height:25px; font-size:10px;">
									<i class="fa fa-trash-alt"></i>
								</button>
							</form>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

</div>


<script>
	$(document).ready(function() {

		$(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
			$(".alert-success").slideUp(500);
		});

	});
</script>