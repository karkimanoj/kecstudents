@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-color:#F8F9FA">
    <div class="row" id="top_header" >
        
    </div>

    <div class="row" style="margin: 2% 1%;">
      <div class="col-md-12" {{--style="border:1px solid green;"--}}>

           <div class="row " {{--"border:1px solid purple;"--}}>
              <div class="col-md-6 m-t-20" style="min-height:170px">
                
                   <div class="section_box1" >
                      <i class="fas fa-download fa-7x margin_center"  style="color:#228AE6;" ></i>
                      
                   </div>
                   <div class="section_box2"  id="download_div">
                   
                     <div class="row">
                       <div class="col-md-12 section_header">
                         <h2>Downloads</h2>
                         <p >
                          <i class="fas fa-check-square"></i>&ensp;upload and download the study materials<br>
                          <i class="fas fa-check-square"></i>&ensp;create your own page of download section
                         </p>
                       </div>
                     </div>
                   
                  
                    
                   </div>
                
               </div>
               <div class="col-md-6 m-t-20">
                 
                   <div class="section_box1">
                       <i class="fas fa-users fa-7x margin_center" style="color:#228AE6;" ></i>
                   </div>
                   <div class="section_box2" id="project_div">
                       <div class="row">
                         <div class="col-md-12 section_header">
                           <h2>Projects</h2>
                           <p >
                             <i class="fas fa-check-square"></i>&ensp; upload new exciting projects<br>
                             <i class="fas fa-check-square"></i>&ensp; download other users project 
                           </p>
                         </div>
                       </div>
                   </div>
               
               </div>
           </div> 
           <div class="row " >

               <div class="col-md-6 m-t-20" >
                
                   <div class="section_box1" >
                       <i class="fas fa-calendar-alt fa-7x margin_center" style="color:#228AE6;"></i>
                   </div>
                   <div class="section_box2">
                       <div class="row">
                         <div class="col-md-12 section_header">
                           <h2>Events</h2>
                           <p >
                             <i class="fas fa-check-square"></i>&ensp;create and view event from this section<br>
                             <i class="fas fa-check-square"></i>&ensp;join the event with others
                           </p>
                         </div>
                       </div>
                   </div>
                
               </div>
               <div class="col-md-6 m-t-20">
                 
                   <div class="section_box1">
                       <i class="fab fa-forumbee fa-7x margin_center" style="color:#228AE6;"></i>
                   </div>
                   <div class="section_box2">
                       <div class="row">
                         <div class="col-md-12 section_header">
                           <h2>forums</h2>
                           <p>
                             <i class="fas fa-check-square"></i>&ensp;create and view post from this section<br>
                             <i class="fas fa-check-square"></i>&ensp;join discussion with others
                           </p>
                         </div>
                       </div>
                   </div>
               
               </div>

            </div> <div class="row " >

               <div class="col-md-6 m-t-20" >
                
                   <div class="section_box1" >
                      
                   </div>
                   <div class="section_box2">
                       
                   </div>
                
               </div>
               <div class="col-md-6 m-t-20">
                 
                   <div class="section_box1">
                       
                   </div>
                   <div class="section_box2">
                       
                   </div>
               
               </div>

            </div> 

          </div>
    </div>

</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function(){
      url='{{url('/')}}';
     
      $('#project_div').click(function(){

        window.open('{{ route('projects.home', ['category'=>'subject', 'cat_id'=>0]) }}');
        
      });
      $('#download_div').click(function(){

        window.open('{{ route('downloads.home', 9) }}');
        
      });
      
    });
  </script>
@endsection