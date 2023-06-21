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
        NERACA SALDO <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

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

<!-- BEGIN FORM-->
<div class="portlet-body form">
   <!-- BEGIN FILTER FORM -->
   <form>
      <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name'); ?>">
      <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
      <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
      <table id="filter-form">
         <tr>
            <td style="padding-bottom:10px;" width="100">Cabang</td>
            <td>
               <input type="text" name="branch" class="m-wrap medium" readonly style="background:#EEE" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
               <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
            </td>
         </tr>
         <tr>
            <td style="padding-bottom:10px;">Bulan-Tahun</td>
            <td>
              <select class="m-wrap small" id="month">
                <?php
                $tmonth = (int)date('m',strtotime($kontrol_periode['periode_awal']));
                $months = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                for ( $i = 1 ; $i < count($months) ; $i++) {
                  if ($i==$tmonth) {
                    ?>
                    <option selected="selected" value="<?php echo $i ?>"><?php echo $months[$i] ?></option>
                    <?php
                  } else {
                ?>
                <option value="<?php echo $i ?>"><?php echo $months[$i] ?></option>
                <?php } } ?>
              </select>
              <select class="m-wrap small" id="year">
                <?php
                $tyear = date('Y',strtotime($kontrol_periode['periode_awal']));
                for ( $j = 2014 ; $j <= date('Y') ; $j++) {
                  if ($j==$tyear) {
                    ?>
                    <option selected=""><?php echo $j ?></option>
                    <?php
                  } else {
                ?>
                <option><?php echo $j ?></option>
                <?php } } ?>
              </select>
            </td>
         </tr>
         <tr>
            <td style="padding-bottom:10px;">Tanggal</td>
            <td>
            <div class="input-append" style="margin-right:5px;">
               <input type="text" class="m-wrap small date-picker mask_date" disabled="" id="periode1" placeholder="dd/mm/yyyy" data-date-startdate="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_awal'])) ?>" data-date-enddate="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_akhir'])) ?>" value="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_awal'])) ?>" style="background-color:#f9f9f9;">
               <a href="javascript:void(0);" class="add-on btn"><i class="icon-calendar"></i></a>
            </div>
            <div class="input-append">
               <input type="text" class="m-wrap small date-picker mask_date" disabled="" id="periode2" placeholder="dd/mm/yyyy" data-date-startdate="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_awal'])) ?>" data-date-enddate="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_akhir'])) ?>" value="<?php echo date('d/m/Y',strtotime($kontrol_periode['periode_akhir'])) ?>" style="background-color:#f9f9f9;">
               <a href="javascript:void(0);" class="add-on btn"><i class="icon-calendar"></i></a>
            </div>
            </td>
         </tr>
         <tr>
            <td></td>
            <td>
               <button class="green btn" id="filter">Tampilkan</button>
               <button class="green btn" id="previewpdf">PDF</button>
               <button class="green btn" id="previewxls">Excel</button>
            </td>
         </tr>
      </table>
   </form>
   <!-- END FILTER FORM -->
   <hr size="1">
   <table width="100%" border="1" bordercolor="#CCC" cellpadding="5" id="general_ledger">
      <thead>
         <tr>
            <th style="background:#EEE;" width="5%">No.</th>
            <th style="background:#EEE;">Account</th>
            <th style="background:#EEE;" width="15%">Saldo Awal</th>
            <th style="background:#EEE;" width="15%">Debet</th>
            <th style="background:#EEE;" width="15%">Credit</th>
            <th style="background:#EEE;" width="15%">Saldo Akhir</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td colspan="6" align="center" style="padding:10px 5px;">
              Please Fill The Filter Option to Show Form
            </td>
         </tr>
      </tbody>
      <tfoot>
         <tr>
            <td></td>
            <td></td>
            <td align="right">Total</td>
            <td align="right" style="font-size:14px; background:#F5F5F5;"><span id="total_debit"></span></td>
            <td align="right" style="font-size:14px; background:#F5F5F5;"><span id="total_credit"></span></td>
            <td></td>
         </tr>
      </tfoot>
   </table>
</div>

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y", {autoUnmask: true});  //direct mask
      });
      
      $('.add-on').click(function(e){
        e.preventDefault();
        $(this).closest('.input-append').find('input').focus();
      })
   });
</script>

<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */
  
  $('#month,#year').change(function(){
    month = parseInt($('#month').val());
    year = parseInt($('#year').val());
    var lastDate = new Date(year, month, 0);
    if (month<10) {
      month = '0'+month;
    }
    var startDate = '01/'+month+'/'+year;
    var endDate = lastDate.getDate()+'/'+month+'/'+year;
    $('#periode1').datepicker('setStartDate',startDate);
    $('#periode1').datepicker('setEndDate',endDate);
    $('#periode2').datepicker('setStartDate',startDate);
    $('#periode2').datepicker('setEndDate',endDate);
    
    $('#periode1').datepicker('setDate',new Date(year , (month-1), 1));
    $('#periode2').datepicker('setDate',new Date(year , (month-1), lastDate.getDate()));
  });

   /* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
   })

   $("#keyword","#dialog_branch").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_branch_by_keyword",
            dataType: "json",
            data: {keyword:keyword},
            success: function(response){
               html = '';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
               }
               $("#result","#dialog_branch").html(html);
            }
         })
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

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('reloadGrid');
   });

   /* END DIALOG ACTION BRANCH */

   $("#filter").click(function(e){
      e.preventDefault();
      $.ajax({
         type: "POST",
         dataType: "json",
         url: site_url+"laporan/get_neraca_saldo_gl2",
         data: {
            branch_code : $("#branch_code").val(),
            periode1 : $('#periode1').val(),
            periode2 : $('#periode2').val()
         },
         success: function(response){
            html = '';
            for(i = 0 ; i < response['data'].length ; i++)
            {
               html += '<tr> \
                  <td align="center">'+response['data'][i].nomor+'</td> \
                  <td>'+response['data'][i].account+'</td> \
                  <td align="right" style="font-size:14px;">'+((response['data'][i].saldo_awal=='')?'':number_format(response['data'][i].saldo_awal,2,',','.'))+'</td> \
                  <td align="right" style="font-size:14px;">'+((response['data'][i].debit=='')?'':number_format(response['data'][i].debit,2,',','.'))+'</td> \
                  <td align="right" style="font-size:14px;">'+((response['data'][i].credit=='')?'':number_format(response['data'][i].credit,2,',','.'))+'</td> \
                  <td align="right" style="font-size:14px;">'+((response['data'][i].saldo_akhir=='')?'':number_format(response['data'][i].saldo_akhir,2,',','.'))+'</td> \
               </tr>';
            }
            $("#total_debit").html(number_format(response['total_debit'],2,',','.'));
            $("#total_credit").html(number_format(response['total_credit'],2,',','.'));
            $("tbody","table#general_ledger ").html(html);
         }
      })
   });
   $("#previewpdf").click(function(e){
      e.preventDefault();
      var branch_code = $("#branch_code").val();
      var periode1 = $("#periode1").val();
      var periode2 = $("#periode2").val();
      window.open(site_url+"laporan_to_pdf/neraca_saldo_gl2/"+branch_code+"/"+periode1+"/"+periode2);
   });
   $("#previewxls").click(function(e){
      e.preventDefault();
      var branch_code = $("#branch_code").val();
      var periode1 = $("#periode1").val();
      var periode2 = $("#periode2").val();
      window.open(site_url+"laporan_to_excel/neraca_saldo_gl2/"+branch_code+"/"+periode1+"/"+periode2);
   });

/* END SCRIPT */
})
</script>