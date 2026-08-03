<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')

    <style>
        .div_design{
            text-align: center;
            margin: auto;
        }

        .title_design{
            color: white;
            padding: 40px;
            font-size: 30px;
            font-weight: bold;
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

            <div class="div_design">

                <h2 class="title_design">Update Category</h2>

                <form action="{{url('update_category', $data->id)}}" method="post">
                    @csrf
                    <label for="">Category Name</label>
                    <input type="text" name="cat_name" value="{{$data->cat_title}}">

                    <input type="submit" class="btn btn-info" value="Update">
                </form>

            </div>

          </div>
        </div>
      </div>
    
      @include('admin.footer')
  </body>
</html>