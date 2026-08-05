<!DOCTYPE html>
<html lang="en">

<head>

    @include('home.css')

    <style type="text/css">
        .table_design{
            border: 1px solid white;
            margin: auto;
            text-align: center;
            margin-top: 100px;
        }

        th{
            background-color: skyblue;
            color: white;
            font-weight: bold;
            font-size: 18px;
            padding: 10px;
            border: 1px solid white;
        }

        td{
            color: white;
            background-color: black;
            border: 1px solid white;
        }

        .book_img{
            height: 120px;
            width: 80px;
            margin: auto;
        }

    </style>

</head>

<body>

    @include('home.header')

    <div class="currently-market">
        <div class="container">
            <div class="row">
                
                @if(session()->has('message'))
                    <div style="margin-top: 10px;" class="alert alert-success">
                        {{session()->get('message')}}
                        <button type="button" class="close" aria-hidden="true" data-bs-dismiss="alert">X</button>
                    </div>
                    
                @endif

                <table class="table_design">
                    <tr>
                        <th>Book Name</th>
                        <th>Book Author</th>
                        <th>Book Status</th>
                        <th>Book Image</th>
                        <th>Cancel Request</th>
                    </tr>

                    @foreach ($book_requests as $request)
                        <tr>
                            <td>{{$request->book->title}}</td>
                            <td>{{$request->book->author_name}}</td>
                            <td>{{$request->status}}</td>
                            <td>
                                <img class="book_img" src="book/{{$request->book->book_img}}">
                            </td>
                            <td>
                                @if($request->status == "Applied")
                                
                                    <a class="btn btn-warning" href="{{url('cancel_request', $request->id)}}">Cancel</a>
                                @else
                                    <p style="color: white; font-weight: bold;">Not Allowed</p>
                                @endif
                            </td>
                        </tr>
                        
                    @endforeach
                </table>

            </div>
        </div>
    </div>

    @include('home.footer')






</body>

</html>