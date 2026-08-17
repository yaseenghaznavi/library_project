<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style type="text/css">
        .table_center{
            text-align: center;
            margin: auto;
            border: 1px solid white;
            margin-top: 50px;
        }

        th{
            background-color: skyblue;
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            color: black;
        }

        td{
            border: 1px solid white;
        }

        .img_author{
            width: 80px;
            border-radius: 50%;
        }

        .img_book{
            width: 150px;
            height: auto;
        }

    </style>

    {{-- Datable CSS --}}
    <link href="https://cdn.datatables.net/v/dt/dt-3.0.1/datatables.min.css" rel="stylesheet">


  </head>
  <body>
    <header class="header">   
      @include('admin.header')
    </header>
    
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{session()->get('message')}}

                    <button type="button" class="close" data-dismiss="alert" area-hidden="true">X</button>
                </div>
            @endif
            
            <div>
                <table class="table_center datatable">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Author Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Author Image</th>
                            <th>Book Image</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($book_data as $book)
                            <tr>
                                <td>{{$book->title}}</td>
                                <td>{{$book->author_name}}</td>
                                <td>{{$book->price}}</td>
                                <td>{{$book->quantity}}</td>
                                <td>{{$book->description}}</td>
                                <td>{{$book->category->cat_title}}</td>
                                <td>
                                    <img class="img_author" src="author/{{$book->author_img}}">
                                </td>
                                <td>
                                    <img class="img_book" src="book/{{$book->book_img}}">
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{url('edit_book', $book->id)}}">Update</a>
                                </td>
                                <td>
                                    <a onclick="confirmation(event)" href="{{url('book_delete', $book->id)}}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

          </div>
        </div>
      </div>
    
      @include('admin.footer')

      <script type="text/javascript">
        function confirmation(ev) { 
            ev.preventDefault(); 
            var urlToRedirect = ev.currentTarget.getAttribute('href'); 
            console.log(urlToRedirect); 
            swal({ 
                title: "Are you sure to Delete this", 
                text: "You will not be able to revert this!", 
                icon: "warning",
                buttons: true, 
                dangerMode: true, 
            })
            .then((willCancel) => { 
                    if (willCancel) { 
                    window.location.href= urlToRedirect; 
                }
            });
        }
      </script>

      <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>

      {{-- Datatable JS --}}
      <script src="https://cdn.datatables.net/v/dt/dt-3.0.1/datatables.min.js" ></script>

      <script type="text/javascript">

        $(document).ready(function(){
            $('.datatable').DataTable();
        });

      </script>

  </body>
</html>