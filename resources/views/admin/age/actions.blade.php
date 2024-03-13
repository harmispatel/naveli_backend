<div class="btn-group">
    <a href="{{ route('age.edit', encrypt($age->id)) }}" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
    <a href="{{ route('age.destroy',encrypt($age->id)) }}" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
</div>
