@if($woman_in_news->file_type == 'link')
    @if(!empty($woman_in_news->posts))
        <video src="{{ $woman_in_news->posts }}" width="150" type="video/mp4" controls autoplay></video>
    @else
        <img src="{{ asset('public/images/uploads/general_image/noImage.png') }}" alt="no_image" style="max-width: 50px;">
    @endif
@else
    @if(!empty($woman_in_news->posts) && file_exists('public/images/uploads/newsPosts/' . $woman_in_news->posts))
        <image src="{{ asset('public/images/uploads/newsPosts/' . $woman_in_news->posts) }}" width="100">
    @else
        <img src="{{ asset('public/images/uploads/general_image/noImage.png') }}" alt="no_image" style="max-width: 50px;">
    @endif
@endif
