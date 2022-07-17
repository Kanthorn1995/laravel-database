<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             สวัสดี , {{ Auth::user()->name}}
             <b class="float-end">จำนวนผู้ใช้ในระบบ <span>{{ count ($users)}}</span> คน</b>
             
        </h2>
    </x-slot>

    <div class="py-12">
      <div class="container">
        <div class="row">
            <table class="table table-striped table-bordered" >
                <thead>
                  <tr>
                    <th scope="col">ลำดับ</th>
                    <th scope="col">ID</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">รหัส</th>
                    <th scope="col">อีเมล</th>
                    <th scope="col">วันที่สร้าง</th>
                    <th scope="col">สร้างมาแล้วกี่วัน</th>
                  </tr>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($users as $row)
                  <tr>
                    <th>{{ $i++ }}</th>
                    <td>{{ $row-> id}}</td>
                    <td>{{ $row-> name}}</td>
                    <td>{{ $row-> password}}</td>
                    <td>{{ $row-> email}}</td>
                    <td>{{ $row-> created_at}}</td>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
      </div>
    </div>
</x-app-layout>
