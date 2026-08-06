<!DOCTYPE html>
<html lang="en">

<head>
   <base href="/public">

    @include('home.css')

</head>

<body>

   @include('home.header')
   
      <div class="currently-market">
         <div class="container">
            <div class="row">
               
               <div class="col-lg-6" style="margin-top: 100px;">
                  <div class="filters">
                     <ul>
                        <li data-filter="*" class="active">All Books</li>
                        @foreach ($categories as $category)

                           <li>
                              <a href="{{url('cat_search', $category->id)}}">{{$category->cat_title}}</a>
                              
                           </li>
                           {{-- <option value="{{$category->id}}">{{$category->cat_title}}</option> --}}

                        @endforeach

                     </ul>
                  </div>
               </div>

               <form action="{{url('search')}}" method="get">
                  @csrf
                  <div class="row" style="margin: 30px;">
                  
                     <div class="col-md-8" >
                        <input class="form-control" type="search" name="search" placeholder="Search for Book title, or author name">

                     </div>

                     <div class="col-md-4">
                        <input class="btn btn-primary" type="submit" value="Search">
                     </div>

                  </div>
               </form>

               <div class="col-lg-12">
                  <div class="row grid">

                     @foreach ($books as $book)
                           
                        <div class="col-lg-6 currently-market-item all msc">
                           <div class="item">
                              <div class="left-image">
                                 <img src="book/{{$book->book_img}}" alt=""
                                       style="border-radius: 20px; min-width: 195px;">
                              </div>
                              <div class="right-content">
                                 <h4>{{$book->title}}</h4>
                                 <span class="author">
                                       <img src="author/{{$book->author_img}}" alt=""
                                          style="max-width: 50px; border-radius: 50%;">
                                       <h6>{{$book->author_name}}</h6>
                                 </span>
                                 <div class="line-dec"></div>
                                 <span class="bid">
                                       Current Available<br><strong>{{$book->quantity}}</strong><br>
                                 </span>
                                 
                                 <div class="text-button">
                                       <a href="details.html">View Item Details</a>
                                 </div>

                                 <br>
                                 <div class="">
                                       <a class='btn btn-primary' href="{{url('borrow_books', $book->id)}}">Apply to Borrow</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     
                     @endforeach
                     

                  </div>
               </div>

               <div class="d-flex justify-content-center mt-4">
                  {{$books->links()}}
               </div>

            </div>
         </div>
      </div>

   @include('home.footer')

</body>

</html>