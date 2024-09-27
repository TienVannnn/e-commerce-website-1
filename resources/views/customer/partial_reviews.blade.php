@foreach ($reviews as $review)
    <div class="media">
        <img src="/uploads/customer/avatars/{{ $review->user->avatar ? $review->user->avatar : 'default-avatar.png' }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
        <div class="media-body">
            <h6>{{ $review->user->name }}<small> - <i>{{ $review->created_at->diffForHumans() }}</i></small></h6>
            <div class="text-primary">
                @for($i = 1; $i <= 5; $i++)
                    @if($review->rate >= $i)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor 
            </div>
            <p>{{ $review->content }}</p>
        </div>
    </div>
@endforeach
