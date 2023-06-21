<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_product');
	}

	/****************************************************************************************/	
	// BEGIN PRODUCT TABUNGAN
	/****************************************************************************************/
	public function tabungan()
	{
		$data['container']  = 'product/tabungan';
		$data['akad']		= $this->model_product->get_akad_tabungan();
		$data['gl_code']	= $this->model_product->function_select_all('mfi_product_saving_gl');
		$this->load->view('core',$data);
	}

	public function datatable_produk_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','product_code','product_name','saldo_minimal','jenis_tabungan' ,'product_type', 'product_saving_gl_code' ,'');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_produk_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_produk_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_produk_tabungan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			
			if($aRow['jenis_tabungan']==0)
			{
				$jenis_tabungan="Reguler";
			}
			else
			{
				$jenis_tabungan="Berencana";
			}

			if($aRow['product_type']==0)
			{
				$product_type="Kelompok";
			}
			else
			{
				$product_type="Individual";
			}

			$row[] = '<input type="checkbox" value="'.$aRow['product_saving_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['product_code'];
			$row[] = $aRow['product_name'];
			$row[] = "Rp. ".number_format($aRow['saldo_minimal'],0,',','.');
			$row[] = $jenis_tabungan;
			$row[] = $product_type;
			$row[] = $aRow['product_saving_gl_code'];
			$row[] = '<center><a href="javascript:;" product_saving_id="'.$aRow['product_saving_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_produk_tabungan()
	{
		$product_code 					= $this->input->post('product_code');
		$product_name 					= $this->input->post('product_name');
		$nick_name 						= $this->input->post('nick_name');
		$akad 							= $this->input->post('akad');
		$saldo_minimal 					= $this->input->post('saldo_minimal');
		$biaya_administrasi 			= $this->input->post('biaya_administrasi');
		$nominal_biaya_administrasi 	= $this->input->post('nominal_biaya_administrasi');
		$pajak 							= $this->input->post('pajak');
		$persen_pajak 					= $this->input->post('persen_pajak');
		$jenis_tabungan 				= $this->input->post('jenis_tabungan');
		$rencana_minimal_setoran 		= $this->input->post('rencana_minimal_setoran');
		$rencana_periode_setoran 		= $this->input->post('rencana_periode_setoran');
		$rencana_minimal_kontrak 		= $this->input->post('rencana_minimal_kontrak');
		$product_type 					= $this->input->post('product_type');
		$product_saving_gl_code 		= $this->input->post('product_saving_gl_code');

		if($jenis_tabungan=="1")
		{
			$data = array(
				 'product_code'				=>$product_code
				,'product_name'				=>$product_name
				,'nick_name'				=>$nick_name
				,'akad'						=>$akad
				,'saldo_minimal'			=>$this->convert_numeric($saldo_minimal)
				,'biaya_administrasi'		=>$this->convert_numeric($biaya_administrasi)
				,'nominal_biaya_administrasi'=>$this->convert_numeric($nominal_biaya_administrasi)
				// ,'pajak'					=>$pajak
				,'persen_pajak'				=>$persen_pajak
				,'jenis_tabungan'			=>$jenis_tabungan
				,'rencana_minimal_setoran'	=>$this->convert_numeric($rencana_minimal_setoran)
				,'rencana_periode_setoran'	=>$rencana_periode_setoran
				,'rencana_minimal_kontrak'	=>$rencana_minimal_kontrak
				,'product_type'				=>$product_type
				,'product_saving_gl_code'	=>$product_saving_gl_code
				);
		}
		else
		{
			$data = array(
				 'product_code'				=>$product_code
				,'product_name'				=>$product_name
				,'nick_name'				=>$nick_name
				,'akad'						=>$akad
				,'saldo_minimal'			=>$this->convert_numeric($saldo_minimal)
				,'biaya_administrasi'		=>$this->convert_numeric($biaya_administrasi)
				,'nominal_biaya_administrasi'=>$this->convert_numeric($nominal_biaya_administrasi)
				// ,'pajak'					=>$pajak
				,'persen_pajak'				=>$persen_pajak
				,'jenis_tabungan'			=>$jenis_tabungan
				,'rencana_minimal_setoran'	=>'0'
				,'rencana_periode_setoran'	=>'2'
				,'rencana_minimal_kontrak'	=>'1'
				,'product_type'				=>$product_type
				,'product_saving_gl_code'	=>$product_saving_gl_code
				);
		}
		

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_product_saving',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_produk_tabungan()
	{
		$product_saving_id = $this->input->post('product_saving_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($product_saving_id) ; $i++ )
		{
			$param = array('product_saving_id'=>$product_saving_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_product_saving',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	public function get_tabungan_by_product_id()
	{
		$product_saving_id = $this->input->post('product_saving_id');
		$data = $this->model_product->get_tabungan_by_product_id($product_saving_id);

		echo json_encode($data);
	}

	public function edit_produk_tabungan()
	{
		$product_saving_id 				= $this->input->post('product_saving_id');
		$product_code 					= $this->input->post('product_code2');
		$product_name 					= $this->input->post('product_name2');
		$nick_name 						= $this->input->post('nick_name2');
		$akad 							= $this->input->post('akad2');
		$saldo_minimal 					= $this->input->post('saldo_minimal2');
		$biaya_administrasi 			= $this->input->post('biaya_administrasi2');
		$nominal_biaya_administrasi 	= $this->input->post('nominal_biaya_administrasi2');
		$pajak 							= $this->input->post('pajak2');
		$persen_pajak 					= $this->input->post('persen_pajak2');
		$jenis_tabungan 				= $this->input->post('jenis_tabungan2');
		$rencana_minimal_setoran 		= $this->input->post('rencana_minimal_setoran2');
		$rencana_periode_setoran 		= $this->input->post('rencana_periode_setoran2');
		$rencana_minimal_kontrak 		= $this->input->post('rencana_minimal_kontrak2');
		$product_type 					= $this->input->post('product_type2');
		$product_saving_gl_code			= $this->input->post('product_saving_gl_code');

			$param = array('product_saving_id'=>$product_saving_id);
			$data = array(
				 'product_code'				=>$product_code
				,'product_name'				=>$product_name
				,'nick_name'				=>$nick_name
				,'akad'						=>$akad
				,'saldo_minimal'			=>$this->convert_numeric($saldo_minimal)
				,'biaya_administrasi'		=>$this->convert_numeric($biaya_administrasi)
				,'nominal_biaya_administrasi'=>$this->convert_numeric($nominal_biaya_administrasi)
				,'pajak'					=>$pajak
				,'persen_pajak'				=>$persen_pajak
				,'jenis_tabungan'			=>$jenis_tabungan
				,'rencana_minimal_setoran'	=>$this->convert_numeric($rencana_minimal_setoran)
				,'rencana_periode_setoran'	=>$rencana_periode_setoran
				,'rencana_minimal_kontrak'	=>$rencana_minimal_kontrak
				,'product_type'				=>$product_type
				,'product_saving_gl_code'	=>$product_saving_gl_code
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_product_saving',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PRODUCT TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN PRODUCT DEPOSITO
	/****************************************************************************************/
	public function deposito()
	{
		$data['container'] = 'product/deposito';
		$data['akad']		= $this->model_product->get_akad_deposit();
		$data['gl_code']	= $this->model_product->function_select_all('mfi_product_deposit_gl');
		$this->load->view('core',$data);
	}

	public function datatable_produk_deposito()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','product_code','product_name','minimal_nominal','akad','pajak' ,'persen_pajak' ,'product_status','product_deposit_gl_code','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_produk_deposito($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_produk_deposito($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_produk_deposito(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			
			if($aRow['product_status']==0)
			{
				$product_status="Aktif";
			}
			else
			{
				$product_status="Tidak Aktif";
			}

			$row[] = '<input type="checkbox" value="'.$aRow['product_deposit_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['product_code'];
			$row[] = $aRow['product_name'];
			$row[] = "Rp. ".number_format($aRow['minimal_nominal'],0,',','.');
			$row[] = $aRow['akad'];
			$row[] = $aRow['pajak'];
			$row[] = $aRow['persen_pajak'];
			$row[] = $aRow['product_deposit_gl_code'];
			$row[] = $product_status;
			$row[] = '<center><a href="javascript:;" product_deposit_id="'.$aRow['product_deposit_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_produk_deposito()
	{
		$product_code 		= $this->input->post('product_code');
		$product_name 		= $this->input->post('product_name');
		$nick_name 			= $this->input->post('nick_name');
		$minimal_nominal 	= $this->input->post('minimal_nominal');
		$akad 				= $this->input->post('akad');
		$pajak 				= $this->input->post('pajak');
		$persen_pajak 		= $this->input->post('persen_pajak');
		$product_status 	= $this->input->post('product_status');
		$product_deposit_gl_code 	= $this->input->post('product_deposit_gl_code');
		
			$data = array(
				 'product_code'		=>$product_code
				,'product_name'		=>$product_name
				,'nick_name'		=>$nick_name
				,'minimal_nominal'	=>$this->convert_numeric($minimal_nominal)
				,'akad'				=>$akad
				,'pajak'			=>$pajak
				,'persen_pajak'		=>$persen_pajak
				,'product_status'	=>$product_status
				,'product_deposit_gl_code'	=>$product_deposit_gl_code
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_product_deposit',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function get_deposito_by_product_id()
	{
		$product_deposit_id = $this->input->post('product_deposit_id');
		$data = $this->model_product->get_deposito_by_product_id($product_deposit_id);

		echo json_encode($data);
	}

	public function edit_produk_deposito()
	{
		$product_deposit_id = $this->input->post('product_deposit_id');
		$product_code 		= $this->input->post('product_code2');
		$product_name 		= $this->input->post('product_name2');
		$nick_name 			= $this->input->post('nick_name2');
		$minimal_nominal 	= $this->input->post('minimal_nominal2');
		$akad 				= $this->input->post('akad2');
		$pajak 				= $this->input->post('pajak2');
		$persen_pajak 		= $this->input->post('persen_pajak2');
		$product_status 	= $this->input->post('product_status2');
		$product_deposit_gl_code 	= $this->input->post('product_deposit_gl_code');

			$param = array('product_deposit_id'=>$product_deposit_id);
			$data = array(
				 'product_code'		=>$product_code
				,'product_name'		=>$product_name
				,'nick_name'		=>$nick_name
				,'minimal_nominal'	=>$this->convert_numeric($minimal_nominal)
				,'akad'				=>$akad
				,'pajak'			=>$pajak
				,'persen_pajak'		=>$persen_pajak
				,'product_status'	=>$product_status
				,'product_deposit_gl_code'	=>$product_deposit_gl_code
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_product_deposit',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_produk_deposito()
	{
		$product_deposit_id = $this->input->post('product_deposit_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($product_deposit_id) ; $i++ )
		{
			$param = array('product_deposit_id'=>$product_deposit_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_product_deposit',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PRODUCT DEPOSITO
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN PRODUCT PEMBIAYAAN
	/****************************************************************************************/
	public function pembiayaan()
	{
		$data['container'] = 'product/pembiayaan';
		$data['gl_code']	= $this->model_product->function_select_all('mfi_product_financing_gl');
		$data['produk_asuransi']	= $this->model_product->function_select_all('mfi_product_insurance');
		$data['akadata'] = $this->model_product->get_akad_financing();
		$this->load->view('core',$data);
	}

	public function datatable_produk_pembiayaan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','product_code','product_name','jenis_pembiayaan','product_financing_gl_code','','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_produk_pembiayaan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_produk_pembiayaan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_produk_pembiayaan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			
			if($aRow['jenis_pembiayaan']==0)
			{
				$Jenis="Individu";
			}
			else
			{
				$Jenis="Kelompok";
			}

			$row[] = '<input type="checkbox" value="'.$aRow['product_financing_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['product_code'];
			$row[] = $aRow['product_name'];
			$row[] = $Jenis;
			$row[] = $aRow['product_financing_gl_code'];
			$row[] = '<center><a  href="#dialog_detail" data-toggle="modal" product_financing_id="'.$aRow['product_financing_id'].'" id="link-detail">Lihat Detail</a></center>';
			$row[] = '<center><a href="javascript:;" product_financing_id="'.$aRow['product_financing_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_financing_by_product_id()
	{
		$product_financing_id 	= $this->input->post('product_financing_id');
		$data 					= $this->model_product->get_financing_by_product_id($product_financing_id);

		echo json_encode($data);
	}


	public function add_produk_financing()
	{
		$product_code 				= $this->input->post('product_code');
		$product_name 				= $this->input->post('product_name');
		$nick_name 					= $this->input->post('nick_name');
		$jenis_pembiayaan 			= $this->input->post('jenis_pembiayaan');
		$flag_asuransi 				= $this->input->post('flag_asuransi');
		$insurance_product_code 	= $this->input->post('insurance_product_code');
		$type_bya_adm 				= $this->input->post('type_bya_adm');
		$rate_bya_adm 				= $this->input->post('rate_bya_adm');
		$nominal_bya_adm 			= $this->input->post('nominal_bya_adm');
		$flag_manfaat_asuransi 		= $this->input->post('flag_manfaat_asuransi');
		$product_financing_gl_code 	= $this->input->post('product_financing_gl_code');
		$insurance_product_code_no 	= $this->input->post('insurance_product_code_no');
		$akad_code 					= $this->input->post('akad_code');
		$periode_angsuran 			= $this->input->post('periode_angsuran');

		if($insurance_product_code_no=='0'){
			$insurance_code_product = "";
		}else{
			$insurance_code_product = $insurance_product_code;
		}
		
		// BEGIN BODY

			$data = array(
				 'product_financing_id'				=> uuid(false)
				,'product_code'						=> $product_code
				,'product_name'						=> $product_name
				,'nick_name'						=> $nick_name
				,'jenis_pembiayaan'					=> $jenis_pembiayaan
				,'flag_asuransi'					=> $flag_asuransi
				,'insurance_product_code'			=> $insurance_code_product
				,'type_bya_adm'						=> $type_bya_adm
				// ,'rate_bya_adm'						=> str_replace(',', '.', $rate_bya_adm)
				// ,'nominal_bya_adm'					=> $this->convert_numeric($nominal_bya_adm)
				,'flag_manfaat_asuransi'			=> $flag_manfaat_asuransi
				,'product_financing_gl_code'		=> $product_financing_gl_code
				,'akad_code'						=> $akad_code
				,'periode_angsuran'					=> $periode_angsuran
			);

			if($type_bya_adm==1){
				$data['rate_bya_adm'] = str_replace(',', '.', $rate_bya_adm);
			}
			if($type_bya_adm==2){
				$data['nominal_bya_adm'] = $this->convert_numeric($nominal_bya_adm);
			}

		// END BODY

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_product_financing',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function edit_produk_financing()
	{
		$product_financing_id 			= $this->input->post('product_financing_id');
		$product_code 					= $this->input->post('product_code');
		$product_name 					= $this->input->post('product_name');
		$nick_name 						= $this->input->post('nick_name');
		$jenis_pembiayaan 				= $this->input->post('jenis_pembiayaan');
		$flag_asuransi 					= $this->input->post('flag_asuransi');
		$insurance_product_code 		= $this->input->post('insurance_product_code');
		$type_bya_adm 					= $this->input->post('type_bya_adm');
		$rate_bya_adm 					= $this->input->post('rate_bya_adm');
		$nominal_bya_adm 				= $this->input->post('nominal_bya_adm');
		$flag_manfaat_asuransi 			= $this->input->post('flag_manfaat_asuransi');
		$product_financing_gl_code 		= $this->input->post('product_financing_gl_code');
		$akad_code 						= $this->input->post('akad_code');
		$periode_angsuran 				= $this->input->post('periode_angsuran');
	
			$param = array('product_financing_id'=>$product_financing_id);
			$data = array(
					 'product_code'						=> $product_code
					,'product_name'						=> $product_name
					,'nick_name'						=> $nick_name
					,'jenis_pembiayaan'					=> $jenis_pembiayaan
					,'flag_asuransi'					=> $flag_asuransi
					,'insurance_product_code'			=> $insurance_product_code
					,'type_bya_adm'						=> $type_bya_adm
					// ,'rate_bya_adm'						=> str_replace(',', '.', $rate_bya_adm)
					// ,'nominal_bya_adm'					=> $this->convert_numeric($nominal_bya_adm)
					,'flag_manfaat_asuransi'			=> $flag_manfaat_asuransi
					,'product_financing_gl_code'		=> $product_financing_gl_code
					,'akad_code'						=> $akad_code
					,'periode_angsuran'					=> $periode_angsuran
				);

			if($type_bya_adm==1){
				$data['rate_bya_adm'] = str_replace(',', '.', $rate_bya_adm);
			}
			if($type_bya_adm==2){
				$data['nominal_bya_adm'] = $this->convert_numeric($nominal_bya_adm);
			}

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_product_financing',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_produk_pembiayaan()
	{
		$product_financing_id = $this->input->post('product_financing_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($product_financing_id) ; $i++ )
		{
			$param = array('product_financing_id'=>$product_financing_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_product_financing',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END PRODUCT PEMBIAYAAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN NOMINAL
	/****************************************************************************************/
	public function nominal()
	{
		$data['container'] = 'product/nominal';
		$this->load->view('core',$data);
	}

	public function datatable_nominal()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','nominal_minimal','nominal_maksimal','created_date','created_by','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_nominal($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_nominal($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_nominal(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();

			$row[] = '<input type="checkbox" value="'.$aRow['nominal_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['nominal_minimal'];
			$row[] = $aRow['nominal_maksimal'];
			$row[] = $aRow['created_date'];
			$row[] = $aRow['created_by'];
			$row[] = '<center><a href="javascript:;" nominal_id="'.$aRow['nominal_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_nominal()
	{
		$nominal_minimal 		= $this->input->post('nominal_minimal');
		$nominal_maksimal 		= $this->input->post('nominal_maksimal');
		$created_by 			= $this->session->userdata('user_id');
		$branch_code 			= $this->session->userdata('branch_code');
		$created_date 			= date('Y-m-d');
		
			$data = array(
				 'nominal_minimal'		=>$nominal_minimal
				,'nominal_maksimal'		=>$nominal_maksimal
				,'created_by'			=>$created_by
				,'created_date'			=>$created_date
				,'branch_code'			=>$branch_code
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_nominal',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	


	public function get_nominal_by_nominal_id()
	{
		$nominal_id 	= $this->input->post('nominal_id');
		$data = $this->model_product->get_nominal_by_nominal_id($nominal_id);

		echo json_encode($data);
	}

	public function edit_nominal()
	{
		$nominal_id 			= $this->input->post('nominal_id');
		$nominal_minimal 		= $this->input->post('nominal_minimal2');
		$nominal_maksimal 		= $this->input->post('nominal_maksimal2');
		$created_by 			= $this->session->userdata('user_id');
		$created_date 			= date('Y-m-d');

			$param = array('nominal_id'=>$nominal_id);
			$data = array(
							 'nominal_minimal'		=>$nominal_minimal
							,'nominal_maksimal'		=>$nominal_maksimal
							,'created_by'			=>$created_by
							,'created_date'			=>$created_date
						);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_nominal',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_nominal()
	{
		$nominal_id = $this->input->post('nominal_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($nominal_id) ; $i++ )
		{
			$param = array('nominal_id'=>$nominal_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_nominal',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END NOMINAL
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN PRODUCT GL KELOMPOK
	/****************************************************************************************/
	function gl_kelompok(){
		$data['container'] = 'product/gl_kelompok';
		$data['gl_account']	= $this->model_product->function_select_gl_account();
		$data['cm_gl'] = $this->model_product->show_cm_gl();
		$this->load->view('core',$data);
	}

	function edit_produk_gl_kelompok(){
		$product_cm_gl_id = $this->input->post('product_cm_gl_id');
		$product_cm_gl_code = $this->input->post('product_cm_gl_code');
		$description = $this->input->post('description');
		$gl_saldo_tab_wajib = $this->input->post('gl_saldo_tab_wajib');
		$gl_saldo_tab_kelompok = $this->input->post('gl_saldo_tab_kelompok');
		$gl_saldo_tab_sukarela = $this->input->post('gl_saldo_tab_sukarela');
		$gl_saldo_tab_minggon = $this->input->post('gl_saldo_tab_minggon');
		$gl_saldo_tab_lwk = $this->input->post('gl_saldo_tab_lwk');
		$gl_saldo_tab_smk = $this->input->post('gl_saldo_tab_smk');

		$data = array(
			'product_cm_gl_code' => $product_cm_gl_code,
			'description' => $description,
			'gl_tab_wajib' => $gl_saldo_tab_wajib,
			'gl_tab_kelompok' => $gl_saldo_tab_kelompok,
			'gl_tab_sukarela' => $gl_saldo_tab_sukarela,
			'gl_tab_minggon' => $gl_saldo_tab_minggon,
			'gl_tab_lwk' => $gl_saldo_tab_lwk,
			'gl_tab_smk' => $gl_saldo_tab_smk
		);

		$table = 'mfi_product_cm_gl';

		$param = array('product_cm_gl_id' => $product_cm_gl_id);

		$this->db->trans_begin();
		$this->model_product->function_update($table,$data,$param);

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			$result = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$result = array('success' => FALSE);
		}

		echo json_encode($result);
	}

	/****************************************************************************************/	
	// END PRODUCT GL KELOMPOK
	/****************************************************************************************/




	/****************************************************************************************/	
	// BEGIN PRODUCT GL PEMBIAYAAN
	/****************************************************************************************/
	public function gl_pembiayaan()
	{
		$data['container'] = 'product/gl_pembiayaan';
		$data['gl_account']	= $this->model_product->function_select_gl_account();
		$this->load->view('core',$data);
	}

	public function datatable_produk_gl_pembiayaan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','product_financing_gl_code','description','','');
			
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_produk_gl_pembiayaan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_produk_gl_pembiayaan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_produk_gl_pembiayaan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();

			$row[] = '<input type="checkbox" value="'.$aRow['product_financing_gl_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['product_financing_gl_code'];
			$row[] = $aRow['description'];
			$row[] = '<center><a  href="#dialog_detail" data-toggle="modal" product_financing_gl_id="'.$aRow['product_financing_gl_id'].'" id="link-detail">Lihat Detail</a></center>';
			$row[] = '<center><a href="javascript:;" product_financing_gl_id="'.$aRow['product_financing_gl_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function get_financing_gl_by_product_id()
	{
		$product_financing_gl_id 	= $this->input->post('product_financing_gl_id');
		$data 						= $this->model_product->get_financing_gl_by_product_id($product_financing_gl_id);

		echo json_encode($data);
	}


	public function get_financing_gl_by_product_id_view()
	{
		$product_financing_gl_id 	= $this->input->post('product_financing_gl_id');
		$data 						= $this->model_product->get_financing_gl_by_product_id_view($product_financing_gl_id);

		echo json_encode($data);
	}


	function add_produk_gl_pembiayaan(){
		$product_financing_gl_code = $this->input->post('product_financing_gl_code');
		$description = $this->input->post('description');
		$gl_saldo_pokok = $this->input->post('gl_saldo_pokok');
		$gl_saldo_margin = $this->input->post('gl_saldo_margin');
		$gl_saldo_catab = $this->input->post('gl_saldo_catab');
		$gl_saldo_tab_wajib = $this->input->post('gl_saldo_tab_wajib');
		$gl_saldo_tab_kelompok = $this->input->post('gl_saldo_tab_kelompok');
		$gl_saldo_tab_sukarela = $this->input->post('gl_saldo_tab_sukarela');
		$gl_saldo_cad_resiko = $this->input->post('gl_saldo_cad_resiko');
		$gl_pendapatan_margin = $this->input->post('gl_pendapatan_margin');
		$gl_pendapatan_adm = $this->input->post('gl_pendapatan_adm');
		$gl_asuransi_jiwa = $this->input->post('gl_asuransi_jiwa');
		$gl_asuransi_jaminan = $this->input->post('gl_asuransi_jaminan');
		$gl_biaya_cpp = $this->input->post('gl_biaya_cpp');
		$gl_cpp = $this->input->post('gl_cpp');
		$gl_biaya_notaris = $this->input->post('gl_biaya_notaris');
		$gl_titipan_wakalah = $this->input->post('gl_titipan_wakalah');
		$gl_persediaan_mba = $this->input->post('gl_persediaan_mba');
		$gl_uangmuka = $this->input->post('gl_uangmuka');
		$gl_mukasah = $this->input->post('gl_mukasah');
		$gl_simpanan_wajib_pinjam = $this->input->post('gl_simpanan_wajib_pinjam');
		$gl_denda = $this->input->post('gl_denda');

		$data = array(
			'product_financing_gl_id' => uuid(FALSE),
			'product_financing_gl_code' => $product_financing_gl_code,
			'description' => $description,
			'gl_saldo_pokok' => $gl_saldo_pokok,
			'gl_saldo_margin' => $gl_saldo_margin,
			'gl_saldo_catab' => $gl_saldo_catab,
			'gl_saldo_tab_wajib' => $gl_saldo_tab_wajib,
			'gl_saldo_tab_kelompok' => $gl_saldo_tab_kelompok,
			'gl_saldo_tab_sukarela' => $gl_saldo_tab_sukarela,
			'gl_saldo_cad_resiko' => $gl_saldo_cad_resiko,
			'gl_pendapatan_margin' => $gl_pendapatan_margin,
			'gl_pendapatan_adm' => $gl_pendapatan_adm,
			'gl_asuransi_jiwa' => $gl_asuransi_jiwa,
			'gl_asuransi_jaminan' => $gl_asuransi_jaminan,
			'gl_biaya_cpp' => $gl_biaya_cpp,
			'gl_cpp' => $gl_cpp,
			'gl_biaya_notaris' => $gl_biaya_notaris,
			'gl_titipan_wakalah' => $gl_titipan_wakalah,
			'gl_persediaan_mba' => $gl_persediaan_mba,
			'gl_uangmuka' => $gl_uangmuka,
			'gl_mukasah' => $gl_mukasah,
			'gl_simpanan_wajib_pinjam' => $gl_simpanan_wajib_pinjam,
			'gl_denda' => $gl_denda
		);

		$this->db->trans_begin();

		$this->model_product->function_insert('mfi_product_financing_gl',$data);

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			$return = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => FALSE);
		}

		echo json_encode($return);
	}	

	public function delete_produk_gl_pembiayaan()
	{
		$product_financing_gl_id = $this->input->post('product_financing_gl_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($product_financing_gl_id) ; $i++ )
		{
			$param = array('product_financing_gl_id'=>$product_financing_gl_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_product_financing_gl',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	public function edit_produk_gl_pembiayaan()
	{
		$product_financing_gl_id 		= $this->input->post('product_financing_gl_id');
		$product_financing_gl_code 		= $this->input->post('product_financing_gl_code');
		$description 					= $this->input->post('description');
		$gl_saldo_pokok 				= $this->input->post('gl_saldo_pokok');
		$gl_saldo_margin 				= $this->input->post('gl_saldo_margin');
		$gl_saldo_catab 				= $this->input->post('gl_saldo_catab');
		$gl_saldo_tab_wajib 			= $this->input->post('gl_saldo_tab_wajib');
		$gl_saldo_tab_kelompok 			= $this->input->post('gl_saldo_tab_kelompok');
		$gl_saldo_tab_sukarela 			= $this->input->post('gl_saldo_tab_sukarela');
		$gl_saldo_cad_resiko 			= $this->input->post('gl_saldo_cad_resiko');
		$gl_pendapatan_margin 			= $this->input->post('gl_pendapatan_margin');
		$gl_pendapatan_adm 				= $this->input->post('gl_pendapatan_adm');
		$gl_asuransi_jiwa 				= $this->input->post('gl_asuransi_jiwa');
		$gl_asuransi_jaminan 			= $this->input->post('gl_asuransi_jaminan');
		$gl_biaya_cpp 					= $this->input->post('gl_biaya_cpp');
		$gl_cpp 						= $this->input->post('gl_cpp');
		$gl_biaya_notaris 				= $this->input->post('gl_biaya_notaris');
		$gl_titipan_wakalah 			= $this->input->post('gl_titipan_wakalah');
		$gl_persediaan_mba 				= $this->input->post('gl_persediaan_mba');
		$gl_uangmuka 					= $this->input->post('gl_uangmuka');
		$gl_mukasah 					= $this->input->post('gl_mukasah');
		$gl_simpanan_wajib_pinjam 		= $this->input->post('gl_simpanan_wajib_pinjam');
		$gl_denda 						= $this->input->post('gl_denda');

			$data = array(
				 'product_financing_gl_code'		=>$product_financing_gl_code
				,'description'						=>$description
				,'gl_saldo_pokok'					=>($gl_saldo_pokok=="")?NULL:$gl_saldo_pokok
				,'gl_saldo_margin'					=>($gl_saldo_margin=="")?NULL:$gl_saldo_margin
				,'gl_saldo_catab'					=>($gl_saldo_catab=="")?NULL:$gl_saldo_catab
				,'gl_saldo_tab_wajib'				=>($gl_saldo_tab_wajib=="")?NULL:$gl_saldo_tab_wajib
				,'gl_saldo_tab_kelompok'			=>($gl_saldo_tab_kelompok=="")?NULL:$gl_saldo_tab_kelompok
				,'gl_saldo_tab_sukarela'			=>($gl_saldo_tab_sukarela=="")?NULL:$gl_saldo_tab_sukarela
				,'gl_saldo_cad_resiko'				=>($gl_saldo_cad_resiko=="")?NULL:$gl_saldo_cad_resiko
				,'gl_pendapatan_margin'				=>($gl_pendapatan_margin=="")?NULL:$gl_pendapatan_margin
				,'gl_pendapatan_adm'				=>($gl_pendapatan_adm=="")?NULL:$gl_pendapatan_adm
				,'gl_asuransi_jiwa'					=>($gl_asuransi_jiwa=="")?NULL:$gl_asuransi_jiwa
				,'gl_asuransi_jaminan'				=>($gl_asuransi_jaminan=="")?NULL:$gl_asuransi_jaminan
				,'gl_biaya_cpp'						=>($gl_biaya_cpp=="")?NULL:$gl_biaya_cpp
				,'gl_cpp'							=>($gl_cpp=="")?NULL:$gl_cpp
				,'gl_biaya_notaris'					=>($gl_biaya_notaris=="")?NULL:$gl_biaya_notaris
				,'gl_titipan_wakalah'				=>($gl_titipan_wakalah=="")?NULL:$gl_titipan_wakalah
				,'gl_persediaan_mba'				=>($gl_persediaan_mba=="")?NULL:$gl_persediaan_mba
				,'gl_uangmuka'						=>($gl_uangmuka=="")?NULL:$gl_uangmuka
				,'gl_mukasah'						=>($gl_mukasah=="")?NULL:$gl_mukasah
				,'gl_simpanan_wajib_pinjam'			=>($gl_simpanan_wajib_pinjam=="")?NULL:$gl_simpanan_wajib_pinjam
				,'gl_denda'							=>($gl_denda=="")?NULL:$gl_denda
				);
			$param = array('product_financing_gl_id'=>$product_financing_gl_id);

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_product_financing_gl',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PRODUCT GL PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN PRODUCT GL DEPOSITO
	/****************************************************************************************/
	public function gl_deposito()
	{
		$data['container'] = 'product/gl_deposito';
		$data['gl_account']	= $this->model_product->function_select_gl_account();
		$this->load->view('core',$data);
	}

	public function datatable_produk_gl_deposito()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','product_deposit_gl_code','description','gl_saldo','gl_bagihasil','gl_pajak_bagihasil','gl_zakat_bagihasil','gl_adm','');
			
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_produk_gl_deposito($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_produk_gl_deposito($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_produk_gl_deposito(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();

			$row[] = '<input type="checkbox" value="'.$aRow['product_deposit_gl_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['product_deposit_gl_code'];
			$row[] = $aRow['description'];
			$row[] = $aRow['gl_saldo'];
			$row[] = $aRow['gl_bagihasil'];
			$row[] = $aRow['gl_pajak_bagihasil'];
			$row[] = $aRow['gl_zakat_bagihasil'];
			$row[] = $aRow['gl_adm'];
			$row[] = '<center><a href="javascript:;" product_deposit_gl_id="'.$aRow['product_deposit_gl_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function get_gl_deposito_by_product_id()
	{
		$product_deposit_gl_id 	= $this->input->post('product_deposit_gl_id');
		$data 						= $this->model_product->get_gl_deposito_by_product_id($product_deposit_gl_id);

		echo json_encode($data);
	}


	public function add_produk_gl_deposito()
	{
		$product_deposit_gl_code 	= $this->input->post('product_deposit_gl_code');
		$description 				= $this->input->post('description');
		$gl_saldo 					= $this->input->post('gl_saldo');
		$gl_bagihasil 				= $this->input->post('gl_bagihasil');
		$gl_pajak_bagihasil 		= $this->input->post('gl_pajak_bagihasil');
		$gl_zakat_bagihasil 		= $this->input->post('gl_zakat_bagihasil');
		$gl_adm 					= $this->input->post('gl_adm');
		
			$data = array(
				 'product_deposit_gl_id'		=>uuid(false)
				,'product_deposit_gl_code'		=>$product_deposit_gl_code
				,'description'					=>$description
				,'gl_saldo'						=>$this->convert_numeric($gl_saldo)
				,'gl_bagihasil'					=>$this->convert_numeric($gl_bagihasil)
				,'gl_pajak_bagihasil'			=>$this->convert_numeric($gl_pajak_bagihasil)
				,'gl_zakat_bagihasil'			=>$this->convert_numeric($gl_zakat_bagihasil)
				,'gl_adm'						=>$this->convert_numeric($gl_adm)
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_product_deposit_gl',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function delete_produk_gl_deposito()
	{
		$product_deposit_gl_id = $this->input->post('product_deposit_gl_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($product_deposit_gl_id) ; $i++ )
		{
			$param = array('product_deposit_gl_id'=>$product_deposit_gl_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_product_deposit_gl',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	public function edit_produk_gl_deposito()
	{
		$product_deposit_gl_id 		= $this->input->post('product_deposit_gl_id');
		$product_deposit_gl_code 	= $this->input->post('product_deposit_gl_code');
		$description 				= $this->input->post('description');
		$gl_saldo 					= $this->input->post('gl_saldo');
		$gl_bagihasil 				= $this->input->post('gl_bagihasil');
		$gl_pajak_bagihasil 		= $this->input->post('gl_pajak_bagihasil');
		$gl_zakat_bagihasil 		= $this->input->post('gl_zakat_bagihasil');
		$gl_adm 					= $this->input->post('gl_adm');
		
			$data = array(
				 'product_deposit_gl_code'		=>$product_deposit_gl_code
				,'description'					=>$description
				,'gl_saldo'						=>$this->convert_numeric($gl_saldo)
				,'gl_bagihasil'					=>$this->convert_numeric($gl_bagihasil)
				,'gl_pajak_bagihasil'			=>$this->convert_numeric($gl_pajak_bagihasil)
				,'gl_zakat_bagihasil'			=>$this->convert_numeric($gl_zakat_bagihasil)
				,'gl_adm'						=>$this->convert_numeric($gl_adm)
				);
			$param = array('product_deposit_gl_id'=>$product_deposit_gl_id);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_product_deposit_gl',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PRODUCT GL DEPOSITO
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN PRODUCT GL INSURANCE
	/****************************************************************************************/
	public function gl_insurance()
	{
		$data['container'] = 'product/gl_insurance';
		$data['gl_account']	= $this->model_product->function_select_gl_account();
		$this->load->view('core',$data);
	}

	public function datatable_produk_gl_insurance()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','product_insurance_gl_code','description','gl_saldo','gl_biaya','gl_adm','');
			
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_produk_gl_insurance($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_produk_gl_insurance($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_produk_gl_insurance(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();

			$row[] = '<input type="checkbox" value="'.$aRow['product_insurance_gl_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['product_insurance_gl_code'];
			$row[] = $aRow['description'];
			$row[] = $aRow['gl_premi'];
			$row[] = $aRow['gl_ujroh'];
			$row[] = $aRow['gl_tabarru'];
			$row[] = '<center><a href="javascript:;" product_insurance_gl_id="'.$aRow['product_insurance_gl_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function get_gl_insurance_by_product_id()
	{
		$product_insurance_gl_id 	= $this->input->post('product_insurance_gl_id');
		$data 						= $this->model_product->get_gl_insurance_by_product_id($product_insurance_gl_id);

		echo json_encode($data);
	}


	public function add_produk_gl_insurance()
	{
		$product_insurance_gl_code 	= $this->input->post('product_insurance_gl_code');
		$description 				= $this->input->post('description');
		$gl_premi 					= $this->input->post('gl_premi');
		$gl_ujroh 					= $this->input->post('gl_ujroh');
		$gl_tabarru 				= $this->input->post('gl_tabarru');
		
			$data = array(
				 'product_insurance_gl_id'		=>uuid(false)
				,'product_insurance_gl_code'	=>$product_insurance_gl_code
				,'description'					=>$description
				,'gl_premi'						=>$this->convert_numeric($gl_premi)
				,'gl_ujroh'						=>$this->convert_numeric($gl_ujroh)
				,'gl_tabarru'					=>$this->convert_numeric($gl_tabarru)
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_product_insurance_gl',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function delete_produk_gl_insurance()
	{
		$product_insurance_gl_id = $this->input->post('product_insurance_gl_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($product_insurance_gl_id) ; $i++ )
		{
			$param = array('product_insurance_gl_id'=>$product_insurance_gl_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_product_insurance_gl',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	public function edit_produk_gl_insurance()
	{
		$product_insurance_gl_id 	= $this->input->post('product_insurance_gl_id');
		$product_insurance_gl_code 	= $this->input->post('product_insurance_gl_code');
		$description 				= $this->input->post('description');
		$gl_premi 					= $this->input->post('gl_premi');
		$gl_ujroh 					= $this->input->post('gl_ujroh');
		$gl_tabarru 				= $this->input->post('gl_tabarru');
		
			$data = array(
				 'product_insurance_gl_code'	=>$product_insurance_gl_code
				,'description'					=>$description
				,'gl_premi'						=>$this->convert_numeric($gl_premi)
				,'gl_ujroh'						=>$this->convert_numeric($gl_ujroh)
				,'gl_tabarru'					=>$this->convert_numeric($gl_tabarru)
				);
			$param = array('product_insurance_gl_id'=>$product_insurance_gl_id);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_product_insurance_gl',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PRODUCT GL INSURANCE
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN PRODUCT GL TABUNGAN
	/****************************************************************************************/
	public function gl_tabungan()
	{
		$data['container'] = 'product/gl_tabungan';		
		$data['gl_account']	= $this->model_product->function_select_gl_account();
		$this->load->view('core',$data);
	}

	public function datatable_produk_gl_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','product_saving_gl_code','description','gl_saldo','gl_biaya','gl_adm','');
			
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_produk_gl_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_produk_gl_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_produk_gl_tabungan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();

			$row[] = '<input type="checkbox" value="'.$aRow['product_saving_gl_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['product_saving_gl_code'];
			$row[] = $aRow['description'];
			$row[] = $aRow['gl_saldo'];
			$row[] = $aRow['gl_biaya'];
			$row[] = $aRow['gl_adm'];
			$row[] = '<center><a href="javascript:;" product_saving_gl_id="'.$aRow['product_saving_gl_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function get_gl_tabungan_by_product_id()
	{
		$product_saving_gl_id 	= $this->input->post('product_saving_gl_id');
		$data 						= $this->model_product->get_gl_tabungan_by_product_id($product_saving_gl_id);

		echo json_encode($data);
	}


	public function add_produk_gl_tabungan()
	{
		$product_saving_gl_code 	= $this->input->post('product_saving_gl_code');
		$description 				= $this->input->post('description');
		$gl_saldo 					= $this->input->post('gl_saldo');
		$gl_biaya 					= $this->input->post('gl_biaya');
		$gl_adm 					= $this->input->post('gl_adm');
		
			$data = array(
				 'product_saving_gl_id'			=>uuid(false)
				,'product_saving_gl_code'		=>$product_saving_gl_code
				,'description'					=>$description
				,'gl_saldo'						=>$this->convert_numeric($gl_saldo)
				,'gl_biaya'						=>$this->convert_numeric($gl_biaya)
				,'gl_adm'						=>$this->convert_numeric($gl_adm)
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_product_saving_gl',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function delete_produk_gl_tabungan()
	{
		$product_saving_gl_id = $this->input->post('product_saving_gl_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($product_saving_gl_id) ; $i++ )
		{
			$param = array('product_saving_gl_id'=>$product_saving_gl_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_product_saving_gl',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	public function edit_produk_gl_tabungan()
	{
		$product_saving_gl_id 		= $this->input->post('product_saving_gl_id');
		$product_saving_gl_code 	= $this->input->post('product_saving_gl_code');
		$description 				= $this->input->post('description');
		$gl_saldo 					= $this->input->post('gl_saldo');
		$gl_biaya 					= $this->input->post('gl_biaya');
		$gl_adm 					= $this->input->post('gl_adm');
		
			$data = array(
				 'product_saving_gl_code'		=>$product_saving_gl_code
				,'description'					=>$description
				,'gl_saldo'						=>$this->convert_numeric($gl_saldo)
				,'gl_biaya'						=>$this->convert_numeric($gl_biaya)
				,'gl_adm'						=>$this->convert_numeric($gl_adm)
				);
			$param = array('product_saving_gl_id'=>$product_saving_gl_id);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_product_saving_gl',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PRODUCT GL TABUNGAN
	/****************************************************************************************/






	/****************************************************************************************/	
	// BEGIN PRODUCT ASURANSI
	/****************************************************************************************/
	public function asuransi()
	{
		$data['container'] = 'product/asuransi';
		$data['kode']	   = $this->model_product->get_insurance_gl();
		// $data['rate_code'] = $this->model_product->get_rate_kode();
		// $data['plan_code'] = $this->model_product->get_plan_kode();
		$this->load->view('core',$data);
	}

	public function datatable_produk_asuransi()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','product_code','product_name','nick_name','','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_produk_asuransi($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_produk_asuransi($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_produk_asuransi(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['product_insurance_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['product_code'];
			$row[] = $aRow['product_name'];
			$row[] = $aRow['nick_name'];
			$row[] = '<center><a  href="#dialog_detail" data-toggle="modal" product_insurance_id="'.$aRow['product_insurance_id'].'" id="link-detail">Detail</a></center>';
			$row[] = '<center><a href="javascript:;" product_insurance_id="'.$aRow['product_insurance_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_product_insurance_id()
	{
		$product_insurance_id 		= $this->input->post('product_insurance_id');
		$data 						= $this->model_product->get_product_insurance_id($product_insurance_id);

		echo json_encode($data);
	}

	public function get_rate_type()
	{
		$data 						= $this->model_product->get_rate_kode();

		echo json_encode($data);
	}

	public function get_plan_type()
	{
		$data 						= $this->model_product->get_plan_kode();

		echo json_encode($data);
	}

	public function add_produk_asuransi()
	{
		$product_code 					= $this->input->post('product_code');
		$product_name 					= $this->input->post('product_name');
		$nick_name 						= $this->input->post('nick_name');
		$insurance_type 				= $this->input->post('insurance_type');
		$rate_type 						= $this->input->post('rate_type');
		$rate_tunggal 					= str_replace(',', '.', $this->input->post('rate_tunggal'));
		$rate_code 						= $this->input->post('rate_code');
		$premium_periode 				= $this->input->post('premium_periode');
		$pembulatan_usia 				= $this->input->post('pembulatan_usia');
		$product_insurance_gl_code 		= $this->input->post('product_insurance_gl_code');
		$plan_code 						= $this->input->post('plan_code');
		
			$data = array(
				 'product_insurance_id'				=>uuid(false)
				,'product_code'						=>$product_code
				,'product_name'						=>$product_name
				,'nick_name'						=>$nick_name
				,'insurance_type'					=>$insurance_type
				,'rate_type'						=>$rate_type
				,'rate_tunggal'						=>($rate_tunggal=='')?0:$rate_tunggal
				,'rate_code'						=>$rate_code
				,'premium_periode'					=>$premium_periode
				,'pembulatan_usia'					=>$pembulatan_usia
				,'product_insurance_gl_code'		=>$product_insurance_gl_code
				,'plan_code'						=>$plan_code
				);

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_product_insurance',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function delete_produk_asuransi()
	{
		$product_insurance_id = $this->input->post('product_insurance_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($product_insurance_id) ; $i++ )
		{
			$param = array('product_insurance_id'=>$product_insurance_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_product_insurance',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	public function edit_produk_asuransi()
	{
		$product_insurance_id			= $this->input->post('product_insurance_id');
		$product_code 					= $this->input->post('product_code');
		$product_name 					= $this->input->post('product_name');
		$nick_name 						= $this->input->post('nick_name');
		$insurance_type 				= $this->input->post('insurance_type');
		$rate_type 						= $this->input->post('rate_type');
		$rate_tunggal 					= str_replace(',', '.', $this->input->post('rate_tunggal'));
		$rate_code 						= $this->input->post('rate_code');
		$premium_periode 				= $this->input->post('premium_periode');
		$pembulatan_usia 				= $this->input->post('pembulatan_usia');
		$product_insurance_gl_code 		= $this->input->post('product_insurance_gl_code');
		$plan_code 						= $this->input->post('plan_code');
		
			$data = array(
				'product_code'						=>$product_code
				,'product_name'						=>$product_name
				,'nick_name'						=>$nick_name
				,'insurance_type'					=>$insurance_type
				,'rate_type'						=>$rate_type
				,'rate_tunggal'						=>($rate_tunggal=='')?0:$rate_tunggal
				,'rate_code'						=>$rate_code
				,'premium_periode'					=>$premium_periode
				,'pembulatan_usia'					=>$pembulatan_usia
				,'product_insurance_gl_code'		=>$product_insurance_gl_code
				,'plan_code'						=>$plan_code
				);

			$param = array('product_insurance_id'=>$product_insurance_id);
		
		$this->db->trans_begin();
		$this->model_product->function_update('mfi_product_insurance',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PRODUCT ASURANSI
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN AKAD
	/****************************************************************************************/
	public function akad()
	{
		$data['container']  = 'product/akad';
		$this->load->view('core',$data);
	}

	public function datatable_akad()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','akad_code','akad_name','type_product','jenis_keuntungan','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_akad($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_akad($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_akad(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			
			if($aRow['type_product']==0)
			{
				$type_product="Tabungan";
			}
			else if ($aRow['type_product']==1)
			{
				$type_product="Deposito";
			}
			else if ($aRow['type_product']==2)
			{
				$type_product="Pembiayaan";
			}
			else if ($aRow['type_product']==3)
			{
				$type_product="Asuransi";
			}

			if($aRow['jenis_keuntungan']==0)
			{
				$jenis_keuntungan="Tidak Ada Keuntungan";
			}
			else if($aRow['jenis_keuntungan']==1)
			{
				$jenis_keuntungan="Margin";
			}
			else if($aRow['jenis_keuntungan']==2)
			{
				$jenis_keuntungan="Bagi Hasil";
			}

			$row[] = '<input type="checkbox" value="'.$aRow['akad_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['akad_code'];
			$row[] = $aRow['akad_name'];
			$row[] = $type_product;
			$row[] = $jenis_keuntungan;
			$row[] = '<center><a href="javascript:;" akad_id="'.$aRow['akad_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_akad_by_akad_id()
	{
		$akad_id 		= $this->input->post('akad_id');
		$data 						= $this->model_product->get_akad_by_akad_id($akad_id);

		echo json_encode($data);
	}

	public function add_akad()
	{
		$akad_code 					= $this->input->post('akad_code');
		$akad_name 					= $this->input->post('akad_name');
		$type_product 				= $this->input->post('type_product');
		$jenis_keuntungan 			= $this->input->post('jenis_keuntungan');
		
			$data = array(
				 'akad_code'				=>$akad_code
				,'akad_name'				=>$akad_name
				,'type_product'				=>$type_product
				,'jenis_keuntungan'			=>$jenis_keuntungan
				);

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_akad',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function edit_akad()
	{
		$akad_id 					= $this->input->post('akad_id');
		$akad_code 					= $this->input->post('akad_code');
		$akad_name 					= $this->input->post('akad_name');
		$type_product 				= $this->input->post('type_product');
		$jenis_keuntungan 			= $this->input->post('jenis_keuntungan');

			$param = array('akad_id'=>$akad_id);
			$data = array(
				 'akad_code'				=>$akad_code
				,'akad_name'				=>$akad_name
				,'type_product'				=>$type_product
				,'jenis_keuntungan'			=>$jenis_keuntungan
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_akad',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_akad()
	{
		$akad_id = $this->input->post('akad_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($akad_id) ; $i++ )
		{
			$param = array('akad_id'=>$akad_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_akad',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END AKAD
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN CATEGORY
	/****************************************************************************************/
	public function list_category()
	{
		$data['container']  = 'product/list_category';
		$data['list_category']	= $this->model_product->function_select_all('mfi_list_code');
		$this->load->view('core',$data);
	}

	public function datatable_list_category()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','list_code_id','code_description','code_group','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_list_category($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_list_category($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_list_category(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();

			$row[] = '<input type="checkbox" value="'.$aRow['list_code_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['code_description'];
			$row[] = $aRow['code_group'];
			$row[] = '<center><a href="javascript:;" list_code_id="'.$aRow['list_code_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_list_category()
	{
		$code_description 		= $this->input->post('code_description');
		$code_group 			= $this->input->post('code_group');
		
			$data = array(
				 'code_description'			=>$code_description
				,'code_group'				=>$code_group
				);

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_list_code',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function get_list_category_by_list_code_id()
	{
		$list_code_id 		= $this->input->post('list_code_id');
		$data 				= $this->model_product->get_list_category_by_list_code_id($list_code_id);

		echo json_encode($data);
	}

	public function edit_list_category()
	{
		$list_code_id 			= $this->input->post('list_code_id');
		$code_description 		= $this->input->post('code_description');
		$code_group 			= $this->input->post('code_group');

			$param = array('list_code_id'=>$list_code_id);
			$data = array(
				 'code_description'			=>$code_description
				,'code_group'				=>$code_group
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_list_code',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_list_category()
	{
		$list_code_id = $this->input->post('list_code_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($list_code_id) ; $i++ )
		{
			$param = array('list_code_id'=>$list_code_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_list_code',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END CATEGORY
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN DETAIL CATEGORY
	/****************************************************************************************/	

	public function datatable_detail_list_category()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','code_group','code_value','display_text','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}
		$rResult 			= $this->model_product->datatable_detail_list_category($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_detail_list_category($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_detail_list_category(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();

			$row[] = '<input type="checkbox" value="'.$aRow['list_code_detail_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['code_group'];
			$row[] = $aRow['code_value'];
			$row[] = $aRow['display_text'];
			$row[] = '<center><a href="javascript:;" list_code_detail_id="'.$aRow['list_code_detail_id'].'" id="link-edit2">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	

	public function add_detail_list_category()
	{
		$code_group 		= $this->input->post('code_group');
		$code_value 		= $this->input->post('code_value');
		$display_text 		= $this->input->post('display_text');
		
			$data = array(
				 'code_group'			=>$code_group
				,'code_value'			=>$code_value
				,'display_text'			=>$display_text
				);

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_list_code_detail',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function get_detail_list_category_by_list_code_id()
	{
		$list_code_id_detail 		= $this->input->post('list_code_detail_id');
		$data 				= $this->model_product->get_detail_list_category_by_list_code_id($list_code_id_detail);

		echo json_encode($data);
	}

	public function edit_detail_list_category()
	{
		$list_code_detail_id 	= $this->input->post('list_code_detail_id');
		$code_group 			= $this->input->post('code_group');
		$code_value 			= $this->input->post('code_value');
		$display_text 			= $this->input->post('display_text');

			$param = array('list_code_detail_id'=>$list_code_detail_id);
			$data = array(
				 'code_group'			=>$code_group
				,'code_value'			=>$code_value
				,'display_text'			=>$display_text
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_list_code_detail',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_detail_list_category()
	{
		$list_code_detail_id = $this->input->post('list_code_detail_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($list_code_detail_id) ; $i++ )
		{
			$param = array('list_code_detail_id'=>$list_code_detail_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_list_code_detail',$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END DETAIL CATEGORY
	/****************************************************************************************/

}

/* End of file produk.php */
/* Location: ./application/controllers/produk.php */