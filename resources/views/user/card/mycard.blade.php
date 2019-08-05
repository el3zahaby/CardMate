@extends('fontend.master')
@section('css')

@endsection

@section('content')
    <!-- about page content area start -->
    <section class="about-page-content-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-page-content-inner"><!-- about page content inner -->
                        <h2 class="title">{{ display('My Cards')  }}</h2>

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="tile">
                                    <div class="panel-group">
                                        <div class="panel panel-default">

                                            <div class="panel-body">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr class="text-center">
                                                        <th>{{ display('Card Name')  }}</th>
                                                        <th>{{ display('Bought Time')  }}</th>
                                                        <th>{{ display('Action')  }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($usercard) > 0)
                                                        @foreach($usercard as $tr)
                                                            <tr class="text-center" id="tr_{{$tr->id}}">
                                                            
                                                                <td>{{display($tr->cats->cat_name)}} -> {{display($tr->card->name)}}</td>
                                                                <td>{{Carbon\Carbon::parse($tr->created_at)->format('d F Y - g:i A')}}</td>
                                                                <td>
                                                                    <button class="btn btn-info btn-sm btn-block dtlsviebtn"
                                                                            data-toggle="modal"  data-target="#dtlsviebtnnn{{$tr->id}}"
                                                                            data-id="{{$tr->id}}" data-details="{{$tr->card->card_details}}"
                                                                            data-image="{{asset($tr->card->card_image)}}">{{ display('View')  }}</button>
                                                                </td>
                                                            </tr>
                                                            <div id="dtlsviebtnnn{{$tr->id}}" class="modal fade" role="dialog">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header headeingall">
                                                                            <h4 class="modal-title" style="text-align: center">{{display($tr->card->name)}}</h4>
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <h4 class="fulldetls">{!! $tr->card_details !!}</h4>
                                                                                    <br>
                                                                                    @if(!empty($tr->card_image))
                                                                                        <img src="{{asset('assets/images/cardimage/'.$tr->card_image)}}" style="width: 100%;height: 200px">
                                                                                    @else

                                                                                    @endif
                                                                                    <input type="hidden" name="delid" value="" class="delid">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer" >
                                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ display('Close')  }}</button>
                                                                            @if($tr->status == 0)
                                                                                <button type="button" class="btn btn-default pull-right" data-id="{{$tr->id}}">{{ display('Used')  }}</button>
                                                                            @else
                                                                                <button type="button" class="btn btn-primary pull-right markused" data-id="{{$tr->id}}">{{ display('Mark As Used')  }}</button>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="4"><h3 style="text-align: center">{{ display('Sorry ! Right now you don\'t have any card')  }}.</h3></td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                                {{$usercard->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div><!-- //.about page content inner -->
                </div>
            </div>
        </div>
    </section>
    <!-- about page content area end -->
@endsection
@section('js')
    <script>
        $(document).ready(function () {

            $('.markused').click(function () {
                var id = $(this).data('id');

                $.ajax({
                    type : "POST",
                    url : "{{route('chnageusercardshowstats')}}",
                    data : {
                        '_token' : "{{csrf_token()}}",
                        'id' : id,
                    },
                    success:function (data) {
                        var btn = "<button class='btn btn-default pull-right'>" + '{{ display('used')  }}' +  "</button>";
                        $('.markused').replaceWith(btn);
                        $('#dtlsviebtnnn'+data.id).modal('hide');
                        $('#tr_'+data.id).remove();
                        location.reload();
                    }
                });
            });

        })
    </script>
@endsection