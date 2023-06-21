<page backbottom="10mm">
<page_footer><div style="text-align:center;width:100%;">([[page_cu]])</div></page_footer>
<h3 align="center" style="line-height:30px;"><?php echo $this->session->userdata('institution_name').'<br>'.$branch_name.'<br>REKAP MUTASI GL'; ?></h3>
<table>
    <tr>
        <td>Periode</td>
        <td>:</td>
        <td><?php echo $from_date.'-'.$thru_date; ?></td>
    </tr>
</table>
<hr size="1">
<br>
<table width="100" cellspacing="0" cellpadding="0" align="center">
    <thead>
        <tr>
            <th width="20" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">No</th>
            <th width="400" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Account</th>
            <th width="110" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Debet</th>
            <th width="110" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;border-right:solid 1px #ccc;">Credit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): ?>
        <tr>
            <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="left"><?php echo $row['nomor'] ?></td>
            <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC; white-space:normal; width:400px;" align="left"><?php echo $row['account'] ?></td>
            <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right"><?php echo (($row['debit']=='')?'':number_format($row['debit'],2,',','.')) ?></td>
            <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;" align="right"><?php echo (($row['credit']=='')?'':number_format($row['credit'],2,',','.')) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tr>
        <td></td>
        <td></td>
        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;background-color:#EEEEEE;" align="right"><?php echo number_format($total_debit,2,',','.') ?></td>
        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;background-color:#EEEEEE;" align="right"><?php echo number_format($total_credit,2,',','.') ?></td>
    </tr>
</table>
</page>