<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        //Eloquent
        $services = Service::paginate(5);
        return view('admin.service.index', compact('services'));
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'service_name' => 'required|unique:services|max:255',
                'service_image' => 'required|mimes:jpg,png,pdf',
            ],
            ['service_name.required' => 'กรุณาป้อนชื่อบริการ',
                'service_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'service_name.unique' => 'ชื่อบริการซ้ำ',
                'service_image.required' => 'กรุณาเพิ่มรูปภาพ',
                'service_image.mimes' => 'กรุณาเพิ่มไฟล์เฉพาะ png,jpg,pdf เท่านั้น',

            ]
        );
        //เข้ารหัวรูปภาพ
        $service_image = $request->file('service_image');
        //generate
        $name_generate = hexdec(uniqid());
        //ดึงนามสกุลไฟล์ภาพ
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        $img_name = $name_generate . '.' . $img_ext;

        //อัพโหลด
        $upload_location = 'image/services/';
        $full_path = $upload_location . $img_name;

        Service::insert([
            'service_name' => $request->service_name,
            'service_image' => $full_path,
            'created_at' => Carbon::now(),
        ]);
        $service_image->move($upload_location, $img_name);

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');

    }

    public function edit($id)
    {
        $service = Service::find($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'service_name' => 'required|max:255',
                'service_image' => 'mimes:jpg,png,pdf,jpeg',
            ],
            ['service_name.required' => 'กรุณาป้อนชื่อบริการ',
                'service_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'service_image.mimes' => 'กรุณาเพิ่มไฟล์เฉพาะ png,jpg,pdf,jpeg เท่านั้น',

            ]
        );

        $service_image = $request->file('service_image');

        // dd($request->service_name, $request->service_image);

        //อัพเดทภาพและชื่อ
        if ($service_image) {
            //generate
            $name_generate = hexdec(uniqid());
            //ดึงนามสกุลไฟล์ภาพ
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            $img_name = $name_generate . '.' . $img_ext;

            //อัพโหลดอัพเดทข้อมูล
            $upload_location = 'image/services/';
            $full_path = $upload_location . $img_name;
            //อัพเดทข้อมูล
            Service::find($id)->update([
                'service_name' => $request->service_name,
                'service_image' => $full_path,

            ]);

            //ลบภาพเก่าและอัพภาพใหม่เเทนที่
            $old_image = $request->old_image;
            unlink($old_image);
            $service_image->move($upload_location, $img_name);
            return redirect()->route('service')->with('success', 'บันทึกรูปภาพสำเร็จ');
        } else
        //อัพเดทชื่ออย่างเดียว
        {
            Service::find($id)->update([
                'service_name' => $request->service_name,
            ]);
            return redirect()->route('service')->with('success', 'บันทึกข้อมูลบริการภาพสำเร็จ');
        }

    }

    public function delete($id)
    {
        //ลบภาพ
        $img = Service::find($id)->service_image;
        unlink($img);

        //ลบภาพและลบข้อมูล
        $delete = Service::find($id)->delete();
        return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');
    }

}
