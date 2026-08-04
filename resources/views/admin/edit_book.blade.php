<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')
    <style>
        .div_center{
            text-align: center;
            margin: auto;
        }

        .title_design{
            color: white;
            padding: 30px;
            font-size: 30px;
            font-weight: bold;
        }

        label{
            display: inline-block;
            width: 200px;
        }

        .div_pad{
            padding: 15px;
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

            <div class="div_center">

                <h1 class="title_design">Update Category</h2>

                <form action="{{url('update_book', $book->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="div_pad">
                        <label for="">Book Title</label>
                        <input type="text" name="title" value="{{$book->title}}">
                    </div>

                    <div class="div_pad">
                        <label>Author Name</label>
                        <input type="text" name="author_name" value="{{$book->author_name}}">
                    </div>

                    
                    <div class="div_pad">
                        <label>Price</label>
                        <input type="text" name="price" value="{{$book->price}}">
                    </div>

                    <div class="div_pad">
                        <label>Quantity</label>
                        <input type="text" name="quantity" value="{{$book->quantity}}">
                    </div>

                    <div class="div_pad">
                        <label>Description</label>
                        <textarea name="description" >{{$book->description}}</textarea>
                    </div>

                    <div class="div_pad">
                        <label>Category</label>
                        <select name="category">
                            <option value="{{$book->category_id}}">{{$book->category->cat_title}}</option>
                            
                            @foreach ($category as $data)
                                <option value="{{$data->id}}">{{$data->cat_title}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="div_pad">
                        <label>Current Author Image</label>
                        <img style="width: 80px; border-radius: 50%; margin: auto;" src="author/{{$book->author_img}}">
                    </div>
                    
                    <div class="div_pad">
                        <label>Change Author Image</label>
                        <input type="file" name="author_img">>
                    </div>

                    <div class="div_pad">
                        <label>Current Book Image</label>
                        <img style="width: 80px; margin: auto;" src="book/{{$book->book_img}}">
                    </div>

                    <div class="div_pad">
                        <label>Change Book Image</label>
                        <input type="file" name="book_img">>
                    </div>

                    <div class="div_pad">
                        <input class="btn btn-info" type="submit" value="Update Book">
                    </div>

                </form>

            </div>

          </div>
        </div>
      </div>

      
    
      @include('admin.footer')
  </body>
</html>