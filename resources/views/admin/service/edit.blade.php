<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           สวัสดี , {{ Auth::user()->name}}  
      </h2>

  </x-slot>

  <div class="py-12">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">แก้ไขบริการ</div>
              <div class="card-body">

            <form action="{{ url('/service/update/'.$service->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="service_name" style="margin-bottom: 10px ">ชื่อบริการ</label>
                <input  class="form-control" type="text" name="service_name" value="{{ $service->service_name }}">
              </div>
              @error('service_name')
                  <span class="text-danger my-2">{{ $message }}</span>
              @enderror
              <br>

              <div class="form-group">
                <label for="service_image" style="margin-bottom: 10px ">ภาพประกอบ</label>
                <br>
                <input  class="form-control-file" type="file" name="service_image" value="{{ $service->service_image }}">
              </div>
              @error('service_image')
                  <span class="text-danger my-2">{{ $message }}</span>
              @enderror
              <br>

              <input type="hidden" name="old_image" value="{{ $service->service_image }}">
              <div class="form-group">
                <img src="{{ asset($service->service_image) }} " width="auto" height="30%">
              </div>
              <br>
              <input class="btn btn-primary" type="submit" style="color: black" value="อัพเดตข้อมูล">
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>


<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>