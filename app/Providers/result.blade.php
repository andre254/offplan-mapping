@extends('layouts.base')
@section('title')
Search Results
@endsection
@section('ogs')
<style>
    :root{--color-blue: #036;--color-indigo: #6610f2;--color-purple: #6f42c1;--color-pink: #e83e8c;--color-red: #dc3545;--color-orange: #fd7e14;--color-yellow: #ffc107;--color-green: #28a745;--color-teal: #20c997;--color-cyan: #17a2b8;--color-white: #fff;--color-gray: #6c757d;--color-gray-dark: #343a40;--color-primary: #036;--color-secondary: #6c757d;--color-success: #28a745;--color-info: #17a2b8;--color-warning: #ffc107;--color-danger: #dc3545;--color-light: #f8f9fa;--color-dark: #343a40;--breakpoint-xs: 0;--breakpoint-sm: 576px;--breakpoint-md: 768px;--breakpoint-lg: 992px;--breakpoint-xl: 1200px;--font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";--font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace}*,::before,::after{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar}@-ms-viewport{width:device-width}nav,section{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff}h1,h5{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}b,strong{font-weight:bolder}sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sup{top:-.5em}a{color:#036;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}img{vertical-align:middle;border-style:none}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}input,button,select,optgroup,textarea{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}button,html [type=button],[type=reset],[type=submit]{-webkit-appearance:button}button::-moz-focus-inner,[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner{padding:0;border-style:none}textarea{overflow:auto;resize:vertical}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h1,h5{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:2.5rem}h5{font-size:1.25rem}.display-6{font-size:1.5rem;font-weight:300;line-height:1.2}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:1rem;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem}.form-control::-ms-expand{background-color:transparent;border:0}select.form-control:not([size]):not([multiple]){height:calc(2.25rem + 2px)}.fade{opacity:0}.collapse{display:none}.dropdown{position:relative}.dropdown-toggle::after{display:inline-block;width:0;height:0;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid;border-right:.3em solid transparent;border-bottom:0;border-left:.3em solid transparent}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:1rem;color:#212529;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.15);border-radius:.25rem}.dropdown-divider{height:0;margin:.5rem 0;overflow:hidden;border-top:1px solid #e9ecef}.dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:#212529;text-align:inherit;white-space:nowrap;background-color:transparent;border:0}.input-group{position:relative;display:flex;flex-wrap:wrap;align-items:stretch;width:100%}.input-group>.form-control{position:relative;flex:1 1 auto;width:1%;margin-bottom:0}.input-group>.form-control:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.input-group-prepend{display:flex}.input-group-prepend{margin-right:-1px}.input-group-text{display:flex;align-items:center;padding:.375rem .75rem;margin-bottom:0;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;text-align:center;white-space:nowrap;background-color:#e9ecef;border:1px solid #ced4da;border-radius:.25rem}.input-group>.input-group-prepend>.input-group-text{border-top-right-radius:0;border-bottom-right-radius:0}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;padding:.5rem 1rem}.navbar>.container{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:.3125rem;padding-bottom:.3125rem;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-nav .dropdown-menu{position:static;float:none}.navbar-collapse{flex-basis:100%;flex-grow:1;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:no-repeat center center;background-size:100% 100%}@media (max-width:991.98px){.navbar-expand-lg>.container{padding-right:0;padding-left:0}}@media (min-width:992px){.navbar-expand-lg{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-lg .navbar-nav{flex-direction:row}.navbar-expand-lg .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg>.container{flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:flex!important;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}.navbar-dark .navbar-brand{color:#17a2b8}.navbar-dark .navbar-nav .nav-link{color:#fff}.navbar-dark .navbar-toggler{color:#fff;border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url(data:image/svg+xml;charset=utf8;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMzAgMzAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggc3Ryb2tlPSIjZmZmIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNNCA3aDIyTTQgMTVoMjJNNCAyM2gyMiIvPjwvc3ZnPg==)}.badge{display:inline-block;padding:.25em .4em;font-size:75%;font-weight:700;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem}.badge:empty{display:none}.badge-pill{padding-right:.6em;padding-left:.6em;border-radius:10rem}.badge-primary{color:#fff;background-color:#036}.badge-secondary{color:#fff;background-color:#6c757d}.close{float:right;font-size:1.5rem;font-weight:700;line-height:1;color:#000;text-shadow:0 1px 0 #fff;opacity:.5}button.close{padding:0;background-color:transparent;border:0;-webkit-appearance:none}.bg-light{background-color:#f8f9fa!important}.border{border:1px solid #dee2e6!important}.rounded,.flash{border-radius:.25rem!important}.flash.prl{border-top-left-radius:.25rem!important;border-top-right-radius:.25rem!important}.desc-holder{border-bottom-right-radius:.25rem!important;border-bottom-left-radius:.25rem!important}.d-none{display:none!important}.d-inline{display:inline!important}.d-block{display:block!important}.d-flex,.desc-holder{display:flex!important}@media (min-width:992px){.d-lg-none{display:none!important}.d-lg-block{display:block!important}}.flex-wrap,.desc-holder{flex-wrap:wrap!important}.justify-content-center{justify-content:center!important}.float-left{float:left!important}.float-right{float:right!important}@media (min-width:992px){.float-lg-left{float:left!important}}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;clip-path:inset(50%);border:0}.w-100{width:100%!important}.mh-100{max-height:100%!important}.m-0,.modal-dialog.search{margin:0!important}.m-1{margin:.25rem!important}.mt-1,.my-1{margin-top:.25rem!important}.mr-1{margin-right:.25rem!important}.my-1{margin-bottom:.25rem!important}.ml-1{margin-left:.25rem!important}.m-2{margin:.5rem!important}.my-2{margin-top:.5rem!important}.mx-2{margin-right:.5rem!important}.my-2{margin-bottom:.5rem!important}.ml-2,.mx-2{margin-left:.5rem!important}.m-3{margin:1rem!important}.my-5{margin-top:3rem!important}.my-5{margin-bottom:3rem!important}.p-0,.modal-dialog.search{padding:0!important}.py-0{padding-top:0!important}.px-0{padding-right:0!important}.py-0{padding-bottom:0!important}.px-0{padding-left:0!important}.p-1{padding:.25rem!important}.py-1{padding-top:.25rem!important}.py-1{padding-bottom:.25rem!important}.p-2{padding:.5rem!important}.px-2{padding-right:.5rem!important}.px-2{padding-left:.5rem!important}.p-3{padding:1rem!important}.py-3{padding-top:1rem!important}.py-3{padding-bottom:1rem!important}.px-4{padding-right:1.5rem!important}.px-4{padding-left:1.5rem!important}.mr-auto{margin-right:auto!important}.ml-auto{margin-left:auto!important}@media (min-width:768px){.mt-md-8{margin-top:7rem!important}.p-md-1{padding:.25rem!important}}@media (min-width:992px){.my-lg-0{margin-top:0!important}.my-lg-0{margin-bottom:0!important}.mr-lg-3{margin-right:1rem!important}}.text-left{text-align:left!important}.text-right{text-align:right!important}.text-center{text-align:center!important}@media (min-width:992px){.text-lg-left{text-align:left!important}}.font-weight-light{font-weight:300!important}.text-white{color:#fff!important}.pop-loader{background-color:rgba(255,255,255,.8);visibility:hidden;z-index:999;position:absolute;top:0;left:0;right:0;bottom:0}.pop-loader .loader{display:block;position:absolute;left:50%;top:50%;width:150px;height:150px;margin:-75px 0 0 -75px;border-radius:50%;border:15px solid transparent;border-top-color:#15223a;-webkit-animation-delay:none;-webkit-animation-duration:2s;-webkit-animation-name:load;-webkit-animation-fill-mode:none;-webkit-animation-direction:none;-webkit-animation-timing-function:linear;-webkit-animation-iteration-count:infinite;-moz-animation-delay:none;-moz-animation-duration:2s;-moz-animation-name:load;-moz-animation-fill-mode:none;-moz-animation-direction:none;-moz-animation-timing-function:linear;-moz-animation-iteration-count:infinite;-o-animation-delay:none;-o-animation-duration:2s;-o-animation-name:load;-o-animation-fill-mode:none;-o-animation-direction:none;-o-animation-timing-function:linear;-o-animation-iteration-count:infinite;animation-delay:none;animation-duration:2s;animation-name:load;animation-fill-mode:none;animation-direction:none;animation-timing-function:linear;animation-iteration-count:infinite;z-index:1000}.pop-loader .loader:before{content:'0 0 30 30';position:absolute;top:3px;left:3px;right:3px;bottom:3px;border-radius:50%;border:8px solid transparent;border-top-color:#15223a;-webkit-animation-delay:none;-webkit-animation-duration:1s;-webkit-animation-name:load-rev;-webkit-animation-fill-mode:none;-webkit-animation-direction:none;-webkit-animation-timing-function:linear;-webkit-animation-iteration-count:infinite;-moz-animation-delay:none;-moz-animation-duration:1s;-moz-animation-name:load-rev;-moz-animation-fill-mode:none;-moz-animation-direction:none;-moz-animation-timing-function:linear;-moz-animation-iteration-count:infinite;-o-animation-delay:none;-o-animation-duration:1s;-o-animation-name:load-rev;-o-animation-fill-mode:none;-o-animation-direction:none;-o-animation-timing-function:linear;-o-animation-iteration-count:infinite;animation-delay:none;animation-duration:1s;animation-name:load-rev;animation-fill-mode:none;animation-direction:none;animation-timing-function:linear;animation-iteration-count:infinite}.pop-loader .loader:after{content:'http://www.w3.org/2000/svg';position:absolute;top:15px;left:15px;right:15px;bottom:15px;border-radius:50%;border:3px solid transparent;border-top-color:#15223a;-webkit-animation-delay:none;-webkit-animation-duration:1.5s;-webkit-animation-name:load;-webkit-animation-fill-mode:none;-webkit-animation-direction:none;-webkit-animation-timing-function:linear;-webkit-animation-iteration-count:infinite;-moz-animation-delay:none;-moz-animation-duration:1.5s;-moz-animation-name:load;-moz-animation-fill-mode:none;-moz-animation-direction:none;-moz-animation-timing-function:linear;-moz-animation-iteration-count:infinite;-o-animation-delay:none;-o-animation-duration:1.5s;-o-animation-name:load;-o-animation-fill-mode:none;-o-animation-direction:none;-o-animation-timing-function:linear;-o-animation-iteration-count:infinite;animation-delay:none;animation-duration:1.5s;animation-name:load;animation-fill-mode:none;animation-direction:none;animation-timing-function:linear;animation-iteration-count:infinite}.pop-loader h5{position:absolute;top:70%;width:100%}@-webkit-keyframes load{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes load{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes load{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes load{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@-webkit-keyframes load-rev{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(-360deg);-ms-transform:rotate(-360deg);transform:rotate(-360deg)}}@-moz-keyframes load-rev{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(-360deg);-ms-transform:rotate(-360deg);transform:rotate(-360deg)}}@-o-keyframes load-rev{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(-360deg);-ms-transform:rotate(-360deg);transform:rotate(-360deg)}}@keyframes load-rev{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(-360deg);-ms-transform:rotate(-360deg);transform:rotate(-360deg)}}.black-gradient-bg{background:-moz-linear-gradient(top,rgba(0,0,0,.6) 0%,rgba(0,0,0,.6) 10%,transparent 100%);background:-webkit-linear-gradient(top,rgba(0,0,0,.6) 0%,rgba(0,0,0,.6) 10%,transparent 100%);background:linear-gradient(to bottom,rgba(0,0,0,.6) 0%,rgba(0,0,0,.6) 10%,transparent 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='%23fff', endColorstr='2', GradientType=0)}.bg-black-fade{background:rgba(52,58,64,.8)}.bg-black-fade.n{background:rgba(52,58,64,.6)}.bg-primary-fade{background-color:rgba(0,51,102,.9)}@media only screen and (max-width:992px){.scrollable{height:auto!important;max-height:200px!important;overflow-y:auto!important}}@media only screen and (min-width:993px){.scrollable{height:auto!important;max-height:500px!important;overflow-y:auto!important}}li.nav-item{margin:0 5px}.flash{position:relative;overflow:hidden}.flash.prl{border-bottom-right-radius:0!important;border-bottom-left-radius:0!important}@media only screen and (min-width:601px){.flash.prl{height:315px}}@media only screen and (max-width:600px){.flash.prl{height:250px}}.flash.prl .price,.flash.prl .title{font-size:25px}.flash.prl .mt-prl{margin-top:2.2rem!important}.flash .holder{position:absolute;z-index:2;right:0;left:0;height:auto}.flash .holder.top{top:0}.flash .holder.cover{bottom:0;top:0}.flash .flash-bg-image{position:absolute;width:100%;height:100%}@media only screen and (max-width:992px){.desc-holder.n-mbl{display:none!important;visibility:hidden}}.font-size-sm{font-size:10px}.font-size-md{font-size:15px}.font-size-lg{font-size:25px}.toggle-btn{position:absolute;z-index:3;right:5px;top:5px}.z-depth-1{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12),0 3px 1px -2px rgba(0,0,0,.2)}.z-depth-2{box-shadow:0 4px 5px 0 rgba(0,0,0,.14),0 1px 10px 0 rgba(0,0,0,.12),0 2px 4px -1px rgba(0,0,0,.3)}.nav-spacer{height:76px;width:100%}
</style>
@endsection
@section('main_content')

<div class="nav-spacer"></div>
<section class="section container p-3">
        {!! Form::open(['url'=>'/search','method'=>'get','class'=>'w-100 bg-light border p-2 m-1 z-depth-2']) !!}
        <div class="d-flex justify-content-center flex-wrap">
            <div class="col-12 col-lg-12 p-1 text-center text-lg-left"><span class="display-6">Modify Search</span></div>
            <div class="col-7 col-md-9 col-lg-10 p-1">
                {!! Form::text('keywords', $li['keywords'], ['class'=>'form-control','placeholder'=>'Project Name,Developer,Location']) !!}
            </div>
            <div class="col-5 col-md-3 col-lg-2 p-1">
                <button class="btn btn-success w-100" type="submit"><i class="fa fa-search"></i> Search</button>
            </div>
            <div class="col-6 col-sm-3 p-1 search-tohide"  style="display: none;">
                {!! Form::label('loc', 'Location', ['class'=>'sr-only']) !!}
                <select class="form-control" name="loc" id="loc">
                    <option value="Any" {{$li['loc'] == 'any' ? 'selected' : ''}} disabled="disabled">Location</option>
                    @foreach($locarr as $key => $val)
                        @if($li['loc'] == $key && isset($li['loc']))
                        <option selected value="{{$key}}">{{$val}}</option>
                        @else
                        <option value="{{$key}}">{{$val}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-sm-3 p-1 search-tohide"  style="display: none;">
                {!! Form::label('dev', 'Developer', ['class'=>'sr-only']) !!}
                <select class="form-control" name="dev" id="dev">
                    <option value="Any" {{$li['dev'] == 'any' ? 'selected' : ''}} disabled="disabled">Developer</option>
                    @foreach($devarr as $key => $val)
                        @if($li['dev'] == $val->first()->dev_id && isset($li['dev']))
                        <option selected value="{{$val->first()->dev_id}}">{{$val->first()->dev_name}}</option>
                        @else
                        <option value="{{$val->first()->dev_id}}">{{$val->first()->dev_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-sm-3 p-1 search-tohide" style="display: none;">
              <label class="sr-only" for="price_min">Price Minimum</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text"><span style="font-size:12px;">AED</span></div>
                </div>
                <select class="form-control" name="price_min" id="price_min">
                    <option value="Any" selected disabled="disabled">Min Price</option>
                    @foreach($price['price'] as $key => $val)
                        <option value="{{$key}}" {{$li['price_min'] == $key ? 'selected' : ''}}>{{$val}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-6 col-sm-3 p-1 search-tohide" style="display: none;">
              <label class="sr-only" for="price_max">Price Maximum</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text"><span style="font-size:12px;">AED</span></div>
                </div>
                <select class="form-control" name="price_max" id="price_max">
                    <option value="Any" selected disabled="disabled">Max Price</option>
                    @foreach($price['price'] as $key => $val)
                        <option value="{{$key}}" {{$li['price_max'] == $key ? 'selected' : ''}}>{{$val}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-6 col-sm-2 p-1 search-tohide" style="display: none;">
                    {!! Form::label('area_min', 'Location', ['class'=>'sr-only']) !!}
                    <input type="number" name="area_min" id="area_min" class="form-control" placeholder="Area min" value="{{$li['area_min']}}">
                </div>
                <div class="col-6 col-sm-2 p-1 search-tohide" style="display: none;">
                    {!! Form::label('area_max', 'Location', ['class'=>'sr-only']) !!}
                    <input type="number" name="area_max" id="area_max" class="form-control" placeholder="Area max" value="{{$li['area_max']}}">
                </div>
            <div class="col-6 col-sm-2 p-1 search-tohide"  style="display: none;">
              <label class="sr-only" for="beds">Bed Minimum</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text p-2"><i class="fa fa-bed"></i></div>
                </div>
                <select class="form-control" name="beds" id="beds">
                    <option value="Any" disabled="disabled">Bed Min</option>
                    <option value="Any" {{$li['beds'] == 'any' ? 'selected' : ''}}>Any</option>
                    <option {{ $li['beds']==0 ? 'selected' : '' }} value="0">Studio</option>
                    @for($i = 0; $i < 10; $i++)
                    @if($li['beds'] == $i+1 && isset($li['beds']))
                    <option value="{{$i+1}}" selected>{{$i+1}}</option>
                    @else
                    <option value="{{$i+1}}">{{$i+1}}</option>
                    @endif
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-6 col-sm-2 p-1 search-tohide"  style="display: none;">
              <label class="sr-only" for="bedm">Bed Maximum</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text p-2"><i class="fa fa-bed"></i></div>
                </div>
                <select class="form-control" name="bedm" id="bedm">
                    <option value="Any" disabled="disabled">Bed Max</option>
                    <option value="Any" {{$li['bedm'] == 'any' ? 'selected' : ''}}>Any</option>
                    <option {{ $li['bedm']==0 ? 'selected' : '' }} value="0">Studio</option>
                    @for($i = 0; $i < 10; $i++)
                    @if($li['bedm'] == $i+1 && isset($li['bedm']))
                    <option value="{{$i+1}}" selected>{{$i+1}}</option>
                    @else
                    <option value="{{$i+1}}">{{$i+1}}</option>
                    @endif
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-6 col-sm-2 p-1 search-tohide"  style="display: none;">
                {!! Form::label('type', 'Type', ['class'=>'sr-only']) !!}
                <select class="form-control" name="type" id="type">
                    <option value="Any" {{$li['type'] == 'any' ? 'selected' : ''}} disabled="disabled">Type</option>
                    @foreach($proptype as $key => $val)
                    @if($li['type'] == $key && isset($li['type']))
                        <option selected value="{{$key}}">{{$val}}</option>
                    @else
                        <option value="{{$key}}">{{$val}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-sm-2 p-1 search-tohide"  style="display: none;">
                {!! Form::label('ord', 'order', ['class'=>'sr-only']) !!}
                <select class="form-control" name="ord" id="ord">
                    <option value="Any" {{$li['ord'] == 'any' ? 'selected' : ''}} disabled="disabled">Order</option>
                    <option value="hp" {{$li['ord'] == 'hp' ? 'selected' : ''}}>Highest Price</option>
                    <option value="lp" {{$li['ord'] == 'lp' ? 'selected' : ''}}>Lowest Price</option>
                    <option value="ha" {{$li['ord'] == 'ha' ? 'selected' : ''}}>Highest Area</option>
                    <option value="la" {{$li['ord'] == 'la' ? 'selected' : ''}}>Lowest Area</option>
                    <option value="hb" {{$li['ord'] == 'hb' ? 'selected' : ''}}>Highest Bedrooms</option>
                    <option value="lb" {{$li['ord'] == 'lb' ? 'selected' : ''}}>Lowest Bedrooms</option>
                </select>
            </div>
            <div class="col-12 col-lg-6 order-lg-2 d-flex flex-wrap p-0">
                <div class="col-6 p-1 m-0">
                    <select name="handf" id="handf" class="form-control">
                        <option value="Any" {{$li['handf'] == 'any' ? 'selected' : ''}} disabled>Handover From</option>
                        <option value="fin" {{$li['handf'] == 'fin' ? 'selected' : ''}}>Finished Projects</option>
                        <option value="soon" {{$li['handf'] == 'soon' ? 'selected' : ''}}>Comming Soon</option>
                        @foreach($date['date'] as $key => $value)
                        @if(!is_array($value))
                        <option value="{{$key}}">{{$value}}</option>
                        @else
                        <optgroup label="{{$key}}">
                        @foreach($value as $kk => $vv)
                            <option value="{{$kk}}" {{$li['handf'] == $kk ? 'selected' : ''}}>{{$vv}}</option>
                        @endforeach
                        </optgroup>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-6 p-1 m-0">
                    <select name="handt" id="handt" class="form-control">
                        <option value="Any" {{$li['handt'] == 'any' ? 'selected' : ''}} disabled>Handover From</option>
                        <option value="fin" {{$li['handt'] == 'fin' ? 'selected' : ''}}>Finished Projects</option>
                        <option value="soon" {{$li['handt'] == 'soon' ? 'selected' : ''}}>Comming Soon</option>
                        @foreach($date['date'] as $key => $value)
                        @if(!is_array($value))
                        <option value="{{$key}}">{{$value}}</option>
                        @else
                        <optgroup label="{{$key}}">
                        @foreach($value as $kk => $vv)
                            <option value="{{$kk}}" {{$li['handt'] == $kk ? 'selected' : ''}}>{{$vv}}</option>
                        @endforeach
                        </optgroup>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-6 order-lg-1 p-1">
                <div class="float-right float-lg-left mr-lg-3"><span class="tog-search"><i class="fas fa-angle-down"></i><span class="tstxt"> More</span><span class="tstxt" style="display: none;"> Less</span> Options</span></div>
                <p class="d-inline mr-auto float-left">
                    Search Results: <span class="badge badge-primary badge-pill">{{ $data->total() }}</span>
                </p>
            </div>
        </div>
        {!! Form::close() !!}
<div class="py-3">
    <div class="w-100 d-flex justify-content-center flex-wrap" id="results">
        @if(isset($data))
            @if(sizeOf($data) > 0)
                @foreach($data as $key => $value)
                <div class="col-12 col-md-6 py-1 px-0 p-md-1">
                    <div class="z-depth-2 rounded">
                        <div class="d-none d-lg-block flash prl">
                            <div class="holder top black-gradient-bg n text-white">
                                <div class="float-lg-left text-left text-white m-2">
                                <a href="{{url('/property/' . $value->prop_slug)}}" class="text-white">
                                    <span class="title">{{$value->prop_name}}</span>
                                    <br />
                                    {{$value->prop_loc}}{{ isset($value->prop_sub_location) ? ', '.$value->prop_sub_location : '' }}
                                </a>
                                </div>
                                <div class="float-right text-right text-white m-2">
                                    
                                    @if($value->prop_dev)
                                    <a href="{{url('/developer/'.$value->dev_slug)}}" class="text-white trans badge badge-primary">{{$value->prop_dev}}</a><br/>
                                    @endif
                                </div>
                            </div>
                            <a href="{{url('/property/' . $value->prop_slug)}}">
                                <img src="{{asset('/images/ph1.jpg')}}" data-src="{{asset($value->prop_img)}}" class="flash-bg-image" alt="{{$value->prop_name}}">
                            </a>
                        </div>

                        <div class="desc-holder n-mbl">
                            <div class="mr-auto m-1 ml-2">
                                <a href="{{url('/property/' . $value->prop_slug)}}" class="text-black">
                                        @isset($value->prop_price)
                                        AED <span class="price font-size-lg">{{ $value->prop_price }}</span> 
                                        <br/>
                                        @else
                                        <span class="font-size-lg">Price on Application</span>
                                        <br/>
                                        @endisset
                                </a>
                                @if(!$value->prop_bed_null)
                                    @if($value->prop_bed)
                                    <i class="fas fa-bed"></i> {{$value->prop_bed}} 
                                    @else
                                    Studio
                                    @endif
                                @endif
                                @if($value->prop_area)
                                <span class="m-1">|</span><i class="fas fa-expand"></i> {{$value->prop_area}} sqft.
                                @endif
                                @if($value->mated_date)
                                <span class="m-1">|</span>
                                    @if($value->prop_date_null)
                                    Coming Soon
                                    @else
                                    @if($value->finished)
                                    Construction Completed
                                    @else
                                    {{$value->mated_date}} 
                                    @endif
                                    @endif
                                @endif

                            </div>
                            <div class="ml-auto m-1">
                                <span onclick="inqop('{{$value->prop_code}}','{{$value->prop_name}}')" class="btn btn-primary px-2 py-1"><span class="sr-only">inquire</span><i class="fas fa-edit"></i></span>
                                <a href="https://api.whatsapp.com/send?phone=971554149608&amp;text=I%20want%20more%20info%20about%20this%20off%20plan%20project%20{{$value->prop_name}}%20Property%20Code%20{{$value->prop_code}}" class="btn btn-success px-2 py-1" target="_blank"><span class="sr-only">message in whatsapp</span><i class="fab fa-whatsapp"></i></a>
                                <a href="{{url('/property/' . $value->prop_slug)}}" target="_blank" class="btn btn-primary px-2 py-1"><span class="sr-only">More Details</span><i class="fas fa-info-circle"></i></a>
                                @if($value->prop_dev)
                                <a href="{{url('/developer/'.$value->dev_slug)}}" class="ml-auto mr-1 my-1">
                                    <img src="{{asset($value->dev_img)}}" class="mh-100" alt="{{$value->dev_name}}">
                                </a>
                            @endif
                            </div>
                        </div>
                    </div>

                    <!-- mobile -->
                    <div class="d-block d-lg-none flash prl z-depth-2 mobprl" data-loc="{{url('/property/' . $value->prop_slug)}}">
                        <div class="holder cover bg-black-fade n text-white">
                            <div class="text-center text-white w-100 mt-prl">
                                <a href="{{url('/property/' . $value->prop_slug)}}" class="text-white">
                                    @isset($value->prop_price)
                                    <sup>AED</sup> <b class="price">{{ $value->prop_price }}</b>
                                    <br/>
                                    @else
                                    Price on Application
                                    <br/>
                                    @endisset

                                    {{$value->prop_name}}
                                    <br />
                                    {{$value->prop_loc}} {{ isset($value->prop_sub_location) ? ', '.$value->prop_sub_location : '' }}
                                </a>
                                @if($value->prop_dev)
                                <br/>
                                <a href="{{url('/developer/'.$value->dev_slug)}}" class="text-white trans badge badge-primary">{{$value->prop_dev}}</a>
                                <br/>
                                @endif
                            
                                @if(!$value->prop_bed_null)
                                    @if($value->prop_bed)
                                    <i class="fas fa-bed"></i> {{$value->prop_bed}} 
                                    @else
                                    Studio
                                    @endif
                                @endif
                                @if($value->prop_area)
                                <span class="m-1">|</span><i class="fas fa-expand"></i> {{$value->prop_area}} sqft.
                                @endif
                                @if($value->mated_date)
                                <span class="m-1">|</span>
                                    @if($value->prop_date_null)
                                    Coming Soon
                                    @else
                                    @if($value->finished)
                                    Construction Completed
                                    @else
                                    {{$value->mated_date}} 
                                    @endif
                                    @endif
                                @endif
                                <p class="mt-1">
                                    <span onclick="inqop('{{$value->prop_code}}','{{$value->prop_name}}')" class="btn btn-primary px-4 py-0"><span class="sr-only">inquire</span><i class="fas fa-edit"></i></span>
                                    <span data-proc="https://api.whatsapp.com/send?phone=971554149608&amp;text=I%20want%20more%20info%20about%20this%20off%20plan%20project%20{{$value->prop_name}}%20Property%20Code%20{{$value->prop_code}}" class="btn btn-success mx-2 px-4 py-0" onclick="proc_link(this,event)"><span class="sr-only">message in whatsapp</span><i class="fab fa-whatsapp"></i></span>
                                    <span data-proc="{{url('/property/' . $value->prop_slug)}}" class="btn btn-primary px-4 py-0" onclick="proc_link(this,event)"><span class="sr-only" >More Details</span><i class="fas fa-info-circle"></i></span>
                                </p>
                            </div>
                        </div>
                        <a href="{{url('/property/' . $value->prop_slug)}}">
                            <img src="{{asset('/images/ph2.jpg')}}" data-src="{{asset($value->prop_img)}}" class="flash-bg-image" alt="{{$value->prop_name}}">
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <h2 class="text-center display-1 text-muted">*NO RESULTS FOUND*</h1>
            @endif
        @else
            <h2 class="text-center display-1 text-muted">*NO RESULTS FOUND*</h1>
        @endif
        <div class="w-100 d-flex justify-content-center flex-wrap">
            {{ $data->appends($li)->links() }}
        </div>
    </div>
</div>
</section>
@endsection

@section('document_ready')
$('.price').each(function(index, el) {
    $(el).html(numberWithCommas($(el).html()));
});
@endsection



@section('scripts')
<script src="{{ asset('js/bootstrap-slider.min.js') }}" ></script>
<script>
function proc_link(elem,e){
    window.open(elem.dataset.proc);
    e.stopPropagation();
}

$('.mobprl').on('click', function(event) {
    event.preventDefault();
    window.location.href = this.dataset.loc;
});
</script>
@endsection