<div >
    <p>Hello {{ $first_name }} {{ $last_name }} ,</p>
    <p>Your Profile is created as a Member of Historical Museum</p>
    <p>Below are the details of your profile</p>
    <p>Username : <strong>{{ $to_email }}</strong></p>
    <p>Password : <strong>{{ $password }}</strong></p>
    <p>Please visit the link to login: {{ URL::route('front_member_login') }}</p>
    <br>
    <p>Thanks</p>
    <p>Sharlot Hall Museum</p>
</div>