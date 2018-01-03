<div>    
    <p>{{$to_name}},  {{$sender_fullname}} has sent you a cash customer. Please call the referral to earn their business!</p>
    <p>Here is the detail of the customer:</p>
    <p>Name: {{ $customer_fullname }}</p>
    <p>Email: {{ $customer_email }}</p>
    <p>Phone: {{ $customer_phone }}</p>
    @if($personal_message)
     <p>Message: {{$personal_message}}</p>
    @endif
</div>