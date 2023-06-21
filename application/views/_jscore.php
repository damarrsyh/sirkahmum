
<script type="text/javascript">
var site_url = "<?php echo site_url(); ?>";
var base_url = "<?php echo base_url(); ?>";
</script>

<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>   
<script src="<?php echo base_url(); ?>assets/plugins/google_chart/jsapi.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/google_chart/uds_api_contents.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/google_chart/jquery.min.js"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->  
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/ui/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.livequery.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/plugins/excanvas.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/respond.js"></script>  
<![endif]-->   
<script src="<?php echo base_url(); ?>assets/plugins/breakpoints/breakpoints.js" type="text/javascript"></script>  
<!-- IMPORTANT! jquery.slimscroll.min.js depends on jquery-ui-1.10.1.custom.min.js --> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/plugins/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.resize.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/date.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>     
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/confirm/jquery-confirm.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url(); ?>assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>assets/scripts/mfi.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/js-terbilang.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.printElement.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<script type="text/javascript">
var number_format = function( number, decimals, dec_point, thousands_sep ){	
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    // Add this number to the element as text.
    return s.join(dec);
};

var dont_block = false;

$(document).ready(function(){
    
    $(".nav-collapse > ul > li").click(function(){
        if($(this).children('.sub-menu').is(':visible')==false){
            App.scrollTo($(this), -200);
        }
    });
    
    $(document).ajaxStart(function(){
        if (dont_block==false) {
            $.blockUI({ message: '<div style="padding:5px 0;">Sedang Mengecek, Mohon Tunggu...</div>' ,css: { backgroundColor: '#fff', color: '#000', fontSize: '12px'} })
        }
    }).ajaxStop($.unblockUI);

    jQuery.validator.addMethod("cek_trx_kontrol_periode", function(value, element) {

        id=element.id;
        objid=$("#"+id);
        trx_date = value.split('/');
        day_trx_date = trx_date[0];
        month_trx_date = trx_date[1];
        year_trx_date = trx_date[2];
        
        from_date = new Date(<?php echo $year_periode_awal ?>,<?php echo $month_periode_awal ?>-1,<?php echo $day_periode_awal ?>);
        to_date = new Date(<?php echo $year_periode_akhir ?>,<?php echo $month_periode_akhir ?>-1,<?php echo $day_periode_akhir ?>);
        trx_date = new Date(year_trx_date,month_trx_date-1,day_trx_date);
        $("span.errtrxdate").remove();
        if(trx_date >= from_date && trx_date <= to_date) {
            ret = true;
        }else{
            ret = false;
            $("#form_process input[name='tanggal']").parent().append('<span class="help-inline ok errtrxdate" style="color:red">Tidak bisa melakukan transaksi diluar tanggal periode</span>');
        }

        return ret;
    }, "Tidak bisa melakukan transaksi diluar tanggal periode");

    jQuery.validator.addMethod("no_ktp_validate", function(value, element) {
        if($.trim(value)!="")
        {
            if(value.length==16){
                return true;
            }else{
                return false;
            }
        }
        else
        {
            return true;
        }
    }, "Harus 16 karakter");


    $(".date-picker").livequery(function(){
        $(this).datepicker();
    });
    $(".date-picker").live('change',function(){
        $(this).select();
        $("div.datepicker").remove();
    });
    $(".date-picker-tgl-lahir").livequery(function(){
        $(this).datepicker({
            startDate: '-100y',
            endDate: '-1y'
        });
    });
    $(".tgl_lahir").livequery(function(){
        $(this).datepicker({
            startDate: '-100y',
            endDate: '+0d'
        });
    });
    // $(".date-picker-range").livequery(function(){
    //     $(this).datepicker({
    //         minDate: '01/04/2015',
    //         maxDate: '30/04/2015',
    //         startDate: '1d',
    //         endDate: '+1m'
    //     });
    // });

    $("#loading").bind('show',function(){
        $(this).show();
    })

    $("#loading").bind('hide',function(){
        $(this).fadeOut('fast');
    });
    
    $(".mask-money").livequery(function(){
        $(this).inputmask('decimal',{
            placeholder:" ", 
            numericInput: true, 
            radixPoint: ",", 
            autoGroup: true, 
            groupSeparator: ".", 
            groupSize: 3,
            repeat: 15
        });
    });

    $(".mask-money").live('focus',function(){
        if($(this).val()==0 && $(this).attr('readonly')==undefined){
            $(this).val('');
        }
        $(this).select();
    });

    $(".mask-money").live('blur',function(){
        if($(this).val()=='' && $(this).attr('readonly')==undefined){
            $(this).val('0');
        }
    });

    
    /*
    |-------------------------------------------------------------------------------
    | BEGIN : ENTER EVENT FOR ADD & EDIT
    |-------------------------------------------------------------------------------
    */

    $("input,select","#form_add").live('keypress',function(e){
        if(e.keyCode==13) {
         e.preventDefault();
          if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT') {
            $(this).next().focus();
          }else{
            if($(this).closest('.control-group').next('.form-actions').length==1){
              $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
            }else{
              if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').attr('readonly'))!='undefined'){
                $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').focus();
                if(typeof($(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').offset())!='undefined'){
                    $(window).scrollTop($(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').offset().top - 200);
                }
              }else{
                $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').focus();
                if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').offset())!='undefined'){
                    $(window).scrollTop($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').offset().top - 200);
                }
              }
            }
          }
        }
    });

    $("input,select","#form_edit").live('keypress',function(e){
        if(e.keyCode==13){
         e.preventDefault();
          if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT'){
            $(this).next().focus();
          }else{
            if($(this).closest('.control-group').next('.form-actions').length==1){
              $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
            }else{
              if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').attr('readonly'))!='undefined'){
                $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').focus();
                if(typeof($(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').offset())!='undefined'){
                    $(window).scrollTop($(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').offset().top - 200);
                }
              }else{
                $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').focus();
                if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').offset())!='undefined'){
                    $(window).scrollTop($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').offset().top - 200);
                }
              }
            }
          }
        }
    });

    /*
    |-------------------------------------------------------------------------------
    | END : ENTER EVENT FOR ADD & EDIT
    |-------------------------------------------------------------------------------
    */
})

function convert_numeric(value)
{
    if(typeof(value)=="undefined"){
        value=0;
    }
    result = value.toString().replace(/\./g,'')//.replace(/\,/g,'.');
    return result;
}

function datepicker_replace(date){
    return date.replace(/\//g,'');
}
</script>