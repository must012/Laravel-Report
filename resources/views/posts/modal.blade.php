<div class="modal fade" id="bookSearch" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div></div>
                <div class="modal-title">책 검색</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-out" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="books" onsubmit="return false">
                <div class="modal-body d-flex">
                    <input type="hidden" name="ttbkey" value="ttbtnwo941642001">
                    <input type="hidden" name="start" value="1">
                    <input type="hidden" name="MaxResults" value="10">
                    <input type="hidden" name="Cover" value="Small">
                    <input type="hidden" name="Output" value="JS">
                    <input class="form-control col-4 mr-3" type="text" name="Query" placeholder="책 제목">
                    <button class="btn btn-sm write-btn blueBtn">검 색
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn blueBtn">선택 완료</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
    <script>
        function formSubmit() {
            var $target = $('#books');
            var param = $target.serialize();
            alert(param);
            $.ajax({
                type: 'GET',
                url: 'http://www.aladin.co.kr/ttb/api/ItemSearch.aspx',
                data: param,
                dataType: 'json',
                success: function(data){
                    alert('success');
                },
                error: function(e){
                    alert('error');
                }

            });
        }
    </script>
@endsection