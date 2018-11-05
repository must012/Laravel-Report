<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return __METHOD__."는 Article 컬렉션을 조회";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return __METHOD__."는 Article 컬렉션을 만들기 위한 폼을 담은 뷰를 반환";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return __METHOD__."는 사용자의 입력한 폼 데이터로 새로운 Atricle 컬렉션을 생성";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return __METHOD__."는 다음 기본 키를 가진 Atticle 모델을 반환".$id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return __METHOD__."는 다음 기본키를 가진 Article 모델을 수정하기 위한 폼을 담은 뷰를 반환".$id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        //
        return __METHOD__."는 사용자가 입력한 폼데이터를 다음 기본키를 가진 Article 모델을 수정".$id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return __METHOD__."는 다음 기본키를 가진 Article 모델을 삭제".$id;
    }
}
