<html>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<body class="grey lighten-3" style="margin:3em">

    <div class="card">
        <div class="card-content">
            <form>
                <div class="input-field">
                    <input name="search" id="search" placeholder="enter one keyword" noautocomplete>
                </div>
            </form>
        </div>
    </div>

    @if($search)
    <h1>{{$search}}</h1>
    @endif

    <div class="row cards-container">
        @foreach($files as $f)
        <div class="col ">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('iox2019/'.$f)}}">
                </div>
                    <a href="{{route('image', $f)}}" class="btn btn-flat btn-block">...</a>
            </div>
        </div>
        @endforeach
    </div>


</body>

</html>
<style>
    .cards-container {
        -webkit-column-count: 6;
        -moz-column-count: 6;
        column-count: 6;
        column-break-inside: avoid;

    }

    .cards-container .card {
        display: inline-block;
        overflow: visible;
    }

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
