<style type="text/css">
  
#t_JurnalUmumRev{
  height: 40px;
  width: 1080;
}
</style>
<!-- BEGIN PAGE HEADER-->
<div class="row-fluid">
   <div class="span12">
      <!-- BEGIN STYLE CUSTOMIZER -->
      <div class="color-panel hidden-phone">
         <div class="color-mode-icons icon-color"></div>
         <div class="color-mode-icons icon-color-close"></div>
         <div class="color-mode">
            <p>THEME COLOR</p>
            <ul class="inline">
               <li class="color-black current color-default" data-style="default"></li>
               <li class="color-blue" data-style="blue"></li>
               <li class="color-brown" data-style="brown"></li>
               <li class="color-purple" data-style="purple"></li>
               <li class="color-white color-light" data-style="light"></li>
            </ul>
            <label class="hidden-phone">
            <input type="checkbox" class="header" checked value="" />
            <span class="color-mode-label">Fixed Header</span>
            </label>                   
         </div>
      </div>
      <!-- END BEGIN STYLE CUSTOMIZER -->
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Jurnal Umum Revisi <small>Untuk melakukan revisi jurnal umum user</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div class="grid-revisi">
<!-- FILTER PERIODE TRANSAKSI -->
<div class="row-fluid">
  <div class="span12">
    <table>
      <tr>
        <td style="padding-top:8px;vertical-align:top;">Periode Voucher Date </td>
        <td style="padding-top:8px;vertical-align:top;">:</td>
        <td>
          <input type="text" id="from_date" class="m-wrap normal mask_date date-picker">
        </td>
        <td>
          <input type="text" id="thru_date" class="m-wrap normal mask_date date-picker">
        </td>
        <td style="vertical-align:top;">
          <input type="submit" id="search" class="btn green" value="Tampilkan">
        </td>
      </tr>
    </table>
  </div>
</div>

<!-- BEGIN GRID TABLE -->
<div class="row-fluid">
   <div class="span12">
    <div id="wraper_table">
      <table id="JurnalUmumRev"></table>
      <div id="pJurnalUmumRev"></div>
    </div>
  </div>
</div>
<!-- END GRID TABLE -->
</div>

