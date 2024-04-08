<div class="btn-group">
    <a href="{{ route('woman-in-news.edit', encrypt($woman_in_news->id)) }}" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
    <a onclick="deleteUsers('{{ $woman_in_news->id }}')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
</div>
