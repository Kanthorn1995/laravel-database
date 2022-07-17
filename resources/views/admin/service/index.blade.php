<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           สวัสดี , {{ Auth::user()->name}}
          
           
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          @if (session("success"))
              
              <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                  <b>{{ session('success') }}</b>
                </div>
              </div>
          @endif
          
          <div class="card">
            <div class="card-header">ตารางข้อมูลบริการ</div>
              <table class="table table-striped table-bordered" >
                  <thead>
                    <tr class="text-center">
                      <th scope="col" class="">ลำดับ</th>
                      <th scope="col">ภาพประกอบ</th>
                      <th scope="col">ชื่อบริการ</th>
                      <th scope="col">วันที่เพิ่ม</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>        
                    </tr>
                  </thead>
                  <tbody>
                      @php($i=1)
                      @foreach($services as $row)
                    <tr class="align-middle text-center">
                      <th >{{$services->firstItem()+$loop->index}}</th>
                      <td ><img class="align-middle text-center" src="{{ asset($row->service_image) }}" alt="" width="200px" height="200px"></td>
                      <td >{{ $row->service_name }}</td>
                      
                      <td >
                      @if ($row->created_at == NULL)
                        NULL
                      @else
                        {{ $row-> created_at}}
                      
                      @endif
                    </td>
                    <td >
                      <a href="{{ url('/service/edit/'.$row->id) }}" class="btn btn-warning ">แก้ไข</a>
                    </td>
                    <td >
                      <a href="{{ url('/service/delete/'.$row->id) }}" class="btn btn-danger " onclick="return confirm('คุณต้องการลบข้อมูลนี้ใช่หรือไม่')">ลบข้อมูล</a>
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $services->links() }}
          </div>

          
              
         

        </div>
       
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">แบบฟอร์ม</div>
              <div class="card-body">

            <form action="{{ route('addService') }}" method="post" enctype="multipart/form-data" >
              @csrf
              <div class="form-group">
                <label for="service_name" style="margin-bottom: 10px ">ชื่อบริการ</label>
                <input  class="form-control" type="text" name="service_name">
              </div>
              @error('service_name')
                  <span class="text-danger my-2">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="service_image" style="margin-bottom: 10px " class="my-1">ภาพประกอบ</label>
                <input  class="form-control-file" type="file" name="service_image">
              </div>
              @error('service_image')
                  <span class="text-danger my-2">{{ $message }}</span>
              @enderror
              <br>
              <input class="btn btn-primary" type="submit" style="color: black" value="บันทึก">
              
            </form>
          </div>
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