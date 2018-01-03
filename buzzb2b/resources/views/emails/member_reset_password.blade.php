<div>
    <p>Hello  {{$first_name}} {{$last_name}},</b></td>
    <p>You have requested to reset your password</p>
    <p>Please use the following link to  <a href="{{URL::route('user_reset_newpassword',[$token])}}" style="text-decoration: none;">reset your password</a></p>
    <p>If you did not request this password change feel free to ignore it.</p>
    <br>
    <p>Thanks</p>
    <p>Sharlot Hall Museum</p>
 </div>