<!DOCTYPE html>
<html lang="en">
   <head>
     <style type="text/css">
        .div_design{
            text-align: center;
              padding: 30px;
        }

        .title_design{
            font-size: 30px;
            font-weight: bold;
            color: white;
            padding: 30px;
        }

        label{
            display: inline-block;
            width: 200px;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .field_design{
            padding: 25px;
        }
     </style>
    
      <!-- basic -->
        @include('home.homecss')
   </head>
   <body>
        @include('sweetalert::alert')
        
      <!-- header section start -->
      <div class="header_section">
        @include('home.header')
      <!-- </div> -->   

      <div class="div_design">
        <h class="title_design">Add Post</h>
        <form action="{{url('user_post')}}" method="POST" enctype="multipart/form-data"> 
            @csrf
            <div class="field_design">
                <label>Title</label>
                 <input type="text" name="title">
            </div>

             <div class="field_design">
                <label>Description</label>
                 <textarea name="description"></textarea>
            </div>

             <div class="field_design">
                <label>Image</label>
                 <input type="file" name="image">
            </div>

            <div class="field_design">
                <!-- <label>Post</label> -->
                <input type="submit" value="Add Post" class="btn btn-outline -secondary">
            </div>
        </form>
      </div>
  
       @include('home.footer')
</html>