<!-- BEGIN PROSES PINBUK -->

  <!-- BEGIN FORM-->
  <div class="portlet-body form form-revisi" style="display:none;">
    <div class="alert alert-error hide">
       Please Fill All Field Below !
    </div>
    <div class="alert alert-success hide">
       Pemindah Bukuan Sukses !
    </div>
      <form id="form_process" class="form-horizontal">

        <!-- DIALOG BRANCH -->
        <div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Kantor Cabang</h3>
           </div>
           <div class="modal-body">
              <div class="row-fluid">
                 <div class="span12">
                    <h4>Masukan Kata Kunci</h4>
                    <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                    <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                 </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
              <button type="button" id="select" class="btn blue">Select</button>
           </div>
        </div>

        <!-- DIALOG CM -->
        <div id="dialog_cm" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Rembug Pusat</h3>
           </div>
           <div class="modal-body">
              <div class="row-fluid">
                 <div class="span12">
                    <h4>Masukan Kata Kunci</h4>
                    <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                    <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                 </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
              <button type="button" id="select" class="btn blue">Select</button>
           </div>
        </div>

        <!-- DIALOG FA -->
        <div id="dialog_fa" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Field Assistant</h3>
           </div>
           <div class="modal-body">
              <div class="row-fluid">
                 <div class="span12">
                    <h4>Masukan Kata Kunci</h4>
                    <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                    <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                 </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
              <button type="button" id="select" class="btn blue">Select</button>
           </div>
        </div>
        <table>
          <tr>
            <td width="120">Kantor Cabang</td>
            <td>
              <input type="text" name="branch" tabindex="1" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="background-color:#DDDDDD;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> 
              <!-- <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a> -->
            </td>
            <td width="50"></td>
            <td width="100">No. Referensi</td>
            <td><input type="text" name="no_referensi" tabindex="3" size="10" id="no_referensi" style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
            <td></td>
          </tr>
          <tr>
            <td width="100" valign="top">Tanggal</td>
            <td valign="top"><input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" maxlength="10" value="<?php echo $current_date; ?>" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
            <td width="50"></td>
            <td valign="top">Deskripsi</td>
            <td valign="top" width="260">
              <textarea id="deskripsi" name="deskripsi" tabindex="4" style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></textarea>
            </td>
            <td valign="bottom" style="padding-bottom:5px;"><button tabindex="5" class="hide btn green search">New Transaction</button></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
        </table>
      </form>

      
      <!-- <hr> -->
      <p>&nbsp;</p>
      <form id="process_transaksi_jurnal" method="post">
        <input type="hidden" name="trx_gl_id" id="trx_gl_id">
        <input type="hidden" name="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
        <input type="hidden" name="tanggal2" value="<?php echo $current_date; ?>">
        <input type="hidden" name="no_referensi2">
        <input type="hidden" name="deskripsi2">
        <div id="tform_loading"></div>
        <!-- <div style="padding:10px;border-left:solid 1px #CCC; border-right:solid 1px #CCC; border-top:solid 1px #CCC"> -->
          <table width="100%" id="form">
            <thead>
              <tr>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="496px">AKUN</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">DEBET</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">CREDIT</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">DESKRIPSI</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border:solid 1px #CCC;" width="50">
              		<img src="<?php echo base_url('assets/img/yes.png'); ?>">
              	</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border:solid 1px #CCC;" width="50">
              		<img src="<?php echo base_url('assets/img/cancel.png'); ?>" width="26">
              	</td>
              </tr>
            </thead>
            <tbody>
              <tr>
              	
              <tr>
            </tbody>
            <tfoot>
              <tr>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
              		<select id="account_def" tabindex="6" style="width:480px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              			<option value="">&nbsp;</option>
              		</select>
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
              		<input type="text" tabindex="7" value="0" id="debet_def" class="mask-money" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
              		<input type="text" value="0" tabindex="8" id="credit_def" class="mask-money" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
              		<textarea id="description_def" tabindex="9" rows="1" style="resize:none;height:20px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></textarea>
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">
              		<a href="javascript:void(0);" tabindex="10" id="yes_def"><img src="<?php echo base_url('assets/img/yes.png'); ?>"></a>
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">
              		<a href="javascript:void(0);" tabindex="11" id="no_def"><img src="<?php echo base_url('assets/img/cancel.png'); ?>" width="26"></a>
              	</td>
              <tr>
            </tfoot>
          </table>
      <!-- </div> -->
      </form>
      <div align="center" style="margin-top:20px;">
         <button type="submit" style="margin-right:20px;" tabindex="12" class="btn blue" id="save_trx">Save</button>
         <button type="reset" class="btn red" tabindex="13" id="cancel_trx">Cancel</button>
      </div>
  </div>
  <!-- END FORM-->

<!-- END PROSES PINBUK -->


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
     
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y", {autoUnmask: false});  //direct mask
      });

      $("#account_def").each(function(){
          $(this).chosen({
              allow_single_deselect: $(this).attr("data-with-diselect") === "1" ? true : false,
              search_contains: true
          });
      });

   });
</script>

<script type="text/javascript">
$(function(){

  jQuery("#search").click(function(){
    jQuery("#JurnalUmumRev").trigger('reloadGrid');
  })

  jQuery("#JurnalUmumRev").jqGrid({
    url: site_url+'transaction/get_jurnal_umum_rev',
    datatype: 'json',
    height: '300',
    postData: {
      from_date: function(){ return $("#from_date").val() },
      thru_date: function(){ return $("#thru_date").val() }
    },
    // width:1000,
    shrinkToFit: false,
    rowNum: 20,
    autowidth: true,
    rowList: [10,20,50,100],
      colNames:['ID','Trx Date','Voucher Date','Voucher Ref','Description','Total Debit','Total Credit','User Input'],
      colModel:[
        {name:'trx_gl_id',index:'trx_gl_id', width:150, hidden:true}
        ,{name:'trx_date',index:'trx_date', width:100, align:'center'}
        ,{name:'voucher_date',index:'voucher_date', width:100, align:'center'}
        ,{name:'voucher_ref',index:'voucher_ref', width:100, align:'center', hidden:false}
        ,{name:'description',index:'description', width:300}
        ,{name:'total_debit',index:'total_debit', width:100, align:'right', formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 2}}
        ,{name:'total_credit',index:'total_credit', width:100, align:'right', formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 2}}
        ,{name:'fullname',index:'fullname', width:200,align:'center'}
      ],
      pager: "#pJurnalUmumRev",
      viewrecords: true,
      sortname: 'trx_date',
      rownumbers: true,
      toolbar:[true,"top"],
      caption: "REVISI JURNAL UMUM"
  });
  $("#t_JurnalUmumRev").append('<div style="margin:2px;"><button id="btn_delete" class="btn red" style="font-size:13px;">Delete Jurnal</button> <button id="btn_edit" class="btn green" style="font-size:13px;">Edit Jurnal</button></div>');

