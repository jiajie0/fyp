<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;  //生成一个更长、更随机的字符串，从而避免文件名冲突：

class EventController extends Controller
{
    public function index()
    {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('staff.login')->withErrors('Please log in as a staff.');
        }
        $event = Event::all();
        return view('event.index', ['event' => $event]);

    }
    public function create()
    {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('staff.login')->withErrors('Please log in as a staff.');
        }
        $staffID = Auth::guard('staff')->user()->StaffID;
        return view('event.create', compact('staffID'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'StaffID' => 'required|exists:staff,StaffID',
            'EventName' => 'required|string|max:255',
            'EventImageURL' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 检查并处理文件上传
        if ($request->hasFile('EventImageURL')) {
            $file = $request->file('EventImageURL');
            $randomFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // 使用 move() 将文件移动到指定目录
            $destinationPath = storage_path('app/public/events/EventImageURL');  // 设置目标路径
            $file->move($destinationPath, $randomFileName);  // 移动文件

            // 保存文件路径到数据库
            $data['EventImageURL'] = 'storage/events/EventImageURL/' . $randomFileName;  // 这里返回的是相对于 public 目录的路径

        }

        // 创建新的游戏记录
        $newEvent = Event::create($data);

        return redirect(route('event.index'))->with('success', 'Event created successfully!');
    }


    public function edit(Event $event)
    {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('staff.login')->withErrors('Please log in as a staff.');
        }
        $staffID = Auth::guard('staff')->user()->StaffID;
        //dd($event); dump and die
        return view('event.edit', ['event' => $event, 'staffID' => $staffID]);
    }

    public function update(Event $event, Request $request)
    {
        $data = $request->validate([
            'StaffID' => 'required|exists:staff,StaffID',
            'EventName' => 'required|string|max:255',
            'EventImageURL' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 检查并处理文件上传
        if ($request->hasFile('EventImageURL')) {
            $file = $request->file('EventImageURL');
            $randomFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // 使用 move() 将文件移动到指定目录
            $destinationPath = storage_path('app/public/events/EventImageURL');  // 设置目标路径
            $file->move($destinationPath, $randomFileName);  // 移动文件

            // 保存文件路径到数据库
            $data['EventImageURL'] = 'storage/events/EventImageURL/' . $randomFileName;  // 这里返回的是相对于 public 目录的路径

        }


        $event->update($data);

        return redirect(route('event.index'))->with('success', 'Event update succesffuly');
    }

    public function delete(Event $event)
    {
        if ($event->EventImageURL) {
            // 删除旧头像
            Storage::delete(str_replace('/storage', 'public', $event->EventImageURL));  // 确保路径格式正确
        }

        // 删除游戏记录
        $event->delete();

        // 重定向并显示成功消息
        return redirect(route('event.index'))->with('success', 'Event deleted successfully');
    }
}
