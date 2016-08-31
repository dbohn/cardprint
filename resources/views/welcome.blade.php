<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Namensschilder erstellen</title>

        <link rel="stylesheet" href="{{ url('css/app.css') }}">
    </head>
    <body>
        <div class="container">
            <h1>Namensschilder erstellen</h1>
            <form action="{{ url('cards/create') }}" method="POST">
                {{ csrf_field() }}
                @foreach(collect(range(0,9))->chunk(2) as $row)
                    <div class="row">
                        @foreach($row as $cell)
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" name="cards[{{ $cell }}]" placeholder="Namensschild {{ $cell }}">
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-md-12 text-right">
                        <div class="pull-left text-left">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="withGraphic" value="1"> Mit Hintergrundgrafik
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="skipEmpty" value="1"> Leere Felder nicht auswerten
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Namensschilder erstellen</button>
                        <button type="reset" class="btn btn-default">Zurücksetzen</button>
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>
