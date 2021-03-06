@extends('posts.write')

@section('form')
    <form class="mb-md-5 mb-sm-4" action="{{ route('posts.update',$list) }}" enctype="multipart/form-data"
          method="post">
        {{ method_field('PUT') }}
        @csrf

        <input type="hidden" name="writer" value="{{ Auth::user()->email }}" readonly>
        <input type="hidden" name="name" value="{{ Auth::user()->name }}" readonly>

        <div class="panel-heading d-flex justify-content-between pt-2 pb-2">

            <div class="contents-title col-3 pt-2">
                <div class="contents-writer">작성자 : {{ Auth::user()->name }} </div>
            </div>
            <div class="action col-2 pt-md-1">
                <button class="btn ml-3 greBtn" id="submit-all" type="submit"><i
                            class="far fa-edit"> 저장</i>
                </button>
            </div>
        </div>

        <div class="panel-body">
            <div class="col-12 p-3 pb-1 m-0 form-group d-flex">
                <input class="form-control col-4 mr-3" type="text" name="book" placeholder="책 제목">
                <button class="btn btn-sm write-btn blueBtn" data-toggle="modal" data-target="#bookSearch">검 색
                </button>
            </div>
        </div>

        <div class="panel-body">
            <div class="col-12 pt-2 form-group {{ $errors->has('title')?'has-error':'' }}">

                <input type="text" id="title" class="form-control" name="title" aria-label="제목" placeholder="제목"
                       value="{{ old('title',$list->title) }}"
                       required>
                {!! $errors->first('title','<span class="form-error">:message</span>') !!}
                <hr style="background-color: whitesmoke">
                <div class="form-group">
                            <textarea class="form-control" id="contents" name="contents"
                                      required> {!! old('contents',$list->content) !!}</textarea>

                </div>
            </div>
        </div>
    </form>
    <div class="panel-footer col-11 p-0 m-auto">
        <div class="form-group">
            <label for="my-dropzone">
                <small class="text-muted">
                    <i class="fa fa-chevron-down"></i>
                </small>

                <small class="text-muted" style="display: none;">
                    <i class="fa fa-chevron-up"></i>
                </small>
            </label>

            <div id="my-dropzone" class="dropzone"></div>
        </div>

    </div>

@endsection