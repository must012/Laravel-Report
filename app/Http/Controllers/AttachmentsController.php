<?php

namespace App\Http\Controllers;

use App\Attachment;
use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    public function store(Request $request)
    {
        //
        $attachments = [];

        if ($request->hasFile('upFiles')) {
            $files = $request->file('upFiles');

            foreach ($files as $file) {

                $filename = date('YmdHis') . "_" . filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);
                $originname = $file->getClientOriginalName();
                $mime = $file->getClientMimeType();
                $size = $file->getClientSize();

                \Log::debug('OriginName = '.$originname);
                \Log::debug("FileSize = " . $size );

                $upload = [
                    'filename' => $filename,
                    'bytes' => $size,
                    'mime' => $mime,
                    'origin_name' => $originname
                ];

                $file->move(attachments_path(), $filename);

                $attachments[] = ($id = $request->input('post_id')) ?
                    \App\Post::find($id)->attachments()->create($upload) :
                    \App\Attachment::create($upload);
            }
        }
        \Log::debug(sizeof($attachments));
        return response()->json($attachments, 200, [], JSON_PRETTY_PRINT);
    }

    public function show(Attachment $attachment)
    {
        //
        $path = attachments_path($attachment->filename);
        $origin = $attachment->origin_name;

        if (! \File::exists($path)) {
            abort(404);
        };

//        $image = \Image::make($path);
        $mime = $attachment->mime;
        \Log::debug('mime = '.$mime);

        return response()->download($path, $origin);
    }

    public function destroy(Attachment $attachment)
    {
        //
        \Log::debug("in attach destroy");
        \Log::debug("id = ".$attachment->filename);

        $path = attachments_path($attachment->filename);

        if (\File::exists($path)) {
            \File::delete($path);
        }

        Attachment::find($attachment->id)->delete();

        return response()->json($attachment, 200, [], JSON_PRETTY_PRINT);
    }
}
