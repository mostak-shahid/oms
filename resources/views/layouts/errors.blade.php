@if(count($errors)>0)
    @php(var_dump($errors))
    <ul>
        @foreach($errors->all() as $error)
            <li class="text-danger">{{$error}}</li>
        @endforeach
    </ul>
@endif