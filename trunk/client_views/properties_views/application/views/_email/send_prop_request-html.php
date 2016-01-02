<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Someone Is Interested In Your Property ( <?php echo $serial; ?> )</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<B>
    Someone Is Interested In Your Property (<a href="<?=$url?>" target="_top">
        <?php echo $serial; ?>
    </a>)
</B>
<span><br>
        Enquiry come from <br>
        <?=$name?> 
        (<a href="tel:<?=$phone?>"><?=$phone?></a>)
</span>
<br /><br />
<?=nl2br($content)?>
<br/>

</td>
</tr>
</table>
</div>
</body>
</html>