/**
* BEGIN ACTION DELETE & EDIT JURNAL 
*/

  // EDIT JURNAL
  $("#btn_edit").click(function(e){
    e.preventDefault();
    var selrow = $("#JurnalUmumRev").jqGrid('getGridParam','selrow');
    if(selrow){
      var data = $("#JurnalUmumRev").jqGrid('getRowData',selrow);
      var trx_gl_id = data.trx_gl_id;
      var trx_date = data.trx_date;
      var voucher_date = data.voucher_date;
      var voucher_ref = data.voucher_ref;
      var description = data.description;
      $("#trx_gl_id",".form-revisi").val(trx_gl_id);
      $("#tanggal",".form-revisi").val(trx_date);
      $("#no_referensi",".form-revisi").val(voucher_ref);
      $("#deskripsi",".form-revisi").val(description);
      $("input[name='tanggal2']").val(trx_date);
      $("input[name='no_referensi2']").val(voucher_ref);
      $("input[name='deskripsi2']").val(description);
      $(".form-revisi").show();
      $(".grid-revisi").hide();
      $(".search").trigger('click');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/get_jurnal_umum_rev_detail",
        data: {
          trx_gl_id:trx_gl_id
        },
        success: function(response){
          var html = '';

          for(i in response)
          {
            account_code=response[i].account_code;
            gl_account_id=$("#account_def option[value='"+account_code+"']").attr('gl_account_id');
            account_type=$("#account_def option[value='"+account_code+"']").attr('account_type');
            account_group_code=$("#account_def option[value='"+account_code+"']").attr('account_group_code');
            $("#account_def option[value='"+account_code+"']").attr('selected',true);
            account_copied = $("#account_def").html();
            console.log($("#account_def").val())
            html += ' \
              <tr> \
                <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
                  <input type="hidden" name="account_code[]" id="account_code" value="'+account_code+'"> \
                  <input type="hidden" name="gl_account_id[]" id="gl_account_id" value="'+gl_account_id+'"> \
                  <input type="hidden" name="account_type[]" id="account_type" value="'+account_type+'"> \
                  <input type="hidden" name="account_group_code[]" id="account_group_code" value="'+account_group_code+'"> \
                  <select id="account" name="account[]" disabled style="width:480px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">'+account_copied+'</select> \
                </td> \
                <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
                  <input type="text" id="debet" name="debet[]" class="mask-money" readonly style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" value="'+((response[i].flag_debit_credit=='D')?response[i].amount:'')+'"> \
                </td> \
                <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
                  <input type="text" id="credit" name="credit[]" class="mask-money" readonly style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" value="'+((response[i].flag_debit_credit=='C')?response[i].amount:'')+'"> \
                </td> \
                <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
                  <textarea id="description" name="description[]" rows="1" readonly style="resize:none;height:20px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">'+response[i].description+'</textarea> \
                </td> \
                <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
                    <a href="javascript:void(0);" id="yes" name="yes[]"><img src="<?php echo base_url("assets/img/yes.png"); ?>" width="26"/></a> \
                </td> \
                <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
                    <a href="javascript:void(0);" id="no" name="no[]"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"/></a> \
                </td> \
              <tr>';
            $("#account_def option[value='"+account_code+"']").attr('selected',false);

          }
          $("#account_def").val('');
          $("#process_transaksi_jurnal table tbody").html(html);

        }
      })
    }else{
      alert("please select a row");
    }

  });

  // DELETE JURNAL
  $("#btn_delete").click(function(){
    selrow = $("#JurnalUmumRev").jqGrid('getGridParam','selrow');
    if(selrow)
    {
      data = $("#JurnalUmumRev").jqGrid('getRowData',selrow);
      trx_gl_id = data.trx_gl_id;
      conf = confirm("Apakah anda yakin akan menghapus jurnal transaksi ini ?");
      if(conf){
        $.ajax({
          type: "POST",
          url: site_url+"transaction/delete_jurnal_transaksi",
          dataType: "json",
          data: {trx_gl_id:trx_gl_id},
          async: false,
          success: function(response){
            if(response.success==true){
              alert("Jurnal Transaksi berhasil dihapus!");
              $("#JurnalUmumRev").trigger('reloadGrid');
              $("#JurnalUmumRev").trigger('reloadGrid'); 
              $("input#trx_gl_id").val('');
            }else{
              alert("Failed to connect into databases, please contact your administrator!")
            }
          },
          error: function(){
            alert("Failed to connect into databases, please contact your administrator!")
          }
        })
      }
    }
    else
    {
      alert("please select a row")
    }
  })

