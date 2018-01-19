<?php
$message='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ececec;">
    <tbody>
    <tr>
		<td align="center" bgcolor="#ececec" height="20" width="640"></td>
    </tr>
    <tr>
		<td align="center" bgcolor="#ececec">
        	<table style="margin:0 10px; background-image:url(http://'.$_SERVER['HTTP_HOST'].'/img/logo.jpg); background-repeat:no-repeat;" border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" width="640">
            	<tbody><tr><td height="20" width="640"></td></tr>
				<tr>
                <td class="w640" align="left" width="640" height="50" style=""></td>
           </tr>
           		<!--<tr><td class="" bgcolor="#ffffff" height="20" width="640"></td></tr>-->
                <tr id="simple-content-row">
                <td class="" width="640">
<table class="" align="center" border="0" cellpadding="0" cellspacing="0" style="width:525px;z-index:999999999999;">
	<tbody><tr>
    	<td class="" width="30"></td>
        <td class="" width="480">
        	<repeater>
                <layout label="Text only">
                    <table class="" border="0" cellpadding="0" cellspacing="0" width="480">
                        <tbody><tr>
                           <td class="" width="480">
					       <p style="font-size: 14px; line-height:20px; margin-top:0px; margin-bottom:2px; font-family: HelveticaNeue, sans-serif;" align="left">
							   <singleline label="Title">Hello, '.$user_name.'!</singleline>
						  </p>
                               <p style="font-size: 14px; line-height:20px; margin-top:0px; margin-bottom:2px; font-family: HelveticaNeue, sans-serif;" align="left">
							   <singleline label="Title">The password for your '.$from_name.' account has successfully been changed.</singleline>
						  </p>
                                </td>
                            </tr>
                            <tr><td class="w580" height="10" width="480"></td></tr>
                        </tbody></table>
                    </layout>
                    
                </repeater>
            </td>
            <td class="w30" width="30"></td>
        </tr>
    </tbody></table>
</td></tr>
                <tr><td class="w640" bgcolor="#ffffff" height="15" width="640"></td></tr>
                
                <tr><td class="w640" height="60" width="640" style="background-color: #ececec;"></td></tr>
            </tbody></table>
        </td>
	</tr>
</tbody></table>';
?>