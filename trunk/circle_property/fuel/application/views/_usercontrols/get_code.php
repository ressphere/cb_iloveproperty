<html>
    <body>
        <form action=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/GetAccessCode";?> method="post">
            <span>Phone No.</span><input name="txtPhoneNo" type="text"/><br/><br/>
            <input type="submit">
        </form>
    </body>
</html>