/**
* END ACTION DELETE & EDIT JURNAL 
*/




  $("#tform_loading").bind('show',function(){
    form_height = $("#form").height();
    $(this).height(form_height);
    form_width = $("#form").width();
    $(this).width(form_width);
    $(this).fadeIn('normal');
  })

  $("#tform_loading").bind('hide',function(){
    $(this).fadeOut('normal');
  })

  $("input[name='tanggal']").change(function(){
    $("input[name='tanggal2']").val($(this).val());
  });
  $("input[name='no_referensi']").keyup(function(){
    $("input[name='no_referensi2']").val($(this).val());
  });
  $("#deskripsi").keyup(function(){
    $("input[name='deskripsi2']").val($(this).val());
  });
  $("input[name='no_referensi']").change(function(){
    $("input[name='no_referensi2']").val($(this).val());
  });
  $("#deskripsi").change(function(){
    $("input[name='deskripsi2']").val($(this).val());
  });
  $("input[name='no_referensi']").blur(function(){
    $("input[name='no_referensi2']").val($(this).val());
  });
  $("#deskripsi").blur(function(){
    $("input[name='deskripsi2']").val($(this).val());
  });

  $("#keyword","#dialog_branch").keypress(function(e){
    // e.preventDefault();
    keyword = $(this).val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_name+' - '+response[i].branch_code+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      });
      return false;
    }
  });

  $("#select","#dialog_branch").click(function(){
    branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
    result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    result_code = $("#result","#dialog_branch").val();
    if(result!=null)
    {
      $("input[name='branch']").val(result_name);
      $("input[name='branch_code']").val(result_code);
      $("input[name='branch_id']").val(branch_id);
      $("#close","#dialog_branch").trigger('click');
    }
  });

  $("#result option","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
  });

  var form1 = $('#form_process');
  var error1 = $('.alert-error');
  var success1 = $('.alert-success');

  form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(error, element) {
      error.appendTo( element.parent(".controls") );
    },
    rules: {
          branch: {
              required: true
          },
          tanggal: {
              required: true,
              cek_trx_kontrol_periode : true
          },
          cm: {
              required: true
          },
          fa: {
              required: true
          }
    },

    invalidHandler: function (event, validator) { //display error alert on form submit              
        success1.hide();
        error1.show();
        App.scrollTo(error1, -200);
    },

    highlight: function (element) { // hightlight error inputs
        $(element)
            .closest('.help-inline').removeClass('ok'); // display OK icon
        $(element)
            .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
    },

    unhighlight: function (element) { // revert the change dony by hightlight
        $(element)
            .closest('.control-group').removeClass('error'); // set error class to the control group
    },

    success: function (label) {
      if(label.closest('.input-append').length==0)
      {
        label
            .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
        .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
      }
      else
      {
         label.closest('.control-group').removeClass('error').addClass('success')
         label.remove();
      }
    },

    submitHandler: false
  
  });

  $(".search").click(function(e){
    e.preventDefault();
    if(form1.valid()===true)
    {
      $("#tform_loading").trigger('show');
      error1.hide();
      var branch_code = $("#branch_code").val();
      $.ajax({
        url: site_url+"transaction/ajax_get_gl_account",
        type: "POST",
        dataType: "json",
        async:false,
        data: { branch_code : branch_code },
        success: function(response){
          html = '<option selected></option>';

          for ( i = 0 ; i < response.length ; i++ )
          {
            html += '<option value="'+response[i].account_code+'" gl_account_id="'+response[i].gl_account_id+'" account_type="'+response[i].account_type+'" account_group_code="'+response[i].account_group_code+'">'+response[i].account_name+' - '+response[i].account_code+'</option>';
          }

          $("#account_def").html(html);
          $("#tform_loading").trigger('hide');
          $('#account_def').trigger("liszt:updated");
        },
        error: function(){
          $("#tform_loading").trigger('hide');
          alert("Failed to Connect into Databases, Please Contact Your Administrator!");
        }
      });
      $("#process_transaksi_jurnal table tbody").html('<tr></tr>');
    }
  });

  $("a#yes").live('click',function(){
  	var account_def = $("#account_def");
  	var debet_def = $("#debet_def");
  	var credit_def = $("#credit_def");
  	var description_def = $("#description_def");
  	var account_copied = $("#account_def").html();
  	var account_def_option = $("select#account_def option:selected");
  	var account_code = account_def.val();
  	var gl_account_id = account_def_option.attr('gl_account_id');
  	var account_type = account_def_option.attr('account_type');
  	var account_group_code = account_def_option.attr('account_group_code');

  	html = ' \
  	      <tr> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<input type="hidden" name="account_code[]" id="account_code" value="'+account_code+'"> \
          		<input type="hidden" name="gl_account_id[]" id="gl_account_id" value="'+gl_account_id+'"> \
          		<input type="hidden" name="account_type[]" id="account_type" value="'+account_type+'"> \
          		<input type="hidden" name="account_group_code[]" id="account_group_code" value="'+account_group_code+'"> \
          		<select id="account" name="account[]" style="width:480px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">'+account_copied+'</select> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<input type="text" id="debet" name="debet[]" class="mask-money" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" value="0"> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<input type="text" id="credit" name="credit[]" class="mask-money" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" value="0"> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<textarea id="description" name="description[]" rows="1" style="resize:none;height:20px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></textarea> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
              	<a href="javascript:void(0);" id="save"><img src="<?php echo base_url("assets/img/save.gif"); ?>" width="26"/></a> \
              	<a href="javascript:void(0);" id="yes" style="display:none;" name="yes[]"><img src="<?php echo base_url("assets/img/yes.png"); ?>" width="26"/></a> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
              	<a href="javascript:void(0);" id="no" name="no[]"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"/></a> \
          	</td> \
          <tr>';
  
    $(this).parent().parent().after(html);
    $("#account_def").val('');
    $("#debet_def").val('0');
    $("#credit_def").val('0');
    $("#description_def").val('');

    $("select#account").each(function(){
      console.log($(this).attr('disablexd'));
      if($(this).attr('disabled')==undefined){
        console.log($(this)+'-1');
        $(this).chosen({
            allow_single_deselect: $(this).attr("data-with-diselect") === "1" ? true : false,
            search_contains: true
        });
      }
    });

  })

  $("a#save").live('click',function(){
    if( $(this).parent().parent().find('#account').val()=="" ||
      $(this).parent().parent().find('#debit').val()=="" ||
      $(this).parent().parent().find('#credit').val()=="" )
    {
      alert("Harap isi field yg kosong!");
    }
    else
    {
      $(this).parent().parent().find("#account").attr('readonly',true);
      $(this).parent().parent().find("#debet").attr('readonly',true);
      $(this).parent().parent().find("#credit").attr('readonly',true);
      $(this).parent().parent().find("#description").attr('readonly',true);
      var account_code = $(this).parent().parent().find("#account").val();
      var gl_account_id = $(this).parent().parent().find("#account option:selected").attr('gl_account_id');
      var account_type = $(this).parent().parent().find("#account option:selected").attr('account_type');
      var account_group_code = $(this).parent().parent().find("#account option:selected").attr('account_group_code');
      $(this).parent().parent().find("#account_code").val(account_code);
      $(this).parent().parent().find("#gl_account_id").val(gl_account_id);
      $(this).parent().parent().find("#account_type").val(account_type);
      $(this).parent().parent().find("#account_group_code").val(account_group_code);
      $(this).parent().find('#yes').show();
      $(this).remove();
      // $(this).closest("tr").find('#account').prop('disabled', true).trigger('liszt:updated');
      $("div#account_chzn").remove();
      $("select#account").show().attr('disabled',true);
    }
  });

  $("a#no").live('click',function(){
  	$(this).parent().parent().remove();
  })

  $("#no_def").click(function(){
  	$("#account_def").val('');
    $('#account_def').trigger("liszt:updated"); //update chosen
	  $("#debet_def").val('0');
	  $("#credit_def").val('0');
	  $("#description_def").val('');
  })

  $("#yes_def").click(function(){

  	var account_def = $("#account_def");
  	var debet_def = $("#debet_def");
  	var credit_def = $("#credit_def");
  	var description_def = $("#description_def");
  	var account_copied = $("#account_def").html();
  	var account_def_option = $("select#account_def option:selected");
  	var account_code = account_def.val();
  	var gl_account_id = account_def_option.attr('gl_account_id');
  	var account_type = account_def_option.attr('account_type');
  	var account_group_code = account_def_option.attr('account_group_code');

  	if( account_def.val()=="" ||
  		debet_def.val()=="" ||
  		credit_def.val()==""
  	   )
  	{
  		alert("Harap isi field yg kosong!");
  	}
  	else
  	{

    	html = ' \
    	      <tr> \
            	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
            		<input type="hidden" name="account_code[]" id="account_code" value="'+account_code+'"> \
            		<input type="hidden" name="gl_account_id[]" id="gl_account_id" value="'+gl_account_id+'"> \
            		<input type="hidden" name="account_type[]" id="account_type" value="'+account_type+'"> \
            		<input type="hidden" name="account_group_code[]" id="account_group_code" value="'+account_group_code+'"> \
            		<select id="account" name="account[]" disabled style="width:480px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">'+account_copied+'</select> \
            	</td> \
            	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
            		<input type="text" id="debet" name="debet[]" class="mask-money" readonly style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" value="'+debet_def.val()+'"> \
            	</td> \
            	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
            		<input type="text" id="credit" name="credit[]" class="mask-money" readonly style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" value="'+credit_def.val()+'"> \
            	</td> \
            	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
            		<textarea id="description" name="description[]" rows="1" readonly style="resize:none;height:20px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">'+description_def.val()+'</textarea> \
            	</td> \
            	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
                	<a href="javascript:void(0);" id="yes" name="yes[]"><img src="<?php echo base_url("assets/img/yes.png"); ?>" width="26"/></a> \
            	</td> \
            	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
                	<a href="javascript:void(0);" id="no" name="no[]"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"/></a> \
            	</td> \
            <tr>';


    	$("#process_transaksi_jurnal tbody").append(html);
      $("select#account:last").val(account_def.val());

      //reset
      $("#account_def").val('');
      $('#account_def').trigger("liszt:updated"); //update chosen
      $("#description_def").val('');
      $("#credit_def").val('0');
      $("#debet_def").val('0');
      $("#credit_def").select();
      $("#debet_def").select();

      }

    });

  $("#save_trx").click(function(){
    var num_of_transaction = 0;
    $("select#account").each(function(){
      if($(this).is(':disabled')==true){
        num_of_transaction++;
      }
    });

    if(num_of_transaction==0){
      alert("Mohon input transaksi terlebih dahulu sebelum di save");
    }
    else if($("#account_def").val()!=""){
      alert("Selesaikan Transaksi terlebih dahulu sebelum di save.");
    }
    else
    {

      $("#loading").trigger('show');
      $.ajax({
        type: "POST",
        dataType: "json",
        data: $("#process_transaksi_jurnal").serialize(),
        url: site_url+"transaction/update_transaksi_jurnal",
        async: false,
        success: function(response){
          if(response.success===true){
            alert(response.message);
            // $("#process_transaksi_jurnal tbody").html('<tr></tr>');
            $("#cancel_trx").trigger('click');
            $("#JurnalUmumRev").trigger('reloadGrid');
          }else{
            alert(response.message);
          }
          $("#loading").trigger('hide');
        },
        error: function(){
          $("#loading").trigger('hide');
          alert("Failed to Connect into Databases, Please Contact Your Administrator!")
        }
      });
    }
  });

  $("#cancel_trx").click(function(){
      $(".form-revisi").hide();
      $(".grid-revisi").show();
  });

});
</script>