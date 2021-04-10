@extends('layouts.base')

@section('meta_title')
@endsection

@section('title')
@endsection

@section('meta_key')
@endsection

@section('meta_desc')

@endsection

@section('ogs')

<style>
:root{--color-blue: #036;--color-indigo: #6610f2;--color-purple: #6f42c1;--color-pink: #e83e8c;--color-red: #dc3545;--color-orange: #fd7e14;--color-yellow: #ffc107;--color-green: #28a745;--color-teal: #20c997;--color-cyan: #17a2b8;--color-white: #fff;--color-gray: #6c757d;--color-gray-dark: #343a40;--color-primary: #036;--color-secondary: #6c757d;--color-success: #28a745;--color-info: #17a2b8;--color-warning: #ffc107;--color-danger: #dc3545;--color-light: #f8f9fa;--color-dark: #343a40;--breakpoint-xs: 0;--breakpoint-sm: 576px;--breakpoint-md: 768px;--breakpoint-lg: 992px;--breakpoint-xl: 1200px;--font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";--font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace}*,::before,::after{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar}@-ms-viewport{width:device-width}nav,section{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff}hr{box-sizing:content-box;height:0;overflow:visible}h1,h5{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}strong{font-weight:bolder}sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sup{top:-.5em}a{color:#036;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}img{vertical-align:middle;border-style:none}table{border-collapse:collapse}th{text-align:inherit}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}input,button,select,optgroup,textarea{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}button,html [type=button],[type=reset],[type=submit]{-webkit-appearance:button}button::-moz-focus-inner,[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner{padding:0;border-style:none}textarea{overflow:auto;resize:vertical}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h1,h5{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:2.5rem}h5{font-size:1.25rem}.lead{font-size:1.25rem;font-weight:300}.display-4{font-size:3.5rem;font-weight:300;line-height:1.2}.display-6{font-size:1.5rem;font-weight:300;line-height:1.2}hr{margin-top:1rem;margin-bottom:1rem;border:0;border-top:1px solid rgba(0,0,0,.1)}.table{width:100%;max-width:100%;margin-bottom:1rem;background-color:transparent}.table th,.table td{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table-sm th,.table-sm td{padding:.3rem}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:1rem;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem}.form-control::-ms-expand{background-color:transparent;border:0}select.form-control:not([size]):not([multiple]){height:calc(2.25rem + 2px)}.fade{opacity:0}.collapse{display:none}.dropdown{position:relative}.dropdown-toggle::after{display:inline-block;width:0;height:0;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid;border-right:.3em solid transparent;border-bottom:0;border-left:.3em solid transparent}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:1rem;color:#212529;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.15);border-radius:.25rem}.dropdown-divider{height:0;margin:.5rem 0;overflow:hidden;border-top:1px solid #e9ecef}.dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:#212529;text-align:inherit;white-space:nowrap;background-color:transparent;border:0}.input-group{position:relative;display:flex;flex-wrap:wrap;align-items:stretch;width:100%}.input-group>.form-control{position:relative;flex:1 1 auto;width:1%;margin-bottom:0}.input-group>.form-control:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.input-group-prepend{display:flex}.input-group-prepend{margin-right:-1px}.input-group-text{display:flex;align-items:center;padding:.375rem .75rem;margin-bottom:0;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;text-align:center;white-space:nowrap;background-color:#e9ecef;border:1px solid #ced4da;border-radius:.25rem}.input-group>.input-group-prepend>.input-group-text{border-top-right-radius:0;border-bottom-right-radius:0}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;padding:.5rem 1rem}.navbar>.container{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:.3125rem;padding-bottom:.3125rem;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-nav .dropdown-menu{position:static;float:none}.navbar-collapse{flex-basis:100%;flex-grow:1;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:no-repeat center center;background-size:100% 100%}@media (max-width:991.98px){.navbar-expand-lg>.container{padding-right:0;padding-left:0}}@media (min-width:992px){.navbar-expand-lg{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-lg .navbar-nav{flex-direction:row}.navbar-expand-lg .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg>.container{flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:flex!important;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}.navbar-dark .navbar-brand{color:#17a2b8}.navbar-dark .navbar-nav .nav-link{color:#fff}.navbar-dark .navbar-toggler{color:#fff;border-color:rgba(255,255,255,.1)}.close{float:right;font-size:1.5rem;font-weight:700;line-height:1;color:#000;text-shadow:0 1px 0 #fff;opacity:.5}button.close{padding:0;background-color:transparent;border:0;-webkit-appearance:none}.bg-primary{background-color:#036!important}.bg-light{background-color:#f8f9fa!important}.bg-white{background-color:#fff!important}.border{border:1px solid #dee2e6!important}.rounded{border-radius:.25rem!important}.d-none{display:none!important}.d-inline{display:inline!important}.d-block{display:block!important}.d-flex,.hero-image{display:flex!important}@media (min-width:992px){.d-lg-none{display:none!important}.d-lg-block{display:block!important}}.flex-wrap,.hero-image{flex-wrap:wrap!important}.justify-content-end{justify-content:flex-end!important}.justify-content-center,.hero-image{justify-content:center!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;clip-path:inset(50%);border:0}.w-100{width:100%!important}.m-0,.modal-dialog.search{margin:0!important}.ml-1{margin-left:.25rem!important}.my-2{margin-top:.5rem!important}.my-2{margin-bottom:.5rem!important}.m-3{margin:1rem!important}.my-5{margin-top:3rem!important}.my-5{margin-bottom:3rem!important}.p-0,.modal-dialog.search{padding:0!important}.p-1{padding:.25rem!important}.pr-1{padding-right:.25rem!important}.py-2{padding-top:.5rem!important}.py-2{padding-bottom:.5rem!important}.p-3{padding:1rem!important}.py-3{padding-top:1rem!important}.py-3{padding-bottom:1rem!important}.ml-auto{margin-left:auto!important}@media (min-width:768px){.mt-md-8{margin-top:7rem!important}}@media (min-width:992px){.my-lg-0{margin-top:0!important}.my-lg-0{margin-bottom:0!important}}.text-center,.hero-image{text-align:center!important}.font-weight-light{font-weight:300!important}.text-white{color:#fff!important}.summary-table td .price{color:#dc3545!important}@-webkit-keyframes load{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes load{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes load{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes load{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@-webkit-keyframes load-rev{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(-360deg);-ms-transform:rotate(-360deg);transform:rotate(-360deg)}}@-moz-keyframes load-rev{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(-360deg);-ms-transform:rotate(-360deg);transform:rotate(-360deg)}}@-o-keyframes load-rev{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(-360deg);-ms-transform:rotate(-360deg);transform:rotate(-360deg)}}@keyframes load-rev{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(-360deg);-ms-transform:rotate(-360deg);transform:rotate(-360deg)}}.black-gradient-bg-rev{background:-moz-linear-gradient(bottom,rgba(0,0,0,.6) 0%,rgba(0,0,0,.6) 10%,transparent 100%);background:-webkit-linear-gradient(bottom,rgba(0,0,0,.6) 0%,rgba(0,0,0,.6) 10%,transparent 100%);background:linear-gradient(to top,rgba(0,0,0,.6) 0%,rgba(0,0,0,.6) 10%,transparent 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='%23fff', endColorstr='2', GradientType=0)}.bg-primary-fade{background-color:rgba(0,51,102,.9)}@media only screen and (max-width:992px){.scrollable{height:auto!important;max-height:200px!important;overflow-y:auto!important}}@media only screen and (min-width:993px){.scrollable{height:auto!important;max-height:500px!important;overflow-y:auto!important}}li.nav-item{margin:0 5px}.font-size-md{font-size:15px}.toggle-btn{position:absolute;z-index:3;right:5px;top:5px}.z-depth-1{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12),0 3px 1px -2px rgba(0,0,0,.2)}.summary-table th{padding:.5rem 0;font-weight:500;text-align:left;width:40%}.summary-table td{width:60%;padding:.5rem 0;font-weight:400;text-align:right}.summary-table td .price{font-weight:600}.bg{position:fixed;width:100%;height:550px;background-repeat:no-repeat;top:0;left:0;z-index:-1;background-position:center;background-size:cover}.hero-image{padding:350px 0 0;height:550px;color:#fff;text-shadow:#444 2px 2px 2px;}

/*mapcontainer css -> move later to scss file */
.map-container{height:89vh;background-color:#efefef;position:relative;}
.map-nav{position:absolute;z-index:2;top:10px;right:8px;padding:5px;background-color:#afafaf;border-radius:5px;max-width:250px;max-height:250px;overflow:auto;}
</style>
<link rel="stylesheet" href="{{ asset('swal/sweetalert2.css') }}"></script>

@endsection
@section('main_content')
<div class="nav-spacer"></div>
<div class="map-container">
    <div  id="map-container" style="width:100%;height:100%"></div>
  <div class="map-nav">
    {!! Form::open(['onSubmit'=>'searchProximity(this,e)','id'=>'search_in_page']) !!}  
        {!! Form::label('location', 'Location', ['class'=>'form-label']) !!}
        <select name="location" id="address-map-control" class="form-control">
            <option value="25.0897791,55.1651898">Current Location</option>
            <option value="25.1241138,55.2384233">test 2</option>
            @foreach($locarr as $key => $val)
                <option value="{{$val}}">{{$val}}</option>
            @endforeach
        </select>

        {!! Form::label('proximity', 'Proximity', ['class'=>'form-label']) !!}
        {!! Form::number('proximity', '', ['class'=>'form-control','id'=>'radius-map-control']) !!}

        {!! Form::label('unit', 'Unit', ['class'=>'form-label']) !!}
        {!! Form::select('unit', ['KM'=>'Kilometers','Miles'=>'Miles'], 'km', ['class'=>'form-control','id'=>'radius-unit-map-control']) !!}
        <button onclick="event.preventDefault();showAddress('#address-map-control');">Draw Proximity</button> <button onclick="event.preventDefault();clearDrawings();deleteMarkers();">Remove Proximity</button>
    {!! Form::close() !!}
</div>
<div id="map"></div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('swal/sweetalert2.js') }}"></script>
<script src="{{ asset('js/gmaps/drawing_map_functions.js') }}"></script>
<script src="{{ asset('js/gmaps/common_map_functions.js') }}"></script>
<script src="{{ asset('js/gmaps/multifunction.js') }}"></script>
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkQOXbAKy5pmRtDXDAi6NdQCF8yZDo90s&v=3.exp&libraries=geometry,drawing&callback=init"></script>

<script>

    function searchProximity(el,e){
        e.preventDefault();
    }
//     var latitudeAndLongitude=document.getElementById("latitudeAndLongitude"),
//     geloc={
//         latitude:'',
//         longitude:''
//     };

//     if (navigator.geolocation){
//       navigator.geolocation.getCurrentPosition(showPosition);
//   }
//   else{
//       latitudeAndLongitude.innerHTML="Geolocation is not supported by this browser.";
//   }

//   function showPosition(position){ 
//     geloc.latitude=position.coords.latitude;
//     geloc.longitude=position.coords.longitude;
//     // latitudeAndLongitude.innerHTML="Latitude: " + position.coords.latitude + 
//     // "<br>Longitude: " + position.coords.longitude; 
//     var geocoder = new google.maps.Geocoder();
//     var latLng = new google.maps.LatLng(geloc.latitude, geloc.longitude);

//     if (geocoder) {
//         geocoder.geocode({ 'latLng': latLng}, function (results, status) {
//          if (status == google.maps.GeocoderStatus.OK) {
//            console.log(results[0].formatted_address); 
//            $('#address').html('Address:'+results[0].formatted_address);
//        }
//        else {
//         $('#address').html('Geocoding failed: '+status);
//         console.log("Geocoding failed: " + status);
//     }
//     }); //geocoder.geocode()
//     }      
// } //showPosition

</script>
@endsection