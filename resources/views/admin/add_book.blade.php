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
            padding: 35px;
            font-size: 40px;
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
                <h1 class = "title_design">Add Books</h1>

                <form action="{{url('store_book')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="div_pad">
                        <label for="">Book Title</label>
                        <input type="text" name="book_name">
                    </div>
                    
                    <div class="div_pad">
                        <label for="">Author Name</label>
                        <input type="text" name="author_name">
                    </div>

                    <div class="div_pad">
                        <label for="">Price</label>
                        <input type="text" name="price">
                    </div>

                    <div class="div_pad">
                        <label for="">Quantity</label>
                        <input type="text" name="quantity">
                    </div>
                    
                    <div class="div_pad">
                        <label for="">Description</label>
                        <textarea name="description"></textarea>
                    </div>

                    <div class="div_pad">
                        <label for="">Category</label>
                        <select name="category" required>
                            <option>Select Category</option>
                            @foreach ($data as $category)
                                <option value="{{$category->id}}">{{$category->cat_title}}</option>
                            @endforeach
                        </select>
                    </div class="div_pad">
                    
                    <div class="div_pad">
                        <label for="">Book Image</label>
                        <input type="file" name="book_img">
                    </div class="div_pad">

                    <div class="div_pad">
                        <label for="">Author Image</label>
                        <input type="file" name="author_img">
                    </div>

                    <div class="div_pad">
                        
                        <input type="submit" value="Add Book" class="btn btn-info">
                    </div>

                </form>
            </div>

          </div>
        </div>
      </div>
    
      @include('admin.footer')
  </body>
</html>