<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')

    <style>
        .center{
            text-align: center;
            margin: auto;
            width: 90%;
            border: 1px solid white;
            margin-top: 60px;
        }

        th{
            background-color: skyblue;
            text-align: center;
            color: white;
            font-size: 15px;
            font-weight: bold;
            padding: 10px;
        }

        td{
            border: 1px solid white;
            text-align: center;
            color: white;
            font-size: 15px;
            font-weight: bold;
            padding: 4px;
        }

    </style>
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

            <div>
                <table class="center">
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Book Name</th>
                        <th>Quantity</th>
                        <th>Borrow Status</th>
                        <th>Book Image</th>
                        <th>Change Status</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Fine</th>
                    </tr>
                    @foreach ($book_requests as $request)
                    <tr>
                            <td>{{$request->user->name}}</td>
                            <td>{{$request->user->email}}</td>
                            <td>{{$request->user->phone}}</td>
                            <td>{{$request->book->title}}</td>
                            <td>{{$request->book->quantity}}</td>
                            <td>
                                @if($request->status == 'Approved')
                                    <span style="color: skyblue">
                                        {{$request->status}}
                                    </span>
                                @elseif($request->status == 'Returned')
                                    <span style="color: Yellow">
                                        {{$request->status}}
                                    </span>
                                @elseif($request->status == 'Applied')
                                    <span style="color: white">
                                        {{$request->status}}
                                    </span>
                                @else
                                    <span style="color: red">
                                        {{$request->status}}
                                    </span>

                                @endif    
                            </td>
                            <td>
                                <img style="height: 150px; width: 90px;" src="book/{{$request->book->book_img}}" alt="">
                            </td>
                            <td>
                                <a class="btn btn-info" href="{{url('approve_book', $request->id)}}">Approved</a>
                                <a class="btn btn-danger" href="{{url('rejected_book', $request->id)}}">Rejected</a>
                                <a class="btn btn-warning" href="{{url('return_book', $request->id)}}">Returned</a>
                            </td>
                            <td>
                                {{-- {{$request->borrow_date}} --}}
                                @if ($request->borrow_date != null)
                                    {{$request->borrow_date}}
                                @else
                                    <p>-</p>
                                @endif
                            </td>
                            <td>
                                @if ($request->due_date != null)
                                    {{$request->due_date}}
                                @else
                                    <p>-</p>
                                @endif    
                            </td>
                            <td>
                                @if ($request->return_date != null)
                                    {{$request->return_date}}
                                @else
                                    <p>-</p>
                                @endif    
                            </td>
                            <td>
                                {{$request->fine}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

          </div>
        </div>
      </div>
    
      @include('admin.footer')
  </body>
</html>
