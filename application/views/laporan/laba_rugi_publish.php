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
        LAPORAN LABA RUGI PUBLISH<small></small>
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
               <input type="text" name="branch" class="m-wrap mfi-textfield" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="background:#EEE"> 
               <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
            </td>
         </tr>
         <!-- <tr>
            <td style="padding-bottom:10px;">Periode</td>
            <td>
               <select id="periode_bulan" name="periode_bulan" class="m-wrap" style="width:110px">
                <option value="">Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
               </select>
               <select id="periode_tahun" name="periode_tahun" class="m-wrap" style="width:80px;">
                <option value="">Tahun</option>
                <?php
                for ( $i = date('Y')-5 ; $i <= date('Y') ; $i++ )
                {
                ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php
                }
                ?>
               </select>
            </td>
         </tr> -->
         <tr>
            <td></td>
            <td>
               <button class="green btn" id="preview">Preview</button>
            </td>
         </tr>
      </table>
   </form>
   <!-- END FILTER FORM -->
   <hr size="1">
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
   });
</script>

<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

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

   /* END DIALOG ACTION BRANCH */

   $("#preview").click(function(e){
        var branch_code = $("#branch_code").val();
        window.open('<?php echo base_url();?>laporan_to_pdf/export_lap_lr_publish/'+branch_code);
   });


   /*$("#filter").click(function(e){
      e.preventDefault();
      $.ajax({
         type: "POST",
         dataType: "json",
         url: site_url+"laporan/get_neraca_saldo_gl",
         data: {
            branch_code : $("#branch_code").val(),
            periode_bulan : $("#periode_bulan").val(),
            periode_tahun : $("#periode_tahun").val()
         },
         success: function(response){
            html = '';
            for(i = 0 ; i < response['data'].length ; i++)
            {
               html += '<tr> \
                  <td align="center">'+response['data'][i].nomor+'</td> \
                  <td>'+response['data'][i].account+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_awal,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].debit,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].credit,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_akhir,2,',','.')+'</td> \
               </tr>';
            }
            $("#total_debit").html(number_format(response['total_debit'],2,',','.'));
            $("#total_credit").html(number_format(response['total_credit'],2,',','.'));
            $("tbody","table#general_ledger ").html(html);
         }
      })
   });*/

/* END SCRIPT */
})
</script>