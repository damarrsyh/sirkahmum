<?php

Class Model_nasabah extends CI_Model 
{
	/* BEGIN REGISTRASI PELUNASAN PEMBIAYAAN *******************************************************/
	public function datatable_pelunasan_pembiayaan_setup($sWhere='',$sOrder='',$sLimit='')
	{ 
		$sql = "SELECT
				mfi_account_financing_lunas.account_financing_no,
				mfi_cif.nama,
				mfi_akad.akad_name,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing_lunas.account_financing_lunas_id
				FROM
				mfi_account_financing_lunas
				INNER JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_account_financing_lunas.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				 ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_product_financing($product_code){
		$sql = "SELECT product_code FROM mfi_product_financing WHERE product_code = ?";

		$param = array($product_code);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_product_code_on_list_code_detail_by_product_financing($product_code_financing){
		$sql = "SELECT code_value AS product_code
		FROM mfi_list_code_detail
		WHERE code_group = 'tabunganindividu'
		AND display_sort = ?::INTEGER";

		$param = array($product_code_financing);

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		if(isset($row['product_code'])){
			return $row['product_code'];
		} else {
			return '';
		}
	}

	function cek_exist_data_on_account_saving($cif_no,$product_code){
		$sql = "SELECT COUNT(*) AS num FROM mfi_account_saving
		WHERE cif_no = ? AND product_code = ? AND status_rekening = '1'";
		$query = $this->db->query($sql,array($cif_no,$product_code));
		$row = $query->row_array();

		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}

	function get_saving_individu($cif_no){
		$sql = "SELECT account_saving_no FROM mfi_account_saving WHERE cif_no = ? AND product_code = '0009'";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_cif_by_account_financing_no($account_financing_no){
		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mc.panggilan,
		mc.jenis_kelamin,
		mc.ibu_kandung,
		mc.tmp_lahir,
		mc.tgl_lahir,
		mc.usia,
		mc.alamat,
		mc.rt_rw,
		mc.desa,
		mc.kecamatan,
		mc.kabupaten,
		mc.kodepos,
		mc.telpon_rumah,
		mc.telpon_seluler,
		maf.account_financing_id,
		maf.account_saving_no,
		maf.nisbah_bagihasil,
		maf.tanggal_jtempo,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.saldo_catab,
		maf.angsuran_catab,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		maf.account_financing_no,
		maf.tanggal_jtempo,
		maf.jtempo_angsuran_last,
		maf.jtempo_angsuran_next,
		maf.periode_jangka_waktu,
		maf.tanggal_jtempo,
		maf.counter_angsuran,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.angsuran_tab_wajib,
		maf.angsuran_tab_kelompok,
		mafs.account_financing_schedulle_id,
		ma.akad_name,
		ma.akad_code,
		mpf.product_name,
		mpf.product_code,
		mas.saldo_memo
		FROM mfi_cif AS mc
		LEFT JOIN mfi_account_financing AS maf ON maf.cif_no = mc.cif_no
		LEFT JOIN mfi_akad AS ma ON ma.akad_code = maf.akad_code
		LEFT JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_account_financing_schedulle AS mafs ON mafs.account_no_financing = maf.account_financing_no
		LEFT JOIN mfi_account_saving AS mas ON mas.account_saving_no = maf.account_saving_no
		WHERE maf.account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array(); 
	}

	public function proses_reg_pelunasan_pembayaran($data)
	{
		$this->db->insert('mfi_account_financing_lunas',$data);
	}

	function get_financing_by_id($id){
		$sql = "SELECT
		mafl.account_financing_lunas_id,
		maf.account_financing_no,
		mc.nama,
		mc.panggilan,
		mc.ibu_kandung,
		mc.tmp_lahir,
		mc.tgl_lahir,
		mc.usia,
		mpf.product_name,
		ma.akad_name,
		maf.pokok,
		maf.margin,
		maf.nisbah_bagihasil,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.angsuran_catab,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.angsuran_catab,
		maf.angsuran_tab_wajib,
		maf.angsuran_tab_kelompok,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.saldo_catab,
		maf.jangka_waktu,
		maf.tanggal_jtempo,
		maf.counter_angsuran,
		mafl.potongan_margin,
		mafl.tanggal_lunas,
		mafl.jenis_pembayaran,
		mafl.account_cash_code,
		mafl.flag_catab,
		mafl.flag_wajib,
		mafl.flag_kelompok,
		mas.account_saving_no,
		mas.saldo_memo
		FROM mfi_account_financing_lunas AS mafl
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafl.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		JOIN mfi_akad AS ma ON ma.akad_code = maf.akad_code
		LEFT JOIN mfi_account_saving AS mas ON mas.account_saving_no = maf.account_saving_no
		WHERE mafl.account_financing_lunas_id = ?";

		$param = array($id);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	/*
	function get_financing_by_id($account_financing_lunas_id){
		$sql = "SELECT
		mc.nama,
		mc.panggilan,
		mc.ibu_kandung,
		mc.tmp_lahir,
		mc.tgl_lahir,
		mc.usia,
		mpf.product_name,
		ma.akad_name,
		maf.account_financing_id,
		maf.account_financing_no,
		maf.pokok,
		maf.margin,
		maf.margin,
		maf.saldo_catab,
		maf.counter_angsuran,
		maf.angsuran_catab,
		maf.nisbah_bagihasil,
		maf.jangka_waktu,
		maf.tanggal_jtempo,
		maf.account_saving_no,
		maf.angsuran_tab_wajib,
		maf.angsuran_tab_kelompok,
		mafl.account_financing_lunas_id,
		mafl.saldo_pokok AS saldo_pokok_lunas,
		mafl.saldo_margin AS saldo_margin_lunas,
		mafl.saldo_catab AS saldo_tabungan_lunas,
		mafl.saldo_wajib AS saldo_wajib_lunas,
		mafl.saldo_kelompok AS saldo_kelompok_lunas,
		mafl.potongan_margin,
		mafl.jenis_pembayaran,
		mafl.account_cash_code,
		mafl.tanggal_lunas,
		mafl.flag_catab,
		mafl.flag_wajib,
		mafl.flag_kelompok,
		mas.saldo_memo
		FROM mfi_account_financing_lunas AS mafl
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafl.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		JOIN mfi_akad AS ma ON ma.akad_code = maf.akad_code
		LEFT JOIN mfi_account_saving AS mas ON mas.account_saving_no = maf.account_saving_no
		WHERE mafl.account_financing_lunas_id = ?";

		$query = $this->db->query($sql,array($account_financing_lunas_id));

		return $query->row_array();
	}
	*/

	public function proses_edit_pelunasan_pembayaran($data,$param)
	{
		$this->db->update('mfi_account_financing_lunas',$data,$param);
	}

	public function delete_data_pelunasan_pembiayaan($param)
	{
		$this->db->delete('mfi_account_financing_lunas',$param);
	}

	public function update_account_financing($data_financing,$param_financing)
	{
		$this->db->update('mfi_account_financing',$data_financing,$param_financing);
	}

	public function update_account_financing_schedulle($data_financing_schedulle,$param_financing_schedulle)
	{
		$this->db->update('mfi_account_financing_schedulle',$data_financing_schedulle,$param_financing_schedulle);
	}
	/* END PELUNASAN PEMBIAYAAN**********************************************************/


	/* BEGIN VERIFIKASI PELUNASAN PEMBIAYAAN**********************************************************/

	function datatable_verifikasi_pelunasan_pembiayaan($sWhere,$sOrder,$sLimit,$branch_code){
		$param = array();

		$sql = "SELECT
		mafl.account_financing_no,
		mc.nama,
		ma.akad_name,
		maf.jangka_waktu,
		mafl.account_financing_lunas_id,
		mcm.cm_name,
		mtaf.trx_account_financing_id
		FROM mfi_account_financing_lunas AS mafl
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafl.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_akad AS ma ON ma.akad_code = maf.akad_code
		JOIN mfi_trx_account_financing AS mtaf ON mtaf.account_financing_no = maf.account_financing_no AND mtaf.trx_financing_type = '2' ";

		if($sWhere != ''){
			$sql .= $sWhere." AND mafl.status_pelunasan '0' ";
			if($branch_code != '00000'){
				$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[] = $branch_code;
			}
		} else {
			$sql .= "WHERE mafl.status_pelunasan = '0' ";
			if($branch_code != '00000'){
				$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[] = $branch_code;
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function proses_verifikasi_pelunasan_pembayaran($data,$param)
	{
		$this->db->update('mfi_account_financing_lunas',$data,$param);
	}

	public function update_account_financing_data($data_acc_financing,$param_acc_financing)
	{
		$this->db->update('mfi_account_financing',$data_acc_financing,$param_acc_financing);
	}

	public function insert_mfi_trx_detail($data_trx_detail)
	{
		$this->db->insert('mfi_trx_detail',$data_trx_detail);
	}

	public function insert_mfi_trx_account_financing($data_trx_account_financing)
	{
		$this->db->insert('mfi_trx_account_financing',$data_trx_account_financing);
	}

	public function insert_mfi_trx_account_saving($data_trx_account_saving)
	{
		$this->db->insert('mfi_trx_account_saving',$data_trx_account_saving);
	}

	public function reject_data_pelunasan_pembiayaan($param)
	{
		$this->db->delete('mfi_account_financing_lunas',$param);
	}

	function delete_trx_account_financing($param){
		$this->db->delete('mfi_trx_account_financing',$param);
	}

	function fn_jurnal_biaya_adm_tab_berencana($account_saving_id,$kas_petugas){
		$sql = "SELECT fn_jurnal_biaya_adm_tab_berencana(?,?)";

		$param = array($account_saving_id,$kas_petugas);

		$query = $this->db->query($sql,$param);
	}

	/* END VERIFIKASI PELUNASAN PEMBIAYAAN**********************************************************/

	/* BEGIN PENCAIRAN PEMBIAYAAN**********************************************************/
	function datatable_pencairan_pembiayaan($sWhere='',$sOrder='',$sLimit=''){
		$param = array();
		$sql = "SELECT
		mfi_akad.akad_code,
		mfi_akad.akad_name,
		mfi_account_financing.account_financing_id,
		mfi_account_financing.account_financing_no,
		mfi_account_financing.jangka_waktu,
		mfi_account_financing.pokok,
		mfi_account_financing_droping.status_droping,
		mfi_account_financing.tanggal_akad,
		mfi_cif.cif_no,
		mfi_cif.nama,
		mfi_cm.cm_name
		FROM mfi_account_financing_droping
		LEFT JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
		LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing_droping.cif_no
		LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
		LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
		LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_account_financing.status_rekening='1' 
			AND mfi_product_financing.jenis_pembiayaan = '0' 
			AND mfi_account_financing.financing_type='1' ";
		}else{
			$sql .= "WHERE mfi_account_financing.status_rekening='1' AND mfi_product_financing.jenis_pembiayaan = '0' 
			AND mfi_account_financing.financing_type='1' ";
		}

		$branch_code = $this->session->userdata('branch_code');

		if ($branch_code!='00000') {
			$sql .= " AND mfi_cif.branch_code = ? ";
			$param[] = $branch_code;
		}
		
		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function delete_data_financing_from_financing_droping($param_droping)
	{
		$this->db->delete('mfi_account_financing_droping',$param_droping);
	}

	public function update_account_financing_droping($data_financing_droping,$param_financing_droping)
	{
		$this->db->update('mfi_account_financing_droping',$data_financing_droping,$param_financing_droping);
	}

	public function update_default_balance($data_default_balance,$param_default_balance)
	{
		$this->db->update('mfi_account_default_balance',$data_default_balance,$param_default_balance);
	}
	/* END PENCAIRAN PEMBIAYAAN**********************************************************/


	/* BEGIN BLOKIR TABUNGAN**********************************************************/

	public function get_cif_by_account_saving_no($account_saving_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_account_saving.account_saving_id,
				mfi_account_saving.account_saving_no,
				mfi_product_saving.product_code,
				mfi_product_saving.product_name,
				mfi_account_saving.saldo_memo,
				mfi_product_saving.saldo_minimal
				FROM
				mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				WHERE mfi_account_saving.account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function update_account_saving_from_blokir($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	public function insert_account_saving_blokir($data_blokir_saving)
	{
		$this->db->insert('mfi_account_saving_blokir',$data_blokir_saving);
	}
	/* END BLOKIR TABUNGAN**********************************************************/

	/* BEGIN BUKA BLOKIR TABUNGAN**********************************************************/

	public function get_cif_by_account_saving_no_for_buka($account_saving_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_account_saving.account_saving_id,
				mfi_account_saving.account_saving_no,
				mfi_product_saving.product_code,
				mfi_product_saving.product_name,
				mfi_account_saving.saldo_memo,
				mfi_account_saving_blokir.account_saving_blokir_id,
				mfi_account_saving_blokir.amount,
				mfi_account_saving_blokir.description,
				mfi_product_saving.saldo_minimal,
				mfi_account_saving.saldo_hold,
				mfi_account_saving.status_rekening
				FROM mfi_account_saving_blokir
				LEFT JOIN mfi_account_saving ON mfi_account_saving.account_saving_no=mfi_account_saving_blokir.account_saving_no
				LEFT JOIN mfi_product_saving ON mfi_product_saving.product_code=mfi_account_saving.product_code
				LEFT JOIN mfi_cif ON mfi_cif.cif_no=mfi_account_saving.cif_no
				WHERE mfi_account_saving_blokir.account_saving_no = ? AND mfi_account_saving_blokir.tipe_mutasi=2";

		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function update_account_saving_from_buka($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	public function update_account_saving_blokir($data_blokir_saving,$param_blokir_saving)
	{
		$this->db->update('mfi_account_saving_blokir',$data_blokir_saving,$param_blokir_saving);
	}
	/* END BUKA BLOKIR TABUNGAN**********************************************************/

	/* BEGIN PENGAJUAN KLAIM ASURANSI**********************************************************/
	// search account saving number
	public function search_cif_by_account_insurance_no($account_insurance_no)
	{
		$sql = "SELECT
				mfi_account_insurance.account_insurance_no,
				mfi_cif.nama,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_account_insurance.product_code,
				mfi_product_insurance.product_name,
				mfi_product_insurance.insurance_type,
				mfi_account_insurance.account_insurance_id,
				mfi_account_insurance.awal_kontrak,
				mfi_account_insurance.akhir_kontrak,
				mfi_account_insurance.benefit_value,
				mfi_account_insurance.premium_value,
				mfi_account_insurance.plan_code,
				mfi_account_insurance.account_saving_no
				FROM
				mfi_cif
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_insurance ON mfi_product_insurance.product_code= mfi_account_insurance.product_code
				WHERE (mfi_account_insurance.account_insurance_no = ?)";
		
		$query = $this->db->query($sql,array($account_insurance_no));

		return $query->row_array();
	}

	public function pengajuan_klaim_asuransi($data)
	{
		$this->db->insert('mfi_insurance_claim',$data);
	}
	/* END PENGAJUAN KLAIM ASURANSI**********************************************************/

	//BEGIN VERIFIKASI ASURANSI KLAIM
	public function datatable_verifikasi_insurance_klaim($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_insurance.account_insurance_no,
				mfi_account_insurance.account_insurance_id,
				mfi_product_insurance.product_name,
				mfi_insurance_claim.type_claim,
				mfi_insurance_claim.claim_status,
				mfi_insurance_claim.amount_claim,
				mfi_cm.cm_name
				FROM
				mfi_insurance_claim
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.account_insurance_no = mfi_insurance_claim.account_insurance_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_insurance.cif_no
				INNER JOIN mfi_product_insurance ON mfi_product_insurance.product_code = mfi_account_insurance.product_code
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function search_cif_by_account_insurance_id($account_insurance_id)
	{
		$sql = "SELECT
				mfi_account_insurance.account_insurance_no,
				mfi_cif.nama,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_account_insurance.product_code,
				mfi_product_insurance.product_name,
				mfi_product_insurance.insurance_type,
				mfi_account_insurance.account_insurance_id,
				mfi_account_insurance.awal_kontrak,
				mfi_account_insurance.akhir_kontrak,
				mfi_account_insurance.benefit_value,
				mfi_account_insurance.premium_value,
				mfi_account_insurance.plan_code,
				mfi_insurance_claim.type_claim,
				mfi_insurance_claim.date_claim,
				mfi_insurance_claim.insurance_claim_id,
				mfi_account_insurance.account_saving_no
				FROM
				mfi_cif
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_insurance ON mfi_product_insurance.product_code= mfi_account_insurance.product_code
				INNER JOIN mfi_insurance_claim ON mfi_insurance_claim.account_insurance_no= mfi_account_insurance.account_insurance_no
				WHERE (mfi_account_insurance.account_insurance_id = ?)";
		
		$query = $this->db->query($sql,array($account_insurance_id));

		return $query->row_array();
	}

	public function proses_verifikasi_klaim_asuransi($data,$param)
	{
		$this->db->update('mfi_insurance_claim',$data,$param);
	}

	public function reject_data_klaim_asuransi($param)
	{
		$this->db->delete('mfi_insurance_claim',$param);
	}

	/****************************************************************************************/
	//BEGIN PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/
	function datatable_pengajuan_pembiayaan_setup($sWhere='',$sOrder='',$sLimit=''){
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
		mafr.registration_no,
		mc.cif_no,
		mc.nama,
		mafr.amount,
		mafr.peruntukan,
		mafr.tanggal_pengajuan,
		mafr.account_financing_reg_id,
		mafr.status,
		mafr.rencana_droping,
		mafr.status,
		mafr.financing_type,
		mcm.cm_name,
		(SELECT mlcd.display_text FROM mfi_list_code_detail AS mlcd
		 WHERE mafr.peruntukan = CAST(mlcd.code_value AS integer)
		 AND code_group = 'peruntukan') AS display_peruntukan
		FROM mfi_account_financing_reg AS mafr
		INNER JOIN mfi_cif AS mc ON mafr.cif_no = mc.cif_no 
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code=mc.cm_code
		WHERE mafr.status = '0' ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ($flag_all_branch==0) {
			$sql .= " AND mc.branch_code = ? ";
			$param[] = $branch_code;
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function add_pengajuan_pembiayaan($data)
	{
		$this->db->insert('mfi_account_financing_reg',$data);
	} 

	public function add_map_pembiayaan($datamap)
	{
		$this->db->insert('mfi_account_financing_map',$datamap);
	}

	public function get_pengajuan_pembiayaan_by_account_financing_reg_id($account_financing_reg_id)
	{
		$sql = "SELECT
		a.registration_no, 
		a.map_no, 
		a.pembiayaan_ke,
		b.cif_no,
		b.nama,
		a.uang_muka,
		a.amount,
		a.peruntukan,
		a.tanggal_pengajuan,
		a.account_financing_reg_id,
		a.status,
		a.description,
		a.rencana_droping,
		a.financing_type, 
		a.ttd_anggota, 
		a.ttd_ketua_majelis, 
		a.ttd_suami, 
		a.ttd_tpl, 
		c.*, c.pend_gaji+c.pend_usaha+c.pend_lainya pend_total, 
		c.by_dapur+c.by_gas+c.by_listrik+c.by_pulsa+c.by_air+c.by_sewa_rumah+c.by_kredit+c.by_arisan+c.by_jajan+c.by_hutang_ph3+c.by_spp_anak+c.by_jajan_anak+c.by_transport_anak+c.by_lainya_anak by_total, 
		c.by_usaha_transport+c.by_usaha_kirim+c.by_usaha_karyawan+c.by_usaha_perawatan+c.by_usaha_konsumsi+c.by_usaha_sewa by_usaha_total, 
		(c.laba_kotor-(c.by_usaha_transport+c.by_usaha_kirim+c.by_usaha_karyawan+c.by_usaha_perawatan+c.by_usaha_konsumsi+c.by_usaha_sewa)) laba_bersih  
		FROM
		mfi_account_financing_reg a 
		LEFT JOIN mfi_cif b ON a.cif_no = b.cif_no 
		LEFT JOIN mfi_account_financing_map c ON a.registration_no = c.registration_no or a.map_no=c.map_no 
		WHERE a.account_financing_reg_id=?::VARCHAR ";

		$query = $this->db->query($sql,array($account_financing_reg_id));

		return $query->row_array();
	}

	public function get_new_registration_no($cif_no, $amountpengajuan, $pyd, $status, $created_by, $created_date) 
	{
		$sql = "SELECT registration_no  FROM mfi_account_financing_reg 
		        WHERE cif_no=? and amount=? and pembiayaan_ke=? and status=? and created_by=? and created_date=? ";

		$query = $this->db->query($sql,array($cif_no, $amountpengajuan, $pyd, $status, $created_by, $created_date));

		return $query->row();
	}

	
	public function get_map_pembiayaan_by_registration_no($registration_no)
	{
		$sql = "SELECT * 
		FROM
		mfi_account_financing_map 
		WHERE 	registration_no=? ";

		$query = $this->db->query($sql,array($registration_no));

		return $query->row_array();
	}

	public function edit_pengajuan_pembiayaan($data,$param)
	{
		$this->db->update('mfi_account_financing_reg',$data,$param);
	}

	public function edit_map_pembiayaan($datamap, $param, $param_map) 
	{
		$this->db->update('mfi_account_financing_map',$datamap); 
		$this->db->where($param);
		$this->db->or_where($param_map);

	}
	
	public function delete_pengajuan_pembiayaan($param)
	{
		$this->db->delete('mfi_account_financing_reg',$param);
	}

	public function delete_map_pembiayaan($param_map)
	{
		$this->db->delete('mfi_account_financing_map',$param_map);
	}


	/****************************************************************************************/
	//END PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/

	//BEGIN RE SCHEDULLING


	public function get_cif_for_rechedulling($account_financing_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.jenis_kelamin,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.product_code,
				mfi_account_financing.branch_code,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.periode_jangka_waktu
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				WHERE mfi_account_financing.account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function proses_rescheduling($data)
	{
		$this->db->insert('mfi_account_financing_re_schedulle',$data);
	}

	//END RE SCHEDULLING

	public function get_account_financing_by_account_financing_no($account_financing_no)
	{
		$sql = "select * from mfi_account_financing where account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function history_outstanding_pembiayaan($cif_no)
	{
		$sql = "SELECT account_financing_no, saldo_pokok, saldo_margin, saldo_catab FROM mfi_account_financing WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function map_data($cif_no)
	{
		$sql = "SELECT *, pend_gaji+pend_usaha+pend_lainya pend_total, by_dapur+by_gas+by_listrik+by_pulsa+by_air+by_sewa_rumah+by_kredit+by_arisan+by_jajan+by_hutang_ph3+by_spp_anak+by_jajan_anak+by_transport_anak+by_lainya_anak by_total, (pend_gaji+pend_usaha+pend_lainya)-(by_dapur+by_gas+by_listrik+by_pulsa+by_air+by_sewa_rumah+by_kredit+by_arisan+by_jajan+by_hutang_ph3+by_spp_anak+by_jajan_anak+by_transport_anak+by_lainya_anak) saving_power   FROM mfi_account_financing_map WHERE cif_no = ? order by pembiayaan_ke desc limit (1) ";
		$query = $this->db->query($sql,array($cif_no));  

		return $query->row_array(); 

	}

	public function get_pyd_ke($cif_no)
	{
		$sql = "SELECT count(cif_no) AS jumlah from mfi_account_financing WHERE cif_no = ? ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function validate_pembiayaan($cif_no)
	{
		$sql = "select count(*) as num from mfi_account_financing where cif_no = ? and status_rekening = 1";
		$query = $this->db->query($sql,array($cif_no));

		$row = $query->row_array();
		if(isset($row['num'])){
			if($row['num']==0){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

	public function get_program_khusus_by_program_owner_code($program_owner_code)
	{
		$sql = "select * from mfi_financing_program where program_owner_code = ?";
		$query = $this->db->query($sql,array($program_owner_code));
		return $query->result_array();
	}

	/**************************************************************************************************/
	//BEGIN PENCAIRAN TABUNGAN Ade 14072014
	/**************************************************************************************************/
	public function proses_pencairan_tabungan($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param); 
	}

	public function grid_verifikasi_pencairan_tabungan($sidx='',$sord='',$limit_rows='',$start='',$branch_id='',$cm_name='',$nama='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
				c.nama
				,c.cif_no
				,b.account_saving_no
				,b.status_rekening
				,b.saldo_memo
				,d.cm_name
				,a.trx_account_saving_id
				,a.trx_date
				,e.branch_name
				,f.product_name
				FROM mfi_trx_account_saving a
				LEFT OUTER JOIN mfi_account_saving b ON a.account_saving_no=b.account_saving_no
				LEFT OUTER JOIN mfi_cif c ON c.cif_no=b.cif_no
				LEFT OUTER JOIN mfi_cm d ON d.cm_code=c.cm_code
				LEFT OUTER JOIN mfi_branch e ON e.branch_id=d.branch_id
				LEFT OUTER JOIN mfi_product_saving f ON b.product_code=f.product_code
				WHERE a.trx_status=0 AND a.trx_saving_type = '5'
			";

		if($branch_id!='SEMUA')
		{
			$sql .= "AND e.branch_id = ? ";
			$param[] = $branch_id;
		}
		if($cm_name!='')
		{
			$sql .= "AND upper(d.cm_name) LIKE ? ";
			$param[] = "%".strtoupper($cm_name)."%";				
		}
		if($nama!='')
		{
			$sql .= "AND upper(c.nama) LIKE ? ";
			$param[] = "%".strtoupper($nama)."%";				
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/**************************************************************************************************/
	//END PENCAIRAN TABUNGAN
	/**************************************************************************************************/

	public function update_mfi_trx_account_saving($data,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data,$param);
	}

	public function get_trx_saving_by_id($trx_id)
	{
		$sql = "select * from mfi_trx_account_saving where trx_account_saving_id = ?";
		$query = $this->db->query($sql,array($trx_id));
		return $query->row_array();
	}

	public function delete_trx_account_saving($param)
	{
		$this->db->delete('mfi_trx_account_saving',$param);
	}

	public function delete_trx_detail($param)
	{
		$this->db->delete('mfi_trx_detail',$param);
	}

	public function get_account_saving($account_saving_no)
	{
		$sql = "select * from mfi_account_saving where account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving_no));
		return $query->row_array();
	}

	/* FUNCTION EXECUTE */
	/**
	* fungsi untuk men-jurnal droping pembiayaan
	* created date 07-aug-2014
	* @author : sayyid
	*/
	public function fn_proses_jurnal_droping_pyd($account_financing_no)
	{
		$sql = "select fn_proses_jurnal_droping_pyd(?)";
		$query = $this->db->query($sql,array($account_financing_no));
	}/**
	* fungsi untuk men-jurnal pelunasan pembiayaan
	* created date 11-aug-2014
	* @author : sayyid
	*/
	public function fn_proses_jurnal_pelunasan_pyd_individu($account_financing_lunas_id)
	{
		$sql = "select fn_proses_jurnal_pelunasan_pyd_individu(?)";
		$query = $this->db->query($sql,array($account_financing_lunas_id));
	}
	public function search_account_financing_no($keyword,$cm_code,$status_rekening=false,$cif_type)
	{
		/* definition */
		$param = array();

		$sql = "SELECT
				(select count(*) from mfi_account_financing_re_schedulle where account_financing_no=a.account_financing_no and status=1) as pembaharuan_ke,
				a.account_financing_no,
				a.product_code,
				a.tanggal_akad,
				a.tanggal_jtempo,
				a.pokok,
				a.margin,
				a.saldo_pokok,
				a.saldo_margin,
				a.saldo_catab,
				a.jangka_waktu,
				a.periode_jangka_waktu,
				a.angsuran_pokok,
				a.angsuran_margin,
				a.angsuran_catab,
				a.tanggal_mulai_angsur,
				b.cif_no,
				a.fa_code,
				b.cif_type,
				b.nama,
				b.ibu_kandung,
				b.tmp_lahir,
				b.tgl_lahir,
				b.usia,
				c.product_name,
				a.angsuran_tab_wajib,
				a.angsuran_tab_kelompok,
				a.biaya_administrasi,
				a.biaya_notaris,
				a.biaya_asuransi_jiwa,
				a.biaya_asuransi_jaminan,
				a.sektor_ekonomi,
				a.peruntukan,
				a.flag_wakalah,
				a.financing_type,
				a.flag_jadwal_angsuran,
				d.cm_name
				FROM mfi_account_financing a
				LEFT JOIN mfi_cif b ON b.cif_no = a.cif_no
				LEFT JOIN mfi_product_financing c ON c.product_code = a.product_code
				LEFT JOIN mfi_cm d ON d.cm_code=b.cm_code
				WHERE (UPPER(a.account_financing_no) like ? OR UPPER(b.nama) like ?)
		";
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		if($status_rekening!=false){
			$sql .= "AND a.status_rekening = ? ";
			$param[] = $status_rekening;
		}

		if($cif_type == '0'){
			$sql .= "AND b.cif_type = ? ";
			$param[] = $cif_type;

			if($cm_code != ''){
				$sql .= "AND d.cm_code = ?";
				$param[] = $cm_code;
			}
		} else {
			$sql .= "AND b.cif_type = ? ";
			$param[] = $cif_type;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	function datatable_verifikasi_rescheduling($sWhere='',$sOrder='',$sLimit='',$tanggal='')
	{
		$sql = "SELECT
				b.nama,
				b.ibu_kandung,
				b.tmp_lahir,
				b.tgl_lahir,
				b.usia,
				c.cm_name,
				a.*
				FROM mfi_account_financing_re_schedulle a
				LEFT JOIN mfi_cif b ON b.cif_no=a.cif_no
				LEFT JOIN mfi_cm c ON c.cm_code=b.cm_code
				";

		$param=array();
		if ( $sWhere != "" ){
			$sql .= "$sWhere AND a.status=0 ";
		}else{
			$sql .= "WHERE a.status=0 AND a.tanggal_reschedule = ? ";
			$param[]=$tanggal;
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function reject_rescheduling($param)
	{
		$this->db->delete('mfi_account_financing_re_schedulle',$param);
	}

	public function update_rescheduling($data,$param)
	{
		$this->db->update('mfi_account_financing_re_schedulle',$data,$param);
	}

	/*
	* Added at 2015-01-21
	* Description : Penambahan Biaya Administrasi pada Pembukaan Rekening Tabungan
	*/
	function get_biaya_administrasi_saving_by_product_code($product_code)
	{
		$sql = "select biaya_administrasi from mfi_product_saving where product_code=?";
		$query = $this->db->query($sql,array($product_code));
		return $query->row_array();
	}

	/*
	** Validasi pengajuan. Ade Sagita 16-03-2015, (dititah k sayyid)
	*/
	public function cek_aktif_pengajuan($cif_no)
	{
		$sql = "SELECT cif_no from mfi_account_financing_reg where cif_no = ? AND status='0' AND financing_type = '0'";
		$query = $this->db->query($sql,array($cif_no));
		return $query->row_array();
	}
	public function cek_aktif_pembiayaan($cif_no)
	{
		$sql = "SELECT cif_no FROM mfi_account_financing WHERE cif_no = ? AND status_rekening NOT IN(0,2) AND financing_type != '1'";
		$query = $this->db->query($sql,array($cif_no));
		return $query->row_array();
	}
	function datatable_verifikasi_pembukaan_rekening($sWhere='',$sOrder='',$sLimit='',$tanggal_buka='',$tanggal_buka2='',$branch_code='')
	{
		$sql = "select
				a.account_saving_id,
				a.account_saving_no,
				b.nama,
				d.cm_name,
				c.product_name,
				a.rencana_setoran,
				a.rencana_jangka_waktu,
				a.tanggal_buka
				from mfi_account_saving a
				inner join mfi_cif b on a.cif_no=b.cif_no
				inner join mfi_product_saving c on a.product_code=c.product_code
				inner join mfi_cm d on b.cm_code=d.cm_code
		";

		$param = array();

		if ( $sWhere != "" ) {
			$sql .= "$sWhere AND a.status_rekening=0";
		} else {
			$sql .= "WHERE a.status_rekening=0";
		}
		if ($branch_code!="00000") {
			$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		if ($tanggal_buka!="" && $tanggal_buka2!="") {
			$sql .= " AND a.tanggal_buka between ? AND ?";
			$param[] = $tanggal_buka;
			$param[] = $tanggal_buka2;
		}

		if ( $sOrder != "" ) {
			$sql .= "$sOrder ";
		} else {
			$sql .= " order by 2 asc";
		}

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/*
	** END Validasi pengajuan
	*/

	function get_account_saving_by_id($account_saving_id)
	{
		$sql = "select * from mfi_account_saving where account_saving_id=?";
		$query = $this->db->query($sql,array($account_saving_id));
		return $query->row_array();
	}
	function jqgrid_data_penghapusan_pembiayaan($sidx='',$sord='',$limit_rows='',$start='',$branch_code='',$cm_code='',$cif_no='')
	{
		$param=array();
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT a.account_financing_id
				,b.cif_no,a.account_financing_no,b.nama,c.cm_name
				,a.pokok, a.margin
				,a.angsuran_pokok, a.angsuran_margin, a.angsuran_catab
				,a.saldo_pokok, a.saldo_margin, a.saldo_catab
				,a.tanggal_akad, a.jangka_waktu, a.periode_jangka_waktu, a.counter_angsuran
				,a.biaya_administrasi, a.biaya_asuransi_jiwa, a.biaya_asuransi_jaminan
				FROM mfi_account_financing a, mfi_cif b, mfi_cm c
				WHERE a.cif_no=b.cif_no and a.status_rekening='1' and b.cm_code=c.cm_code";

		if ($branch_code!='') {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		if ($cm_code!='') {
			$sql .= " and b.cm_code = ?";
			$param[] = $cm_code;
		}
		if ($cif_no!='') {
			$sql .= " and b.cif_no = ?";
			$param[] = $cif_no;
		}

		$sql.= " $order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function check_valid_data_tab_berencana($product_code,$cif_no)
	{
		$sql = "select count(*) as total from mfi_account_saving where product_code = ? and cif_no = ? and status_rekening=1";
		$query = $this->db->query($sql,array($product_code,$cif_no));
		return $query->row_array();
	}

	function cek_angsuran($account_financing_no)
	{
		$sql = "select count(*) num from mfi_trx_account_financing where account_financing_no=? and trx_financing_type=1";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		return $row['num'];
	}

	function update_trx_account_financing($data,$param){
		$this->db->update('mfi_trx_account_financing',$data,$param);
	}

	function update_trx_detail($data,$param){
		$this->db->update('mfi_trx_detail',$data,$param);
	}

	function get_account_saving_by_account_financing_no($account_financing_no){
		$sql = "select 
				b.account_saving_no,
				b.saldo_memo,
				b.saldo_riil
				from mfi_account_financing a, mfi_account_saving b 
				where a.account_saving_no=b.account_saving_no and 
				a.account_financing_no=?
				";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();

		if(isset($row['account_saving_no'])==true){
			$account_saving_no=$row['account_saving_no'];
		}else{
			$account_saving_no=false;
		}

		return $account_saving_no;
	}

	function update_account_saving($data,$param){
		$this->db->update('mfi_account_saving',$data,$param);
	}

	function get_registration_no_by_account_financing_no($account_financing_no){
		$sql = "select registration_no from mfi_account_financing where account_financing_no=?";
		$query=$this->db->query($sql,array($account_financing_no));
		$row=$query->row_array();
		return (isset($row['registration_no'])==true)?$row['registration_no']:'';
	} 

	function get_registration_no_by_reg_id($param){
		$sql = "select registration_no from mfi_account_financing_reg where account_financing_reg_id=?";
		$query=$this->db->query($sql,array($param));
		$row=$query->row_array();
		return (isset($row['registration_no'])==true)?$row['registration_no']:'';
	}


	function update_account_financing_reg($data,$param){
		$this->db->update('mfi_account_financing_reg',$data,$param);
	}

	function insert_log_koreksi_droping($data){
		$this->db->insert('mfi_log_koreksi_droping',$data);
	}

	public function datatable_perubahan_pencairan($sWhere='',$sOrder='',$sLimit='',$tgl_akad='',$branch_code='',$cm_code='')
	{
		$param = array();
		$sql = "
		SELECT
			mfi_akad.akad_code,
			mfi_akad.akad_name,
			mfi_account_financing.account_financing_id,
			mfi_account_financing.account_financing_no,
			mfi_account_financing.jangka_waktu,
			mfi_account_financing.pokok,
			mfi_account_financing.tanggal_akad,
			mfi_cif.cif_no,
			mfi_cif.nama,
			mfi_cm.cm_name
		FROM mfi_account_financing
		LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
		LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
		LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
		LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
		";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			$sql .= " AND mfi_account_financing.status_rekening = 0 ";
			$sql .= " AND mfi_account_financing.tanggal_akad <= ? ";
			$tgl_akad = substr($tgl_akad,4,4).'-'.substr($tgl_akad,2,2).'-'.substr($tgl_akad,0,2);
			$param[] = $tgl_akad;
		}else{
			$sql .= " AND mfi_account_financing.status_rekening = 0 ";
			$sql .= " WHERE mfi_account_financing.tanggal_akad <= ? ";
			$tgl_akad = substr($tgl_akad,4,4).'-'.substr($tgl_akad,2,2).'-'.substr($tgl_akad,0,2);
			$param[] = $tgl_akad;
		}

		if ($branch_code!="00000") {
			$sql .= " AND mfi_cif.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if ($cm_code!="") {
			$sql .= " AND mfi_cif.cm_code=?";
			$param[] = $cm_code;
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	function get_data_perubahan_pencairan($account_financing_no)
	{
		$sql = "
			SELECT
				a.account_financing_id,
				a.account_financing_no,
				a.tanggal_akad,
				a.tanggal_mulai_angsur,
				a.pokok,
				b.cif_no,
				b.nama,
				c.cm_code,
				c.cm_name
			FROM mfi_account_financing a, mfi_cif b, mfi_cm c
			WHERE a.cif_no=b.cif_no AND b.cm_code=c.cm_code
			AND a.account_financing_no = ?
		";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	// ========================================================
	function search_rekening_tabungan($rekening){
		$sql = "SELECT
		mas.account_saving_no,
		mc.nama,
		mcm.cm_name,
		mc.ibu_kandung,
		mc.tmp_lahir,
		mc.tgl_lahir,
		mps.product_name,
		mas.biaya_administrasi,
		mas.rencana_setoran,
		mas.rencana_periode_setoran,
		mas.rencana_setoran_next,
		mas.tanggal_buka,
		mas.rencana_jangka_waktu,
		mas.counter_angsruan,
		mass.rencana_jangka_waktu_setelah,
		mass.tanggal_perpanjangan
		FROM mfi_cif AS mc
		JOIN mfi_account_saving AS mas ON mas.cif_no = mc.cif_no
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_account_saving_schedulle AS mass ON mass.account_saving_no = mas.account_saving_no
		WHERE mas.account_saving_no = ?";

		$param = array($rekening);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function get_value_verif($account_saving_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.branch_code,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.cif_no,
				mfi_cif.cm_code,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.cif_type,
				mfi_cif.telpon_seluler,
				
				mfi_cm.cm_name as majlis,

				mfi_account_saving.rencana_setoran,
				mfi_account_saving.rencana_jangka_waktu,
				mfi_account_saving.rencana_awal_kontrak,
				mfi_account_saving.rencana_setoran_next,
				mfi_account_saving.tanggal_buka,
				mfi_account_saving.rencana_setoran_last,
				mfi_account_saving.account_saving_id,
				mfi_account_saving.account_saving_no,
				mfi_account_saving.biaya_administrasi,
				mfi_account_saving.saldo_memo,
				mfi_account_saving.counter_angsruan,
				mfi_account_saving.product_code,
				mfi_account_saving.rencana_periode_setoran,

				-- mfi_product_saving.product_code,
				mfi_product_saving.product_name,
				mfi_product_saving.saldo_minimal,

				mfi_account_saving_schedule.rencana_jangka_waktu_setelah,
				mfi_account_saving_schedule.tanggal_perpanjangan

				FROM
				mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_saving_schedule ON mfi_account_saving_schedule.account_saving_no = mfi_account_saving.account_saving_no
				
				WHERE mfi_account_saving.account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	function hitung_hari_libur($mulai_angsur,$tanggal_jatuh_tempo){
		$sql = "SELECT COUNT(*) AS jumlah FROM mfi_hari_libur WHERE EXTRACT(DOW FROM tanggal) = EXTRACT(DOW FROM ?::DATE) AND tanggal BETWEEN ? AND ?";
		$param = array($mulai_angsur,$mulai_angsur,$tanggal_jatuh_tempo);
		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function update_cif_no_ktp($dataktp, $param)
	{
		$this->db->update('mfi_cif',$dataktp,$param);
	}

	function add_cif_kelompok($data_cif_kel)
	{
		$this->db->insert('mfi_cif_kelompok', $data_cif_kel);
	}

	public function edit_tanda_tangan2($map_no, $nama_gambar, $tipe)
	{
		return $this->db->update('mfi_account_financing_reg', [$tipe => $nama_gambar], ['map_no' => $map_no]);
	}

	public function get_data_map($account_financing_reg_id)
	{
		$sql = "
		SELECT
			mfi_account_financing_reg.cif_no AS no_anggota,
			mfi_cif.nama AS nama_lengkap,
			mfi_cif.no_ktp,
			mfi_cif.alamat,
			mfi_cif.cif_type,
			mfi_cm.cm_name AS rembug,
			mfi_cif_kelompok.p_nama AS nama_pasangan,
			mfi_fa.fa_name AS nama_tpl,
			mfi_account_financing_reg.financing_type AS jenis_pembiayaan,
			mfi_account_financing_reg.pembiayaan_ke,
			mfi_account_financing_reg.amount AS jumlah_pengajuan,
			mfi_account_financing_reg.jangka_waktu,
			mfi_account_financing_reg.peruntukan as id_peruntukan,
			peruntukan_list.display_text AS peruntukan,
			mfi_account_financing_reg.tanggal_pengajuan,
			mfi_account_financing_reg.rencana_droping,
			mfi_account_financing_reg.description,
			mfi_account_financing_reg.ttd_anggota,
			mfi_account_financing_map.telp_no AS no_telp_anggota,
			mfi_account_financing_map.pekerjaan as id_pekerjaan_anggota,
			pekerjaan_anggota_list.display_text AS pekerjaan_anggota,
			mfi_account_financing_map.psg_telp AS no_telp_suami,
			pekerjaan_suami_list.display_text AS pekerjaan_suami,
			mfi_account_financing_map.pend_gaji AS pendapatan_gaji,
			mfi_account_financing_map.pend_usaha AS pendapatan_usaha,
			mfi_account_financing_map.pend_lainya AS pendapatan_lainnya,
			( mfi_account_financing_map.pend_gaji + mfi_account_financing_map.pend_usaha + mfi_account_financing_map.pend_lainya ) AS total_pendapatan,
			mfi_account_financing_map.jumlah_tanggungan,
			mfi_account_financing_map.by_dapur AS biaya_rumah_tangga,
			mfi_account_financing_map.by_listrik AS biaya_rekening,
			mfi_account_financing_map.by_sewa_rumah AS biaya_kontrakan,
			mfi_account_financing_map.by_spp_anak AS biaya_pendidikan,
			mfi_account_financing_map.by_hutang_ph3 AS hutang_lainnya,
			( mfi_account_financing_map.by_dapur + mfi_account_financing_map.by_listrik + mfi_account_financing_map.by_sewa_rumah + mfi_account_financing_map.by_spp_anak + mfi_account_financing_map.by_hutang_ph3 ) AS total_biaya,
			mfi_account_financing_map.jenis_usaha,
			mfi_account_financing_map.jenis_komoditi as komoditi,
			mfi_account_financing_map.lama_usaha,
			mfi_account_financing_map.lokasi_usaha,
			mfi_account_financing_map.aset_usaha_desc as aset_usaha,
			mfi_account_financing_map.no_izin_usaha as surat_ijin_usaha,
			mfi_account_financing_map.aset_usaha_nom as nilai_aset,
			mfi_account_financing_map.modal_awal as modal,
			mfi_account_financing_map.omset_usaha as omset,
			mfi_account_financing_map.hpp_usaha as hpp,
			mfi_account_financing_map.persediaan_usaha as persediaan,
			mfi_account_financing_map.piutang_usaha as piutang,
			mfi_account_financing_map.laba_kotor,
			mfi_account_financing_map.by_usaha_karyawan as by_usaha,
			mfi_account_financing_map.by_usaha_sewa as sewa_tempat,
			(
				mfi_account_financing_map.by_usaha_karyawan + mfi_account_financing_map.by_usaha_sewa
			) as total_biaya_usaha,
			(
				mfi_account_financing_map.laba_kotor - 
				(mfi_account_financing_map.by_usaha_karyawan + mfi_account_financing_map.by_usaha_sewa)
			) as keuntungan_usaha,
			mfi_account_financing_map.plafond_sebelumnya,
			mfi_account_financing_map.prestasi_angsuran,
			mfi_account_financing_map.total_setoran,
			mfi_account_financing_map.count_total_setoran,
			mfi_account_financing_map.total_penarikan,
			mfi_account_financing_map.count_total_penarikan,
			mfi_account_financing_map.rataan_setoran,
			mfi_account_financing_map.count_rataan_setoran,
			mfi_account_financing_map.tabungan_sukarela,
			mfi_account_financing_map.taber_html
		FROM
			mfi_account_financing_reg
			LEFT JOIN mfi_account_financing_map ON mfi_account_financing_map.registration_no = mfi_account_financing_reg.registration_no 
			OR mfi_account_financing_map.map_no = mfi_account_financing_reg.map_no
			LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing_reg.cif_no
			LEFT JOIN mfi_cif_kelompok ON mfi_cif_kelompok.cif_id = mfi_cif.cif_id
			LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
			LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
			LEFT JOIN mfi_list_code_detail AS peruntukan_list ON peruntukan_list.code_value = CAST ( mfi_account_financing_reg.peruntukan AS VARCHAR ) 
			AND peruntukan_list.code_group = 'peruntukan'
			left JOIN mfi_list_code_detail AS pekerjaan_anggota_list ON pekerjaan_anggota_list.code_value = CAST ( mfi_account_financing_map.pekerjaan AS VARCHAR ) 
			AND pekerjaan_anggota_list.code_group = 'pekerjaan' 
			left JOIN mfi_list_code_detail AS pekerjaan_suami_list ON pekerjaan_suami_list.code_value = CAST ( mfi_account_financing_map.psg_pekerjaan AS VARCHAR ) 
			AND pekerjaan_suami_list.code_group = 'pekerjaan' 
		WHERE
			account_financing_reg_id = '" . $account_financing_reg_id . "'
		";
		return $this->db->query($sql);
	}

	public function get_pasangan_n_tpl($no_anggota)
	{
		$this->db->select('
			mfi_cif_kelompok.p_nama as nama_pasangan,
			mfi_fa.fa_name as nama_tpl
		');
		$this->db->join('mfi_cif_kelompok', 'mfi_cif_kelompok.cif_id = mfi_cif.cif_id', 'left');
		$this->db->join('mfi_cm', 'mfi_cm.cm_code = mfi_cif.cm_code', 'left');
		$this->db->join('mfi_fa', 'mfi_fa.fa_code = mfi_cm.fa_code', 'left');
		$this->db->where('mfi_cif.cif_no', $no_anggota);
		return $this->db->get('mfi_cif');
	}


}