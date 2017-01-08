<html>
    <form action=<?php echo "/index.php/PhoneRegistration/GetPassword";?> method="post">
        <span>Phone No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><input name="txtPhoneNo" type="text"/><br/><br/>
        <span>Access Code&nbsp;</span><input name="txtAccessCode" type="text"/><br/><br/>
        <span><B><?=$result?></B></span><br/>
        <input type="submit">
    </form>
</html>