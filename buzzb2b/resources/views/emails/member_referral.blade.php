<div >
    <p>Hello, {{ $to_name }}</p>
    @if($personal_message)
    <p>Your Friend send a referral message to you</p>
    <h4>{{$personal_message}}</h4>
    @endif
    <a href="https://vimeo.com/128273907">
     <img src="{{asset('/upload/referral.png')}}">
    </a>.
</div>