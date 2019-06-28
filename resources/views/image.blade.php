<html>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<body class="grey lighten-3">
    <div class="card" style="margin:3em">
        <div class="card-content">
            <div class="center-align">
                <img src="{{url('iox2019/'.$id)}}" style="width:250px">
            </div>

            <span class="card-title">Labels</span>
            @foreach($json->labels as $lbl)
            <div class="chip">{{$lbl}}</div>
            @endforeach

            <span class="card-title">Web</span>
            @foreach($json->web as $lbl)
            <div class="chip">{{$lbl}}</div>
            @endforeach

            <span class="card-title">Text</span>
            @foreach($json->text as $lbl)
            <div class="chip">{{$lbl}}</div>
            @endforeach
        </div>
    </div>
</body>

</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
