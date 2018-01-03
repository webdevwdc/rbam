<div>
    <p>Hello, {{ $name }}</p>
    <p>&nbsp;</p>
    <p>Welcome to BuzzB2B.</p>
    <p>Your generated password is: {{ $password }}.</p>
    <p>Following are the crendential for login: </p>
    <P>&nbsp;</P>
    <table border="0">
        <tr>
            <td>Email:</td>
            <td>{{$email}}</td>
        </tr>
        <tr>
            <td>Password:</td>
            <td>{{ $password }}</td>
        </tr>    
    </table>
    <p>Thanks</p>
</div>